<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Leaderboard Hero Section -->
<div
    style="background: linear-gradient(135deg, #FFD700, #FFA500, #FF6347); padding: 60px 0; position: relative; overflow: hidden;">
    <div class="container"
        style="max-width: 1200px; margin: 0 auto; text-align: center; padding: 0 20px; position: relative; z-index: 2;">
        <div style="display: inline-flex; align-items: center; gap: 16px; margin-bottom: 16px;">
            <i class="fa-solid fa-trophy" style="font-size: 48px; color: white; animation: bounce 2s infinite;"></i>
            <h1
                style="margin: 0; font-size: 42px; font-weight: 700; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                Hall of Fame
            </h1>
        </div>
        <p class="headline-medium" style="color: white; margin-bottom: 8px; font-weight: 500;">
            🏆 Top Honest Finders of DIU 🏆
        </p>
        <p class="body-large" style="color: rgba(255,255,255,0.95); max-width: 700px; margin: 0 auto;">
            Celebrating our community heroes who help reunite lost items with their owners
        </p>
    </div>

    <!-- Decorative elements -->
    <div
        style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; border-radius: 50%; background: rgba(255,255,255,0.1); z-index: 1;">
    </div>
    <div
        style="position: absolute; bottom: -100px; left: -100px; width: 400px; height: 400px; border-radius: 50%; background: rgba(255,255,255,0.1); z-index: 1;">
    </div>
</div>

<!-- Leaderboard Content -->
<div style="max-width: 1000px; margin: -40px auto 60px; padding: 0 20px; position: relative; z-index: 3;">

    <?php if (empty($data['topUsers'])): ?>
        <!-- No Users Yet -->
        <div class="md-card" style="padding: 60px 20px; text-align: center;">
            <i class="fa-solid fa-trophy"
                style="font-size: 64px; color: var(--md-sys-color-outline); margin-bottom: 20px;"></i>
            <h3 class="title-large" style="color: var(--md-sys-color-on-surface-variant); margin-bottom: 12px;">
                No Heroes Yet
            </h3>
            <p class="body-large" style="color: var(--md-sys-color-on-surface-variant); margin: 0;">
                Be the first to earn Honesty Points by helping return lost items!
            </p>
        </div>
    <?php else: ?>
        <!-- Leaderboard Table -->
        <div class="md-card" style="padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr
                            style="background: linear-gradient(135deg, var(--md-sys-color-primary), var(--md-sys-color-tertiary));">
                            <th
                                style="padding: 20px 16px; text-align: center; color: white; font-weight: 600; width: 80px;">
                                Rank</th>
                            <th style="padding: 20px 16px; text-align: left; color: white; font-weight: 600;">User</th>
                            <th
                                style="padding: 20px 16px; text-align: center; color: white; font-weight: 600; width: 150px;">
                                Points</th>
                            <th
                                style="padding: 20px 16px; text-align: center; color: white; font-weight: 600; width: 200px;">
                                Badge</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1;
                        foreach ($data['topUsers'] as $user):
                            // Determine background for top 3
                            $rowStyle = '';
                            if ($rank == 1) {
                                $rowStyle = 'background: linear-gradient(90deg, #FFF9E6, #FFFFFF);';
                            } elseif ($rank == 2) {
                                $rowStyle = 'background: linear-gradient(90deg, #F5F5F5, #FFFFFF);';
                            } elseif ($rank == 3) {
                                $rowStyle = 'background: linear-gradient(90deg, #FFF3E0, #FFFFFF);';
                            }

                            // Determine badge
                            $badge = '';
                            $badgeColor = '';
                            if ($rank == 1) {
                                $badge = '🥇 Gold Champion';
                                $badgeColor = '#FFD700';
                            } elseif ($rank == 2) {
                                $badge = '🥈 Silver Guardian';
                                $badgeColor = '#C0C0C0';
                            } elseif ($rank == 3) {
                                $badge = '🥉 Bronze Hero';
                                $badgeColor = '#CD7F32';
                            } else {
                                $badge = '⭐ Active Scout';
                                $badgeColor = '#42A5F5';
                            }
                            ?>
                            <tr style="<?php echo $rowStyle; ?> border-bottom: 1px solid var(--md-sys-color-outline-variant); transition: all 0.3s;"
                                onmouseover="this.style.transform='scale(1.01)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)';"
                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">

                                <!-- Rank -->
                                <td style="padding: 20px 16px; text-align: center;">
                                    <div
                                        style="width: 50px; height: 50px; margin: 0 auto; border-radius: 50%; background: <?php echo $badgeColor; ?>; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                        <?php echo $rank; ?>
                                    </div>
                                </td>

                                <!-- User Info -->
                                <td style="padding: 20px 16px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if (!empty($user->avatar)): ?>
                                            <img src="<?php echo URLROOT; ?>/public/uploads/avatars/<?php echo $user->avatar; ?>"
                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 3px solid <?php echo $badgeColor; ?>;"
                                                alt="<?php echo htmlspecialchars($user->name); ?>">
                                        <?php else: ?>
                                            <div
                                                style="width: 50px; height: 50px; border-radius: 50%; background: var(--md-sys-color-primary-container); display: flex; align-items: center; justify-content: center; border: 3px solid <?php echo $badgeColor; ?>; font-weight: 600; font-size: 20px; color: var(--md-sys-color-primary);">
                                                <?php echo strtoupper(substr($user->name, 0, 1)); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div
                                                style="font-size: 16px; font-weight: 600; color: var(--md-sys-color-on-surface); margin-bottom: 2px;">
                                                <?php echo htmlspecialchars($user->name); ?>
                                            </div>
                                            <div style="font-size: 13px; color: var(--md-sys-color-on-surface-variant);">
                                                <?php echo ucfirst($user->role); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Points -->
                                <td style="padding: 20px 16px; text-align: center;">
                                    <div
                                        style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px; background: <?php echo $badgeColor; ?>; border-radius: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        <i class="fa-solid fa-star" style="font-size: 18px; color: white;"></i>
                                        <span style="font-size: 20px; font-weight: 700; color: white;">
                                            <?php echo number_format($user->points); ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Badge -->
                                <td style="padding: 20px 16px; text-align: center;">
                                    <div
                                        style="padding: 8px 16px; background: <?php echo $badgeColor; ?>; color: white; border-radius: 20px; font-weight: 600; font-size: 14px; display: inline-block; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        <?php echo $badge; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $rank++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Motivational CTA -->
        <div
            style="margin-top: 40px; text-align: center; padding: 40px 20px; background: linear-gradient(135deg, var(--md-sys-color-primary-container), var(--md-sys-color-tertiary-container)); border-radius: 16px;">
            <h3 class="title-large" style="margin-bottom: 12px; color: var(--md-sys-color-primary);">
                🌟 Want to be on the leaderboard?
            </h3>
            <p class="body-large"
                style="color: var(--md-sys-color-on-primary-container); margin-bottom: 24px; max-width: 600px; margin-left: auto; margin-right: auto;">
                Help return lost items to their owners and earn 10 Honesty Points for each successful return!
            </p>
            <a href="<?php echo URLROOT; ?>/posts" class="md-button md-button-filled" style="padding: 12px 32px;">
                <i class="fa-solid fa-search" style="margin-right: 8px;"></i> Browse Lost Items
            </a>
        </div>
    <?php endif; ?>
</div>

<style>
    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @media (max-width: 768px) {

        table th,
        table td {
            padding: 12px 8px !important;
            font-size: 14px !important;
        }

        div[style*="font-size: 42px"] {
            font-size: 32px !important;
        }
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>