<?php
class Reaction
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Set or toggle a reaction
     * If user clicks same reaction twice, remove it (toggle off)
     * If user clicks different reaction, update it
     */
    public function setReaction($post_id, $user_id, $type)
    {
        // Check if user already reacted
        $existing = $this->getUserReaction($post_id, $user_id);

        if ($existing && $existing->type == $type) {
            // Same reaction - toggle off (delete)
            $this->db->query('DELETE FROM reactions WHERE post_id = :post_id AND user_id = :user_id');
            $this->db->bind(':post_id', $post_id);
            $this->db->bind(':user_id', $user_id);
            $this->db->execute();
            return ['action' => 'removed'];
        } elseif ($existing) {
            // Different reaction - update
            $this->db->query('UPDATE reactions SET type = :type WHERE post_id = :post_id AND user_id = :user_id');
            $this->db->bind(':type', $type);
            $this->db->bind(':post_id', $post_id);
            $this->db->bind(':user_id', $user_id);
            $this->db->execute();
            return ['action' => 'updated'];
        } else {
            // No reaction - insert new
            $this->db->query('INSERT INTO reactions (post_id, user_id, type) VALUES (:post_id, :user_id, :type)');
            $this->db->bind(':post_id', $post_id);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':type', $type);
            $this->db->execute();
            return ['action' => 'added'];
        }
    }

    /**
     * Get all reactions for a post, grouped by type
     */
    public function getReactions($post_id)
    {
        $this->db->query('SELECT type, COUNT(*) as count FROM reactions WHERE post_id = :post_id GROUP BY type');
        $this->db->bind(':post_id', $post_id);

        $results = $this->db->resultSet();

        // Convert to associative array for easy access
        $reactions = [
            'like' => 0,
            'love' => 0,
            'care' => 0,
            'haha' => 0,
            'wow' => 0,
            'sad' => 0,
            'angry' => 0,
            'total' => 0
        ];

        foreach ($results as $result) {
            $reactions[$result->type] = (int) $result->count;
            $reactions['total'] += (int) $result->count;
        }

        return $reactions;
    }

    /**
     * Get current user's reaction on a post
     */
    public function getUserReaction($post_id, $user_id)
    {
        $this->db->query('SELECT * FROM reactions WHERE post_id = :post_id AND user_id = :user_id');
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':user_id', $user_id);

        return $this->db->single();
    }

    /**
     * Get total reaction count for a post
     */
    public function getTotalReactions($post_id)
    {
        $this->db->query('SELECT COUNT(*) as total FROM reactions WHERE post_id = :post_id');
        $this->db->bind(':post_id', $post_id);

        $result = $this->db->single();
        return $result ? (int) $result->total : 0;
    }
}
?>