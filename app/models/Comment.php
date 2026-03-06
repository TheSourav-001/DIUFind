<?php
class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get all comments for a specific post
    public function getCommentsByPostId($post_id)
    {
        $this->db->query('SELECT comments.*, 
                          users.name as user_name, 
                          users.avatar,
                          users.role
                          FROM comments 
                          LEFT JOIN users ON comments.user_id = users.id 
                          WHERE comments.post_id = :post_id 
                          ORDER BY comments.created_at DESC');

        $this->db->bind(':post_id', $post_id);

        return $this->db->resultSet();
    }

    // Add a new comment (supports nesting via parent_id)
    public function addComment($data)
    {
        $this->db->query('INSERT INTO comments (post_id, user_id, body, parent_id) 
                          VALUES (:post_id, :user_id, :body, :parent_id)');

        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':parent_id', isset($data['parent_id']) ? $data['parent_id'] : null);

        return $this->db->execute();
    }

    // Get comment count for a post
    public function getCommentCount($post_id)
    {
        $this->db->query('SELECT COUNT(*) as count FROM comments WHERE post_id = :post_id');
        $this->db->bind(':post_id', $post_id);

        $row = $this->db->single();
        return $row->count;
    }

    // Delete a comment (for future use)
    public function deleteComment($id)
    {
        $this->db->query('DELETE FROM comments WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }
}
