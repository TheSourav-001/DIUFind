<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Hero Section (Premium Gradient + Glass) -->
<div style="position: relative; overflow: hidden; padding: 120px 0 80px;">
    <!-- Animated Background Blobs -->
    <div
        style="position: absolute; top: -10%; left: -10%; width: 50%; height: 50%; background: radial-gradient(circle, rgba(0,109,59,0.1) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; filter: blur(50px); animation: float 6s ease-in-out infinite;">
    </div>
    <div
        style="position: absolute; bottom: 10%; right: -5%; width: 40%; height: 40%; background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; filter: blur(50px); animation: float 8s ease-in-out infinite reverse;">
    </div>

    <div class="container" style="position: relative; z-index: 2; text-align: center;">
        <div data-aos="zoom-in" data-aos-duration="1000">
            <div
                style="display: inline-flex; align-items: center; gap: 10px; padding: 8px 24px; background: white; border-radius: 50px; box-shadow: var(--shadow-sm); margin-bottom: 24px; border: 1px solid rgba(0,0,0,0.04);">
                <span
                    style="width: 8px; height: 8px; background: #22C55E; border-radius: 50%; display: inline-block;"></span>
                <span
                    style="font-size: 14px; font-weight: 600; color: var(--primary-600); letter-spacing: 0.5px; text-transform: uppercase;">Smart
                    Lost & Found System</span>
            </div>

            <h1
                style="font-size: 56px; font-weight: 800; line-height: 1.1; margin-bottom: 24px; letter-spacing: -1.5px;">
                Find What Matters, <br>
                <span class="text-gradient">Connect The Campus</span>
            </h1>

            <p
                style="font-size: 20px; color: var(--text-secondary); max-width: 650px; margin: 0 auto 40px; line-height: 1.6;">
                The official AI-powered platform for Daffodil International University to securely report, track, and
                recover lost items.
            </p>

            <div style="display: flex; gap: 16px; justify-content: center;">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo URLROOT; ?>/posts" class="btn-premium btn-primary">
                        <i class="fa-solid fa-layer-group"></i> Browse Feed
                    </a>
                    <a href="<?php echo URLROOT; ?>/posts/add" class="btn-premium btn-outline" style="background: white;">
                        <i class="fa-solid fa-plus-circle"></i> Report Item
                    </a>
                <?php else: ?>
                    <a href="<?php echo URLROOT; ?>/users/register" class="btn-premium btn-primary">
                        <i class="fa-solid fa-rocket"></i> Get Started
                    </a>
                    <a href="<?php echo URLROOT; ?>/users/login" class="btn-premium btn-outline" style="background: white;">
                        <i class="fa-solid fa-key"></i> Sign In
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Stats Bento Grid -->
<div class="container" style="margin-bottom: 80px;">
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(2, auto); gap: 24px;">
        <!-- Large Main Stat -->
        <div class="glass-card" data-aos="fade-up"
            style="grid-column: span 2; grid-row: span 2; padding: 40px; border-radius: 24px; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; background: white;">
            <div
                style="position: absolute; top: 0; right: 0; width: 150px; height: 150px; background: linear-gradient(135deg, var(--primary-100), transparent); border-radius: 0 0 0 100%;">
            </div>
            <div>
                <div
                    style="width: 64px; height: 64px; background: var(--primary-100); color: var(--primary-600); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 24px;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 style="font-size: 48px; font-weight: 800; color: var(--text-main); margin-bottom: 8px;">
                    <?php echo number_format($data['stats']['total_items']); ?>
                </h3>
                <p style="font-size: 18px; color: var(--text-secondary); font-weight: 500;">Total Items Reported</p>
            </div>
            <div
                style="margin-top: 24px; width: 100%; height: 6px; background: var(--surface-off-white); border-radius: 10px; overflow: hidden;">
                <div style="width: 75%; height: 100%; background: var(--primary-gradient); border-radius: 10px;"></div>
            </div>
        </div>

        <!-- Secondary Stats -->
        <div class="glass-card" data-aos="fade-up" data-aos-delay="100"
            style="grid-column: span 1; padding: 32px; border-radius: 24px; background: #F0FDF4; border-color: #DCFCE7;">
            <div style="font-size: 36px; font-weight: 800; color: var(--primary-600); margin-bottom: 4px;">
                <?php echo number_format($data['stats']['items_returned']); ?>
            </div>
            <p style="font-size: 14px; color: var(--primary-700); font-weight: 600;">Recovered Items</p>
            <i class="fa-solid fa-check-circle"
                style="position: absolute; top: 24px; right: 24px; color: var(--primary-300); font-size: 24px;"></i>
        </div>

        <div class="glass-card" data-aos="fade-up" data-aos-delay="200"
            style="grid-column: span 1; padding: 32px; border-radius: 24px; background: #FEFCE8; border-color: #FEF9C3;">
            <div style="font-size: 36px; font-weight: 800; color: #CA8A04; margin-bottom: 4px;">
                <?php echo $data['stats']['success_rate']; ?>%
            </div>
            <p style="font-size: 14px; color: #A16207; font-weight: 600;">Success Rate</p>
            <i class="fa-solid fa-trophy"
                style="position: absolute; top: 24px; right: 24px; color: #FDE047; font-size: 24px;"></i>
        </div>

        <!-- Wide User Stat -->
        <div class="glass-card" data-aos="fade-up" data-aos-delay="300"
            style="grid-column: span 2; padding: 32px; border-radius: 24px; display: flex; align-items: center; justify-content: space-between; background: white;">
            <div>
                <div style="font-size: 36px; font-weight: 800; color: var(--text-main); margin-bottom: 4px;">
                    <?php echo number_format($data['stats']['active_users']); ?>
                </div>
                <p style="font-size: 14px; color: var(--text-secondary); font-weight: 600;">Active Community Members</p>
            </div>
            <div style="display: flex;">
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%; background: #E2E8F0; border: 2px solid white; margin-left: -12px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #64748B;">
                        <?php echo $i < 3 ? '<i class="fa-solid fa-user"></i>' : '+'; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<!-- Top Heroes Section (Horizontal Scroll/Grid) -->
