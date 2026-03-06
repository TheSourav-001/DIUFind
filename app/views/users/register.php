<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container" style="display: flex; justify-content: center; align-items: center;  padding: 60px 20px;">
    <div class="glass-card" style="width: 100%; max-width: 550px; padding: 40px; border-radius: 24px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <div
                style="width: 60px; height: 60px; background: var(--primary-100); color: var(--primary-600); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 8px;">Create Account</h1>
            <p style="color: var(--text-secondary);">Join the DIU community to report and find items</p>
        </div>

        <form action="<?php echo URLROOT; ?>/users/register" method="POST">
            <!-- Name -->
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">Full
                    Name <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <i class="fa-solid fa-user"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="text" name="name"
                        class="input-premium <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>"
                        style="padding-left: 48px;" placeholder="John Doe" value="<?php echo $data['name']; ?>"
                        required>
                </div>
                <?php if (!empty($data['name_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $data['name_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

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

            <!-- Phone -->
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">Phone
                    Number <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <i class="fa-solid fa-phone"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="tel" name="phone"
                        class="input-premium <?php echo (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>"
                        style="padding-left: 48px;" placeholder="01XXXXXXXXX" value="<?php echo $data['phone']; ?>"
                        required>
                </div>
                <?php if (!empty($data['phone_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $data['phone_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Role -->
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">I
                    am a <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <i class="fa-solid fa-id-badge"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <select name="role" class="input-premium"
                        style="padding-left: 48px; appearance: none; cursor: pointer;" required>
                        <option value="">Select Your Role</option>
                        <option value="student" <?php echo ($data['role'] == 'student') ? 'selected' : ''; ?>>Student
                        </option>
                        <option value="faculty" <?php echo ($data['role'] == 'faculty') ? 'selected' : ''; ?>>Faculty
                            Member</option>
                        <option value="staff" <?php echo ($data['role'] == 'staff') ? 'selected' : ''; ?>>Staff/Employee
                        </option>
                    </select>
                    <i class="fa-solid fa-chevron-down"
                        style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light); pointer-events: none;"></i>
                </div>
                <?php if (!empty($data['role_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $data['role_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">Password
                    <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <i class="fa-solid fa-lock"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="password" name="password"
                        class="input-premium <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                        style="padding-left: 48px;" placeholder="Min 6 characters" required>
                </div>
                <?php if (!empty($data['password_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $data['password_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div style="margin-bottom: 24px;">
                <label
                    style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">Confirm
                    Password <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <i class="fa-solid fa-lock"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="password" name="confirm_password"
                        class="input-premium <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>"
                        style="padding-left: 48px;" placeholder="Re-enter password" required>
                </div>
                <?php if (!empty($data['confirm_password_err'])): ?>
                    <span style="display: block; font-size: 12px; color: #ef4444; margin-top: 6px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $data['confirm_password_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-premium btn-primary" style="width: 100%;">
                <i class="fa-solid fa-rocket"></i> Create Account
            </button>
        </form>

        <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid rgba(0,0,0,0.05);">
            <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 8px;">Already have an account?</p>
            <a href="<?php echo URLROOT; ?>/users/login" style="color: var(--primary-600); font-weight: 700;">Login</a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<div class="container" style="max-width: 500px; margin-top: var(--md-sys-spacing-5);">
    <div class="md-card" style="padding: var(--md-sys-spacing-3);">
        <h1 class="headline-medium" style="margin-bottom: 8px;">Create Account</h1>
        <p class="body-large"
            style="color: var(--md-sys-color-on-surface-variant); margin-bottom: var(--md-sys-spacing-3);">
            Join the DIU community to report and find lost items
        </p>

        <form action="<?php echo URLROOT; ?>/users/register" method="POST">
            <!-- Name -->
            <div class="md-text-field">
                <input type="text" name="name"
                    class="md-input <?php echo (!empty($data['name_err'])) ? 'error' : ''; ?>" placeholder=" "
                    value="<?php echo $data['name']; ?>" required>
                <label class="md-label">Full Name *</label>
                <?php if (!empty($data['name_err'])): ?>
                    <span class="md-error-text"><?php echo $data['name_err']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="md-text-field">
                <input type="email" name="email"
                    class="md-input <?php echo (!empty($data['email_err'])) ? 'error' : ''; ?>" placeholder=" "
                    value="<?php echo $data['email']; ?>" required>
                <label class="md-label">DIU Email (@diu.edu.bd) *</label>
                <?php if (!empty($data['email_err'])): ?>
                    <span class="md-error-text"><?php echo $data['email_err']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Phone Number -->
            <div class="md-text-field">
                <input type="tel" name="phone"
                    class="md-input <?php echo (!empty($data['phone_err'])) ? 'error' : ''; ?>" placeholder=" "
                    value="<?php echo $data['phone']; ?>" required>
                <label class="md-label">Phone Number (01XXXXXXXXX) *</label>
                <?php if (!empty($data['phone_err'])): ?>
                    <span class="md-error-text"><?php echo $data['phone_err']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Role -->
            <div class="md-text-field">
                <select name="role" class="md-select" required>
                    <option value="">Select Your Role</option>
                    <option value="student" <?php echo ($data['role'] == 'student') ? 'selected' : ''; ?>>Student</option>
                    <option value="faculty" <?php echo ($data['role'] == 'faculty') ? 'selected' : ''; ?>>Faculty Member
                    </option>
                    <option value="staff" <?php echo ($data['role'] == 'staff') ? 'selected' : ''; ?>>Staff/Employee
                    </option>
                </select>
                <label class="md-label">I am a *</label>
                <?php if (!empty($data['role_err'])): ?>
                    <span class="md-error-text"><?php echo $data['role_err']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="md-text-field">
                <input type="password" name="password"
                    class="md-input <?php echo (!empty($data['password_err'])) ? 'error' : ''; ?>" placeholder=" "
                    required>
                <label class="md-label">Password (min 6 characters) *</label>
                <?php if (!empty($data['password_err'])): ?>
                    <span class="md-error-text"><?php echo $data['password_err']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="md-text-field">
                <input type="password" name="confirm_password"
                    class="md-input <?php echo (!empty($data['confirm_password_err'])) ? 'error' : ''; ?>"
                    placeholder=" " required>
                <label class="md-label">Confirm Password *</label>
                <?php if (!empty($data['confirm_password_err'])): ?>
                    <span class="md-error-text"><?php echo $data['confirm_password_err']; ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="md-button md-button-filled"
                style="width: 100%; height: 48px; margin-top: var(--md-sys-spacing-2);">
                Create Account
            </button>
        </form>

        <div class="text-center" style="margin-top: var(--md-sys-spacing-3);">
            <span class="body-large">Already have an account? </span>
            <a href="<?php echo URLROOT; ?>/users/login"
                style="color: var(--md-sys-color-primary); text-decoration: none; font-weight: 500;">Login</a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>