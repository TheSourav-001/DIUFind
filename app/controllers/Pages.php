<?php
class Pages extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        // Load Post model for analytics
        $postModel = $this->model('Post');
        $stats = $postModel->getDashboardStats();

        // Load User model for top heroes (with fallback if migration not run yet)
        $top_heroes = [];
        try {
            $userModel = $this->model('User');
            // Changed from monthly to all-time to ensure the section is always visible
            $top_heroes = $userModel->getTopHeroes(5); 
        } catch (PDOException $e) {
            // Gracefully handle if points column doesn't exist yet (migration not run)
            // This allows the site to load so user can run the migration
            $top_heroes = [];
        }

        $data = [
            'title' => 'DIU Smart Lost & Found',
            'description' => 'Report and find lost items across all DIU campuses with AI-powered smart matching',
            'stats' => $stats,
            'top_heroes' => $top_heroes
        ];

        $this->view('pages/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About DIUfind'
        ];

        $this->view('pages/about', $data);
    }

    public function leaderboard()
    {
        // Load User model for leaderboard
        $userModel = $this->model('User');
        // Changed from monthly to all-time to show real info correctly
        $topUsers = $userModel->getTopUsers(20); 

        $data = [
            'title' => 'Hall of Fame - Leaderboard',
            'topUsers' => $topUsers
        ];

        $this->view('pages/leaderboard', $data);
    }
}
