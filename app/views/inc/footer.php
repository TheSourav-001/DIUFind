</main>

<footer style="background: white; border-top: 1px solid rgba(0,0,0,0.05); padding: 60px 0 30px; margin-top: auto;">
    <div class="container">
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px;">
            <!-- Brand Column -->
            <div data-aos="fade-up">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <div
                        style="width: 40px; height: 40px; background: var(--primary-gradient); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span
                        style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 24px; color: var(--text-main);">DIU
                        Find</span>
                </div>
                <p style="color: var(--text-secondary); margin-bottom: 20px;">
                    The official smart lost and found management system for Daffodil International University.
                </p>
                <div style="display: flex; gap: 12px;">
                    <a href="#" class="icon-box"
                        style="width: 40px; height: 40px; font-size: 18px; margin: 0; background: white; border: 1px solid #e2e8f0;">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="icon-box"
                        style="width: 40px; height: 40px; font-size: 18px; margin: 0; background: white; border: 1px solid #e2e8f0;">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="icon-box"
                        style="width: 40px; height: 40px; font-size: 18px; margin: 0; background: white; border: 1px solid #e2e8f0;">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div data-aos="fade-up" data-aos-delay="100">
                <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Quick Links</h4>
                <ul style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="<?php echo URLROOT; ?>" style="color: var(--text-secondary);">Home</a></li>
                    <li><a href="<?php echo URLROOT; ?>/posts" style="color: var(--text-secondary);">Community Feed</a>
                    </li>
                    <li><a href="<?php echo URLROOT; ?>/posts/map" style="color: var(--text-secondary);">Campus Map</a>
                    </li>
                    <li><a href="<?php echo URLROOT; ?>/pages/leaderboard"
                            style="color: var(--text-secondary);">Leaderboard</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div data-aos="fade-up" data-aos-delay="200">
                <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Contact Us</h4>
                <ul style="display: flex; flex-direction: column; gap: 12px;">
                    <li style="display: flex; gap: 10px; color: var(--text-secondary);">
                        <i class="fa-solid fa-location-dot" style="color: var(--primary-500); margin-top: 4px;"></i>
                        <span>Daffodil Smart City,<br>Birulia, Savar, Dhaka</span>
                    </li>
                    <li style="display: flex; gap: 10px; color: var(--text-secondary);">
                        <i class="fa-solid fa-envelope" style="color: var(--primary-500); margin-top: 4px;"></i>
                        <span>support@diu.edu.bd</span>
                    </li>
                </ul>
            </div>
        </div>

        <div
            style="border-top: 1px solid rgba(0,0,0,0.05); padding-top: 30px; text-align: center; color: var(--text-light); font-size: 14px;">
            <p>&copy; <?php echo date('Y'); ?> DIU Find. All rights reserved.</p>
            <p style="margin-top: 8px;">Developed by <span style="color: var(--primary-500); font-weight: 600;">Sourav
                    Dipto Apu</span></p>
        </div>
    </div>
</footer>

