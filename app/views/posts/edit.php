<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container" style="max-width: 900px;">
    <div style="margin-bottom: var(--md-sys-spacing-2);">
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['id']; ?>" class="md-button md-button-outlined">
            <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Cancel
        </a>
    </div>

    <div class="md-card" style="padding: var(--md-sys-spacing-3);">
        <h1 class="title-large" style="color: var(--md-sys-color-primary); margin-bottom: 8px;">Edit Post</h1>
        <p class="body-large"
            style="color: var(--md-sys-color-on-surface-variant); margin-bottom: var(--md-sys-spacing-3);">
            Update your post details
        </p>

        <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="POST">

            <!-- Post Type -->
            <div class="md-text-field">
                <select name="type" class="md-select" required>
                    <option value="">Select Type</option>
                    <option value="Lost" <?php echo ($data['type'] == 'Lost') ? 'selected' : ''; ?>>Lost Item</option>
                    <option value="Found" <?php echo ($data['type'] == 'Found') ? 'selected' : ''; ?>>Found Item
                    </option>
                    <option value="Event" <?php echo ($data['type'] == 'Event') ? 'selected' : ''; ?>>Event/Notice
                    </option>
                    <option value="Other" <?php echo ($data['type'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
                <label class="md-label">Post Type *</label>
            </div>

            <!-- Category -->
            <div class="md-text-field">
                <select name="category_id" class="md-select">
                    <option value="">Select Category</option>
                    <option value="1" <?php echo ($data['category_id'] == 1) ? 'selected' : ''; ?>>Electronics (Laptop,
                        Phone, Charger)</option>
                    <option value="2" <?php echo ($data['category_id'] == 2) ? 'selected' : ''; ?>>ID Cards (Student ID,
                        NID, Passport)</option>
                    <option value="3" <?php echo ($data['category_id'] == 3) ? 'selected' : ''; ?>>Books & Stationery
                    </option>
                    <option value="4" <?php echo ($data['category_id'] == 4) ? 'selected' : ''; ?>>Accessories (Watch,
                        Jewelry, Wallet)</option>
                </select>
                <label class="md-label">Item Category</label>
            </div>

            <!-- Location -->
            <div class="md-text-field">
                <select name="location_id" class="md-select">
                    <option value="">Select Location</option>
                    <option value="1" <?php echo ($data['location_id'] == 1) ? 'selected' : ''; ?>>AB1 Building</option>
                    <option value="2" <?php echo ($data['location_id'] == 2) ? 'selected' : ''; ?>>Knowledge Tower
                    </option>
                    <option value="3" <?php echo ($data['location_id'] == 3) ? 'selected' : ''; ?>>Central Library
                    </option>
                    <option value="4" <?php echo ($data['location_id'] == 4) ? 'selected' : ''; ?>>Food Court</option>
                    <option value="5" <?php echo ($data['location_id'] == 5) ? 'selected' : ''; ?>>Bus Station</option>
                    <option value="6" <?php echo ($data['location_id'] == 6) ? 'selected' : ''; ?>>Innovation Lab
                    </option>
                </select>
                <label class="md-label">Location</label>
            </div>

            <!-- Title -->
            <div class="md-text-field">
                <input type="text" name="title"
                    class="md-input <?php echo (!empty($data['title_err'])) ? 'error' : ''; ?>" placeholder=" "
                    value="<?php echo $data['title']; ?>" required>
                <label class="md-label">Title (Short, descriptive) *</label>
                <?php if (!empty($data['title_err'])): ?>
                    <span class="md-error-text">
                        <?php echo $data['title_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="md-text-field">
                <textarea name="body" class="md-input <?php echo (!empty($data['body_err'])) ? 'error' : ''; ?>"
                    placeholder=" " rows="6" required><?php echo $data['body']; ?></textarea>
                <label class="md-label">Detailed Description *</label>
                <?php if (!empty($data['body_err'])): ?>
                    <span class="md-error-text">
                        <?php echo $data['body_err']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <div
                style="display: flex; gap: var(--md-sys-spacing-2); justify-content: flex-end; margin-top: var(--md-sys-spacing-3);">
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['id']; ?>"
                    class="md-button md-button-outlined" style="padding: 0 32px;">Cancel</a>
                <button type="submit" class="md-button md-button-filled" style="padding: 0 32px;">Update Post</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Floating label support
    document.querySelectorAll('.md-input').forEach(input => {
        if (input.value) input.classList.add('filled');
        input.addEventListener('input', function () {
            if (this.value) this.classList.add('filled');
            else this.classList.remove('filled');
        });
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>