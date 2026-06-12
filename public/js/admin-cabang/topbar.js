document.addEventListener('DOMContentLoaded', function() {
    // Dropdown toggle logic
    const notifBtn = document.getElementById('notif-dropdown-btn');
    const notifMenu = document.getElementById('notif-dropdown-menu');

    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notifMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!notifMenu.contains(e.target) && e.target !== notifBtn && !notifBtn.contains(e.target)) {
                notifMenu.classList.add('hidden');
            }
        });
    }

    // Dynamic unread count updater based on localStorage
    updateUnreadState();

    // Individual click reader
    document.addEventListener('click', function(e) {
        let notifItem = e.target.closest('.notif-item, .notif-page-item');
        if (notifItem) {
            let notifId = notifItem.getAttribute('data-id');
            if (notifId) {
                let readNotifs = JSON.parse(localStorage.getItem('read_notifications') || '[]');
                if (!readNotifs.includes(notifId)) {
                    readNotifs.push(notifId);
                    localStorage.setItem('read_notifications', JSON.stringify(readNotifs));
                }
            }
        }
    });
});

function updateUnreadState() {
    let readNotifs = JSON.parse(localStorage.getItem('read_notifications') || '[]');
    let unreadTopbarItems = document.querySelectorAll('.notif-item');
    let unreadPageItems = document.querySelectorAll('.notif-page-item');
    
    // First, handle topbar dropdown items
    let topbarUnreadCount = 0;
    unreadTopbarItems.forEach(item => {
        let notifId = item.getAttribute('data-id');
        if (readNotifs.includes(notifId)) {
            item.classList.remove('notif-unread');
            item.classList.remove('animate-pulse');
        } else {
            topbarUnreadCount++;
        }
    });

    // Also update notification page items if present
    unreadPageItems.forEach(item => {
        let notifId = item.getAttribute('data-id');
        if (readNotifs.includes(notifId)) {
            item.classList.remove('notif-unread');
            item.classList.remove('animate-pulse');
        }
    });

    // Update UI elements for badge and count text
    const badge = document.querySelector('.badge-notif');
    const countText = document.querySelector('.badge-count-text');

    if (topbarUnreadCount > 0) {
        if (badge) badge.classList.remove('hidden');
        if (countText) countText.innerText = topbarUnreadCount + ' Baru';
    } else {
        if (badge) badge.classList.add('hidden');
        if (countText) countText.innerText = '0 Baru';
    }
}

function markAllAsReadFromTopbar(e) {
    if (e) e.preventDefault();
    let readNotifs = JSON.parse(localStorage.getItem('read_notifications') || '[]');
    let unreadTopbarItems = document.querySelectorAll('.notif-item');
    let unreadPageItems = document.querySelectorAll('.notif-page-item');

    unreadTopbarItems.forEach(item => {
        let notifId = item.getAttribute('data-id');
        if (notifId && !readNotifs.includes(notifId)) {
            readNotifs.push(notifId);
        }
    });

    unreadPageItems.forEach(item => {
        let notifId = item.getAttribute('data-id');
        if (notifId && !readNotifs.includes(notifId)) {
            readNotifs.push(notifId);
        }
    });

    localStorage.setItem('read_notifications', JSON.stringify(readNotifs));
    updateUnreadState();
}
