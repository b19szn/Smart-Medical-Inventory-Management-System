// Sidebar Toggle
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Dynamic item selection for stock operations
    const itemSelects = document.querySelectorAll('.item-select');
    itemSelects.forEach(select => {
        select.addEventListener('change', function() {
            const itemId = this.value;
            if (itemId) {
                fetchItemDetails(itemId);
            }
        });
    });
});

// Fetch item details (for stock operations)
function fetchItemDetails(itemId) {
    // This would typically make an AJAX call to get item details
    console.log('Fetching details for item:', itemId);
}

// Chart initialization (for dashboard)
function initializeCharts() {
    // This would use a charting library like Chart.js
    console.log('Initializing charts...');
}

// Export functionality
function exportData(format, type) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/export/${format}`;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken.content;
        form.appendChild(csrfInput);
    }
    
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'type';
    typeInput.value = type;
    form.appendChild(typeInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Real-time search
function setupSearch() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // Perform search
                console.log('Searching for:', this.value);
            }, 300);
        });
    }
}

// Initialize on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCharts);
    document.addEventListener('DOMContentLoaded', setupSearch);
} else {
    initializeCharts();
    setupSearch();
}