<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Initialize Animations & Loader -->
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
    });

    // Loader Logic
    window.addEventListener('load', function () {
        const loader = document.getElementById('loader-wrapper');
        const isLoaded = sessionStorage.getItem('diuFindLoaded');

        if (isLoaded) {
            loader.style.display = 'none';
        } else {
            setTimeout(() => {
                loader.classList.add('loader-hidden');
                loader.addEventListener('transitionend', () => {
                    loader.style.display = 'none';
                });
                sessionStorage.setItem('diuFindLoaded', 'true');
            }, 1500);
        }
    });

    // Floating label support for inputs
    document.querySelectorAll('.input-premium').forEach(input => {
        // Add listeners if needed for specific interactions
    });

    // ===== NOTIFICATION SYSTEM LOGIC =====
    <?php if (isset($_SESSION['user_id'])): ?>
        const notificationBtn = document.getElementById('notification-btn');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationBadge = document.getElementById('notification-badge');
        const notificationList = document.getElementById('notification-list');
        const markAllReadBtn = document.getElementById('mark-all-read-btn');

        if (notificationBtn) {
            // Toggle dropdown
            notificationBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isVisible = notificationDropdown.style.display === 'block';
                notificationDropdown.style.display = isVisible ? 'none' : 'block';

                if (!isVisible) {
                    loadNotifications();
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (notificationDropdown && !notificationDropdown.contains(e.target) && e.target !== notificationBtn) {
                    notificationDropdown.style.display = 'none';
                }
            });

            // Mark all as read
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', async function () {
                    try {
                        const response = await fetch('<?php echo URLROOT; ?>/notifications/markAllRead', {
                            method: 'POST'
                        });
                        const data = await response.json();
                        if (data.success) {
                            loadNotifications();
                            updateBadge();
                        }
                    } catch (error) {
                        console.error('Error marking all as read:', error);
                    }
                });
            }

            // Load notifications
            async function loadNotifications() {
                try {
                    const response = await fetch('<?php echo URLROOT; ?>/notifications/index');
                    const data = await response.json();

                    if (data.success) {
                        renderNotifications(data.notifications);
                    }
                } catch (error) {
                    notificationList.innerHTML = '<div style="padding: 20px; text-align: center; color: var(--md-sys-color-error);">Failed to load notifications</div>';
                }
            }

            // Render notifications (Premium Style)
            function renderNotifications(notifications) {
                if (notifications.length === 0) {
                    notificationList.innerHTML = `
                    <div style="padding: 60px 20px; text-align: center;">
                        <div style="width: 60px; height: 60px; background: var(--surface-off-white); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: var(--text-light);">
                            <i class="fa-regular fa-bell" style="font-size: 24px;"></i>
                        </div>
                        <h4 style="margin: 0 0 6px; font-size: 16px; font-weight: 600;">No notifications</h4>
                        <p style="margin: 0; font-size: 13px; color: var(--text-secondary);">You're all caught up!</p>
                    </div>
                `;
                    return;
                }

                notificationList.innerHTML = notifications.map((notif, index) => {
                    const isUnread = notif.is_read == 0;

                    // Determine colors/icons based on type
                    let colorClass = 'text-primary';
                    let icon = 'fa-bell';
                    let bgColor = 'var(--primary-100)';
                    let iconColor = 'var(--primary-600)';

                    if (notif.message.toLowerCase().includes('reject')) {
                        bgColor = '#FEF2F2'; iconColor = '#EF4444'; icon = 'fa-circle-xmark';
                    } else if (notif.message.toLowerCase().includes('approv')) {
                        bgColor = '#F0FDF4'; iconColor = '#22C55E'; icon = 'fa-circle-check';
                    }

                    return `
                    <div class="notification-item ${isUnread ? 'unread' : ''}" data-id="${notif.id}" 
                         style="padding: 16px; border-bottom: 1px solid rgba(0,0,0,0.03); cursor: pointer; transition: background 0.2s; ${isUnread ? 'background: var(--surface-off-white);' : ''}"
                         onmouseover="this.style.background='rgba(0,0,0,0.02)'" 
                         onmouseout="this.style.background='${isUnread ? 'var(--surface-off-white)' : 'white'}'">
                        <div style="display: flex; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: ${bgColor}; color: ${iconColor}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid ${icon}"></i>
                            </div>
                            <div style="flex: 1;">
                                <p style="margin: 0 0 4px; font-size: 14px; font-weight: 500; color: var(--text-main); line-height: 1.4;">
                                    ${notif.message}
                                </p>
                                <span style="font-size: 11px; color: var(--text-light); font-weight: 500;">
                                    ${timeAgo(notif.created_at)}
                                </span>
                            </div>
                            ${isUnread ? '<div style="width: 8px; height: 8px; background: var(--primary-500); border-radius: 50%; margin-top: 6px;"></div>' : ''}
                        </div>
                    </div>
                `;
                }).join('');

                // Add click listeners
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.addEventListener('click', async function () {
                        const notifId = this.dataset.id;
                        await markNotificationAsRead(notifId);
                    });
                });
            }

            // Mark single notification as read
            async function markNotificationAsRead(id) {
                try {
                    await fetch(`<?php echo URLROOT; ?>/notifications/markRead/${id}`, {
                        method: 'POST'
                    });
                    loadNotifications();
                    updateBadge();
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                }
            }

            // Update badge count
            async function updateBadge() {
                try {
                    const response = await fetch('<?php echo URLROOT; ?>/notifications/getCount');
                    const data = await response.json();

                    if (data.success && data.count > 0) {
                        notificationBadge.textContent = data.count > 99 ? '99+' : data.count;
                        notificationBadge.style.display = 'flex';
                    } else {
                        notificationBadge.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error updating badge:', error);
                }
            }

            function timeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const seconds = Math.floor((now - date) / 1000);

                if (seconds < 60) return 'Just now';
                const minutes = Math.floor(seconds / 60);
                if (minutes < 60) return minutes + 'm ago';
                const hours = Math.floor(minutes / 60);
                if (hours < 24) return hours + 'h ago';
                const days = Math.floor(hours / 24);
                if (days < 7) return days + 'd ago';
                return date.toLocaleDateString();
            }

            // Initial load
            updateBadge();
            setInterval(updateBadge, 10000); // Poll every 10s
        }
    <?php endif; ?>
</script>
</body>

</html>