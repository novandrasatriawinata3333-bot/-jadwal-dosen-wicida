import './bootstrap';
import Alpine from 'alpinejs';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// ========================================
// DOM READY HANDLER
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎓 Lab WICIDA - Jadwal Dosen System');
    console.log('📅 Version 1.0.0');
    console.log('🚀 Powered by Laravel + Vite + TailwindCSS + DaisyUI');
    
    // Initialize features
    initAlerts();
    initThemeSwitcher();
    initTooltips();
    initModals();
    initFormValidation();
});

// ========================================
// AUTO-HIDE ALERTS
// ========================================
function initAlerts() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    
    alerts.forEach(alert => {
        // Add close button if not exists
        if (!alert.querySelector('.alert-close')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'btn btn-ghost btn-sm btn-circle alert-close';
            closeBtn.innerHTML = '✕';
            closeBtn.onclick = () => hideAlert(alert);
            alert.appendChild(closeBtn);
        }
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            hideAlert(alert);
        }, 5000);
    });
}

function hideAlert(alert) {
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';
    setTimeout(() => {
        alert.remove();
    }, 300);
}

// ========================================
// THEME SWITCHER
// ========================================
function initThemeSwitcher() {
    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'wicida';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    // Listen to theme change
    const themeButtons = document.querySelectorAll('[data-set-theme]');
    themeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const newTheme = this.getAttribute('data-set-theme');
            setTheme(newTheme);
        });
    });
    
    // Keyboard shortcut: Ctrl+Shift+T
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.shiftKey && e.key === 'T') {
            toggleTheme();
        }
    });
}

function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    
    // Show toast notification
    showToast(`Theme changed to ${theme}`, 'info');
}

function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'wicida' : 'dark';
    setTheme(newTheme);
}

// ========================================
// TOOLTIPS
// ========================================
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tip]');
    tooltips.forEach(el => {
        el.classList.add('tooltip');
    });
}

// ========================================
// MODALS
// ========================================
function initModals() {
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('dialog[open]');
            openModals.forEach(modal => {
                modal.close();
            });
        }
    });
}

// ========================================
// FORM VALIDATION
// ========================================
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('input-error');
                    
                    // Show error message
                    const errorMsg = field.getAttribute('data-error') || 'This field is required';
                    showFieldError(field, errorMsg);
                } else {
                    field.classList.remove('input-error');
                    hideFieldError(field);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showToast('Please fill in all required fields', 'error');
            }
        });
    });
}

function showFieldError(field, message) {
    // Remove existing error
    hideFieldError(field);
    
    // Create error element
    const errorEl = document.createElement('label');
    errorEl.className = 'label field-error';
    errorEl.innerHTML = `<span class="label-text-alt text-error">${message}</span>`;
    
    // Insert after field
    field.parentNode.insertBefore(errorEl, field.nextSibling);
}

function hideFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// ========================================
// TOAST NOTIFICATIONS
// ========================================
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-end toast-top`;
    
    const alertClass = type === 'success' ? 'alert-success' : 
                       type === 'error' ? 'alert-error' : 
                       type === 'warning' ? 'alert-warning' : 'alert-info';
    
    toast.innerHTML = `
        <div class="alert ${alertClass} shadow-lg">
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// ========================================
// UTILITY FUNCTIONS
// ========================================

// Copy to clipboard
window.copyToClipboard = function(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Copied to clipboard!', 'success');
    }).catch(err => {
        showToast('Failed to copy', 'error');
    });
};

// Format currency (IDR)
window.formatCurrency = function(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
};

// Format date
window.formatDate = function(date) {
    return new Intl.DateTimeFormat('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }).format(new Date(date));
};

// Debounce function
window.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

// ========================================
// EXPORT FUNCTIONS (if needed)
// ========================================
export { showToast, setTheme, toggleTheme };
