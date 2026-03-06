<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Register user
    public function register($data)
    {
        $this->db->query('INSERT INTO users (name, email, phone, role, password_hash) VALUES (:name, :email, :phone, :role, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':password', $data['password']);

        return $this->db->execute();
    }

    // Login user
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($row) {
            $hashed_password = $row->password_hash;
            if (password_verify($password, $hashed_password)) {
                return $row;
            }
        }

        return false;
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        return $this->db->rowCount() > 0;
    }

    // Get user by ID
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    // ==================== PROFILE UPDATE METHODS ====================

    /**
     * Update user profile
     */
    public function updateUser($data)
    {
        // Check if email exists for another user
        if (isset($data['email'])) {
            $this->db->query('SELECT id FROM users WHERE email = :email AND id != :id');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':id', $data['id']);

            if ($this->db->single()) {
                return false; // Email already taken
            }
        }

        // Build update query dynamically
        $fields = [];
        if (isset($data['name']))
            $fields[] = 'name = :name';
        if (isset($data['email']))
            $fields[] = 'email = :email';
        if (isset($data['phone']))
            $fields[] = 'phone = :phone';
        if (isset($data['password']))
            $fields[] = 'password_hash = :password';
        if (isset($data['avatar']))
            $fields[] = 'avatar = :avatar';

        if (empty($fields))
            return false;

        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $this->db->query($sql);

        if (isset($data['name']))
            $this->db->bind(':name', $data['name']);
        if (isset($data['email']))
            $this->db->bind(':email', $data['email']);
        if (isset($data['phone']))
            $this->db->bind(':phone', $data['phone']);
        if (isset($data['password']))
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        if (isset($data['avatar']))
            $this->db->bind(':avatar', $data['avatar']);
        $this->db->bind(':id', $data['id']);

        return $this->db->execute();
    }

    // ==================== USER ANALYTICS METHODS ====================

    /**
     * Get comprehensive user statistics
     */
    public function getUserStats($user_id)
    {
        return [
            'total_posts' => $this->getUserTotalPosts($user_id),
            'resolved_items' => $this->getUserResolvedItems($user_id),
            'success_rate' => $this->getUserSuccessRate($user_id),
            'lost_vs_found' => $this->getMyLostVsFoundRatio($user_id),
            'item_categories' => $this->getMyItemCategories($user_id),
            'location_stats' => $this->getMyLocationStats($user_id),
            'monthly_activity' => $this->getMonthlyActivity($user_id)
        ];
    }

    /**
     * Get total posts by user
     */
    private function getUserTotalPosts($user_id)
    {
        $this->db->query('SELECT COUNT(*) as total FROM posts WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    /**
     * Get resolved items by user
     */
    private function getUserResolvedItems($user_id)
    {
        $this->db->query("SELECT COUNT(*) as total FROM posts WHERE user_id = :user_id AND status = 'resolved'");
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    /**
     * Calculate user's success rate
     */
    private function getUserSuccessRate($user_id)
    {
        $total = $this->getUserTotalPosts($user_id);
        $resolved = $this->getUserResolvedItems($user_id);

        if ($total == 0)
            return 0;

        return round(($resolved / $total) * 100, 1);
    }

    /**
     * Get user's lost vs found ratio
     */
    public function getMyLostVsFoundRatio($user_id)
    {
        $this->db->query("SELECT 
            SUM(CASE WHEN type = 'Lost' THEN 1 ELSE 0 END) as lost,
            SUM(CASE WHEN type = 'Found' THEN 1 ELSE 0 END) as found
            FROM posts
            WHERE user_id = :user_id");

        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();

        return [
            'lost' => $result->lost ?? 0,
            'found' => $result->found ?? 0
        ];
    }

    /**
     * Get user's item categories (what they lose most)
     */
    public function getMyItemCategories($user_id)
    {
        $this->db->query("SELECT 
            COALESCE(categories.name, 'General') as category,
            COUNT(*) as count
            FROM posts
            LEFT JOIN categories ON posts.category_id = categories.id
            WHERE posts.user_id = :user_id
            GROUP BY categories.id, categories.name
            ORDER BY count DESC");

        return $this->db->resultSet();
    }

    /**
     * Get top heroes for the current month
     * Based on resolved 'Found' posts
     */
    public function getMonthlyTopHeroes($limit = 5)
    {
        $this->db->query("SELECT 
            users.name, 
            users.avatar, 
            users.role,
            users.points as total_lifetime_points,
            COUNT(posts.id) * 10 as points,
            COUNT(posts.id) as items_returned
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.type = 'Found' 
            AND posts.status = 'resolved'
            AND MONTH(posts.updated_at) = MONTH(CURRENT_DATE())
            AND YEAR(posts.updated_at) = YEAR(CURRENT_DATE())
            GROUP BY users.id
            ORDER BY points DESC
            LIMIT :limit");

        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    /**
     * Get user's location stats (where they lose items most)
     */
    public function getMyLocationStats($user_id)
    {
        $this->db->query("SELECT 
            COALESCE(locations.name, 'Unknown') as location,
            COUNT(*) as count
            FROM posts
            LEFT JOIN locations ON posts.location_id = locations.id
            WHERE posts.user_id = :user_id
            GROUP BY locations.id, locations.name
            ORDER BY count DESC
            LIMIT 5");

        $this->db->bind(':user_id', $user_id);

        return $this->db->resultSet();
    }

    /**
     * Get user's monthly activity for the last 6 months
     */
    public function getMonthlyActivity($user_id)
    {
        $this->db->query("SELECT 
            DATE_FORMAT(created_at, '%Y-%m') as month,
            COUNT(*) as count
            FROM posts
            WHERE user_id = :user_id
            AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY month ASC");

        $this->db->bind(':user_id', $user_id);

        return $this->db->resultSet();
    }

    // ==================== GAMIFICATION METHODS ====================

    /**
     * Add points to a user (for gamification)
     */
    public function addPoints($user_id, $points)
    {
        $this->db->query('UPDATE users SET points = points + :points WHERE id = :user_id');
        $this->db->bind(':points', $points);
        $this->db->bind(':user_id', $user_id);

        return $this->db->execute();
    }

    /**
     * Get top users by points for leaderboard (Hall of Fame)
     */
    public function getTopUsers($limit = 20)
    {
        $this->db->query("SELECT 
            id,
            name,
            email,
            avatar,
            points,
            role,
            created_at
            FROM users
            WHERE points > 0
            ORDER BY points DESC, name ASC
            LIMIT :limit");

        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    /**
     * Get top 3 heroes for homepage widget
     */
    public function getTopHeroes($limit = 3)
    {
        return $this->getTopUsers($limit);
    }
}
