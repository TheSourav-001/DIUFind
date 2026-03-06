<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container"
    style="display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 200px); padding: 40px 20px;">
    <?php flash('register_success'); ?>

    <div class="glass-card" style="width: 100%; max-width: 480px; padding: 40px; border-radius: 24px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <div
                style="width: 60px; height: 60px; background: var(--primary-100); color: var(--primary-600); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 8px;">Welcome Back</h1>
            <p style="color: var(--text-secondary);">Access the DIU Lost & Found portal</p>
        </div>

        <form action="<?php echo URLROOT; ?>/users/login" method="POST">
            <!-- Email -->
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">DIU
                    Email <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <i class="fa-solid fa-envelope"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="email" name="email"
                        class="input-premium <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                        style="padding-left: 48px;" placeholder="username@diu.edu.bd"
                        value="<?php echo $data['email']; ?>" required>
                </div>
                <?php if (!empty($data['email_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $data['email_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div style="margin-bottom: 24px;">
                <label
                    style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">Password
                    <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <i class="fa-solid fa-lock"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="password" name="password"
                        class="input-premium <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                        style="padding-left: 48px;" placeholder="••••••••" required>
                </div>
                <?php if (!empty($data['password_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $data['password_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-premium btn-primary" style="width: 100%;">
                <i class="fa-solid fa-right-to-bracket"></i> Login
            </button>
        </form>

        <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid rgba(0,0,0,0.05);">
            <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 8px;">Don't have an account?</p>
            <a href="<?php echo URLROOT; ?>/users/register" style="color: var(--primary-600); font-weight: 700;">Create
                Account</a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<div class="container" style="max-width: 500px; margin-top: var(--md-sys-spacing-5);">
    <?php flash('register_success'); ?>

    <div class="md-card" style="padding: var(--md-sys-spacing-3);">
        <h1 class="headline-medium" style="margin-bottom: 8px;">Login</h1>
        <p class="body-large"
            style="color: var(--md-sys-color-on-surface-variant); margin-bottom: var(--md-sys-spacing-3);">
            Access the DIU Lost & Found portal
        </p>

        <form action="<?php echo URLROOT; ?>/users/login" method="POST">
            <!-- Email -->
            <div class="md-text-field">
                <input type="email" name="email"
                    class="md-input <?php echo (!empty($data['email_err'])) ? 'error' : ''; ?>" placeholder=" "
                    value="<?php echo $data['email']; ?>" required>
                <label class="md-label">DIU Email *</label>
                <?php if (!empty($data['email_err'])): ?>
                    <span class="md-error-text"><?php echo $data['email_err']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="md-text-field">
                <input type="password" name="password"
                    class="md-input <?php echo (!empty($data['password_err'])) ? 'error' : ''; ?>" placeholder=" "
                    required>
                <label class="md-label">Password *</label>
                <?php if (!empty($data['password_err'])): ?>
                    <span class="md-error-text"><?php echo $data['password_err']; ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="md-button md-button-filled"
                style="width: 100%; height: 48px; margin-top: var(--md-sys-spacing-2);">
                Login
            </button>
        </form>

        <div class="text-center" style="margin-top: var(--md-sys-spacing-3);">
            <span class="body-large">Don't have an account? </span>
            <a href="<?php echo URLROOT; ?>/users/register"
                style="color: var(--md-sys-color-primary); text-decoration: none; font-weight: 500;">Register</a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>