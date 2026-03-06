<?php
class Posts extends Controller
{
    private $postModel;
    private $userModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        // Build filters array from GET parameters
        $filters = [
            'search' => isset($_GET['search']) ? trim($_GET['search']) : null,
            'type' => isset($_GET['type']) ? trim($_GET['type']) : null,
            'category' => isset($_GET['category']) ? $_GET['category'] : [],
            'location' => isset($_GET['location']) ? $_GET['location'] : [],
            'date_from' => isset($_GET['date_from']) ? trim($_GET['date_from']) : null,
            'date_to' => isset($_GET['date_to']) ? trim($_GET['date_to']) : null,
            'sort' => isset($_GET['sort']) ? trim($_GET['sort']) : 'newest'
        ];

        // Get filtered posts
        $posts = $this->postModel->getPosts($filters);

        $data = [
            'posts' => $posts,
            'filters' => $filters
        ];

        $this->view('posts/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Handle image upload
            $image_name = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['image']['name'];
                $filetype = $_FILES['image']['type'];
                $filesize = $_FILES['image']['size'];

                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed) && $filesize < 5242880) { // 5MB
                    $image_name = uniqid() . '_' . time() . '.' . $ext;
                    $upload_path = UPLOAD_DIR . $image_name;

                    // Create uploads directory if it doesn't exist
                    if (!file_exists(UPLOAD_DIR)) {
                        mkdir(UPLOAD_DIR, 0777, true);
                    }

                    move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
                }
            }

            $data = [
                'title' => trim($_POST['title']),
                'type' => trim($_POST['type']),
                'body' => trim($_POST['body']),
                'location_id' => trim($_POST['location_id']) ?: null,
                'category_id' => trim($_POST['category_id']) ?: null,
                'image_path' => $image_name,
                'latitude' => !empty($_POST['latitude']) ? trim($_POST['latitude']) : null,
                'longitude' => !empty($_POST['longitude']) ? trim($_POST['longitude']) : null,
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter description';
            }
            // Make sure no errors
            if (empty($data['title_err']) && empty($data['body_err'])) {
                // Add post
                if ($this->postModel->addPost($data)) {
                    // Create notification for user
                    $notificationModel = $this->model('Notification');
                    $notificationModel->create([
                        'user_id' => $_SESSION['user_id'],
                        'actor_id' => $_SESSION['user_id'],
                        'type' => 'post_created',
                        'post_id' => null,
                        'comment_id' => null,
                        'message' => 'You created a new post: "' . substr($data['title'], 0, 50) . '"'
                    ]);

                    flash('post_message', 'Post created successfully');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('posts/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'type' => '',
                'body' => '',
                'title_err' => '',
                'body_err' => ''
            ];

            $this->view('posts/add', $data);
        }
    }

    // Show single post
    public function show($id)
    {
        $post = $this->postModel->getPostById($id);

        if (!$post) {
            redirect('posts');
        }

        $userModel = $this->model('User'); // Assuming userModel is needed for getUserById
        $user = $userModel->getUserById($post->user_id);

        $commentModel = $this->model('Comment');
        $comments = $commentModel->getCommentsByPostId($id);

        // Load reactions
        $reactionModel = $this->model('Reaction');
        $reactions = $reactionModel->getReactions($id);
        $userReaction = null;
        if (isLoggedIn()) {
            $userReactionObj = $reactionModel->getUserReaction($id, $_SESSION['user_id']);
            $userReaction = $userReactionObj ? $userReactionObj->type : null;
        }

        $data = [
            'post' => $post,
            'user' => $user,
            'comments' => $comments,
            'reactions' => $reactions,
            'userReaction' => $userReaction
        ];

        $this->view('posts/show', $data);
    }

    // Edit post
    public function edit($id)
    {
        $post = $this->postModel->getPostById($id);

        // Check ownership
        if ($post->user_id != $_SESSION['user_id']) {
            flash('post_message', 'Unauthorized access', 'alert alert-danger');
            redirect('posts');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'type' => trim($_POST['type']),
                'body' => trim($_POST['body']),
                'location_id' => trim($_POST['location_id']) ?: null,
                'category_id' => trim($_POST['category_id']) ?: null,
                'title_err' => '',
                'body_err' => ''
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter description';
            }

            if (empty($data['title_err']) && empty($data['body_err'])) {
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post updated successfully');
                    redirect('posts/show/' . $id);
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('posts/edit', $data);
            }
        } else {
            $data = [
                'id' => $id,
                'title' => $post->title,
                'type' => $post->type,
                'body' => $post->body,
                'location_id' => $post->location_id,
                'category_id' => $post->category_id,
                'title_err' => '',
                'body_err' => ''
            ];

            $this->view('posts/edit', $data);
        }
    }

    // Delete post
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->postModel->getPostById($id);

            // Check ownership
            if ($post->user_id != $_SESSION['user_id']) {
                flash('post_message', 'Unauthorized access', 'alert alert-danger');
                redirect('posts');
            }

            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('posts');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }

    // Mark post as resolved
    public function resolve($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $post = $this->postModel->getPostById($id);

        // Check ownership
        if ($post->user_id != $_SESSION['user_id']) {
            flash('post_message', 'Unauthorized access', 'alert alert-danger');
            redirect('posts');
        }

        // Update status to resolved
        if ($this->postModel->updateStatus($id, 'resolved')) {
            // Send notification to owner
            // sendNotification($user_id, $message, $link_path, $type, $actor_id, $post_id)
            sendNotification(
                $_SESSION['user_id'],
                '🎉 Post marked as resolved! Great job helping the community.',
                'users/profile',
                'post_resolved',
                $_SESSION['user_id'],
                $id
            );

            // Award points if it's a 'Found' item (Honesty Points)
            if ($post->type == 'Found') {
                // Award +10 points
                $this->userModel->addPoints($_SESSION['user_id'], 10);
                flash('post_message', '🎉 Post resolved! You earned +10 Honesty Points for helping the community!', 'alert alert-success');
            } else {
                flash('post_message', 'Post marked as resolved and removed from feed!', 'alert alert-success');
            }

            redirect('users/profile');
        } else {
            die('Something went wrong');
        }
    }

    // Display interactive campus map
    public function map()
    {
        $data = [
            'title' => 'DIU Campus Map - Live Lost & Found'
        ];

        $this->view('posts/map', $data);
    }

    // AJAX endpoint for map data
    public function getMapData()
    {
        header('Content-Type: application/json');

        // Get all posts with location data
        $posts = $this->postModel->getPostsWithLocation();

        // Format data for map markers
        $mapData = [];
        foreach ($posts as $post) {
            $mapData[] = [
                'id' => $post->id,
                'title' => $post->title,
                'type' => $post->type,
                'latitude' => (float) $post->latitude,
                'longitude' => (float) $post->longitude,
                'image' => $post->image,
                'created_at' => date('M d, Y', strtotime($post->created_at))
            ];
        }

        echo json_encode([
            'success' => true,
            'posts' => $mapData
        ]);
    }

    // === MODERN GREEN CARD PDF DESIGN ===
    public function downloadPoster($id)
    {
        $post = $this->postModel->getPostById($id);
        if (!$post) {
            redirect('posts');
        }
        $userModel = $this->model('User');
        $user = $userModel->getUserById($post->user_id);
        require_once APPROOT . '/libraries/PosterPDF.php';

        $pdf = new PosterPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false);

        // Colors
        $greenPrimary = [26, 77, 46]; // Darker green from image #1A4D2E
        $greenLight = [0, 109, 59];   // Standard green
        $textDark = [33, 37, 41];
        $textGray = [108, 117, 125];
        $bgGray = [245, 247, 250];    // Light gray background

        // === 1. BACKGROUND ===
        $pdf->SetFillColor($bgGray[0], $bgGray[1], $bgGray[2]);
        $pdf->Rect(0, 0, 210, 297, 'F');

        // === 2. HEADER ===
        // Full width green header
        $pdf->SetFillColor($greenPrimary[0], $greenPrimary[1], $greenPrimary[2]);
        $pdf->Rect(0, 0, 210, 40, 'F');

        // Diagonal stripes pattern (Top Right)
        $pdf->SetDrawColor(255, 255, 255); // White lines
        $pdf->SetLineWidth(0.5);

        // Drawing diagonal lines
        for ($i = 0; $i < 20; $i++) {
            $xStart = 160 + ($i * 4);
            $yStart = 0;
            $xEnd = 160 + ($i * 4) + 20; // Slant
            $yEnd = 40;

            if ($xStart < 210) {
                $pdf->Line($xStart, $yStart, $xEnd, $yEnd);
            }
        }

        // "LOST ITEM" / "FOUND ITEM" Text
        $statusText = ($post->type == 'Lost') ? 'LOST ITEM' : 'FOUND ITEM';
        $pdf->SetXY(20, 12);
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, $statusText, 0, 1, 'L');

        // === 3. WHITE CARD BODY ===
        // Main content container (White rounded rect with shadow effect simulated)

        // Shadow (offset gray rect)
        $pdf->SetFillColor(230, 230, 230);
        $pdf->RoundedRect(16, 51, 178, 214, 3, 'F'); // Increased height to 214

        // Main white rect
        $pdf->SetFillColor(255, 255, 255);
        $pdf->RoundedRect(15, 50, 178, 214, 3, 'F'); // Increased height to 214

        // === 4. REPORTED BY & LOGO ===
        $yPos = 65;

        // Reported By Section
        $pdf->SetXY(25, $yPos);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor($textGray[0], $textGray[1], $textGray[2]);
        $pdf->Cell(100, 5, "Reported By:", 0, 1);

        $pdf->SetXY(25, $yPos + 6);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor($textDark[0], $textDark[1], $textDark[2]);
        $pdf->Cell(100, 8, $this->decodeText($user->name ?: 'Anonymous'), 0, 1);

        $pdf->SetXY(25, $yPos + 15);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor($textGray[0], $textGray[1], $textGray[2]);
        if (!empty($user->phone)) {
            $pdf->Cell(100, 5, $user->phone, 0, 1);
        }
        $pdf->SetX(25);
        $pdf->Cell(100, 5, $user->email, 0, 1);

        // Logo (Top Right of Card)
        $logoPath = dirname(APPROOT) . '/public/img/logo.png';
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 140, $yPos, 40);
        }

        // === 5. ITEM DETAILS TABLE ===
        $tableY = 100;

        // Header Row
        $pdf->SetFillColor($greenPrimary[0], $greenPrimary[1], $greenPrimary[2]);
        $pdf->Rect(25, $tableY, 158, 10, 'F');

        $pdf->SetXY(25, $tableY + 2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(20, 6, "Qty", 0, 0, 'C');
        $pdf->Cell(78, 6, "Item Description", 0, 0, 'L');
        $pdf->Cell(35, 6, "Category", 0, 0, 'C');
        $pdf->Cell(25, 6, "Location", 0, 1, 'C');

        // Data Row
        $rowY = $tableY + 10;
        $pdf->SetFillColor(245, 245, 245); // Light gray row
        $pdf->Rect(25, $rowY, 158, 80, 'F'); // Taller row (80mm) for larger image

        $pdf->SetXY(25, $rowY + 5);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor($textDark[0], $textDark[1], $textDark[2]);
        $pdf->Cell(20, 6, "1", 0, 0, 'C');

        // Title & Description
        $pdf->SetXY(45, $rowY + 5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(78, 6, $this->decodeText($post->title), 0, 1, 'L');

        $pdf->SetXY(45, $rowY + 12);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor($textGray[0], $textGray[1], $textGray[2]);
        $pdf->MultiCell(78, 5, $this->decodeText(substr($post->body, 0, 100)), 0, 'L');

        // Category
        $pdf->SetXY(123, $rowY + 5);
        $pdf->SetTextColor($textDark[0], $textDark[1], $textDark[2]);
        $pdf->Cell(35, 6, $this->decodeText($post->category_name), 0, 0, 'C');

        // Location
        $pdf->SetXY(158, $rowY + 5);
        $pdf->Cell(25, 6, $this->decodeText($post->location_name), 0, 1, 'C');

        // Image centered under description text
        if (!empty($post->image_path)) {
            $imagePath = UPLOAD_DIR . $post->image_path;
            if (file_exists($imagePath)) {
                $imgY = $rowY + 25; // Moved up slightly

                // Get original dimensions
                list($origW, $origH) = getimagesize($imagePath);

                // Target box dimensions
                $maxWidth = 75; // Increased width
                $maxHeight = 50; // Increased height

                // Scale logic
                $ratio = min($maxWidth / $origW, $maxHeight / $origH);
                $newW = $origW * $ratio;
                $newH = $origH * $ratio;

                // Centering inside description area 
                $newX = 45 + (78 - $newW) / 2;
                $newY = $imgY; // Top align in image area

                $pdf->Image($imagePath, $newX, $newY, $newW, $newH);
            }
        }

        // Lines separating columns
        $pdf->SetDrawColor(220, 220, 220);
        $pdf->Line(45, $tableY, 45, $rowY + 80); // Extended (80)
        $pdf->Line(123, $tableY, 123, $rowY + 80); // Extended (80)
        $pdf->Line(158, $tableY, 158, $rowY + 80); // Extended (80)

        // === 6. BOTTOM CARDS ===
        $bottomY = 195; // Pushed down due to taller table

        // LEFT: Terms Box
        $pdf->SetDrawColor(230, 230, 230);
        $pdf->RoundedRect(25, $bottomY, 85, 65, 2, 'D'); // Width reduced to 85

        $pdf->SetXY(30, $bottomY + 5);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor($greenPrimary[0], $greenPrimary[1], $greenPrimary[2]);
        $pdf->Cell(80, 6, "Terms & Instructions", 0, 1);

        $pdf->SetXY(30, $bottomY + 12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($textGray[0], $textGray[1], $textGray[2]);
        $pdf->MultiCell(80, 4, "This is an official lost & found report generated by DIU Find system. If you have information about this item, please contact the reporter or campus security immediately.", 0, 'L');

        // QR Code
        $qrY = $bottomY + 35;
        $postUrl = URLROOT . '/posts/show/' . $id;
        $chartUrl = "https://quickchart.io/qr?text=" . urlencode($postUrl) . "&size=300&ecLevel=H&margin=1&format=png";
        $tmpQrFile = sys_get_temp_dir() . '/qr_' . $id . '.png';
        $qrContent = @file_get_contents($chartUrl);
        if ($qrContent) {
            file_put_contents($tmpQrFile, $qrContent);
            $pdf->Image($tmpQrFile, 30, $qrY - 2, 25, 25);
            unlink($tmpQrFile);
        }

        $pdf->SetXY(30, $qrY + 24);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($textDark[0], $textDark[1], $textDark[2]);
        $pdf->Cell(25, 4, "Scan for Details", 0, 0, 'C');

        // Campus Security (Right of QR)
        $pdf->SetXY(60, $qrY);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor($greenPrimary[0], $greenPrimary[1], $greenPrimary[2]);
        $pdf->Cell(50, 5, "Campus Security", 0, 1);
        $pdf->SetXY(60, $qrY + 6);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor($textDark[0], $textDark[1], $textDark[2]);
        $pdf->Cell(50, 4, "Help Line:", 0, 1);
        $pdf->SetXY(60, $qrY + 11);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($textGray[0], $textGray[1], $textGray[2]);
        $pdf->Cell(50, 4, "+880 1671901212", 0, 1);
        $pdf->SetX(60);
        $pdf->Cell(50, 4, "+880 9617910233", 0, 1);


        // RIGHT: Status Card (Dark Top, Light Bottom)
        $statusX = 115; // Shifted Left to align with Main Card right edge (193)
        $statusW = 78;

        // Top Box (Dark)
        $pdf->SetFillColor($greenPrimary[0], $greenPrimary[1], $greenPrimary[2]);
        $pdf->Rect($statusX, $bottomY, $statusW, 35, 'F');

        // Status Text
        $pdf->SetXY($statusX, $bottomY + 8);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(200, 200, 200); // Light gray text
        $pdf->Cell($statusW - 5, 5, "Status:", 0, 1, 'R');

        $pdf->SetXY($statusX, $bottomY + 14);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell($statusW - 5, 10, "ACTIVE", 0, 1, 'R');

        // Separator line inside
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->SetLineWidth(0.2);
        $pdf->Line($statusX + 5, $bottomY + 28, $statusX + $statusW - 5, $bottomY + 28);

        // ID
        $pdf->SetXY($statusX, $bottomY + 30);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($statusW, 5, "ID: " . uniqid(), 0, 1, 'C');

        // Bottom Box (Light)
        $pdf->SetFillColor(245, 245, 245);
        $pdf->Rect($statusX, $bottomY + 35, $statusW, 30, 'F');
        // Border around whole thing
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Rect($statusX, $bottomY, $statusW, 65, 'D');

        // Invoice Details
        $pdf->SetXY($statusX, $bottomY + 42);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor($textDark[0], $textDark[1], $textDark[2]);
        $pdf->Cell($statusW - 5, 6, "No: #" . str_pad($post->id, 5, '0', STR_PAD_LEFT), 0, 1, 'R');

        $pdf->SetXY($statusX, $bottomY + 49);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor($textGray[0], $textGray[1], $textGray[2]);
        $pdf->Cell($statusW - 5, 5, "Date: " . date('d F Y', strtotime($post->created_at)), 0, 1, 'R');

        // === 7. FOOTER ===
        // Large Dark Footer
        $pdf->SetFillColor($greenPrimary[0], $greenPrimary[1], $greenPrimary[2]);
        $pdf->Rect(0, 270, 210, 27, 'F'); // Taller footer

        $pdf->SetXY(0, 275);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(210, 6, "DIU Find - Official Lost & Found Portal for Daffodil International University", 0, 1, 'C');

        $pdf->SetXY(0, 283);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(200, 200, 200);
        $pdf->Cell(210, 5, "Developed by Sourav Dipto Apu", 0, 1, 'C');

        $pdf->Output('D', 'DIU_Find_' . $post->type . '_' . $id . '.pdf');
    }

    // Helper to handle text encoding for FPDF (supports basic Latin-1)
    private function decodeText($text)
    {
        return iconv('UTF-8', 'windows-1252', $text);
    }
}