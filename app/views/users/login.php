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
            <?php csrfField(); ?>
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
                        value="<?php echo Security::h($data['email'] ?? ''); ?>" required>
                </div>
                <?php if (!empty($data['email_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo Security::h($data['email_err']); ?>
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
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo Security::h($data['password_err']); ?>
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