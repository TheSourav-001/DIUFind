<?php
class Reactions extends Controller
{
    private $reactionModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Not authenticated']);
            exit;
        }

        $this->reactionModel = $this->model('Reaction');
    }

    /**
     * AJAX endpoint to handle reactions
     * Expects JSON: { postId: x, type: 'love' }
     */
    public function react()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method']);
            exit;
        }

        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['postId']) || !isset($input['type'])) {
            echo json_encode(['error' => 'Missing parameters']);
            exit;
        }

        $postId = (int) $input['postId'];
        $type = $input['type'];
        $userId = $_SESSION['user_id'];

        // Validate reaction type
        $validTypes = ['like', 'love', 'care', 'haha', 'wow', 'sad', 'angry'];
        if (!in_array($type, $validTypes)) {
            echo json_encode(['error' => 'Invalid reaction type']);
            exit;
        }

        // Process reaction
        $result = $this->reactionModel->setReaction($postId, $userId, $type);

        // Create notification if it's a new reaction and not user's own post
        if ($result['action'] == 'added') {
            $postModel = $this->model('Post');
            $post = $postModel->getPostById($postId);

            if ($post->user_id != $userId) {
                $notificationModel = $this->model('Notification');
                $emojis = ['like' => '👍', 'love' => '❤️', 'care' => '🤗', 'haha' => '😂', 'wow' => '😮', 'sad' => '😢', 'angry' => '😡'];
                $notificationModel->create([
                    'user_id' => $post->user_id,
                    'actor_id' => $userId,
                    'type' => 'post_reaction',
                    'post_id' => $postId,
                    'comment_id' => null,
                    'message' => Security::h($_SESSION['user_name']) . ' reacted ' . $emojis[$type] . ' to your post'
                ]);
            }
        }

        // Get updated counts
        $reactions = $this->reactionModel->getReactions($postId);
        $userReaction = $this->reactionModel->getUserReaction($postId, $userId);

        echo json_encode([
            'success' => true,
            'action' => $result['action'],
            'reactions' => $reactions,
            'userReaction' => $userReaction ? $userReaction->type : null
        ]);
    }
}
?>