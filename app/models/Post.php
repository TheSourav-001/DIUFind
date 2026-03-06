<?php
class Post
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get all posts with advanced filters
    public function getPosts($filters = [])
    {
        $sql = 'SELECT posts.*, 
                posts.id as postId, 
                users.id as userId, 
                posts.created_at as postCreated,
                users.name as user_name, 
                users.email as user_email, 
                users.avatar, 
                users.trust_score, 
                categories.name as category_name, 
                categories.icon_class, 
                locations.name as location_name
                FROM posts 
                LEFT JOIN users ON posts.user_id = users.id 
                LEFT JOIN categories ON posts.category_id = categories.id
                LEFT JOIN locations ON posts.location_id = locations.id';

        $conditions = [];

        // Search filter
        if (!empty($filters['search'])) {
            $conditions[] = '(posts.title LIKE :search OR posts.body LIKE :search OR locations.name LIKE :search)';
        }

        // Type filter
        if (!empty($filters['type'])) {
            $conditions[] = 'posts.type = :type';
        }

        // Category filter (multiple)
        if (!empty($filters['category']) && is_array($filters['category'])) {
            $placeholders = [];
            foreach ($filters['category'] as $index => $cat) {
                $placeholders[] = ':category' . $index;
            }
            $conditions[] = 'posts.category_id IN (' . implode(',', $placeholders) . ')';
        }

        // Location filter (multiple)
        if (!empty($filters['location']) && is_array($filters['location'])) {
            $placeholders = [];
            foreach ($filters['location'] as $index => $loc) {
                $placeholders[] = ':location' . $index;
            }
            $conditions[] = 'posts.location_id IN (' . implode(',', $placeholders) . ')';
        }

        // Date range filter
        if (!empty($filters['date_from'])) {
            $conditions[] = 'posts.created_at >= :date_from';
        }
        if (!empty($filters['date_to'])) {
            $conditions[] = 'posts.created_at <= :date_to';
        }

        // CRITICAL: Hide ONLY resolved posts (show active, pending, NULL, etc.)
        // This keeps resolved posts in database for analytics but hides from feed
        // Changed from requiring 'active' to excluding 'resolved' to accommodate existing data
        $conditions[] = "(posts.status IS NULL OR posts.status != 'resolved')";

        // Append WHERE clause
        if (count($conditions) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        // Sorting
        $sort = $filters['sort'] ?? 'newest';
        switch ($sort) {
            case 'oldest':
                $sql .= ' ORDER BY posts.created_at ASC';
                break;
            case 'title':
                $sql .= ' ORDER BY posts.title ASC';
                break;
            default: // newest
                $sql .= ' ORDER BY posts.created_at DESC';
        }

        $this->db->query($sql);

        // Bind parameters
        if (!empty($filters['search'])) {
            $this->db->bind(':search', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['type'])) {
            $this->db->bind(':type', $filters['type']);
        }

        if (!empty($filters['category']) && is_array($filters['category'])) {
            foreach ($filters['category'] as $index => $cat) {
                $this->db->bind(':category' . $index, $cat);
            }
        }

        if (!empty($filters['location']) && is_array($filters['location'])) {
            foreach ($filters['location'] as $index => $loc) {
                $this->db->bind(':location' . $index, $loc);
            }
        }

        if (!empty($filters['date_from'])) {
            $this->db->bind(':date_from', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $this->db->bind(':date_to', $filters['date_to'] . ' 23:59:59');
        }

        return $this->db->resultSet();
    }

    // Update post status
    public function updateStatus($id, $status)
    {
        $this->db->query('UPDATE posts SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    // ==================== ANALYTICS METHODS ====================

    /**
     * Get comprehensive dashboard statistics
     */
    public function getDashboardStats()
    {
        return [
            'total_items' => $this->getTotalItems(),
            'items_returned' => $this->getItemsReturned(),
            'active_users' => $this->getActiveUsers(),
            'success_rate' => $this->getSuccessRate(),
            'lost_vs_found' => $this->getLostVsFoundRatio(),
            'location_stats' => $this->getLocationStats(),
            'category_stats' => $this->getCategoryStats(),
            'top_users' => $this->getTopUsers(),
            'recent_posts' => $this->getRecentPosts(5)
        ];
    }

    /**
     * Get total number of posts
     */
    public function getTotalItems()
    {
        $this->db->query('SELECT COUNT(*) as total FROM posts');
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    /**
     * Get number of resolved/returned items
     */
    public function getItemsReturned()
    {
        $this->db->query("SELECT COUNT(*) as total FROM posts WHERE status = 'resolved'");
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    /**
     * Get number of active users
     */
    public function getActiveUsers()
    {
        $this->db->query('SELECT COUNT(DISTINCT user_id) as total FROM posts');
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    /**
     * Calculate success rate percentage
     */
    public function getSuccessRate()
    {
        $total = $this->getTotalItems();
        $returned = $this->getItemsReturned();

        if ($total == 0)
            return 0;

        return round(($returned / $total) * 100, 1);
    }

    /**
     * Get Lost vs Found ratio for pie chart
     */
    public function getLostVsFoundRatio()
    {
        $this->db->query("SELECT 
            SUM(CASE WHEN type = 'Lost' THEN 1 ELSE 0 END) as lost,
            SUM(CASE WHEN type = 'Found' THEN 1 ELSE 0 END) as found
            FROM posts");

        $result = $this->db->single();

        return [
            'lost' => $result->lost ?? 0,
            'found' => $result->found ?? 0
        ];
    }

    /**
     * Get location statistics (top 5 for heatmap)
     */
    public function getLocationStats()
    {
        $this->db->query("SELECT 
            COALESCE(locations.name, 'Unknown') as location,
            COUNT(*) as count
            FROM posts
            LEFT JOIN locations ON posts.location_id = locations.id
            GROUP BY location_id, locations.name
            ORDER BY count DESC
            LIMIT 5");

        return $this->db->resultSet();
    }

    /**
     * Get category statistics for pie chart
     */
    public function getCategoryStats()
    {
        $this->db->query("SELECT 
            COALESCE(categories.name, 'General') as category,
            COUNT(*) as count
            FROM posts
            LEFT JOIN categories ON posts.category_id = categories.id
            GROUP BY categories.id, categories.name
            ORDER BY count DESC");

        return $this->db->resultSet();
    }

    /**
     * Get top users by post count
     */
    public function getTopUsers()
    {
        $this->db->query("SELECT 
            users.name,
            users.trust_score,
            COUNT(posts.id) as post_count
            FROM posts
            JOIN users ON posts.user_id = users.id
            GROUP BY users.id, users.name, users.trust_score
            ORDER BY post_count DESC
            LIMIT 5");

        return $this->db->resultSet();
    }

    /**
     * Get recent posts for table
     */
    public function getRecentPosts($limit = 5)
    {
        $this->db->query("SELECT 
            posts.id,
            posts.title,
            posts.type,
            posts.status,
            posts.created_at,
            users.name as user_name,
            COALESCE(locations.name, 'Unknown') as location_name
            FROM posts
            JOIN users ON posts.user_id = users.id
            LEFT JOIN locations ON posts.location_id = locations.id
            ORDER BY posts.created_at DESC
            LIMIT :limit");

        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    // Add post
    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts (user_id, title, type, body, location_id, category_id, image_path, latitude, longitude) 
                          VALUES (:user_id, :title, :type, :body, :location_id, :category_id, :image_path, :latitude, :longitude)');

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':location_id', $data['location_id'] ?? null);
        $this->db->bind(':category_id', $data['category_id'] ?? null);
        $this->db->bind(':image_path', $data['image_path'] ?? null);
        $this->db->bind(':latitude', $data['latitude'] ?? null);
        $this->db->bind(':longitude', $data['longitude'] ?? null);

        return $this->db->execute();
    }

    // Get post by ID
    public function getPostById($id)
    {
        $this->db->query('SELECT posts.*, 
                          users.name as user_name, 
                          users.email as user_email, 
                          users.avatar, 
                          users.trust_score,
                          categories.name as category_name,
                          locations.name as location_name
                          FROM posts
                          LEFT JOIN users ON posts.user_id = users.id
                          LEFT JOIN categories ON posts.category_id = categories.id
                          LEFT JOIN locations ON posts.location_id = locations.id
                          WHERE posts.id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    // Update post
    public function updatePost($data)
    {
        $this->db->query('UPDATE posts 
                          SET title = :title,
                              body = :body,
                              type = :type,
                              location_id = :location_id,
                              category_id = :category_id,
                              points_awarded = :points_awarded
                          WHERE id = :id');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title'] ?? '');
        $this->db->bind(':body', $data['body'] ?? '');
        $this->db->bind(':type', $data['type'] ?? '');
        $this->db->bind(':location_id', $data['location_id'] ?? null);
        $this->db->bind(':category_id', $data['category_id'] ?? null);
        $this->db->bind(':points_awarded', $data['points_awarded'] ?? 0);

        return $this->db->execute();
    }

    // Delete post
    public function deletePost($id)
    {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    // Get posts by user ID
    public function getPostsByUserId($user_id)
    {
        $this->db->query('SELECT posts.*, 
                          categories.name as category_name,
                          locations.name as location_name
                          FROM posts
                          LEFT JOIN categories ON posts.category_id = categories.id
                          LEFT JOIN locations ON posts.location_id = locations.id
                          WHERE posts.user_id = :user_id
                          ORDER BY posts.created_at DESC');

        $this->db->bind(':user_id', $user_id);

        return $this->db->resultSet();
    }

    // Get all posts with location data for map
    public function getPostsWithLocation()
    {
        $this->db->query('SELECT posts.id, posts.title, posts.type, posts.latitude, posts.longitude, posts.image, posts.created_at
                          FROM posts
                          WHERE posts.latitude IS NOT NULL AND posts.longitude IS NOT NULL
                          AND posts.status = "active"
                          ORDER BY posts.created_at DESC');

        return $this->db->resultSet();
    }
}