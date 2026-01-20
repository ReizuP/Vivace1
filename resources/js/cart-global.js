/**
 * Global Cart Management Script
 * Provides cart functionality across all pages
 */

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateNavCartCount();
});

/**
 * Update navigation cart count badge
 */
function updateNavCartCount() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        updateCartBadge(data.count);
    })
    .catch(error => {
        console.error('Error fetching cart count:', error);
    });
}

/**
 * Update cart badge in navigation
 */
function updateCartBadge(count) {
    const badge = document.querySelector('.navbar .badge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

/**
 * Show toast notification
 */
function showGlobalToast(message, type = 'success') {
    // Create toast if it doesn't exist
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3 toast-container';
        toastContainer.style.zIndex = '11';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white">
                <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">${message}</div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    const toastElement = document.getElementById(toastId);
    const toast = new window.bootstrap.Toast(toastElement);
    toast.show();

    // Remove toast from DOM after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}

/**
 * Format number as currency
 */
function formatCurrency(amount) {
    return parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * Add item to cart via AJAX (can be called from any page)
 */
function addToCartGlobal(productId, quantity = 1) {
    return fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showGlobalToast(data.message, 'success');
            updateCartBadge(data.cartCount);
        } else {
            showGlobalToast(data.message, 'danger');
        }
        return data;
    })
    .catch(error => {
        console.error('Error:', error);
        showGlobalToast('Failed to add to cart. Please try again.', 'danger');
        throw error;
    });
}

// Make functions globally available
window.updateNavCartCount = updateNavCartCount;
window.updateCartBadge = updateCartBadge;
window.showGlobalToast = showGlobalToast;
window.formatCurrency = formatCurrency;
window.addToCartGlobal = addToCartGlobal;
