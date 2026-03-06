<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Custom CSS for Premium Profile -->
<style>
    body {
        background-color: #f8faff; /* Ultra light cool gray/blue background */
    }

    /* Container & Layout */
    .container.profile-layout {
        max-width: 1240px;
        margin: 40px auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 32px;
        align-items: start;
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Glass Cards */
    .glass-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
    }
    
    .glass-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.03), 0 4px 6px -2px rgba(0, 0, 0, 0.01);
    }

    /* Sticker Sidebar */
    .profile-sidebar {
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Profile Header Styling within Card */
    .profile-header-bg {
        height: 140px;
        background: linear-gradient(135deg, var(--md-sys-color-primary) 0%, #3b82f6 50%, #8b5cf6 100%);
        position: relative;
    }

    .avatar-wrapper {
        width: 128px;
        height: 128px;
        border-radius: 50%;
        border: 5px solid white;
        background: white;
        position: absolute;
        bottom: -64px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        z-index: 10;
        overflow: hidden;
    }

    .avatar-wrapper img, .avatar-wrapper .avatar-placeholder {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        font-weight: 700;
        background: linear-gradient(135deg, #cbd5e1, #94a3b8);
    }

    /* Typography */
    .text-slate-900 { color: #0f172a; }
    .text-slate-500 { color: #64748b; }
    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    
    /* Stats Row - Clean Micro Dashboard */
    .mini-stats {
        display: flex;
        justify-content: center;
        gap: 32px;
        padding: 24px 0;
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
    }

    .mini-stat-item {
        text-align: center;
    }
    .mini-stat-val { font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.2; }
    .mini-stat-label { font-size: 11px; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px; font-weight: 600; }

    /* Main Analytics Cards */
    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    .charts-grid-2x2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        padding-top: 16px;
    }

    .chart-box {
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 280px;
    }

    .chart-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (max-width: 992px) {
        .analytics-grid { grid-template-columns: 1fr; }
        .charts-grid-2x2 { grid-template-columns: 1fr; }
    }

    .stat-box {
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
    }

    .icon-square {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    /* List Items (Posts & Claims) */
    .list-item-card {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
        display: flex;
        gap: 20px;
    }
    .list-item-card:last-child { border-bottom: none; }
    .list-item-card:hover { background: #fafcff; }

    /* Responsive */
    @media (max-width: 992px) {
        .container.profile-layout {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .profile-sidebar { position: relative; top: 0; }
    }
</style>

<div class="container profile-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="profile-sidebar">
        <!-- Main Profile Card -->
        <article class="glass-card">
            <!-- Header Background -->
            <div class="profile-header-bg">
                <div class="avatar-wrapper">
                    <?php if (!empty($data['user']->avatar)): ?>
                            <img src="<?php echo URLROOT; ?>/public/uploads/avatars/<?php echo $data['user']->avatar; ?>" alt="<?php echo $data['user']->name; ?>">
                    <?php else: ?>
                            <div class="avatar-placeholder">
                                <?php echo strtoupper(substr($data['user']->name, 0, 1)); ?>
                            </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- User Details -->
            <div style="padding: 72px 24px 24px; text-align: center;">
                <h1 class="text-slate-900 font-bold" style="font-size: 24px; margin: 0 0 4px;"><?php echo $data['user']->name; ?></h1>
                
                <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: #f0f9ff; border-radius: 20px; color: #0ea5e9; font-size: 13px; font-weight: 600;">
                    <i class="fa-solid fa-shield-cat" style="font-size: 12px;"></i>
                    <?php echo ucfirst($data['user']->role ?? 'Verified Member'); ?>
                </div>

                <div style="margin-top: 24px; text-align: left; display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div style="width: 40px; height: 40px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Email</div>
                            <div style="font-size: 14px; color: #334155; font-weight: 500; word-break: break-all;"><?php echo $data['user']->email; ?></div>
                        </div>
                    </div>

                    <?php if (!empty($data['user']->phone)): ?>
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <div style="width: 40px; height: 40px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Phone</div>
                                <div style="font-size: 14px; color: #334155; font-weight: 500;"><?php echo $data['user']->phone; ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div style="width: 40px; height: 40px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Joined</div>
                            <div style="font-size: 14px; color: #334155; font-weight: 500;"><?php echo date('M Y', strtotime($data['user']->created_at)); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Mini Stats -->
                <div class="mini-stats">
                    <div class="mini-stat-item">
                        <div class="mini-stat-val"><?php echo count($data['posts']); ?></div>
                        <div class="mini-stat-label">Total Posts</div>
                    </div>
                    <div class="mini-stat-item">
                        <div class="mini-stat-val" style="color: #059669;"><?php echo $data['user']->trust_score ?? 0; ?></div>
                        <div class="mini-stat-label">Trust Score</div>
                    </div>
                </div>

                <!-- Actions -->
                <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 12px;">
                    <a href="<?php echo URLROOT; ?>/users/settings" class="md-button md-button-tonal" style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-gear" style="margin-right: 8px;"></i> Edit Profile
                    </a>
                    <a href="<?php echo URLROOT; ?>/users/downloadPDF" class="md-button md-button-outlined" style="width: 100%; justify-content: center; color: #ef4444; border-color: #fecaca;">
                        <i class="fa-solid fa-cloud-arrow-down" style="margin-right: 8px;"></i> Download Data
                    </a>
                </div>
            </div>
        </article>
    </aside>


    <!-- RIGHT MAIN CONTENT -->
    <main>
        <?php flash('profile_message'); ?>

        <div style="margin-bottom: 32px;">
            <h2 class="text-slate-900" style="font-size: 22px; font-weight: 800; margin-bottom: 16px;">Analytics Overview</h2>
            
            <div class="analytics-grid">
                <!-- Posts Card -->
                <div class="glass-card stat-box">
                    <div class="icon-square" style="background: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="text-slate-500" style="font-size: 13px; font-weight: 600;">ACTIVE POSTS</div>
                        <div class="text-slate-900" style="font-size: 28px; font-weight: 800;"><?php echo $data['stats']['total_posts']; ?></div>
                    </div>
                </div>

                <!-- Rate Card -->
                <div class="glass-card stat-box">
                    <div class="icon-square" style="background: #f0fdf4; color: #16a34a;">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="text-slate-500" style="font-size: 13px; font-weight: 600;">SUCCESS RATE</div>
                        <div class="text-slate-900" style="font-size: 28px; font-weight: 800;"><?php echo $data['stats']['success_rate']; ?>%</div>
                    </div>
                </div>

                <!-- Returned Card -->
                <div class="glass-card stat-box">
                    <div class="icon-square" style="background: #faf5ff; color: #9333ea;">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <div class="text-slate-500" style="font-size: 13px; font-weight: 600;">ITEMS RETURNED</div>
                        <div class="text-slate-900" style="font-size: 28px; font-weight: 800;"><?php echo $data['stats']['resolved_items']; ?></div>
                    </div>
                </div>
            </div>

            <!-- Charts Container -->
            <div class="glass-card" style="padding: 32px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px;">
                    <h3 class="text-slate-900" style="font-size: 18px; font-weight: 800; margin: 0;">Activity Insights</h3>
                    <select style="border: 1px solid #e2e8f0; background: white; font-size: 12px; color: #475569; padding: 6px 12px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        <option>Last 6 Months</option>
                    </select>
                </div>

                <div class="charts-grid-2x2">
                    <!-- Quadrant 1: Activity Trend -->
                    <div class="chart-box">
                        <h4 class="chart-title"><i class="fa-solid fa-arrow-trend-up" style="color: #8b5cf6;"></i> Activity Trend (6 Months)</h4>
                        <div style="flex: 1; position: relative;">
                            <canvas id="myActivityChart"></canvas>
                        </div>
                    </div>

                    <!-- Quadrant 2: Lost vs Found -->
                    <div class="chart-box">
                        <h4 class="chart-title"><i class="fa-solid fa-circle-half-stroke" style="color: #10b981;"></i> Lost vs Found Ratio</h4>
                        <div style="flex: 1; position: relative;">
                            <canvas id="myLostFoundChart"></canvas>
                        </div>
                    </div>

                    <!-- Quadrant 3: Categories -->
                    <div class="chart-box">
                        <h4 class="chart-title"><i class="fa-solid fa-shapes" style="color: #f59e0b;"></i> Item Categories</h4>
                        <div style="flex: 1; position: relative;">
                            <canvas id="myCategoryChart"></canvas>
                        </div>
                    </div>

                    <!-- Quadrant 4: Top Locations -->
                    <div class="chart-box">
                        <h4 class="chart-title"><i class="fa-solid fa-map-location-dot" style="color: #3b82f6;"></i> Top Loss Locations</h4>
                        <div style="flex: 1; position: relative;">
                            <canvas id="myLocationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CLAIMS & REQUESTS -->
        <?php
        $pending_claims = 0;
        $claims_list = isset($data['claims']) ? $data['claims'] : [];
        foreach ($claims_list as $c)
            if ($c->status == 'pending')
                $pending_claims++;
        ?>
        <div style="margin-bottom: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h2 class="text-slate-900" style="font-size: 20px; font-weight: 800;">Claim Requests</h2>
                <?php if ($pending_claims > 0): ?>
                        <span style="background: #fff7ed; color: #f97316; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 12px; border: 1px solid #ffedd5;">
                            <?php echo $pending_claims; ?> NEW REQUESTS
                        </span>
                <?php endif; ?>
            </div>

            <div class="glass-card">
                <?php if (!empty($claims_list)): ?>
                        <div style="display: flex; flex-direction: column;">
                            <?php foreach ($claims_list as $claim): ?>
                                    <div class="list-item-card">
                                        <!-- Avatar -->
                                        <div style="flex-shrink: 0; width: 48px; height: 48px;">
                                            <?php if (!empty($claim->claimer_avatar)): ?>
                                                    <img src="<?php echo URLROOT; ?>/public/uploads/avatars/<?php echo $claim->claimer_avatar; ?>" style="width: 100%; height: 100%; border-radius: 12px; object-fit: cover;">
                                            <?php else: ?>
                                                    <div style="width: 100%; height: 100%; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #64748b; font-size: 18px;">
                                                        <?php echo strtoupper(substr($claim->claimer_name, 0, 1)); ?>
                                                    </div>
                                            <?php endif; ?>
                                        </div>
                                
                                        <!-- Content -->
                                        <div style="flex: 1;">
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;"><?php echo htmlspecialchars($claim->claimer_name); ?></h4>
                                                <span style="font-size: 12px; font-weight: 500; color: #94a3b8;"><?php echo date('M d, h:i a', strtotime($claim->created_at)); ?></span>
                                            </div>
                                            <p style="margin: 0 0 10px; font-size: 14px; color: #475569;">
                                                Requested to claim <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $claim->post_id; ?>" style="color: var(--md-sys-color-primary); font-weight: 600; text-decoration: none;"><?php echo htmlspecialchars($claim->post_title); ?></a>
                                            </p>
                                    
                                            <?php if (!empty($claim->message)): ?>
                                                    <div style="background: #f8fafc; padding: 12px; border-radius: 8px; font-size: 13px; color: #334155; margin-bottom: 12px; border: 1px solid #e2e8f0; font-style: italic;">
                                                        "<?php echo htmlspecialchars($claim->message); ?>"
                                                    </div>
                                            <?php endif; ?>

                                            <!-- Action Bar -->
                                            <div style="display: flex; gap: 10px;">
                                                <?php if ($claim->status == 'pending'): ?>
                                                        <button onclick="approveClaim(<?php echo $claim->id; ?>)" class="md-button md-button-filled" style="height: 32px; font-size: 12px; background: #10b981; border-radius: 8px;">
                                                            <i class="fa-solid fa-check" style="margin-right: 6px;"></i> Approve
                                                        </button>
                                                        <button onclick="rejectClaim(<?php echo $claim->id; ?>)" class="md-button md-button-outlined" style="height: 32px; font-size: 12px; color: #ef4444; border-color: #ef4444; border-radius: 8px;">
                                                            Reject
                                                        </button>
                                                        <button onclick="escalateClaim(<?php echo $claim->id; ?>)" class="md-button md-button-text" style="height: 32px; font-size: 12px; color: #f59e0b;">
                                                            Escalate
                                                        </button>
                                                <?php else: ?>
                                                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #f1f5f9; border-radius: 6px; color: #64748b; font-size: 12px; font-weight: 600;">
                                                            <?php echo $claim->status == 'accepted' ? '<i class="fa-solid fa-check-circle" style="color: #10b981;"></i> Approved' : '<i class="fa-solid fa-circle-xmark" style="color: #ef4444;"></i> ' . ucfirst($claim->status); ?>
                                                        </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                <?php else: ?>
                        <div style="text-align: center; padding: 48px; color: #94a3b8;">
                            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <i class="fa-solid fa-inbox" style="font-size: 24px; opacity: 0.5;"></i>
                            </div>
                            <p style="font-size: 14px; margin: 0;">No claim requests pending.</p>
                        </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- MY POSTS -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h2 class="text-slate-900" style="font-size: 20px; font-weight: 800;">My Listings</h2>
                <a href="<?php echo URLROOT; ?>/posts/add" class="md-button md-button-filled" style="height: 36px; padding: 0 16px; font-size: 13px; border-radius: 10px;">
                    <i class="fa-solid fa-plus" style="margin-right: 6px;"></i> New Post
                </a>
            </div>

            <div class="glass-card">
                <?php if (!empty($data['posts'])): ?>
                        <div style="display: flex; flex-direction: column;">
                            <?php foreach ($data['posts'] as $post): ?>
                                    <div class="list-item-card" style="align-items: center;">
                                        <!-- Icon -->
                                        <div style="width: 56px; height: 56px; border-radius: 16px; background: <?php echo $post->type == 'Lost' ? '#fef2f2' : '#f0fdf4'; ?>; display: flex; align-items: center; justify-content: center; font-size: 20px; color: <?php echo $post->type == 'Lost' ? '#ef4444' : '#16a34a'; ?>; flex-shrink: 0;">
                                            <i class="fa-solid <?php echo $post->type == 'Lost' ? 'fa-magnifying-glass' : 'fa-hand-holding-heart'; ?>"></i>
                                        </div>

                                        <!-- Details -->
                                        <div style="flex: 1; min-width: 0;">
                                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                                <span style="font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 6px; text-transform: uppercase; background: <?php echo $post->type == 'Lost' ? '#fee2e2' : '#dcfce7'; ?>; color: <?php echo $post->type == 'Lost' ? '#991b1b' : '#166534'; ?>;">
                                                    <?php echo $post->type; ?>
                                                </span>
                                                <?php if ($post->category_name): ?>
                                                        <span style="font-size: 11px; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 6px;"><?php echo $post->category_name; ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $post->title; ?></h4>
                                            <div style="font-size: 13px; color: #64748b; margin-top: 2px;">
                                                <i class="fa-solid fa-location-dot" style="margin-right: 4px; font-size: 11px;"></i> <?php echo $post->location_name ?? 'Unknown Location'; ?>
                                                <span style="margin: 0 6px; opacity: 0.3;">|</span>
                                                <?php echo timeAgo($post->created_at); ?>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div style="display: flex; gap: 4px;">
                                            <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->id; ?>" class="md-button md-button-text" style="width: 36px; height: 36px; padding: 0; color: #64748b;" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $post->id; ?>" class="md-button md-button-text" style="width: 36px; height: 36px; padding: 0; color: #3b82f6;" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $post->id; ?>" method="POST" style="margin: 0;" onsubmit="return confirm('Delete this post?');">
                                                <button type="submit" class="md-button md-button-text" style="width: 36px; height: 36px; padding: 0; color: #ef4444;" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                <?php else: ?>
                        <div style="padding: 40px; text-align: center;">
                            <p style="color: #64748b; font-size: 14px;">You haven't posted any items yet.</p>
                        </div>
                <?php endif; ?>
            </div>
        </div>

    </main>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    function approveClaim(id) {
        Swal.fire({
            title: 'Approve?',text: 'The claimer will be notified.',icon: 'question',
            showCancelButton: true, confirmButtonText: 'Approve', confirmButtonColor: '#10b981'
        }).then((result) => { if(result.isConfirmed) window.location.href = '<?php echo URLROOT; ?>/claims/approve/' + id; });
    }
    function rejectClaim(id) {
        Swal.fire({
            title: 'Reject?',text: 'This cannot be undone.',icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Reject', confirmButtonColor: '#ef4444'
        }).then((result) => { if(result.isConfirmed) window.location.href = '<?php echo URLROOT; ?>/claims/reject/' + id; });
    }
     function escalateClaim(id) {
        Swal.fire({
            title: 'Escalate?',text: 'Notify admin for review?',icon: 'info',
            showCancelButton: true, confirmButtonText: 'Escalate', confirmButtonColor: '#f59e0b'
        }).then((result) => { if(result.isConfirmed) window.location.href = '<?php echo URLROOT; ?>/claims/escalate/' + id; });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const chartConfig = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } };
        
        // 1. Lost vs Found
        new Chart(document.getElementById('myLostFoundChart'), {
            type: 'doughnut',
            data: {
                labels: ['Lost', 'Found'],
                datasets: [{ 
                    data: [<?php echo $data['stats']['lost_vs_found']['lost']; ?>, <?php echo $data['stats']['lost_vs_found']['found']; ?>],
                    backgroundColor: ['#ef4444', '#10b981'], borderWidth: 0
                }]
            },
            options: { cutout: '65%', plugins: { legend: { display: false } } }
        });

        // 2. Locations
        new Chart(document.getElementById('myLocationChart'), {
            type: 'bar',
            data: {
                labels: [<?php foreach ($data['stats']['location_stats'] as $l)
                    echo "'$l->location',"; ?>],
                datasets: [{ label: 'Items', data: [<?php foreach ($data['stats']['location_stats'] as $l)
                    echo "$l->count,"; ?>], backgroundColor: '#3b82f6', borderRadius: 4 }]
            },
            options: { scales: { x: { display: false }, y: { display: false } }, plugins: { legend: { display: false } } }
        });

        // 3. Categories
        new Chart(document.getElementById('myCategoryChart'), {
            type: 'pie',
            data: {
                labels: [<?php foreach ($data['stats']['item_categories'] as $c)
                    echo "'$c->category',"; ?>],
                datasets: [{ data: [<?php foreach ($data['stats']['item_categories'] as $c)
                    echo "$c->count,"; ?>], backgroundColor: ['#6366f1', '#ec4899', '#f59e0b', '#10b981'] }]
            },
            options: { plugins: { legend: { display: false } } }
        });

        // 4. Activity
        const activityCtx = document.getElementById('myActivityChart');
        if(activityCtx) {
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
                    datasets: [{
                        label: 'Posts',
                        data: [
                            <?php
                            foreach ($data['stats']['monthly_activity'] as $a)
                                echo "$a->count,";
                            if (empty($data['stats']['monthly_activity']))
                                echo "0,0,0,0,0,0";
                            ?>
                        ], 
                        borderColor: '#8b5cf6', tension: 0.4, fill: true, backgroundColor: 'rgba(139, 92, 246, 0.1)'
                    }]
                },
                options: { scales: { y: { display: false }, x: { display: false } }, plugins: { legend: { display: false } } }
            });
        }
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>