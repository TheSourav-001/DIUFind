<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Custom CSS for Premium Horizontal Filters & Animations -->
<style>
    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Horizontal Filter Bar Styling */
    .filter-bar-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 24px;
        margin-bottom: 32px;
        position: relative;
        z-index: 5;
    }

    .filter-main-row {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-secondary-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
        padding-top: 20px;
        border-top: 1px dashed rgba(0, 0, 0, 0.1);
    }

    /* Premium Search Input */
    .search-wrapper {
        position: relative;
        width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 16px 20px 16px 52px;
        border-radius: 14px;
        border: 1px solid #e0e0e0;
        background: #f8fafc;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        background: white;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(var(--md-sys-color-primary-rgb), 0.1);
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 18px;
    }

    /* Chip Styling */
    .type-chip-group {
        display: flex;
        gap: 8px;
        background: #f1f5f9;
        padding: 6px;
        border-radius: 16px;
    }

    .type-chip input {
        display: none;
    }

    .type-chip span {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .type-chip input:checked+span {
        background: white;
        color: var(--md-sys-color-primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .type-chip:hover span {
        color: var(--md-sys-color-on-surface);
    }

    /* Dropdown Styling */
    .custom-select-wrapper {
        position: relative;
        min-width: 180px;
        flex: 1;
    }

    .custom-select {
        width: 100%;
        appearance: none;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #475569;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .custom-select:hover {
        border-color: #cbd5e1;
    }

    .custom-select:focus {
        border-color: var(--md-sys-color-primary);
        outline: none;
    }

    /* Toggle Switch */
    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
    }

    /* Card Hover Effects */
    .post-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid transparent;
        overflow: hidden;
        position: relative;
        background: white;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        border-color: var(--md-sys-color-outline-variant);
    }

    .post-card.found-type:hover {
        border-color: var(--md-sys-color-primary);
    }

    .post-card.lost-type:hover {
        border-color: var(--md-sys-color-error);
    }

    @media (max-width: 992px) {
        .filter-main-row {
            grid-template-columns: 1fr;
        }

        .type-chip-group {
            width: 100%;
            justify-content: space-between;
        }

        .type-chip {
            flex: 1;
        }

        .type-chip span {
            justify-content: center;
        }

        .filter-secondary-row {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<div style="background-color: #F8FAFC; min-height: 100vh; padding-bottom: 80px;">

    <!-- Hero Header -->
    <div style="background: white; padding: 40px 0 60px; border-bottom: 1px solid #f1f5f9;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <div>
                    <h1 class="headline-large" style="color: #1e293b; font-weight: 800; letter-spacing: -0.5px;">
                        Community Feed</h1>
                    <p class="body-large" style="color: #64748b;">Connecting lost items with their owners</p>
                </div>
                <a href="<?php echo URLROOT; ?>/posts/add" class="md-button md-button-filled"
                    style="padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 12px rgba(var(--md-sys-color-primary-rgb), 0.3);">
                    <i class="fa-solid fa-plus" style="margin-right: 8px;"></i> Report Item
                </a>
            </div>
        </div>
    </div>

    <div class="container"
        style="max-width: 1200px; margin: -40px auto 0; padding: 0 20px; position: relative; z-index: 10;">
        <?php flash('post_message'); ?>

        <!-- TOP FILTER BAR (Beautiful & Perfect) -->
        <div class="filter-bar-container" data-aos="fade-up" data-aos-delay="0">
            <form method="GET" action="<?php echo URLROOT; ?>/posts" id="filterForm">
                <div class="filter-main-row">
                    <!-- Search Input -->
                    <div class="search-wrapper">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" name="search" class="search-input"
                            placeholder="Search for items like 'Blue Wallet' or 'Calculator'..."
                            value="<?php echo $_GET['search'] ?? ''; ?>">
                    </div>

                    <!-- Type Chips -->
                    <div class="type-chip-group">
                        <label class="type-chip">
                            <input type="radio" name="type" value="" <?php echo (!isset($_GET['type']) || $_GET['type'] == '') ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <span>All</span>
                        </label>
                        <label class="type-chip">
                            <input type="radio" name="type" value="Lost" <?php echo (isset($_GET['type']) && $_GET['type'] == 'Lost') ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <span>🔴 Lost</span>
                        </label>
                        <label class="type-chip">
                            <input type="radio" name="type" value="Found" <?php echo (isset($_GET['type']) && $_GET['type'] == 'Found') ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <span>🟢 Found</span>
                        </label>
                    </div>
                </div>

                <div class="filter-secondary-row">
                    <!-- Filters -->
                    <div class="custom-select-wrapper">
                        <select name="category" class="custom-select" onchange="this.form.submit()">
                            <option value="">📂 All Categories</option>
                            <option value="1" <?php echo (isset($_GET['category']) && $_GET['category'] == '1') ? 'selected' : ''; ?>>📱 Electronics</option>
                            <option value="2" <?php echo (isset($_GET['category']) && $_GET['category'] == '2') ? 'selected' : ''; ?>>📚 Books</option>
                            <option value="3" <?php echo (isset($_GET['category']) && $_GET['category'] == '3') ? 'selected' : ''; ?>>👕 Clothing</option>
                            <option value="4" <?php echo (isset($_GET['category']) && $_GET['category'] == '4') ? 'selected' : ''; ?>>🪪 ID Cards</option>
                            <option value="5" <?php echo (isset($_GET['category']) && $_GET['category'] == '5') ? 'selected' : ''; ?>>🔑 Keys</option>
                            <option value="6" <?php echo (isset($_GET['category']) && $_GET['category'] == '6') ? 'selected' : ''; ?>>📦 Other</option>
                        </select>
                    </div>

                    <div class="custom-select-wrapper">
                        <select name="location" class="custom-select" onchange="this.form.submit()">
                            <option value="">📍 All Locations</option>
                            <option value="1" <?php echo (isset($_GET['location']) && $_GET['location'] == '1') ? 'selected' : ''; ?>>🏢 Main Campus</option>
                            <option value="2" <?php echo (isset($_GET['location']) && $_GET['location'] == '2') ? 'selected' : ''; ?>>📖 Library</option>
                            <option value="3" <?php echo (isset($_GET['location']) && $_GET['location'] == '3') ? 'selected' : ''; ?>>🍽️ Cafeteria</option>
                            <option value="4" <?php echo (isset($_GET['location']) && $_GET['location'] == '4') ? 'selected' : ''; ?>>🏠 Dormitory</option>
                        </select>
                    </div>

                    <div class="custom-select-wrapper">
                        <select name="sort" class="custom-select" onchange="this.form.submit()">
                            <option value="newest" <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>🕒 Newest First</option>
                            <option value="oldest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'oldest') ? 'selected' : ''; ?>>⏰ Oldest First</option>
                            <option value="title" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'title') ? 'selected' : ''; ?>>🔤 Title (A-Z)</option>
                        </select>
                    </div>

                    <!-- Date & Resolved Toggle -->
                    <div style="display: flex; gap: 8px; flex: 1;">
                        <input type="date" name="date_from" class="custom-select" style="min-width: unset;"
                            value="<?php echo $_GET['date_from'] ?? ''; ?>" onchange="this.form.submit()">
                    </div>

                    <label class="toggle-wrapper">
                        <span style="font-size: 14px; font-weight: 600; color: #475569;">Show Resolved</span>
                        <div style="position: relative; width: 44px; height: 24px;">
                            <input type="checkbox" name="show_resolved" value="1" <?php echo (isset($_GET['show_resolved'])) ? 'checked' : ''; ?> onchange="this.form.submit()"
                                style="opacity: 0; width: 0; height: 0;">
                            <span class="slider"
                                style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px;"></span>
                            <span class="slider-thumb"
                                style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%;"></span>
                        </div>
                    </label>
                    <style>
                        input:checked+.slider {
                            background-color: var(--md-sys-color-primary);
                        }

                        input:checked+.slider+.slider-thumb {
                            transform: translateX(20px);
                        }
                    </style>

                    <?php if (isset($_GET['search']) || isset($_GET['type']) || isset($_GET['category']) || isset($_GET['location'])): ?>
                        <a href="<?php echo URLROOT; ?>/posts" class="md-button md-button-text"
                            style="color: var(--md-sys-color-error);">
                            <i class="fa-solid fa-times-circle" style="margin-right: 6px;"></i> Clear
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- POSTS GRID -->
        <main data-aos="fade-up" data-aos-delay="100">
            <?php if (!empty($data['posts'])): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                    <?php foreach ($data['posts'] as $index => $post): ?>
                        <div class="md-card post-card <?php echo $post->type == 'Lost' ? 'lost-type' : 'found-type'; ?>"
                            style="padding: 0; border-radius: 20px; display: flex; flex-direction: column; height: 100%;">

                            <!-- Image -->
                            <div style="position: relative; height: 200px; overflow: hidden; background: #f1f5f9;">
                                <?php if (!empty($post->image_path)): ?>
                                    <img src="<?php echo UPLOAD_URL . $post->image_path; ?>" alt="<?php echo $post->title; ?>"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div
                                        style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: <?php echo $post->type == 'Lost' ? '#fef2f2' : '#f0fdf4'; ?>;">
                                        <i class="fa-solid <?php echo $post->type == 'Lost' ? 'fa-magnifying-glass' : 'fa-box-open'; ?>"
                                            style="font-size: 48px; color: <?php echo $post->type == 'Lost' ? 'var(--md-sys-color-error)' : 'var(--md-sys-color-primary)'; ?>; opacity: 0.5;"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Badges -->
                                <div style="position: absolute; top: 12px; left: 12px; display: flex; gap: 8px;">
                                    <span
                                        style="padding: 6px 12px; border-radius: 20px; background: <?php echo $post->type == 'Lost' ? 'rgba(239, 68, 68, 0.9)' : 'rgba(16, 185, 129, 0.9)'; ?>; color: white; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; backdrop-filter: blur(4px);">
                                        <?php echo $post->type; ?>
                                    </span>
                                    <?php if (isset($post->status) && $post->status == 'resolved'): ?>
                                        <span
                                            style="padding: 6px 12px; border-radius: 20px; background: rgba(255,255,255,0.9); color: #0f172a; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Resolved
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Content -->
                            <div style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
                                <div style="margin-bottom: 12px;">
                                    <?php if ($post->category_name): ?>
                                        <span
                                            style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <?php echo $post->category_name; ?>
                                        </span>
                                    <?php endif; ?>
                                    <h3 class="title-medium"
                                        style="margin-top: 4px; font-weight: 700; font-size: 18px; line-height: 1.4; color: #0f172a;">
                                        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->id; ?>"
                                            style="text-decoration: none; color: inherit;">
                                            <?php echo $post->title; ?>
                                        </a>
                                    </h3>
                                </div>

                                <p class="body-medium"
                                    style="color: #475569; margin-bottom: 20px; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo strip_tags($post->body); ?>
                                </p>

                                <div style="margin-top: auto; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; color: #64748b; font-size: 13px; margin-bottom: 12px;">
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-map-marker-alt"></i>
                                            <?php echo $post->location_name ?? 'Unknown'; ?>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <i class="fa-regular fa-clock"></i>
                                            <?php echo timeAgo($post->created_at); ?>
                                        </div>
                                    </div>
                                    <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->id; ?>"
                                        class="md-button md-button-tonal"
                                        style="width: 100%; justify-content: center; font-weight: 600; border-radius: 12px; border: 1.5px solid #00A854; color: #00A854; transition: all 0.3s ease;">
                                        View Details <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="md-card" data-aos="fade-up"
                    style="padding: 60px 20px; text-align: center; border-radius: 24px; background: white;">
                    <div
                        style="width: 100px; height: 100px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fa-solid fa-wind" style="font-size: 40px; color: #94a3b8;"></i>
                    </div>
                    <h3 class="headline-small" style="margin-bottom: 8px; color: #1e293b;">No matches found</h3>
                    <p class="body-large" style="color: #64748b; max-width: 400px; margin: 0 auto 24px;">
                        Try adjusting your filters or search terms to find what you're looking for.
                    </p>
                    <a href="<?php echo URLROOT; ?>/posts" class="md-button md-button-outlined"
                        style="padding: 0 32px;">Clear Filters</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>