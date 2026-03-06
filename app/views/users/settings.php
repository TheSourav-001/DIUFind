<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="margin-bottom: 32px;">
        <h1 class="headline-large" style="color: var(--md-sys-color-primary); margin-bottom: 8px;">
            <i class="fa-solid fa-user-cog" style="margin-right: 12px;"></i> Edit Profile
        </h1>
        <p class="body-large" style="color: var(--md-sys-color-on-surface-variant);">
            Update your personal information and account settings
        </p>
    </div>

    <?php flash('profile_message'); ?>

    <!-- Settings Form Card -->
    <div class="md-card" style="padding: 32px;">
        <form action="<?php echo URLROOT; ?>/users/settings" method="POST" enctype="multipart/form-data">

            <!-- Name Field -->
            <div style="margin-bottom: 24px;">
                <label class="label-large"
                    style="display: block; margin-bottom: 8px; color: var(--md-sys-color-on-surface);">
                    Full Name <span style="color: var(--md-sys-color-error);">*</span>
                </label>
                <div class="md-text-field">
                    <input type="text" name="name"
                        class="md-input <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" placeholder=" "
                        value="<?php echo $data['user']->name; ?>" required>
                    <label class="md-label">Enter your full name</label>
                </div>
                <?php if (!empty($data['name_err'])): ?>
                    <span style="color: var(--md-sys-color-error); font-size: 14px; margin-top: 4px; display: block;">
                        <?php echo $data['name_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Email Field (Read-only) -->
            <div style="margin-bottom: 24px;">
                <label class="label-large"
                    style="display: block; margin-bottom: 8px; color: var(--md-sys-color-on-surface);">
                    Email Address
                </label>
                <div class="md-text-field">
                    <input type="email" name="email_display" class="md-input"
                        value="<?php echo $data['user']->email; ?>" readonly
                        style="background: var(--md-sys-color-surface-variant); cursor: not-allowed;">
                    <label class="md-label">Email cannot be changed</label>
                </div>
                <span
                    style="color: var(--md-sys-color-on-surface-variant); font-size: 13px; margin-top: 4px; display: block;">
                    <i class="fa-solid fa-info-circle"></i> For security reasons, email addresses cannot be modified
                </span>
            </div>

            <!-- Phone Field -->
            <div style="margin-bottom: 24px;">
                <label class="label-large"
                    style="display: block; margin-bottom: 8px; color: var(--md-sys-color-on-surface);">
                    Phone Number
                </label>
                <div class="md-text-field">
                    <input type="tel" name="phone"
                        class="md-input <?php echo (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>" placeholder=" "
                        value="<?php echo $data['user']->phone ?? ''; ?>">
                    <label class="md-label">10-20 digit phone number</label>
                </div>
                <?php if (!empty($data['phone_err'])): ?>
                    <span style="color: var(--md-sys-color-error); font-size: 14px; margin-top: 4px; display: block;">
                        <?php echo $data['phone_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Avatar/Profile Picture Upload -->
            <div style="margin-bottom: 24px;">
                <label class="label-large"
                    style="display: block; margin-bottom: 8px; color: var(--md-sys-color-on-surface);">
                    Profile Picture
                </label>

                <!-- Current Avatar Preview -->
                <?php if (!empty($data['user']->avatar)): ?>
                    <div style="margin-bottom: 12px; text-align: center;">
                        <img src="<?php echo URLROOT; ?>/public/uploads/avatars/<?php echo $data['user']->avatar; ?>"
                            alt="Current Avatar"
                            style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; box-shadow: var(--md-sys-elevation-2);">
                        <p class="body-small" style="margin-top: 8px; color: var(--md-sys-color-on-surface-variant);">
                            Current picture</p>
                    </div>
                <?php endif; ?>

                <input type="file" name="avatar" accept="image/*" class="md-input"
                    style="padding: 12px; border: 1px solid var(--md-sys-color-outline); border-radius: 8px;">
                <span
                    style="color: var(--md-sys-color-on-surface-variant); font-size: 13px; margin-top: 4px; display: block;">
                    <i class="fa-solid fa-image"></i> JPG, PNG, or GIF (max 2MB)
                </span>
                <?php if (!empty($data['avatar_err'])): ?>
                    <span style="color: var(--md-sys-color-error); font-size: 14px; margin-top: 4px; display: block;">
                        <?php echo $data['avatar_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <hr style="border: none; border-top: 1px solid var(--md-sys-color-outline-variant); margin: 32px 0;">

            <h3 class="title-large" style="margin-bottom: 16px; color: var(--md-sys-color-on-surface);">
                Change Password
            </h3>
            <p class="body-medium" style="color: var(--md-sys-color-on-surface-variant); margin-bottom: 20px;">
                Leave blank if you don't want to change your password
            </p>

            <!-- New Password -->
            <div style="margin-bottom: 24px;">
                <label class="label-large"
                    style="display: block; margin-bottom: 8px; color: var(--md-sys-color-on-surface);">
                    New Password
                </label>
                <div class="md-text-field">
                    <input type="password" name="password"
                        class="md-input <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                        placeholder=" ">
                    <label class="md-label">At least 6 characters</label>
                </div>
                <?php if (!empty($data['password_err'])): ?>
                    <span style="color: var(--md-sys-color-error); font-size: 14px; margin-top: 4px; display: block;">
                        <?php echo $data['password_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div style="margin-bottom: 32px;">
                <label class="label-large"
                    style="display: block; margin-bottom: 8px; color: var(--md-sys-color-on-surface);">
                    Confirm Password
                </label>
                <div class="md-text-field">
                    <input type="password" name="confirm_password"
                        class="md-input <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>"
                        placeholder=" ">
                    <label class="md-label">Re-enter your password</label>
                </div>
                <?php if (!empty($data['confirm_password_err'])): ?>
                    <span style="color: var(--md-sys-color-error); font-size: 14px; margin-top: 4px; display: block;">
                        <?php echo $data['confirm_password_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap;">
                <a href="<?php echo URLROOT; ?>/users/profile" class="md-button md-button-outlined">
                    <i class="fa-solid fa-times" style="margin-right: 8px;"></i> Cancel
                </a>
                <button type="submit" class="md-button md-button-filled">
                    <i class="fa-solid fa-save" style="margin-right: 8px;"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Info Card -->
    <div class="md-card" style="padding: 20px; margin-top: 24px; background: var(--md-sys-color-tertiary-container);">
        <div style="display: flex; gap: 12px; align-items: start;">
            <i class="fa-solid fa-shield-check"
                style="font-size: 24px; color: var(--md-sys-color-tertiary); margin-top: 4px;"></i>
            <div>
                <h4 class="title-medium" style="margin-bottom: 4px; color: var(--md-sys-color-on-tertiary-container);">
                    Your data is secure
                </h4>
                <p class="body-medium" style="color: var(--md-sys-color-on-tertiary-container); margin: 0;">
                    All passwords are encrypted using industry-standard security practices. Your personal information is
                    never shared with third parties.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .md-text-field input:read-only {
        opacity: 0.6;
    }

    @media (max-width: 768px) {
        .container {
            padding: 12px !important;
        }

        .md-card {
            padding: 20px !important;
        }

        div[style*="flex"] {
            flex-direction: column !important;
        }

        div[style*="flex"]>* {
            width: 100%;
        }
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>