<?php
/**
 * Claim Model
 * Handles all database operations for claims
 */
class Claim
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Create a new claim
     */
    public function create($data)
    {
        $this->db->query('INSERT INTO claims (post_id, claimant_id, message, status) 
                          VALUES (:post_id, :claimant_id, :message, :status)');

        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':claimant_id', $data['claimer_id']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':status', 'pending');

        return $this->db->execute();
    }

    /**
     * Get claim by ID
     */
    public function getClaimById($id)
    {
        $this->db->query('SELECT c.*, 
                          p.title as post_title, 
                          p.user_id as post_owner_id,
                          u.name as claimer_name,
                          u.email as claimer_email,
                          u.phone as claimer_phone,
                          u.avatar as claimer_avatar
                          FROM claims c
                          JOIN posts p ON c.post_id = p.id
                          JOIN users u ON c.claimant_id = u.id
                          WHERE c.id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    /**
     * Check if user has already claimed a post
     */
    public function hasUserClaimed($post_id, $user_id)
    {
        $this->db->query('SELECT id FROM claims WHERE post_id = :post_id AND claimant_id = :user_id');
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':user_id', $user_id);

        $this->db->single();
        return $this->db->rowCount() > 0;
    }

    /**
     * Update claim status
     */
    public function updateStatus($claim_id, $status)
    {
        $this->db->query('UPDATE claims SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $claim_id);

        return $this->db->execute();
    }

    /**
     * Get all claims for a specific post
     */
    public function getClaimsByPost($post_id)
    {
        $this->db->query('SELECT c.*, 
                          u.name as claimer_name, 
                          u.email as claimer_email, 
                          u.phone as claimer_phone,
                          u.avatar as claimer_avatar
                          FROM claims c 
                          JOIN users u ON c.claimant_id = u.id 
                          WHERE c.post_id = :post_id 
                          ORDER BY c.created_at DESC');
        $this->db->bind(':post_id', $post_id);

        return $this->db->resultSet();
    }

    /**
     * Get pending claims count for posts owned by user (for badge)
     */
    public function getPendingClaimsCount($owner_id)
    {
        $this->db->query("SELECT COUNT(*) as count 
                          FROM claims c
                          JOIN posts p ON c.post_id = p.id
                          WHERE p.user_id = :owner_id 
                          AND c.status = 'pending'");
        $this->db->bind(':owner_id', $owner_id);

        $result = $this->db->single();
        return $result ? (int) $result->count : 0;
    }

    /**
     * Get all claims for posts owned by user (messenger-style list)
     * Sorted by: pending first, then by date
     */
    public function getClaimsForOwner($owner_id)
    {
        $this->db->query("SELECT c.*, 
                          p.title as post_title, 
                          p.type as post_type, 
                          p.id as post_id,
                          u.name as claimer_name, 
                          u.email as claimer_email,
                          u.phone as claimer_phone,
                          u.avatar as claimer_avatar
                          FROM claims c
                          JOIN posts p ON c.post_id = p.id
                          JOIN users u ON c.claimant_id = u.id
                          WHERE p.user_id = :owner_id
                          ORDER BY 
                            CASE c.status 
                              WHEN 'pending' THEN 1
                              WHEN 'admin_review' THEN 2
                              WHEN 'accepted' THEN 3
                              WHEN 'rejected' THEN 4
                              ELSE 5
                            END,
                            c.created_at DESC");
        $this->db->bind(':owner_id', $owner_id);

        return $this->db->resultSet();
    }

    /**
     * Get claims made by a specific user
     */
    public function getClaimsByUser($user_id)
    {
        $this->db->query('SELECT c.*, 
                          p.title as post_title, 
                          p.type as post_type 
                          FROM claims c 
                          JOIN posts p ON c.post_id = p.id 
                          WHERE c.claimant_id = :user_id 
                          ORDER BY c.created_at DESC');
        $this->db->bind(':user_id', $user_id);

        return $this->db->resultSet();
    }
}
?>