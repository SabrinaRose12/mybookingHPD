// RoomSense — app.js
import './echo';

// ── Apply theme IMMEDIATELY to avoid flash ──
(function() {
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();

document.addEventListener('DOMContentLoaded', () => {

    // ── Auto-dismiss flash alerts after 5 seconds ──
    document.querySelectorAll('[data-auto-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity    = '0';
            el.style.transform  = 'translateY(-8px)';
            setTimeout(() => el.remove(), 500);
        }, 5000);
    });

    // ── Confirm before destructive actions ──
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', e => {
            const message = btn.dataset.confirm || 'Are you sure?';
            if (!confirm(message)) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    // ── Submit hidden form on data-form-submit click ──
    document.querySelectorAll('[data-form-id]').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = document.getElementById(btn.dataset.formId);
            if (form) form.submit();
        });
    });

    // ── Logout Modal Functions ──
    window.openLogoutModal = function() {
        const modal = document.getElementById('logout-modal');
        const content = document.getElementById('logout-modal-content');
        
        if (!modal || !content) return;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 50);
    };

    window.closeLogoutModal = function() {
        const modal = document.getElementById('logout-modal');
        const content = document.getElementById('logout-modal-content');
        
        if (!modal || !content) return;
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    };

    window.confirmLogout = function() {
        const form = document.getElementById('logout-form') || document.getElementById('logout-form-mobile');
        if (form) {
            form.submit();
        }
    };

    const modal = document.getElementById('logout-modal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });
    }
});