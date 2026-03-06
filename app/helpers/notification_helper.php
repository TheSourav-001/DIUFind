<?php
/**
 * Helper function to create notifications
 * Call this from any controller to trigger a notification
 */

// Ensure Notification model is loaded
require_once __DIR__ . '/../models/Notification.php';

if (!function_exists('createNotification')) {
    function createNotification($user_id, $type, $message, $actor_id = null, $post_id = null, $comment_id = null)
    {
        $notificationModel = new Notification();

        return $notificationModel->create([
            'user_id' => $user_id,
            'actor_id' => $actor_id,
            'type' => $type,
            'post_id' => $post_id,
            'comment_id' => $comment_id,
            'message' => $message
        ]);
    }
}

/**
 * Simplified notification helper
 * Usage: sendNotification($user_id, "Your claim was approved!", "posts/show/123")
 */
if (!function_exists('sendNotification')) {
    function sendNotification($user_id, $message, $link_path = '', $type = 'system', $actor_id = null, $post_id = null)
    {
        return createNotification($user_id, $type, $message, $actor_id, $post_id, null);
    }
}
?>