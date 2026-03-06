<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Breadcrumb Navigation -->
<div
    style="background: var(--md-sys-color-surface-variant); padding: 16px 0; border-bottom: 1px solid var(--md-sys-color-outline-variant);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div
            style="display: flex; align-items: center; gap: 8px; color: var(--md-sys-color-on-surface-variant); font-size: 14px;">
            <a href="<?php echo URLROOT; ?>"
                style="color: var(--md-sys-color-primary); text-decoration: none; transition: color 0.2s;">
                <i class="fa-solid fa-home"></i> Home
            </a>
            <i class="fa-solid fa-chevron-right" style="font-size: 12px;"></i>
            <span style="color: var(--md-sys-color-on-surface-variant);">Features</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 12px;"></i>
            <span style="color: var(--md-sys-color-on-surface); font-weight: 500;">
                <?php echo $data['feature']['title']; ?>
            </span>
        </div>
    </div>
</div>

<!-- Hero Section -->
<div
    style="background: <?php echo $data['feature']['bg_color']; ?>; padding: 80px 0; text-align: center; animation: fadeIn 0.6s ease-out;">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        <!-- Large Icon -->
        <div
            style="width: 120px; height: 120px; margin: 0 auto 24px; border-radius: 50%; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
            <i class="<?php echo $data['feature']['icon']; ?>"
                style="font-size: 64px; color: <?php echo $data['feature']['color']; ?>;"></i>
        </div>

        <!-- Title -->
        <h1 class="headline-large"
            style="color: <?php echo $data['feature']['color']; ?>; font-weight: 700; margin-bottom: 16px; font-size: 48px;">
            <?php echo $data['feature']['title']; ?>
        </h1>

        <!-- Short Intro -->
        <p class="body-large"
            style="color: var(--md-sys-color-on-surface); max-width: 700px; margin: 0 auto; font-size: 20px; line-height: 1.6;">
            <?php echo $data['feature']['short_intro']; ?>
        </p>
    </div>
</div>

<!-- Main Content -->
<div style="max-width: 900px; margin: -40px auto 60px; padding: 0 20px;">

    <!-- Introduction Card -->
    <div class="md-card" style="padding: 40px; margin-bottom: 24px; animation: slideUp 0.6s ease-out 0.1s backwards;">
        <p class="body-large"
            style="line-height: 1.8; margin: 0; color: var(--md-sys-color-on-surface); font-size: 18px;">
            <?php echo $data['feature']['description']; ?>
        </p>
    </div>

    <!-- Feature Sections -->
    <?php
    $delay = 0.2;
    foreach ($data['feature']['sections'] as $section):
        ?>
        <div class="md-card"
            style="padding: 40px; margin-bottom: 24px; animation: slideUp 0.6s ease-out <?php echo $delay; ?>s backwards;">
            <h2 class="title-large"
                style="color: <?php echo $data['feature']['color']; ?>; font-weight: 600; margin-bottom: 16px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-check-circle" style="font-size: 24px;"></i>
                <?php echo $section['heading']; ?>
            </h2>
            <p class="body-large"
                style="line-height: 1.8; margin: 0; color: var(--md-sys-color-on-surface-variant); font-size: 17px;">
                <?php echo $section['content']; ?>
            </p>
        </div>
        <?php
        $delay += 0.1;
    endforeach;
    ?>

    <!-- Key Benefits Card -->
    <div class="md-card"
        style="padding: 40px; margin-bottom: 24px; background: linear-gradient(135deg, <?php echo $data['feature']['bg_color']; ?>, var(--md-sys-color-surface)); animation: slideUp 0.6s ease-out <?php echo $delay; ?>s backwards;">
        <h2 class="title-large"
            style="color: <?php echo $data['feature']['color']; ?>; font-weight: 600; margin-bottom: 24px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-star" style="font-size: 24px;"></i>
            Key Benefits
        </h2>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <?php foreach ($data['feature']['benefits'] as $benefit): ?>
                <li
                    style="padding: 12px 0; display: flex; align-items: start; gap: 12px; border-bottom: 1px solid var(--md-sys-color-outline-variant);">
                    <i class="fa-solid fa-circle-check"
                        style="color: <?php echo $data['feature']['color']; ?>; font-size: 20px; margin-top: 2px; flex-shrink: 0;"></i>
                    <span class="body-large"
                        style="color: var(--md-sys-color-on-surface); line-height: 1.6; font-size: 16px;">
                        <?php echo $benefit; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- CTA Card -->
    <div class="md-card"
        style="padding: 48px; text-align: center; background: linear-gradient(135deg, var(--md-sys-color-primary-container), var(--md-sys-color-tertiary-container)); animation: slideUp 0.6s ease-out <?php echo $delay + 0.1; ?>s backwards;">
        <h3 class="title-large"
            style="margin-bottom: 16px; color: var(--md-sys-color-on-primary-container); font-size: 24px;">
            Ready to Experience This Feature?
        </h3>
        <p class="body-large"
            style="margin-bottom: 32px; color: var(--md-sys-color-on-primary-container); max-width: 600px; margin-left: auto; margin-right: auto;">
            Join DIU Find today and start experiencing all these amazing features that make finding lost items easier
            than ever.
        </p>
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?php echo URLROOT; ?>/posts" class="md-button md-button-filled"
                    style="padding: 14px 32px; font-size: 16px;">
                    <i class="fa-solid fa-home" style="margin-right: 8px;"></i>
                    Go to Community Feed
                </a>
                <a href="<?php echo URLROOT; ?>/posts/add" class="md-button md-button-tonal"
                    style="padding: 14px 32px; font-size: 16px;">
                    <i class="fa-solid fa-plus" style="margin-right: 8px;"></i>
                    Report an Item
                </a>
            <?php else: ?>
                <a href="<?php echo URLROOT; ?>/users/register" class="md-button md-button-filled"
                    style="padding: 14px 32px; font-size: 16px;">
                    <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i>
                    Create Free Account
                </a>
                <a href="<?php echo URLROOT; ?>/users/login" class="md-button md-button-outlined"
                    style="padding: 14px 32px; font-size: 16px; background: white;">
                    <i class="fa-solid fa-sign-in" style="margin-right: 8px;"></i>
                    Sign In
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Back to Home -->
    <div style="text-align: center; margin-top: 32px; animation: fadeIn 0.6s ease-out 0.8s backwards;">
        <a href="<?php echo URLROOT; ?>" class="md-button md-button-text" style="padding: 12px 24px;">
            <i class="fa-solid fa-arrow-left" style="margin-right: 8px;"></i>
            Back to Homepage
        </a>
    </div>
</div>

<!-- Animations -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        h1.headline-large {
            font-size: 36px !important;
        }

        .md-card {
            padding: 24px !important;
        }

        div[style*="padding: 80px"] {
            padding: 48px 0 !important;
        }
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>