<?php
class Notification
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Create a new notification
     */
    public function create($data)
    {
        $this->db->query('INSERT INTO notifications (user_id, actor_id, type, post_id, comment_id, message) 
                          VALUES (:user_id, :actor_id, :type, :post_id, :comment_id, :message)');

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':actor_id', $data['actor_id'] ?? null);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':post_id', $data['post_id'] ?? null);
        $this->db->bind(':comment_id', $data['comment_id'] ?? null);
        $this->db->bind(':message', $data['message']);

        return $this->db->execute();
    }

    /**
     * Get all notifications for a user (latest first)
     */
    public function getUserNotifications($user_id, $limit = 20)
    {
        $this->db->query('SELECT n.*, 
                          u.name as actor_name, 
                          u.avatar as actor_avatar,
                          p.title as post_title
                          FROM notifications n
                          LEFT JOIN users u ON n.actor_id = u.id
                          LEFT JOIN posts p ON n.post_id = p.id
                          WHERE n.user_id = :user_id
                          ORDER BY n.created_at DESC
                          LIMIT :limit');

        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount($user_id)
    {
        $this->db->query('SELECT COUNT(*) as count FROM notifications WHERE user_id = :user_id AND is_read = 0');
        $this->db->bind(':user_id', $user_id);

        $result = $this->db->single();
        return $result ? (int) $result->count : 0;
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead($notification_id, $user_id)
    {
        $this->db->query('UPDATE notifications SET is_read = 1 WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $notification_id);
        $this->db->bind(':user_id', $user_id);

        return $this->db->execute();
    }

    /**
     * Mark all user's notifications as read
     */
    public function markAllAsRead($user_id)
    {
        $this->db->query('UPDATE notifications SET is_read = 1 WHERE user_id = :user_id AND is_read = 0');
        $this->db->bind(':user_id', $user_id);

        return $this->db->execute();
    }

    /**
     * Delete notification
     */
    public function delete($notification_id, $user_id)
    {
        $this->db->query('DELETE FROM notifications WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $notification_id);
        $this->db->bind(':user_id', $user_id);

        return $this->db->execute();
    }

    /**
     * Get new notifications count since last check (for real-time updates)
     */
    public function getNewNotifications($user_id, $since_id = 0)
    {
        $this->db->query('SELECT n.*, 
                          u.name as actor_name,
                          u.avatar as actor_avatar
                          FROM notifications n
                          LEFT JOIN users u ON n.actor_id = u.id
                          WHERE n.user_id = :user_id AND n.id > :since_id
                          ORDER BY n.created_at DESC');

        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':since_id', $since_id);

        return $this->db->resultSet();
    }
}
?>