<?php if (!empty($data['top_heroes']) && count($data['top_heroes']) > 0): ?>
    <div class="section-padding" style="background: white;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 40px;">
                <div data-aos="fade-right">
                    <span
                        style="color: var(--primary-500); font-weight: 700; letter-spacing: 1px; text-transform: uppercase; font-size: 12px; display: block; margin-bottom: 8px;">Hall
                        of Fame</span>
                    <h2 class="section-title" style="margin-bottom: 0; font-size: 42px;">Top Heroes</h2>
                </div>
                <a href="<?php echo URLROOT; ?>/pages/leaderboard" class="btn-premium btn-outline" data-aos="fade-left">View
                    All</a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <?php
                $medals = ['🥇', '🥈', '🥉'];
                $colors = ['#FFD700', '#C0C0C0', '#CD7F32'];
                $bgs = ['#FFFBEB', '#F8FAFC', '#FFF7ED'];
                $rank = 0;
                ?>
                <?php foreach ($data['top_heroes'] as $hero): ?>
                    <div class="glass-card" data-aos="zoom-in-up" data-aos-delay="<?php echo $rank * 100; ?>"
                        style="text-align: center; padding: 40px 24px; border-radius: 32px; background: <?php echo $bgs[$rank]; ?>; position: relative;">
                        <div style="position: absolute; top: 20px; left: 20px; font-size: 32px;"><?php echo $medals[$rank]; ?>
                        </div>

                        <div style="margin-bottom: 24px; position: relative; display: inline-block;">
                            <?php if (!empty($hero->avatar)): ?>
                                <img src="<?php echo URLROOT; ?>/public/uploads/avatars/<?php echo $hero->avatar; ?>"
                                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: var(--shadow-md);">
                            <?php else: ?>
                                <div
                                    style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, <?php echo $colors[$rank]; ?>, white); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800; color: white; border: 4px solid white; box-shadow: var(--shadow-md); margin: 0 auto;">
                                    <?php echo strtoupper(substr($hero->name, 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                            <div
                                style="position: absolute; bottom: 0; right: 0; background: <?php echo $colors[$rank]; ?>; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; font-weight: 800; font-size: 14px;">
                                <?php echo $rank + 1; ?>
                            </div>
                        </div>

                        <h3 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            <?php echo htmlspecialchars($hero->name); ?>
                        </h3>
                        <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">Return Champion</p>

                        <div
                            style="background: white; padding: 8px 16px; border-radius: 50px; display: inline-flex; align-items: center; gap: 8px; box-shadow: var(--shadow-sm);">
                            <i class="fa-solid fa-star" style="color: <?php echo $colors[$rank]; ?>;"></i>
                            <span
                                style="font-weight: 700; color: var(--text-main);"><?php echo number_format($hero->points); ?></span>
                            <span style="font-size: 12px; color: var(--text-light); text-transform: uppercase;">pts</span>
                        </div>
                    </div>
                    <?php $rank++;
                    if ($rank >= 3)
                        break; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<!-- Recent Reports Section -->
<div class="section-padding" style="background: rgba(246, 249, 252, 0.5);">
    <div class="container">
        <div style="margin-bottom: 40px; display: flex; align-items: center; gap: 12px;" data-aos="fade-right">
            <div
                style="width: 48px; height: 48px; background: var(--primary-100); color: var(--primary-600); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <h2 style="font-size: 32px; font-weight: 800; color: var(--text-main); margin: 0;">Recent Reports</h2>
                <p style="color: var(--text-secondary); margin: 0;">Stay updated with the latest community activity</p>
            </div>
        </div>

        <div class="glass-card" data-aos="fade-up"
            style="padding: 0; border-radius: 24px; overflow: hidden; border: 1px solid rgba(0,0,0,0.05);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                            <th
                                style="padding: 18px 24px; font-weight: 700; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Title</th>
                            <th
                                style="padding: 18px 24px; font-weight: 700; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Type</th>
                            <th
                                style="padding: 18px 24px; font-weight: 700; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Status</th>
                            <th
                                style="padding: 18px 24px; font-weight: 700; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Location</th>
                            <th
                                style="padding: 18px 24px; font-weight: 700; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Reporter</th>
                            <th
                                style="padding: 18px 24px; font-weight: 700; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['stats']['recent_posts']) && !empty($data['stats']['recent_posts'])): ?>
                            <?php foreach ($data['stats']['recent_posts'] as $post): ?>
                                <tr style="border-bottom: 1px solid #edf2f7; transition: all 0.2s;"
                                    onmouseover="this.style.background='#f8fafc'"
                                    onmouseout="this.style.background='transparent'">
                                    <td style="padding: 18px 24px;">
                                        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->id; ?>"
                                            style="font-weight: 700; color: var(--text-main); font-size: 15px; text-decoration: none;">
                                            <?php echo htmlspecialchars($post->title); ?>
                                        </a>
                                    </td>
                                    <td style="padding: 18px 24px;">
                                        <span
                                            class="md-chip <?php echo $post->type == 'Lost' ? 'md-chip-status-lost' : 'md-chip-status-found'; ?>"
                                            style="font-size: 11px;">
                                            <?php echo $post->type; ?>
                                        </span>
                                    </td>
                                    <td style="padding: 18px 24px;">
                                        <?php if ($post->status == 'resolved'): ?>
                                            <div
                                                style="display: flex; align-items: center; gap: 6px; color: #16A34A; font-weight: 600; font-size: 14px;">
                                                <i class="fa-solid fa-check-circle"></i> Resolved
                                            </div>
                                        <?php else: ?>
                                            <div
                                                style="display: flex; align-items: center; gap: 6px; color: #2563EB; font-weight: 600; font-size: 14px;">
                                                <i class="fa-solid fa-circle-dot" style="font-size: 10px;"></i> Active
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 18px 24px; color: var(--text-secondary); font-size: 14px;">
                                        <i class="fa-solid fa-location-dot" style="margin-right: 6px; opacity: 0.7;"></i>
                                        <?php echo htmlspecialchars($post->location_name); ?>
                                    </td>
                                    <td style="padding: 18px 24px; color: var(--text-main); font-weight: 500; font-size: 14px;">
                                        <?php echo htmlspecialchars($post->user_name); ?>
                                    </td>
                                    <td style="padding: 18px 24px; color: var(--text-light); font-size: 14px;">
                                        <?php echo timeAgo($post->created_at); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-light);">No
                                    recent reports available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div style="padding: 20px; background: #f8fafc; text-align: center; border-top: 1px solid #edf2f7;">
                <a href="<?php echo URLROOT; ?>/posts" class="md-button md-button-text" style="font-weight: 700;">
                    View All Activity <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Dashboard Section -->
<div class="section-padding">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;" data-aos="fade-up">
            <h2 class="section-title">Live Insights</h2>
            <p style="color: var(--text-secondary); max-width: 500px; margin: 0 auto;">Real-time data visualization of
                lost and found trends across the campus.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 32px;">
            <!-- Chart 1 -->
            <div class="glass-card" style="padding: 32px; border-radius: 24px; background: white;" data-aos="fade-up"
                data-aos-delay="0">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 700;">Resolution Ratio</h3>
                    <div
                        style="padding: 4px 12px; background: #F0FDF4; color: #16A34A; font-size: 12px; font-weight: 600; border-radius: 50px;">
                        Real-time</div>
                </div>
                <div style="height: 250px;">
                    <canvas id="lostFoundChart"></canvas>
                </div>
            </div>

            <!-- Chart 2 -->
            <div class="glass-card" style="padding: 32px; border-radius: 24px; background: white;" data-aos="fade-up"
                data-aos-delay="100">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 700;">Hotspot Areas</h3>
                    <i class="fa-solid fa-map-location-dot" style="color: var(--text-light);"></i>
                </div>
                <div style="height: 250px;">
                    <canvas id="locationChart"></canvas>
                </div>
            </div>

            <!-- Chart 3 -->
            <div class="glass-card" style="padding: 32px; border-radius: 24px; background: white;" data-aos="fade-up"
                data-aos-delay="200">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 700;">Item Categories</h3>
                    <i class="fa-solid fa-tags" style="color: var(--text-light);"></i>
                </div>
                <div style="height: 250px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- Chart 4 -->
            <div class="glass-card" style="padding: 32px; border-radius: 24px; background: white;" data-aos="fade-up"
                data-aos-delay="300">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 700;">Contribution</h3>
                    <i class="fa-solid fa-chart-bar" style="color: var(--text-light);"></i>
                </div>
                <div style="height: 250px;">
                    <canvas id="topUsersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="section-padding" style="background: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;" data-aos="fade-up">
            <h2 class="section-title">Why DIU Find?</h2>
            <p style="color: var(--text-secondary);">Advanced features designed for the modern campus.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <!-- Lightning Fast -->
            <a href="<?php echo URLROOT; ?>/features/show/lightning-fast" style="display: block;" data-aos="fade-up"
                data-aos-delay="0">
                <div class="feature-card-premium">
                    <div class="icon-box">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text-main);">
                        Lightning Fast</h3>
                    <p style="color: var(--text-secondary); font-size: 15px;">Instantly report and search items with our
                        optimized engine.</p>
                </div>
            </a>

            <!-- Secure -->
            <a href="<?php echo URLROOT; ?>/features/show/secure-private" style="display: block;" data-aos="fade-up"
                data-aos-delay="100">
                <div class="feature-card-premium">
                    <div class="icon-box">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text-main);">Secure
                        & Private</h3>
                    <p style="color: var(--text-secondary); font-size: 15px;">Your data is encrypted and protected with
                        enterprise security.</p>
                </div>
            </a>

            <!-- AI Powered -->
            <a href="<?php echo URLROOT; ?>/features/show/ai-powered" style="display: block;" data-aos="fade-up"
                data-aos-delay="200">
                <div class="feature-card-premium">
                    <div class="icon-box">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text-main);">AI
                        Powered</h3>
                    <p style="color: var(--text-secondary); font-size: 15px;">Smart matching algorithms automatically
                        connect owners with finders.</p>
                </div>
            </a>

            <!-- Real-time Alerts -->
            <a href="<?php echo URLROOT; ?>/features/show/real-time-alerts" style="display: block;" data-aos="fade-up"
                data-aos-delay="300">
                <div class="feature-card-premium">
                    <div class="icon-box" style="color: #ef4444; background: #fef2f2;">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text-main);">
                        Real-time Alerts</h3>
                    <p style="color: var(--text-secondary); font-size: 15px;">Get notified instantly when matching items
                        are found.</p>
                </div>
            </a>

            <!-- Community -->
            <a href="<?php echo URLROOT; ?>/features/show/community-driven" style="display: block;" data-aos="fade-up"
                data-aos-delay="400">
                <div class="feature-card-premium">
                    <div class="icon-box" style="color: #3b82f6; background: #eff6ff;">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text-main);">
                        Community Driven</h3>
                    <p style="color: var(--text-secondary); font-size: 15px;">Connect and communicate with fellow DIU
                        students and staff.</p>
                </div>
            </a>

            <!-- Mobile Ready -->
            <a href="<?php echo URLROOT; ?>/features/show/mobile-ready" style="display: block;" data-aos="fade-up"
                data-aos-delay="500">
                <div class="feature-card-premium">
                    <div class="icon-box" style="color: #f97316; background: #fff7ed;">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text-main);">Mobile
                        Ready</h3>
                    <p style="color: var(--text-secondary); font-size: 15px;">Access from anywhere on any device with
                        our fully responsive design.</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div
    style="padding: 100px 0; background: var(--primary-700); position: relative; overflow: hidden; text-align: center;">
    <div
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background: url('https://www.transparenttextures.com/patterns/cubes.png');">
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <h2 style="font-size: 42px; color: white; margin-bottom: 24px; font-weight: 800;" data-aos="fade-up">Ready to
            join the community?</h2>
        <p style="color: var(--primary-100); font-size: 18px; max-width: 600px; margin: 0 auto 40px;" data-aos="fade-up"
            data-aos-delay="100">
            Be a part of a safer, more connected campus. Join DIU Find today.
        </p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="<?php echo URLROOT; ?>/users/register" class="btn-premium"
                style="background: white; color: var(--primary-700); padding: 16px 48px; font-size: 18px;"
                data-aos="fade-up" data-aos-delay="200">
                Create Account
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Chart Rendering Scripts (Maintained Logic) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#64748B';

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            scales: {
                y: {
                    grid: { display: false },
                    border: { display: false }
                },
                x: {
                    grid: { display: false },
                    border: { display: false }
                }
            }
        };

        // Chart 1: Lost vs Found (Doughnut)
        const lostFoundCtx = document.getElementById('lostFoundChart').getContext('2d');
        new Chart(lostFoundCtx, {
            type: 'doughnut',
            data: {
                labels: ['Lost Items', 'Found Items'],
                datasets: [{
                    data: [
                        <?php echo $data['stats']['lost_vs_found']['lost']; ?>,
                        <?php echo $data['stats']['lost_vs_found']['found']; ?>
                    ],
                    backgroundColor: ['#EF4444', '#10B981'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: { ...chartOptions, cutout: '75%' }
        });

        // Chart 2: Heatmap (Bar)
        const locationCtx = document.getElementById('locationChart').getContext('2d');
        new Chart(locationCtx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($data['stats']['location_stats'] as $loc): ?>'<?php echo $loc->location; ?>', <?php endforeach; ?>],
                datasets: [{
                    label: 'Reports',
                    data: [<?php foreach ($data['stats']['location_stats'] as $loc): ?><?php echo $loc->count; ?>, <?php endforeach; ?>],
                    backgroundColor: '#3B82F6',
                    borderRadius: 4
                }]
            },
            options: { ...chartOptions, maintainAspectRatio: false }
        });

        // Chart 3: Categories (Pie)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: [<?php foreach ($data['stats']['category_stats'] as $cat): ?>'<?php echo $cat->category; ?>', <?php endforeach; ?>],
                datasets: [{
                    data: [<?php foreach ($data['stats']['category_stats'] as $cat): ?><?php echo $cat->count; ?>, <?php endforeach; ?>],
                    backgroundColor: ['#8B5CF6', '#F59E0B', '#EC4899', '#10B981', '#6366F1'],
                    borderWidth: 0
                }]
            },
            options: chartOptions
        });

        // Chart 4: Top Users (Horizontal Bar)
        const topUsersCtx = document.getElementById('topUsersChart').getContext('2d');
        new Chart(topUsersCtx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($data['stats']['top_users'] as $user): ?>'<?php echo $user->name; ?>', <?php endforeach; ?>],
                datasets: [{
                    label: 'Posts',
                    data: [<?php foreach ($data['stats']['top_users'] as $user): ?><?php echo $user->post_count; ?>, <?php endforeach; ?>],
                    backgroundColor: '#F97316',
                    borderRadius: 4
                }]
            },
            options: { ...chartOptions, indexAxis: 'y' }
        });
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>