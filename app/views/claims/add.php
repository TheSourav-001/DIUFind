<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container" style="max-width: 700px; margin: 40px auto;">
    <div style="margin-bottom: var(--md-sys-spacing-2);">
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->id; ?>"
            class="md-button md-button-outlined">
            <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Back to Post
        </a>
    </div>

    <div class="md-card" style="padding: var(--md-sys-spacing-4);">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: var(--md-sys-spacing-3);">
            <div
                style="width: 80px; height: 80px; margin: 0 auto 12px; border-radius: 50%; background: linear-gradient(135deg, #FF6F00, #FF8F00); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-hand-holding-heart" style="font-size: 40px; color: white;"></i>
            </div>
            <h1 class="headline-large" style="color: var(--md-sys-color-primary); margin-bottom: 8px;">
                Claim This Item
            </h1>
            <p class="body-large" style="color: var(--md-sys-color-on-surface-variant); margin: 0;">
                Submitting a claim for: <strong>
                    <?php echo $data['post']->title; ?>
                </strong>
            </p>
        </div>

        <!-- Info Box -->
        <div
            style="padding: 16px; background: var(--md-sys-color-primary-container); border-radius: 12px; margin-bottom: var(--md-sys-spacing-3); border-left: 4px solid var(--md-sys-color-primary);">
            <h3 class="title-medium" style="color: var(--md-sys-color-on-primary-container); margin-bottom: 8px;">
                <i class="fa-solid fa-info-circle" style="margin-right: 8px;"></i>
                Before You Claim
            </h3>
            <ul style="color: var(--md-sys-color-on-primary-container); margin: 0; padding-left: 20px;">
                <li>Be honest and provide accurate information</li>
                <li>Describe how you can prove this item is yours</li>
                <li>The owner will review your claim</li>
                <li>You may be asked to verify ownership</li>
            </ul>
        </div>

        <!-- Claim Form -->
        <form action="<?php echo URLROOT; ?>/claims/store/<?php echo $data['post']->id; ?>" method="POST">
            <div style="margin-bottom: var(--md-sys-spacing-3);">
                <label class="label-large"
                    style="display: block; margin-bottom: 8px; color: var(--md-sys-color-on-surface);">
                    Why is this item yours? <span style="color: var(--md-sys-color-error);">*</span>
                </label>
                <p class="body-small" style="color: var(--md-sys-color-on-surface-variant); margin-bottom: 12px;">
                    Provide specific details that prove ownership (e.g., unique features, where you lost it, what's
                    inside, etc.)
                </p>
                <div class="md-text-field">
                    <textarea name="message"
                        class="md-input <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>"
                        placeholder=" " rows="6" required
                        style="resize: vertical; min-height: 150px;"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
                    <label class="md-label">Describe why this is your item...</label>
                </div>
                <?php if (!empty($data['message_err'])): ?>
                    <span style="color: var(--md-sys-color-error); font-size: 14px; margin-top: 4px; display: block;">
                        <?php echo $data['message_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap;">
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->id; ?>"
                    class="md-button md-button-outlined">
                    <i class="fa-solid fa-times" style="margin-right: 8px;"></i> Cancel
                </a>
                <button type="submit" class="md-button md-button-filled" style="background: #FF6F00;">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> Submit Claim
                </button>
            </div>
        </form>
    </div>

    <!-- Warning Box -->
    <div
        style="padding: 16px; background: var(--md-sys-color-error-container); border-radius: 12px; margin-top: var(--md-sys-spacing-3);">
        <p class="body-medium" style="color: var(--md-sys-color-on-error-container); margin: 0;">
            <i class="fa-solid fa-exclamation-triangle" style="margin-right: 8px;"></i>
            <strong>Warning:</strong> Submitting false claims may result in account suspension. Only claim items that
            genuinely belong to you.
        </p>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>