<?php
class Users extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'role' => trim($_POST['role']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email already registered';
                }
            }

            // Validate phone
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone number';
            } elseif (!preg_match('/^01[0-9]{9}$/', $data['phone'])) {
                $data['phone_err'] = 'Phone must be 11 digits (01XXXXXXXXX)';
            }

            // Validate role
            if (empty($data['role'])) {
                $data['role_err'] = 'Please select your role';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['role_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    flash('register_success', 'Registration successful. Please login.');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/register', $data);
            }
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'role' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'role_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if ($this->userModel->findUserByEmail($data['email']) == false) {
                $data['email_err'] = 'No user found';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            $this->view('users/login', $data);
        }
    }

    private function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_avatar'] = $user->avatar;
        redirect('');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        flash('user_message', 'You are now logged out');
        redirect('users/login');
    }

    // Profile page
    public function profile()
    {
        // Check if logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $userId = $_SESSION['user_id'];

        // Load models
        $postModel = $this->model('Post');
        $claimModel = $this->model('Claim');

        // Get user data
        $user = $this->userModel->getUserById($userId);

        // Get user's posts
        $posts = $postModel->getPostsByUserId($userId);

        // Get claims received on user's posts
        $claims = $claimModel->getClaimsForOwner($userId);

        // Calculate personal stats
        $totalPosts = count($posts);
        $resolvedPosts = 0;
        $lostCount = 0;
        $foundCount = 0;
        $locationStats = [];
        $categoryStats = [];
        $monthlyActivity = [];

        foreach ($posts as $post) {
            // Count resolved
            if (isset($post->status) && $post->status == 'resolved') {
                $resolvedPosts++;
            }

            // Count Lost vs Found
            if ($post->type == 'Lost') {
                $lostCount++;
            } else {
                $foundCount++;
            }

            // Count by location
            if (isset($post->location_name)) {
                $loc = $post->location_name;
                if (!isset($locationStats[$loc])) {
                    $locationStats[$loc] = 0;
                }
                $locationStats[$loc]++;
            }

            // Count by category
            if (isset($post->category_name)) {
                $cat = $post->category_name;
                if (!isset($categoryStats[$cat])) {
                    $categoryStats[$cat] = 0;
                }
                $categoryStats[$cat]++;
            }

            // Monthly activity
            $month = date('Y-m', strtotime($post->created_at));
            if (!isset($monthlyActivity[$month])) {
                $monthlyActivity[$month] = 0;
            }
            $monthlyActivity[$month]++;
        }

        // Calculate success rate
        $successRate = $totalPosts > 0 ? round(($resolvedPosts / $totalPosts) * 100, 1) : 0;

        // Format location stats for chart
        $locationStatsFormatted = [];
        foreach ($locationStats as $location => $count) {
            $locationStatsFormatted[] = (object) ['location' => $location, 'count' => $count];
        }

        // Format category stats for chart
        $categoryStatsFormatted = [];
        foreach ($categoryStats as $category => $count) {
            $categoryStatsFormatted[] = (object) ['category' => $category, 'count' => $count];
        }

        // Format monthly activity
        $monthlyActivityFormatted = [];
        foreach ($monthlyActivity as $month => $count) {
            $monthlyActivityFormatted[] = (object) ['month' => $month, 'count' => $count];
        }

        $data = [
            'user' => $user,
            'posts' => $posts,
            'claims' => $claims,
            'stats' => [
                'total_posts' => $totalPosts,
                'resolved_items' => $resolvedPosts,
                'success_rate' => $successRate,
                'lost_vs_found' => [
                    'lost' => $lostCount,
                    'found' => $foundCount
                ],
                'location_stats' => $locationStatsFormatted,
                'item_categories' => $categoryStatsFormatted,
                'monthly_activity' => $monthlyActivityFormatted
            ]
        ];

        $this->view('users/profile', $data);
    }

    // Settings/Edit Profile
    public function settings()
    {
        // Check if logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'id' => $userId,
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user' => $user,
                'name_err' => '',
                'phone_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'avatar_err' => ''
            ];

            // Validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter your name';
            }

            // Validate phone
            if (!empty($data['phone'])) {
                if (!preg_match('/^[0-9]{10,20}$/', $data['phone'])) {
                    $data['phone_err'] = 'Phone number must be 10-20 digits';
                }
            }

            // Validate avatar upload
            $avatarFilename = null;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['avatar']['name'];
                $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $filesize = $_FILES['avatar']['size'];

                if (!in_array($filetype, $allowed)) {
                    $data['avatar_err'] = 'Only JPG, PNG and GIF files allowed';
                } elseif ($filesize > 2097152) { // 2MB
                    $data['avatar_err'] = 'File size must be less than 2MB';
                } else {
                    // Generate unique filename
                    $avatarFilename = uniqid('avatar_', true) . '.' . $filetype;
                }
            }

            // Validate password (if provided)
            if (!empty($data['password'])) {
                if (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }

                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // If no errors, update user
            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['avatar_err'])) {
                $updateData = [
                    'id' => $userId,
                    'name' => $data['name']
                ];

                // Add phone if provided
                if (!empty($data['phone'])) {
                    $updateData['phone'] = $data['phone'];
                }

                // Add password if provided
                if (!empty($data['password'])) {
                    $updateData['password'] = $data['password'];
                }

                // Handle avatar upload
                if ($avatarFilename) {
                    $uploadDir = 'public/uploads/avatars/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $avatarFilename)) {
                        // Delete old avatar
                        if (!empty($user->avatar) && file_exists($uploadDir . $user->avatar)) {
                            unlink($uploadDir . $user->avatar);
                        }
                        $updateData['avatar'] = $avatarFilename;
                    }
                }

                if ($this->userModel->updateUser($updateData)) {
                    // Update session name if changed
                    $_SESSION['user_name'] = $data['name'];

                    // Update session avatar if changed
                    if (isset($updateData['avatar'])) {
                        $_SESSION['user_avatar'] = $updateData['avatar'];
                    }

                    flash('profile_message', 'Profile updated successfully!', 'alert-success');
                    redirect('users/profile');
                } else {
                    $data['name_err'] = 'Something went wrong. Please try again.';
                    $this->view('users/settings', $data);
                }
            } else {
                $this->view('users/settings', $data);
            }
        } else {
            // GET request - show form
            $data = [
                'user' => $user,
                'name_err' => '',
                'phone_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'avatar_err' => ''
            ];

            $this->view('users/settings', $data);
        }
    }

    // Download User Profile as PDF
    public function downloadPDF()
    {
        // Check if logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        $stats = $this->userModel->getUserStats($userId);
        $postModel = $this->model('Post');
        $posts = $postModel->getPostsByUserId($userId);

        // Output HTML formatted for printing to PDF
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <title>User Profile - <?php echo htmlspecialchars($user->name); ?></title>
            <style>
                @media print {
                    body {
                        margin: 0;
                    }
                }

                body {
                    font-family: Arial, sans-serif;
                    margin: 40px;
                }

                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 3px solid #1976D2;
                    padding-bottom: 20px;
                }

                .section {
                    margin-bottom: 25px;
                    page-break-inside: avoid;
                }

                .stat-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr 1fr;
                    gap: 15px;
                    margin: 20px 0;
                }

                .stat-box {
                    border: 2px solid #ddd;
                    padding: 15px;
                    border-radius: 8px;
                    text-align: center;
                }

                .stat-value {
                    font-size: 32px;
                    font-weight: bold;
                    color: #1976D2;
                }

                .stat-label {
                    color: #666;
                    margin-top: 5px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }

                th,
                td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }

                th {
                    background: #1976D2;
                    color: white;
                }

                h2 {
                    color: #1976D2;
                    border-bottom: 2px solid #1976D2;
                    padding-bottom: 8px;
                }

                .footer {
                    margin-top: 40px;
                    text-align: center;
                    color: #999;
                    font-size: 12px;
                }
            </style>
        </head>

        <body>
            <div class="header">
                <h1><?php echo htmlspecialchars($user->name); ?>'s Profile</h1>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
                <?php if (!empty($user->phone)): ?>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user->phone); ?></p>
                <?php endif; ?>
                <p><strong>Member Since:</strong> <?php echo date('F d, Y', strtotime($user->created_at ?? 'now')); ?></p>
            </div>

            <div class="section">
                <h2>📊 Performance Statistics</h2>
                <div class="stat-grid">
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $stats['total_posts']; ?></div>
                        <div class="stat-label">Total Posts</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $stats['success_rate']; ?>%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $stats['resolved_items']; ?></div>
                        <div class="stat-label">Items Returned</div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>📈 Activity Summary</h2>
                <table>
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Lost Items Reported</td>
                        <td><?php echo $stats['lost_vs_found']['lost']; ?></td>
                    </tr>
                    <tr>
                        <td>Found Items Reported</td>
                        <td><?php echo $stats['lost_vs_found']['found']; ?></td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <h2>📝 Recent Posts (Last 5)</h2>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    <?php
                    $recentPosts = array_slice($posts, 0, 5);
                    foreach ($recentPosts as $post):
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post->title); ?></td>
                            <td><?php echo htmlspecialchars($post->type); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($post->status)); ?></td>
                            <td><?php echo date('M d, Y', strtotime($post->created_at)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentPosts)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999;">No posts yet</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="footer">
                <p>Generated on <?php echo date('F d, Y \a\t H:i:s'); ?> | DIU Smart Lost & Found System</p>
            </div>
        </body>
        <script>
            // Auto-trigger print dialog for PDF generation
            window.onload = function () {
                window.print();
                setTimeout(function () {
                    window.close();
                }, 500);
            };
        </script>

        </html>
        <?php
        exit;
    }
}
