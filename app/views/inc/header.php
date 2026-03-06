<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - DIU Smart City</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animation Library (AOS) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">

    <style>
        /* Header Specific Overrides */
        .nav-active-indicator {
            position: absolute;
            bottom: -2px;
            left: 0;
            height: 2px;
            background: var(--primary-500);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .user-dropdown-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            animation: slideDownFade 0.3s ease forwards;
            transform-origin: top right;
        }

        @keyframes slideDownFade {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>

<body>
    <!-- Full-Screen Loader -->
    <div id="loader-wrapper">
        <div class="loader-content">
            <div class="loader-logo"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="spinner"></div>
            <h2 class="loader-title">DIU Find</h2>
            <p class="loader-subtitle">Connecting Community...</p>
            <div class="loader-dots"><span></span><span></span><span></span></div>
        </div>
    </div>

    <!-- Premium Glass Header -->
    <header class="md-top-app-bar">
        <div class="container"
            style="display: flex; align-items: center; justify-content: space-between; height: 100%;">
            <!-- Brand -->
            <a href="<?php echo URLROOT; ?>"
                style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <div
                    style="width: 40px; height: 40px; background: var(--primary-gradient); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-gradient"
                    style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 24px;">DIU Find</span>
            </a>

            <!-- Navigation -->
            <?php if (isset($_SESSION['user_id'])):
                $current_url = $_SERVER['REQUEST_URI'];
                ?>
                <nav style="display: flex; gap: 4px; background: rgba(0,0,0,0.03); padding: 4px; border-radius: 50px;"
                    class="hidden-mobile">
                    <a href="<?php echo URLROOT; ?>"
                        class="nav-link-premium <?php echo strpos($current_url, '/pages/index') !== false || $current_url == '/DIUfind/' || $current_url == '/DIUfind/public/' ? 'active' : ''; ?>"
                        style="border-radius: 50px; padding: 10px 24px;">
                        Home
                    </a>
                    <a href="<?php echo URLROOT; ?>/posts"
                        class="nav-link-premium <?php echo strpos($current_url, '/posts') !== false && strpos($current_url, '/map') === false ? 'active' : ''; ?>"
                        style="border-radius: 50px; padding: 10px 24px;">
                        Feed
                    </a>
                    <a href="<?php echo URLROOT; ?>/posts/map"
                        class="nav-link-premium <?php echo strpos($current_url, '/map') !== false ? 'active' : ''; ?>"
                        style="border-radius: 50px; padding: 10px 24px;">
                        <i class="fa-solid fa-map-location-dot" style="margin-right: 6px;"></i> Campus Map
                    </a>
                </nav>

                <!-- User Actions -->
                <div style="display: flex; align-items: center; gap: 16px;">
                    <!-- Notifications -->
                    <div style="position: relative;">
                        <button id="notification-btn"
                            style="width: 44px; height: 44px; border-radius: 50%; border: none; background: white; color: var(--text-secondary); cursor: pointer; transition: all 0.2s; box-shadow: var(--shadow-sm); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-bell" style="font-size: 20px;"></i>
                            <span id="notification-badge"
                                style="display: none; position: absolute; top: 0; right: 0; background: #EF4444; color: white; width: 18px; height: 18px; border-radius: 50%; font-size: 10px; font-weight: 700; align-items: center; justify-content: center; border: 2px solid white;"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notification-dropdown" class="user-dropdown-glass"
                            style="display: none; position: absolute; top: 120%; right: -20px; width: 380px; z-index: 1000; overflow: hidden;">
                            <div
                                style="padding: 16px 20px; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.5);">
                                <h3 style="margin: 0; font-size: 16px; font-weight: 700;">Notifications</h3>
                                <button id="mark-all-read-btn"
                                    style="background: none; border: none; font-size: 12px; color: var(--primary-500); font-weight: 700; cursor: pointer;">
                                    Mark all read
                                </button>
                            </div>
                            <div id="notification-list" style="max-height: 400px; overflow-y: auto;">
                                <div style="padding: 40px; text-align: center; color: #aaa;">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile -->
                    <a href="<?php echo URLROOT; ?>/users/profile"
                        style="display: flex; align-items: center; gap: 10px; padding: 4px 16px 4px 4px; background: white; border-radius: 50px; box-shadow: var(--shadow-sm); transition: all 0.2s;"
                        class="hover-scale">
                        <div
                            style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-100); color: var(--primary-600); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; overflow: hidden; border: 2px solid white;">
                            <?php if (!empty($_SESSION['user_avatar']) && file_exists(dirname(APPROOT) . '/public/uploads/avatars/' . $_SESSION['user_avatar'])): ?>
                                <img src="<?php echo URLROOT; ?>/uploads/avatars/<?php echo $_SESSION['user_avatar']; ?>"
                                    alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fa-solid fa-user"></i>
                            <?php endif; ?>
                        </div>
                        <span
                            style="font-weight: 600; font-size: 14px; color: var(--text-main); margin-right: 4px;"><?php echo explode(' ', $_SESSION['user_name'])[0]; ?></span>
                    </a>

                    <a href="<?php echo URLROOT; ?>/users/logout" class="btn-outline"
                        style="padding: 8px 20px; font-size: 14px; border-width: 1.5px; border-radius: 50px;">
                        Logout
                    </a>
                </div>
            <?php else: ?>
                <div style="display: flex; gap: 16px;">
                    <a href="<?php echo URLROOT; ?>/users/login" class="btn-outline"
                        style="border: none; padding: 10px 24px;">
                        Sign In
                    </a>
                    <a href="<?php echo URLROOT; ?>/users/register" class="btn-primary"
                        style="padding: 10px 24px; font-size: 14px;">
                        Get Started
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main>