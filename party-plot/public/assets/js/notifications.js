/**
 * Admin Notifications System
 * Handles real-time notifications for admin panel
 */

class AdminNotifications {
    constructor() {
        this.notifications = [];
        this.unreadCount = 0;
        this.isInitialized = false;
        this.isLoading = false; // Add loading flag
        this.markAllReadTimeout = null; // Add timeout for debouncing
        this.init();
    }

    init() {
        if (this.isInitialized) return;

        this.bindEvents();
        this.loadNotifications(); // Load real notifications from API
        this.updateNotificationCount();
        this.renderNotifications();
        this.isInitialized = true;

        console.log('Admin Notifications initialized');
    }

    bindEvents() {
        // Handle notification item clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.notification-item')) {
                const notificationId = e.target.closest('.notification-item').dataset.id;
                this.handleNotificationClick(notificationId);
            }
        });

        // Mark as read when dropdown is shown (Zono theme event)
        document.addEventListener('mouseenter', (e) => {
            if (e.target.closest('.notification-dropdown')) {
                // Clear existing timeout
                if (this.markAllReadTimeout) {
                    clearTimeout(this.markAllReadTimeout);
                }

                // Set new timeout to debounce the call
                this.markAllReadTimeout = setTimeout(() => {
                    this.markAllAsRead();
                }, 500); // Wait 500ms before calling
            }
        });
    }



    loadNotifications() {
        // Prevent infinite calls
        if (this.isLoading) {
            console.log('Already loading notifications, skipping...');
            return;
        }

        console.log('Loading notifications...');
        this.isLoading = true;

        // Load notifications from API
        this.makeApiCall('/admin/api/notifications', 'GET')
            .then(data => {
                console.log('Notifications API response:', data);
                if (data && data.notifications) {
                    this.notifications = data.notifications;
                    this.unreadCount = data.unread_count || 0;
                    this.updateNotificationCount();
                    this.renderNotifications();
                    console.log('Notifications updated successfully. Count:', this.unreadCount);
                    console.log('Notifications array:', this.notifications);
                } else {
                    console.log('No notifications data received. Response:', data);
                }
            })
            .catch(error => {
                console.error('Failed to load notifications:', error);
                console.log('Error details:', error.message);
                this.notifications = [];
                this.unreadCount = 0;
                this.updateNotificationCount();
                this.renderNotifications();
            })
            .finally(() => {
                this.isLoading = false;
            });
    }

    updateNotificationCount() {
        console.log('Updating notification count:', this.unreadCount);

        // Update the main badge on the bell icon
        const badge = document.getElementById('notification-badge');
        if (badge) {
            if (this.unreadCount > 0) {
                badge.textContent = this.unreadCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // Update the count in the dropdown header
        const countElement = document.getElementById('notification-count');
        if (countElement) {
            countElement.textContent = this.unreadCount;
        }

        // Update sidebar badge
        const sidebarBadge = document.getElementById('sidebar-notification-badge');
        if (sidebarBadge) {
            if (this.unreadCount > 0) {
                sidebarBadge.textContent = this.unreadCount;
                sidebarBadge.style.display = 'inline-block';
            } else {
                sidebarBadge.style.display = 'none';
            }
        }
    }

    renderNotifications() {
        const container = document.getElementById('notification-list');
        if (!container) return;

        if (this.notifications.length === 0) {
            container.innerHTML = this.getEmptyStateHTML();
            return;
        }

        container.innerHTML = this.notifications
            .slice(0, 20) // Show more notifications with increased width and height
            .map(notification => this.createNotificationHTML(notification))
            .join('');
    }

    createNotificationHTML(notification) {
        const isRead = notification.read_at ? 'read' : 'unread';
        const timeAgo = this.getTimeAgo(notification.created_at);
        const notificationMessage = this.getNotificationMessage(notification);
        const notificationIcon = this.getNotificationIcon(notification.type);
        const notificationType = this.getNotificationTypeLabel(notification);
        const priorityClass = this.getPriorityClass(notification);

        return `
            <div class="notification-item ${isRead} ${priorityClass}" data-id="${notification.id}">
                <div class="notification-content">
                    <div class="notification-icon">
                        <i class="fa-solid ${notificationIcon}"></i>
                    </div>
                    <div class="notification-details">
                        <div class="notification-header">
                            <span class="notification-type-badge">${notificationType}</span>
                            <span class="notification-time">${timeAgo}</span>
                        </div>
                        <div class="notification-text">${notificationMessage}</div>
                    </div>
                </div>
            </div>
        `;
    }

    getNotificationMessage(notification) {
        const type = notification.type || 'general';
        const data = notification.data || {};

        switch(type) {
            case 'agency_wallet_request':
                const message = notification.message || 'Wallet Request has been Updated. Check Transaction History';
                return message;

            case 'booking_created':
                const bookingMessage = notification.message || "New Booking Created";
                return bookingMessage;

            case 'payment_received':
                const payerName = data.payer_name || 'Someone';
                const paymentAmount = data.amount || 'payment';
                const paymentMethodType = data.payment_method || 'payment method';
                return `${payerName} has successfully made a payment of $${paymentAmount} via ${paymentMethodType}.`;

            case 'system_alert':
                return `System Alert: ${notification.message || 'A system alert has been triggered. Please check the system status.'}`;

            default:
                // Try to use the original message if available
                if (notification.message) {
                    return notification.message;
                } else if (notification.title) {
                    return notification.title;
                } else {
                    return 'New notification received';
                }
        }
    }



    getPriorityClass(notification) {
        const priorityMap = {
            'agency_wallet_request': 'priority-high',
            'system_alert': 'priority-high',
            'payment_received': 'priority-medium',
            'booking_created': 'priority-medium'
        };
        return priorityMap[notification.type] || 'priority-'+notification.data.priority;
    }

    getEmptyStateHTML() {
        return `
            <div class="notification-empty">
                <div class="empty-icon">
                    <i class="fa fa-bell-slash"></i>
                </div>
                <h6 class="empty-title">No notifications</h6>
                <p class="empty-message">You're all caught up! New notifications will appear here.</p>
            </div>
        `;
    }

    getNotificationIcon(type) {
        const icons = {
            'agency_wallet_request': 'fa-wallet',
            'booking_created': 'fa-calendar-check',
            'payment_received': 'fa-credit-card',
            'system_alert': 'fa-exclamation-triangle',
            'booking': 'fa-calendar-check',
            'wallet': 'fa-wallet',
            'default': 'fa-info-circle'
        };
        return icons[type] || icons.default;
    }

    getNotificationTypeLabel(notification) {
        const labels = {
            'agency_wallet_request': 'Wallet Request',
            'booking_created': 'New Booking',
            'payment_received': 'Payment',
            'system_alert': 'System Alert',
            'general': 'General'
        };
        return labels[notification.type] || notification.title;
    }

    getTimeAgo(date) {
        const now = new Date();
        const past = new Date(date);
        const diffInSeconds = Math.floor((now - past) / 1000);

        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
        return `${Math.floor(diffInSeconds / 86400)}d ago`;
    }

    async handleNotificationClick(notificationId) {
        try {
            console.log('Handling notification click for ID:', notificationId);

            // Mark this specific notification as read
            await this.markAsRead(notificationId);

            // Get the notification data to find the redirect URL
            const notification = this.notifications.find(n => n.id == notificationId);
            if (notification) {
                const redirectUrl = this.getRedirectUrl(notification);
                if (redirectUrl) {
                    console.log('Redirecting to:', redirectUrl);
                    window.location.href = redirectUrl;
                } else {
                    console.log('No redirect URL found for notification');
                }
            }
        } catch (error) {
            console.error('Error handling notification click:', error);
            this.showToast('Error processing notification', 'error');
        }
    }

    getRedirectUrl(notification) {
        const type = notification.type || 'general';
        const data = notification.data || {};

        // First check if there's a direct redirect_url in the notification
        if (notification.redirect_url) {
            return notification.redirect_url;
        }

        // Then check if there's a redirect_url in the data
        if (data.redirect_url) {
            return data.redirect_url;
        }

        // Generate redirect URL based on notification type
        switch(type) {
            case 'agency_wallet_request':
                if (data.agency_id) {
                    return `/admin/agency-wallet/${data.agency_id}`;
                }
                return '/admin/pending-wallet-history';

            case 'booking_created':
                if (data.booking_id) {
                    return `/admin/bookings/${data.booking_id}`;
                }
                return '/admin/bookings';

            case 'payment_received':
                return '/admin/pending-wallet-history';

            case 'system_alert':
                return '/admin/settings';

            default:
                return null;
        }
    }

    async markAsRead(notificationId) {
        try {
            console.log('Marking notification as read:', notificationId);

            const response = await this.makeApiCall(`/admin/api/notifications/${notificationId}/mark-read`, 'POST');

            if (response.success) {
                console.log('Notification marked as read successfully');

                // Update the notification in our local array
                const notificationIndex = this.notifications.findIndex(n => n.id == notificationId);
                if (notificationIndex !== -1) {
                    this.notifications[notificationIndex].read_at = new Date().toISOString();
                }

                // Update the UI to show the notification as read
                const notificationElement = document.querySelector(`[data-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.classList.remove('unread');
                    notificationElement.classList.add('read');
                }

                // Update the notification count
                this.unreadCount = Math.max(0, this.unreadCount - 1);
                this.updateNotificationCount();

                return true;
            } else {
                console.error('Failed to mark notification as read:', response.message);
                return false;
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
            return false;
        }
    }

    markAllAsRead() {
        // Don't call API if no unread notifications
        if (this.unreadCount === 0) {
            console.log('No unread notifications to mark as read');
            return;
        }

        // Mark all as read via API
        this.makeApiCall('/admin/api/notifications/mark-all-read', 'POST')
            .then(() => {
                this.notifications.forEach(n => {
                    if (!n.read_at) {
                        n.read_at = new Date().toISOString();
                    }
                });
                this.unreadCount = 0;
                this.updateNotificationCount();
                this.renderNotifications();
            })
            .catch(error => {
                console.error('Failed to mark all notifications as read:', error);
            });
    }

    showToast(message, type = 'info') {
        // Use SweetAlert2 if available, otherwise use browser alert
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: message,
                icon: type,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        } else {
            alert(message);
        }
    }

    // Method to add new notification (for real-time updates)
    addNotification(notification) {
        this.notifications.unshift(notification);
        if (!notification.read_at) {
            this.unreadCount++;
        }
        this.updateNotificationCount();
        this.renderNotifications();
        this.showToast(notification.title, 'info');
    }

    // Method to refresh notifications manually
    refreshNotifications() {
        console.log('Manually refreshing notifications...');
        this.loadNotifications();
    }

    // Method to delete notification
    async deleteNotification(notificationId) {
        try {
            console.log('Deleting notification:', notificationId);

            const result = await this.makeApiCall(`/admin/api/notifications/${notificationId}`, 'DELETE');

            if (result.success) {
                // Remove from local array
                this.notifications = this.notifications.filter(n => n.id !== notificationId);

                // Update count
                this.updateNotificationCount();

                // Re-render if on notifications page
                if (window.location.pathname.includes('/notifications')) {
                    window.location.reload();
                } else {
                    this.renderNotifications();
                }

                this.showToast('Notification deleted successfully', 'success');
            } else {
                this.showToast('Failed to delete notification', 'error');
            }
        } catch (error) {
            console.error('Error deleting notification:', error);
            this.showToast('Failed to delete notification', 'error');
        }
    }

    // Method to add test notification (for development/testing)


    // Method to make API calls (placeholder for future implementation)
    async makeApiCall(url, method = 'POST', data = {}) {
        try {
            console.log('Making API call to:', url, 'Method:', method);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            console.log('CSRF Token found:', !!csrfToken);

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json'
                },
                body: method !== 'GET' ? JSON.stringify(data) : undefined,
                credentials: 'same-origin' // Include cookies for session authentication
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            if (!response.ok) {
                const errorText = await response.text();
                console.log('Error response text:', errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log('API response:', result);
            return result;
        } catch (error) {
            console.error('API call failed:', error);
            // Don't show error toast for now since API is not implemented
            // this.showToast('Failed to process notification', 'error');
            throw error; // Re-throw to let calling code handle it
        }
    }
}

// Initialize notifications when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔔 Notifications JavaScript loaded!');

    // Prevent multiple initializations
    if (window.adminNotifications) {
        console.log('Admin notifications already initialized');
        return;
    }

    console.log('🔔 Initializing AdminNotifications...');
    window.adminNotifications = new AdminNotifications();


});

// Export for global access
window.AdminNotifications = AdminNotifications;


