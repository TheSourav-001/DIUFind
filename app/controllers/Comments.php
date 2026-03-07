<?php
class Comments extends Controller
{
    private $commentModel;
    private $postModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->commentModel = $this->model('Comment');
        $this->postModel = $this->model('Post');
    }

    // Add a comment to a post
    public function add($post_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Apply rate limiting: Max 5 comments per minute per user/IP
            if (!Security::checkRateLimit('comment_add_' . $_SESSION['user_id'], 5, 60)) {
                flash('comment_message', 'Too many comments. Please wait a moment.', 'alert alert-danger');
                redirect('posts/show/' . $post_id);
            }
            // Sanitize POST data
            $_POST = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'post_id' => $post_id,
                'user_id' => $_SESSION['user_id'],
                'body' => trim($_POST['body']),
                'parent_id' => isset($_POST['parent_id']) && !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : null,
                'body_err' => ''
            ];

            // Validate comment body
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter a comment';
            }

            // Make sure no errors
            if (empty($data['body_err'])) {
                // Add comment
                if ($this->commentModel->addComment($data)) {
                    // Create notification
                    $notificationModel = $this->model('Notification');
                    $postModel = $this->model('Post');
                    $post = $postModel->getPostById($post_id);

                    if ($data['parent_id']) {
                        // Reply to comment - notify comment owner
                        $commentModel = $this->model('Comment');
                        $parentComment = $commentModel->getCommentsByPostId($post_id);
                        foreach ($parentComment as $c) {
                            if ($c->id == $data['parent_id'] && $c->user_id != $_SESSION['user_id']) {
                                $notificationModel->create([
                                    'user_id' => $c->user_id,
                                    'actor_id' => $_SESSION['user_id'],
                                    'type' => 'comment_reply',
                                    'post_id' => $post_id,
                                    'comment_id' => $data['parent_id'],
                                    'message' => $_SESSION['user_name'] . ' replied to your comment'
                                ]);
                            }
                        }
                    } else {
                        // New comment - notify post owner
                        if ($post->user_id != $_SESSION['user_id']) {
                            $notificationModel->create([
                                'user_id' => $post->user_id,
                                'actor_id' => $_SESSION['user_id'],
                                'type' => 'post_comment',
                                'post_id' => $post_id,
                                'comment_id' => null,
                                'message' => $_SESSION['user_name'] . ' commented on your post'
                            ]);
                        }
                    }

                    flash('comment_message', 'Comment added successfully');
                    redirect('posts/show/' . $post_id);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                flash('comment_message', $data['body_err'], 'alert alert-danger');
                redirect('posts/show/' . $post_id);
            }
        } else {
            redirect('posts/show/' . $post_id);
        }
    }

    // Delete a comment (owner only)
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get comment to check ownership
            $comment = $this->commentModel->getCommentById($id);

            // Check if user owns the comment or is admin
            if ($comment->user_id != $_SESSION['user_id']) {
                flash('comment_message', 'Unauthorized access', 'alert alert-danger');
                redirect('posts');
            }

            if ($this->commentModel->deleteComment($id)) {
                flash('comment_message', 'Comment removed');
                redirect('posts/show/' . $comment->post_id);
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }
}
