/**
 * cart.js
 * Standalone cart helper — use this if you need addToCart()
 * callable from outside product.php (e.g. other pages).
 * product.php inlines its own version; this file stays in sync.
 */

function addToCart(productId) {
    fetch('cartLogic.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            updateCartBadge(data.new_count);
        } else {
            console.error('Cart error:', data.message);
        }
    })
    .catch(error => console.error('Fetch error:', error));
}

function updateCartBadge(count) {
    document.querySelectorAll('.cart-badge').forEach(b => {
        b.innerText = count;
        b.style.display = count > 0 ? 'flex' : 'none';
    });
}