<?php
class Notifications extends Controller
{
    private $notificationModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Not authenticated']);
            exit;
        }

        $this->notificationModel = $this->model('Notification');
    }

    /**
     * Get user's notifications (for dropdown)
     */
    public function index()
    {
        header('Content-Type: application/json');

        $notifications = $this->notificationModel->getUserNotifications($_SESSION['user_id'], 20);
        $unreadCount = $this->notificationModel->getUnreadCount($_SESSION['user_id']);

        echo json_encode([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Get unread count only (for badge polling)
     */
    public function getCount()
    {
        header('Content-Type: application/json');

        $count = $this->notificationModel->getUnreadCount($_SESSION['user_id']);

        echo json_encode([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markRead($notification_id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid method']);
            exit;
        }

        $result = $this->notificationModel->markAsRead($notification_id, $_SESSION['user_id']);

        echo json_encode([
            'success' => $result
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid method']);
            exit;
        }

        $result = $this->notificationModel->markAllAsRead($_SESSION['user_id']);

        echo json_encode([
            'success' => $result
        ]);
    }

    /**
     * Delete notification
     */
    public function delete($notification_id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid method']);
            exit;
        }

        $result = $this->notificationModel->delete($notification_id, $_SESSION['user_id']);

        echo json_encode([
            'success' => $result
        ]);
    }
}
?>