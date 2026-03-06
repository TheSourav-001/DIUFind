<?php
require APPROOT . '/views/inc/header.php';
require APPROOT . '/helpers/comment_helper.php';
?>

<div class="container" style="max-width: 900px;">
    <div style="margin-bottom: var(--md-sys-spacing-2);">
        <a href="<?php echo URLROOT; ?>/posts" class="md-button md-button-outlined">
            <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Back to Feed
        </a>
    </div>

    <?php flash('post_message'); ?>

    <div class="md-card" style="padding: var(--md-sys-spacing-3);">
        <!-- Post Image -->
        <?php if (!empty($data['post']->image_path)): ?>
            <div
                style="margin: calc(-1 * var(--md-sys-spacing-3)) calc(-1 * var(--md-sys-spacing-3)) var(--md-sys-spacing-3) calc(-1 * var(--md-sys-spacing-3)); overflow: hidden; border-radius: var(--md-sys-shape-corner-medium) var(--md-sys-shape-corner-medium) 0 0;">
                <img src="<?php echo UPLOAD_URL . $data['post']->image_path; ?>" alt="<?php echo $data['post']->title; ?>"
                    style="width: 100%; max-height: 500px; object-fit: cover;">
            </div>
        <?php endif; ?>


        <!-- Resolved Banner -->
        <?php if (isset($data['post']->status) && $data['post']->status == 'resolved'): ?>
            <div
                style="padding: var(--md-sys-spacing-3); background: linear-gradient(135deg, var(--md-sys-color-primary-container), var(--md-sys-color-tertiary-container)); border-radius: var(--md-sys-shape-corner-medium); margin-bottom: var(--md-sys-spacing-3); border: 2px solid var(--md-sys-color-primary);">
                <div style="display: flex; align-items: center; gap: var(--md-sys-spacing-2);">
                    <i class="fa-solid fa-check-circle" style="font-size: 48px; color: var(--md-sys-color-primary);"></i>
                    <div>
                        <h3 class="title-large"
                            style="color: var(--md-sys-color-on-primary-container); margin-bottom: 4px;">
                            ✅ This Item Has Been Resolved!
                        </h3>
                        <p class="body-large" style="color: var(--md-sys-color-on-primary-container); margin: 0;">
                            The owner has marked this as returned/found. Thank you to everyone who helped!
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Post Type Badge -->
        <div style="margin-bottom: var(--md-sys-spacing-2); display: flex; gap: 8px; flex-wrap: wrap;">
            <span class="body-large"
                style="display: inline-block; padding: 6px 16px; background: var(--md-sys-color-<?php echo $data['post']->type == 'Lost' ? 'error' : 'primary'; ?>-container); color: var(--md-sys-color-on-<?php echo $data['post']->type == 'Lost' ? 'error' : 'primary'; ?>-container); border-radius: var(--md-sys-shape-corner-full); font-weight: 500;">
                <?php echo $data['post']->type; ?>
            </span>
            <?php if (isset($data['post']->status) && $data['post']->status == 'resolved'): ?>
                <span class="body-large"
                    style="display: inline-block; padding: 6px 16px; background: var(--md-sys-color-surface-variant); color: var(--md-sys-color-on-surface-variant); border-radius: var(--md-sys-shape-corner-full); font-weight: 500;">
                    ✓ RESOLVED
                </span>
            <?php endif; ?>
        </div>

        <!-- Post Title -->
        <h1 class="headline-medium" style="color: var(--md-sys-color-primary); margin-bottom: var(--md-sys-spacing-2);">
            <?php echo $data['post']->title; ?>
        </h1>

        <!-- Location & Category -->
        <div
            style="display: flex; gap: var(--md-sys-spacing-2); margin-bottom: var(--md-sys-spacing-3); flex-wrap: wrap;">
            <?php if ($data['post']->location_name): ?>
                <div style="display: flex; align-items: center; gap: 8px; color: var(--md-sys-color-on-surface-variant);">
                    <i class="fa-solid fa-map-marker-alt" style="color: var(--md-sys-color-primary);"></i>
                    <span class="body-large">
                        <?php echo $data['post']->location_name; ?>
                    </span>
                </div>
            <?php endif; ?>
            <?php if ($data['post']->category_name): ?>
                <div style="display: flex; align-items: center; gap: 8px; color: var(--md-sys-color-on-surface-variant);">
                    <i class="fa-solid fa-tag" style="color: var(--md-sys-color-secondary);"></i>
                    <span class="body-large">
                        <?php echo $data['post']->category_name; ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Post Body -->
        <div class="body-large"
            style="line-height: 1.6; margin-bottom: var(--md-sys-spacing-3); white-space: pre-wrap;">
            <?php echo $data['post']->body; ?>
        </div>

        <!-- Author Info -->
        <div
            style="padding: var(--md-sys-spacing-2); background: var(--md-sys-color-surface-variant); border-radius: var(--md-sys-shape-corner-small); margin-bottom: var(--md-sys-spacing-2);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-weight: 500; margin-bottom: 4px;">
                        <i class="fa-solid fa-user" style="margin-right: 8px; color: var(--md-sys-color-primary);"></i>
                        <?php echo $data['post']->user_name; ?>
                    </div>
                    <div style="color: var(--md-sys-color-on-surface-variant); font-size: 14px;">
                        <i class="fa-solid fa-calendar" style="margin-right: 8px;"></i>
                        Posted on
                        <?php echo date('F d, Y \a\t h:i A', strtotime($data['post']->created_at)); ?>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 24px;">⭐</span>
                        <div>
                            <div style="font-weight: 500; font-size: 18px;">
                                <?php echo $data['post']->trust_score; ?>
                            </div>
                            <div style="font-size: 12px; color: var(--md-sys-color-on-surface-variant);">Trust Score
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- REACTIONS SECTION -->
        <div class="reactions-wrapper"
            style="padding: 16px 0; border-top: 1px solid var(--md-sys-color-outline); border-bottom: 1px solid var(--md-sys-color-outline); margin-bottom: var(--md-sys-spacing-2);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <!-- Reaction Counts -->
                <div class="reaction-counts" style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <?php if ($data['reactions']['total'] > 0): ?>
                        <?php
                        $reactionEmojis = [
                            'like' => '👍',
                            'love' => '❤️',
                            'care' => '🤗',
                            'haha' => '😂',
                            'wow' => '😮',
                            'sad' => '😢',
                            'angry' => '😡'
                        ];
                        foreach ($data['reactions'] as $type => $count):
                            if ($type != 'total' && $count > 0):
                                ?>
                                <span class="reaction-count-badge"
                                    style="display: inline-flex; align-items: center; gap: 4px; background: var(--md-sys-color-surface-variant); padding: 4px 12px; border-radius: 16px;">
                                    <span style="font-size: 18px;"><?php echo $reactionEmojis[$type]; ?></span>
                                    <span class="label-small" style="font-weight: 600;"><?php echo $count; ?></span>
                                </span>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    <?php else: ?>
                        <span class="body-small" style="color: var(--md-sys-color-on-surface-variant);">Be the first to
                            react!</span>
                    <?php endif; ?>
                </div>

                <!-- Reaction Button with Hover Dock -->
                <?php if (isLoggedIn()): ?>
                    <div class="reaction-button-wrapper" style="position: relative;">
                        <button
                            class="main-reaction-btn md-button md-button-<?php echo $data['userReaction'] ? 'filled' : 'tonal'; ?>"
                            data-post-id="<?php echo $data['post']->id; ?>"
                            data-user-reaction="<?php echo $data['userReaction'] ?? ''; ?>"
                            style="display: flex; align-items: center; gap: 6px;">
                            <span class="reaction-icon" style="font-size: 18px;">
                                <?php
                                if ($data['userReaction']) {
                                    $icons = ['like' => '👍', 'love' => '❤️', 'care' => '🤗', 'haha' => '😂', 'wow' => '😮', 'sad' => '😢', 'angry' => '😡'];
                                    echo $icons[$data['userReaction']];
                                } else {
                                    echo '👍';
                                }
                                ?>
                            </span>
                            <span
                                class="reaction-label"><?php echo $data['userReaction'] ? ucfirst($data['userReaction']) : 'React'; ?></span>
                        </button>

                        <!-- Emoji Reaction Dock (appears on hover) -->
                        <div class="emoji-dock"
                            style="display: none; position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); margin-bottom: 8px; background: white; padding: 8px; border-radius: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); z-index: 1000;">
                            <div style="display: flex; gap: 4px;">
                                <button class="emoji-btn" data-reaction="like" title="Like"
                                    style="font-size: 32px; background: none; border: none; cursor: pointer; transition: transform 0.2s; border-radius: 50%; padding: 4px;">👍</button>
                                <button class="emoji-btn" data-reaction="love" title="Love"
                                    style="font-size: 32px; background: none; border: none; cursor: pointer; transition: transform 0.2s; border-radius: 50%; padding: 4px;">❤️</button>
                                <button class="emoji-btn" data-reaction="care" title="Care"
                                    style="font-size: 32px; background: none; border: none; cursor: pointer; transition: transform 0.2s; border-radius: 50%; padding: 4px;">🤗</button>
                                <button class="emoji-btn" data-reaction="haha" title="Laugh"
                                    style="font-size: 32px; background: none; border: none; cursor: pointer; transition: transform 0.2s; border-radius: 50%; padding: 4px;">😂</button>
                                <button class="emoji-btn" data-reaction="wow" title="Wow"
                                    style="font-size: 32px; background: none; border: none; cursor: pointer; transition: transform 0.2s; border-radius: 50%; padding: 4px;">😮</button>
                                <button class="emoji-btn" data-reaction="sad" title="Sad"
                                    style="font-size: 32px; background: none; border: none; cursor: pointer; transition: transform 0.2s; border-radius: 50%; padding: 4px;">😢</button>
                                <button class="emoji-btn" data-reaction="angry" title="Angry"
                                    style="font-size: 32px; background: none; border: none; cursor: pointer; transition: transform 0.2s; border-radius: 50%; padding: 4px;">😡</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Go to Map Button -->
        <?php if (!empty($data['post']->latitude) && !empty($data['post']->longitude)): ?>
            <div
                style="margin-bottom: var(--md-sys-spacing-2); padding-bottom: var(--md-sys-spacing-2); border-bottom: 1px solid var(--md-sys-color-outline-variant);">
                <a href="<?php echo URLROOT; ?>/posts/map?focus=<?php echo $data['post']->id; ?>"
                    class="md-button md-button-filled"
                    style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; background: linear-gradient(135deg, #1976D2, #1565C0); color: white; padding: 16px; font-weight: 500; box-shadow: 0 2px 8px rgba(25,118,210,0.3);">
                    <i class="fa-solid fa-map-location-dot" style="font-size: 18px;"></i>
                    <span>View Location on Campus Map</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- Download Poster Button -->
        <div
            style="margin-bottom: var(--md-sys-spacing-2); padding-bottom: var(--md-sys-spacing-2); border-bottom: 2px solid var(--md-sys-color-outline-variant);">
            <a href="<?php echo URLROOT; ?>/posts/downloadPoster/<?php echo $data['post']->id; ?>" target="_blank"
                class="md-button md-button-outlined"
                style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; border: 2px solid var(--md-sys-color-primary); color: var(--md-sys-color-primary); padding: 16px; font-weight: 600; border-radius: var(--md-sys-shape-corner-medium);">
                <i class="fa-solid fa-print" style="font-size: 20px;"></i>
                <span>Download Printable Poster (PDF)</span>
            </a>
        </div>

        <!-- Mark as Resolved Button (Owner Only, if not resolved) - PROMINENT DESIGN -->
        <?php if ($data['post']->user_id == $_SESSION['user_id'] && (!isset($data['post']->status) || $data['post']->status != 'resolved')): ?>
            <div
                style="padding-top: var(--md-sys-spacing-3); border-top: 2px solid var(--md-sys-color-outline-variant); margin-bottom: var(--md-sys-spacing-2);">
                <button onclick="confirmResolve(<?php echo $data['post']->id; ?>)" class="md-button md-button-filled"
                    style="width: 100%; padding: 20px; font-size: 18px; font-weight: 700; background: linear-gradient(135deg, #00897B, #00695C); color: white; box-shadow: 0 4px 12px rgba(0,137,123,0.4); transition: all 0.3s ease; border: none; border-radius: 12px;">
                    <i class="fa-solid fa-check-circle" style="margin-right: 12px; font-size: 24px;"></i>
                    Mark as Resolved (Remove from Feed)
                </button>
                <p
                    style="text-align: center; margin-top: 12px; font-size: 13px; color: var(--md-sys-color-on-surface-variant);">
                    <i class="fa-solid fa-info-circle" style="margin-right: 4px;"></i>
                    This will hide the post from feed and mark it as successfully resolved
                </p>
            </div>

            <script>
                function confirmResolve(postId) {
                    Swal.fire({
                        title: 'Mark as Resolved?',
                        html: '<p style="font-size: 16px; color: #666;">Did you successfully return/find this item?</p><p style="font-size: 14px; margin-top: 8px; color: #999;">This will remove the post from the feed.</p>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00897B',
                        cancelButtonColor: '#757575',
                        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes, Resolve It',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            popup: 'swal-wide'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create form and submit
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '<?php echo URLROOT; ?>/posts/resolve/<?php echo $data['post']->id; ?>';
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            </script>
        <?php endif; ?>

        <!-- Edit/Delete Buttons (Owner Only) -->
        <?php if ($data['post']->user_id == $_SESSION['user_id']): ?>
            <div
                style="display: flex; gap: var(--md-sys-spacing-2); padding-top: var(--md-sys-spacing-2); border-top: 1px solid var(--md-sys-color-outline-variant);">
                <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>"
                    class="md-button md-button-tonal" style="flex: 1;">
                    <i class="fa-solid fa-edit" style="margin-right: 8px;"></i> Edit Post
                </a>
                <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="POST"
                    style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    <button type="submit" class="md-button md-button-outlined"
                        style="width: 100%; border-color: var(--md-sys-color-error); color: var(--md-sys-color-error);">
                        <i class="fa-solid fa-trash" style="margin-right: 8px;"></i> Delete Post
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- CONTACT & ACTIONS SECTION -->
    <?php if ($data['post']->user_id != $_SESSION['user_id']): ?>
        <div class="md-card"
            style="padding: var(--md-sys-spacing-3); margin-top: var(--md-sys-spacing-3); background: linear-gradient(135deg, var(--md-sys-color-primary-container), var(--md-sys-color-secondary-container));">
            <h3 class="title-large"
                style="margin-bottom: var(--md-sys-spacing-2); color: var(--md-sys-color-on-primary-container); display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-phone-volume" style="color: var(--md-sys-color-primary);"></i>
                Contact & Actions
            </h3>

            <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
                <!-- Contact Buttons (only show if owner has phone) -->
                <?php if (!empty($data['user']->phone)): ?>
                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $data['user']->phone); ?>?text=Hi,%20I%20saw%20your%20post%20about:%20<?php echo urlencode($data['post']->title); ?>"
                        target="_blank" class="md-button md-button-filled"
                        style="flex: 1; min-width: 140px; background: #25D366; color: white; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 20px;"></i>
                        <span>Chat on WhatsApp</span>
                    </a>

                    <a href="tel:<?php echo $data['user']->phone; ?>" class="md-button md-button-filled"
                        style="flex: 1; min-width: 140px; background: #1976D2; color: white; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid fa-phone" style="font-size: 18px;"></i>
                        <span>Call Now</span>
                    </a>
                <?php else: ?>
                    <div
                        style="padding: 12px; background: var(--md-sys-color-surface-variant); border-radius: 8px; color: var(--md-sys-color-on-surface-variant); flex: 1;">
                        <i class="fa-solid fa-info-circle" style="margin-right: 8px;"></i>
                        Owner has not provided a phone number
                    </div>
                <?php endif; ?>

                <!-- Claim Button (only for Found items that are NOT resolved) -->
                <?php if ($data['post']->type == 'Found' && (!isset($data['post']->status) || $data['post']->status != 'resolved')): ?>
                    <button id="claimButton" onclick="claimPost(<?php echo $data['post']->id; ?>)"
                        class="md-button md-button-filled"
                        style="flex: 1; min-width: 200px; background: linear-gradient(135deg, #FF6F00, #F57C00); color: white; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; box-shadow: 0 4px 12px rgba(255,111,0,0.4);">
                        <i class="fa-solid fa-hand-holding-heart" style="font-size: 20px;"></i>
                        <span>Claim</span>
                    </button>

                    <script>
                        function claimPost(postId) {
                            // Step 1: Confirmation popup
                            Swal.fire({
                                title: 'Claim This Post?',
                                text: 'Are you sure you want to claim this post?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#FF6F00',
                                cancelButtonColor: '#757575',
                                confirmButtonText: '<i class="fa-solid fa-check"></i> Yes',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Step 2: Submit claim via AJAX
                                    Swal.fire({
                                        title: 'Sending...',
                                        text: 'Please wait',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    // Send AJAX request
                                    fetch('<?php echo URLROOT; ?>/claims/submit/' + postId, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: 'message=User claims this item belongs to them.'
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                // Step 3: Success message
                                                Swal.fire({
                                                    title: 'Claim Sent!',
                                                    text: 'Claim request sent to the post owner.',
                                                    icon: 'success',
                                                    confirmButtonColor: '#4CAF50'
                                                });
                                                // Disable the button
                                                document.getElementById('claimButton').disabled = true;
                                                document.getElementById('claimButton').innerHTML = '<i class="fa-solid fa-check"></i> Claim Sent';
                                                document.getElementById('claimButton').style.background = '#9E9E9E';
                                            } else {
                                                Swal.fire({
                                                    title: 'Error',
                                                    text: data.message || 'Failed to send claim',
                                                    icon: 'error',
                                                    confirmButtonColor: '#F44336'
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'Something went wrong. Please try again.',
                                                icon: 'error',
                                                confirmButtonColor: '#F44336'
                                            });
                                        });
                                }
                            });
                        }
                    </script>
                <?php endif; ?>
            </div>

            <p class="body-small"
                style="margin-top: var(--md-sys-spacing-2); color: var(--md-sys-color-on-secondary-container); margin-bottom: 0;">
                <i class="fa-solid fa-shield-alt" style="margin-right: 4px;"></i>
                Please be respectful and verify ownership before claiming items.
            </p>
        </div>
    <?php endif; ?>

    <!-- COMMENTS SECTION -->
    <div class="md-card" style="padding: var(--md-sys-spacing-3); margin-top: var(--md-sys-spacing-3);">
        <h2 class="title-large"
            style="margin-bottom: var(--md-sys-spacing-2); display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-comments" style="color: var(--md-sys-color-primary);"></i>
            Comments (<?php echo count($data['comments']); ?>)
        </h2>

        <?php flash('comment_message'); ?>

        <!-- Add Comment Form (hide if resolved) -->
        <?php if (!isset($data['post']->status) || $data['post']->status != 'resolved'): ?>
            <div
                style="margin-bottom: var(--md-sys-spacing-3); padding: var(--md-sys-spacing-2); background: var(--md-sys-color-surface-variant); border-radius: var(--md-sys-shape-corner-medium);">
                <form action="<?php echo URLROOT; ?>/comments/add/<?php echo $data['post']->id; ?>" method="POST">
                    <div class="md-text-field">
                        <textarea name="body" class="md-input" placeholder=" " rows="3" required
                            style="resize: vertical; min-height: 80px;"></textarea>
                        <label class="md-label">Write a comment...</label>
                    </div>
                    <button type="submit" class="md-button md-button-filled" style="margin-top: var(--md-sys-spacing-1);">
                        <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> Post Comment
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div
                style="margin-bottom: var(--md-sys-spacing-3); padding: var(--md-sys-spacing-2); background: var(--md-sys-color-surface-variant); border-radius: var(--md-sys-shape-corner-medium); text-align: center; color: var(--md-sys-color-on-surface-variant);">
                <i class="fa-solid fa-lock" style="margin-right: 8px;"></i>
                Comments are disabled for resolved posts
            </div>
        <?php endif; ?>

        <!-- Comments List (Recursive Nested Structure) -->
        <?php if (!empty($data['comments'])): ?>
            <div style="margin-top: var(--md-sys-spacing-3);">
                <?php
                // Use recursive function to render comments with unlimited nesting
                renderComments($data['comments'], null, 0);
                ?>
            </div>
        </div>
    <?php else: ?>
        <p class="body-medium"
            style="text-align: center; padding: var(--md-sys-spacing-3); color: var(--md-sys-color-on-surface-variant);">
            <i class="fa-regular fa-comment"></i> No comments yet. Be the first to comment!
        </p>
    <?php endif; ?>
</div>
</div>

<!-- JavaScript for Reactions and Nested Comments -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ===== REACTIONS SYSTEM =====
        const reactionBtn = document.querySelector('.main-reaction-btn');
        const emojiDock = document.querySelector('.emoji-dock');

        if (reactionBtn && emojiDock) {
            let hoverTimeout;

            // Show emoji dock on hover
            reactionBtn.addEventListener('mouseenter', function () {
                clearTimeout(hoverTimeout);
                emojiDock.style.display = 'block';
            });

            // Keep dock visible when hovering over it
            emojiDock.addEventListener('mouseenter', function () {
                clearTimeout(hoverTimeout);
            });

            // Hide dock when leaving both
            function hideDock() {
                hoverTimeout = setTimeout(() => {
                    emojiDock.style.display = 'none';
                }, 300);
            }

            reactionBtn.addEventListener('mouseleave', hideDock);
            emojiDock.addEventListener('mouseleave', hideDock);

            // Handle emoji clicks
            document.querySelectorAll('.emoji-btn').forEach(btn => {
                btn.addEventListener('mouseenter', function () {
                    this.style.transform = 'scale(1.3)';
                });

                btn.addEventListener('mouseleave', function () {
                    this.style.transform = 'scale(1)';
                });

                btn.addEventListener('click', async function (e) {
                    e.preventDefault();
                    const reactionType = this.dataset.reaction;
                    const postId = reactionBtn.dataset.postId;

                    try {
                        const response = await fetch('<?php echo URLROOT; ?>/reactions/react', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                postId: postId,
                                type: reactionType
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Reload to update UI
                            location.reload();
                        }
                    } catch (error) {
                        console.error('Reaction error:', error);
                    }
                });
            });
        }

        // ===== NESTED COMMENTS SYSTEM =====
        // Reply button click - show/hide reply form
        document.querySelectorAll('.reply-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const replyForm = document.getElementById(`reply-form-${commentId}`);

                // Hide all other reply forms
                document.querySelectorAll('.reply-form').forEach(form => {
                    if (form.id !== `reply-form-${commentId}`) {
                        form.style.display = 'none';
                    }
                });

                // Toggle current reply form
                if (replyForm.style.display === 'none' || !replyForm.style.display) {
                    replyForm.style.display = 'block';
                    replyForm.querySelector('textarea').focus();
                } else {
                    replyForm.style.display = 'none';
                }
            });
        });

        // Cancel reply button
        document.querySelectorAll('.cancel-reply').forEach(btn => {
            btn.addEventListener('click', function () {
                const replyForm = this.closest('.reply-form');
                replyForm.style.display = 'none';
                replyForm.querySelector('textarea').value = '';
            });
        });
    });
</script>

<style>
    .emoji-dock {
        transition: all 0.2s ease-out;
    }

    .emoji-btn:hover {
        background: var(--md-sys-color-surface-variant) !important;
    }

    .comment-item {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>