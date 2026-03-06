<?php
/**
 * Claims Controller
 * Handles all claim-related functionality
 * 
 * ACCESS CONTROL:
 * - Any user (except post owner) can submit a claim
 * - Only post owner can Approve/Reject/Call Admin
 */
class Claims extends Controller
{
    private $claimModel;
    private $postModel;
    private $userModel;

    public function __construct()
    {
        // Must be logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        // Load models
        $this->claimModel = $this->model('Claim');
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    /**
     * Submit a new claim (AJAX endpoint)
     * Called when user clicks "Claim" button on post details
     */
    public function submit($post_id)
    {
        // Must be POST request
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        // Get post details
        $post = $this->postModel->getPostById($post_id);

        if (!$post) {
            echo json_encode(['success' => false, 'message' => 'Post not found']);
            return;
        }

        // User cannot claim their own post
        if ($post->user_id == $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'You cannot claim your own post']);
            return;
        }

        // Check if user already claimed this post
        if ($this->claimModel->hasUserClaimed($post_id, $_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'You have already submitted a claim for this item']);
            return;
        }

        // Create the claim
        $claimData = [
            'post_id' => $post_id,
            'claimer_id' => $_SESSION['user_id'],
            'message' => isset($_POST['message']) ? trim($_POST['message']) : 'User claims this item belongs to them.'
        ];

        if ($this->claimModel->create($claimData)) {
            // Send notification to post owner
            $this->sendNotification(
                $post->user_id,
                $_SESSION['user_name'] . ' has requested to claim your post: "' . $post->title . '"',
                'claim',
                $_SESSION['user_id'],
                $post_id
            );

            echo json_encode([
                'success' => true,
                'message' => 'Claim request sent to the post owner.'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit claim. Please try again.']);
        }
    }

    /**
     * Approve a claim (POST OWNER ONLY)
     */
    public function approve($claim_id)
    {
        $claim = $this->claimModel->getClaimById($claim_id);

        if (!$claim) {
            flash('profile_message', 'Claim not found', 'alert-danger');
            redirect('users/profile');
            return;
        }

        // Get the post to verify ownership
        $post = $this->postModel->getPostById($claim->post_id);

        // ACCESS CONTROL: Only post owner can approve
        if ($post->user_id != $_SESSION['user_id']) {
            flash('profile_message', 'You are not authorized to perform this action', 'alert-danger');
            redirect('users/profile');
            return;
        }

        // Update claim status
        if ($this->claimModel->updateStatus($claim_id, 'accepted')) {
            // Get owner contact info
            $owner = $this->userModel->getUserById($_SESSION['user_id']);
            $contactInfo = !empty($owner->phone) ? $owner->phone : $owner->email;

            // Notify the claimer that their claim was approved
            $this->sendNotification(
                $claim->claimant_id,
                '✅ Your claim for "' . $post->title . '" has been APPROVED! Contact owner: ' . $contactInfo,
                'claim_approved',
                $_SESSION['user_id'],
                $post->id
            );

            // Notify owner (confirmation)
            $this->sendNotification(
                $_SESSION['user_id'],
                'You approved the claim request for "' . $post->title . '"',
                'claim_action',
                $_SESSION['user_id'],
                $post->id
            );

            flash('profile_message', 'Claim approved! Contact info sent to the claimer.', 'alert-success');
        } else {
            flash('profile_message', 'Failed to approve claim', 'alert-danger');
        }

        redirect('users/profile');
    }

    /**
     * Reject a claim (POST OWNER ONLY)
     */
    public function reject($claim_id)
    {
        $claim = $this->claimModel->getClaimById($claim_id);

        if (!$claim) {
            flash('profile_message', 'Claim not found', 'alert-danger');
            redirect('users/profile');
            return;
        }

        // Get the post to verify ownership
        $post = $this->postModel->getPostById($claim->post_id);

        // ACCESS CONTROL: Only post owner can reject
        if ($post->user_id != $_SESSION['user_id']) {
            flash('profile_message', 'You are not authorized to perform this action', 'alert-danger');
            redirect('users/profile');
            return;
        }

        // Update claim status
        if ($this->claimModel->updateStatus($claim_id, 'rejected')) {
            // Notify the claimer that their claim was rejected
            $this->sendNotification(
                $claim->claimant_id,
                '❌ Your claim for "' . $post->title . '" has been rejected.',
                'claim_rejected',
                $_SESSION['user_id'],
                $post->id
            );

            // Notify owner (confirmation)
            $this->sendNotification(
                $_SESSION['user_id'],
                'You rejected the claim request for "' . $post->title . '"',
                'claim_action',
                $_SESSION['user_id'],
                $post->id
            );

            flash('profile_message', 'Claim rejected. The claimer has been notified.', 'alert-success');
        } else {
            flash('profile_message', 'Failed to reject claim', 'alert-danger');
        }

        redirect('users/profile');
    }

    /**
     * Escalate claim to admin (POST OWNER ONLY)
     */
    public function escalate($claim_id)
    {
        $claim = $this->claimModel->getClaimById($claim_id);

        if (!$claim) {
            flash('profile_message', 'Claim not found', 'alert-danger');
            redirect('users/profile');
            return;
        }

        // Get the post to verify ownership
        $post = $this->postModel->getPostById($claim->post_id);

        // ACCESS CONTROL: Only post owner can escalate
        if ($post->user_id != $_SESSION['user_id']) {
            flash('profile_message', 'You are not authorized to perform this action', 'alert-danger');
            redirect('users/profile');
            return;
        }

        // Update claim status to admin_review
        if ($this->claimModel->updateStatus($claim_id, 'admin_review')) {
            // Notify the claimer that their claim was escalated
            $this->sendNotification(
                $claim->claimant_id,
                '⚠️ Your claim for "' . $post->title . '" has been escalated to admin for review.',
                'claim_escalated',
                $_SESSION['user_id'],
                $post->id
            );

            // Notify owner (confirmation)
            $this->sendNotification(
                $_SESSION['user_id'],
                'You escalated the claim request for "' . $post->title . '" to admin.',
                'claim_action',
                $_SESSION['user_id'],
                $post->id
            );

            flash('profile_message', 'Claim escalated to admin. Both parties have been notified.', 'alert-success');
        } else {
            flash('profile_message', 'Failed to escalate claim', 'alert-danger');
        }

        redirect('users/profile');
    }

    /**
     * Helper function to send notifications
     */
    private function sendNotification($user_id, $message, $type, $actor_id, $post_id)
    {
        // Use the global sendNotification helper if available
        if (function_exists('sendNotification')) {
            return sendNotification($user_id, $message, '', $type, $actor_id, $post_id);
        }

        // Fallback: direct database insert
        $notificationModel = $this->model('Notification');
        return $notificationModel->create([
            'user_id' => $user_id,
            'actor_id' => $actor_id,
            'type' => $type,
            'post_id' => $post_id,
            'comment_id' => null,
            'message' => $message
        ]);
    }
}
?>