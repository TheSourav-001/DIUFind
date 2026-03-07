<?php
/**
 * Recursive Comment Renderer
 * Renders comments in a tree structure with unlimited nesting
 */
function renderComments($comments, $parentId = null, $depth = 0)
{
    $maxDepth = 8; // Limit visual nesting to prevent layout issues on mobile

    foreach ($comments as $comment) {
        if ($comment->parent_id == $parentId) {
            // Calculate indentation (limit to max depth)
            $visualDepth = min($depth, $maxDepth);
            $marginLeft = $visualDepth * 20; // 20px per level
            ?>
            <div class="comment-item" data-comment-id="<?php echo $comment->id; ?>"
                style="margin-left: <?php echo $marginLeft; ?>px; margin-bottom: 12px; border-left: <?php echo $visualDepth > 0 ? '2px solid var(--md-sys-color-outline)' : 'none'; ?>; padding-left: <?php echo $visualDepth > 0 ? '12px' : '0'; ?>;">

                <div style="display: flex; gap: 12px;">
                    <!-- Avatar -->
                    <div style="flex-shrink: 0;">
                        <?php
                        // Check if avatar exists and file is valid
                        $showAvatar = false;
                        if (!empty($comment->avatar)) {
                            $avatarPath = APPROOT . '/../public/uploads/' . $comment->avatar;
                            if (file_exists($avatarPath)) {
                                $showAvatar = true;
                            }
                        }

                        if ($showAvatar):
                            ?>
                            <img src="<?php echo UPLOAD_URL . $comment->avatar; ?>"
                                alt="<?php echo htmlspecialchars($comment->user_name); ?>"
                                style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                        <?php else: ?>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: var(--md-sys-color-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px;">
                                <?php echo strtoupper(substr($comment->user_name, 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Comment Content -->
                    <div style="flex: 1; min-width: 0;">
                        <div style="background: var(--md-sys-color-surface-variant); padding: 12px; border-radius: 12px;">
                            <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 4px;">
                                <span class="label-large" style="font-weight: 600; color: var(--md-sys-color-on-surface);">
                                    <?php echo htmlspecialchars($comment->user_name); ?>
                                </span>
                                <?php if ($comment->role == 'admin'): ?>
                                    <span class="body-small"
                                        style="padding: 2px 6px; background: var(--md-sys-color-error); color: white; border-radius: 4px; font-size: 10px;">ADMIN</span>
                                <?php endif; ?>
                            </div>
                            <p class="body-medium"
                                style="margin: 0; color: var(--md-sys-color-on-surface-variant); word-wrap: break-word;">
                                <?php echo nl2br(htmlspecialchars($comment->body)); ?>
                            </p>
                        </div>

                        <div style="display: flex; gap: 12px; align-items: center; margin-top: 4px; padding-left: 12px;">
                            <span class="body-small" style="color: var(--md-sys-color-on-surface-variant);">
                                <?php echo timeAgo($comment->created_at); ?>
                            </span>
                            <button class="reply-btn body-small" data-comment-id="<?php echo $comment->id; ?>"
                                style="background: none; border: none; color: var(--md-sys-color-primary); cursor: pointer; font-weight: 600;">
                                <i class="fa-solid fa-reply"></i> Reply
                            </button>
                        </div>

                        <!-- Reply Form (hidden by default) -->
                        <div class="reply-form" id="reply-form-<?php echo $comment->id; ?>" style="display: none; margin-top: 8px;">
                            <form action="<?php echo URLROOT; ?>/comments/add/<?php echo $comment->post_id; ?>" method="POST"
                                style="background: var(--md-sys-color-surface); padding: 12px; border-radius: 8px;">
                                <?php csrfField(); ?>
                                <input type="hidden" name="parent_id" value="<?php echo $comment->id; ?>">
                                <div class="md-text-field">
                                    <textarea name="body" class="md-input" placeholder=" " rows="2" required
                                        style="resize: vertical; min-height: 60px;"></textarea>
                                    <label class="md-label">Write a reply...</label>
                                </div>
                                <div style="display: flex; gap: 8px; margin-top: 8px; justify-content: flex-end;">
                                    <button type="button" class="md-button md-button-text cancel-reply">Cancel</button>
                                    <button type="submit" class="md-button md-button-filled"
                                        style="font-size: 13px; height: 32px; padding: 0 16px;">
                                        <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> Reply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // RECURSION: Render children of this comment
            renderComments($comments, $comment->id, $depth + 1);
        }
    }
}

// Helper function for time ago
if (!function_exists('timeAgo')) {
    function timeAgo($datetime)
    {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;

        if ($diff < 60)
            return 'Just now';
        if ($diff < 3600)
            return floor($diff / 60) . ' minutes ago';
        if ($diff < 86400)
            return floor($diff / 3600) . ' hours ago';
        if ($diff < 604800)
            return floor($diff / 86400) . ' days ago';

        return date('M d, Y', $timestamp);
    }
}
?>