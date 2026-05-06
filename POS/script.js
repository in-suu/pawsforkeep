const placeholderImage = "images/placeholder.svg";

const productDatabase = window.dbProducts || [];

let cart = [];
try {
    const savedCart = localStorage.getItem('posCart');
    if (savedCart) cart = JSON.parse(savedCart);
} catch (e) {
    console.error("Failed to parse cart from localStorage");
}
const grid = document.getElementById('productGrid');
const cartContainer = document.getElementById('cartItems');

let currentCategory = "all";

function displayProducts(filter = "all", searchTerm = "") {
    grid.innerHTML = '';
    currentCategory = filter;
    
    let filtered = filter === "all" ? productDatabase : productDatabase.filter(p => p.category === filter);

    if (searchTerm) {
        filtered = filtered.filter(p => p.name.toLowerCase().includes(searchTerm.toLowerCase()));
    }

    if (filtered.length === 0) {
        grid.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #888; padding: 50px;">No products found matching "${searchTerm}"</p>`;
        return;
    }

    filtered.forEach(p => {
        const card = document.createElement('div');
        card.className = 'product-card';
        const visual = p.image
            ? `<img src="${p.image}" alt="${p.name}" onerror="this.src='https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/logo.png'">`
            : `<div class="product-placeholder"><i class="fa-solid fa-paw"></i><span>No Image</span></div>`;

        card.innerHTML = `
            <div class="product-img-container" onclick="openProductModal('${p.id}')" style="cursor: pointer;">${visual}</div>
            <div class="product-name" onclick="openProductModal('${p.id}')" style="cursor: pointer;">${p.name}</div>
            <div class="product-footer">
                <span class="price">₱${p.price.toFixed(2)}</span>
                <button class="add-btn" onclick="addToCart('${p.id}')">Add to Cart</button>
            </div>
        `;
        grid.appendChild(card);
    });
}

// SEARCH LOGIC
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', (e) => {
        displayProducts(currentCategory, e.target.value);
    });
}

function addToCart(productId, qtyToAdd = 1) {
    const product = productDatabase.find(p => String(p.id) === String(productId));
    if (!product) return;
    
    const dateStr = new Date().toLocaleDateString();
    const existing = cart.find(item => String(item.id) === String(productId));

    if (existing) {
        existing.quantity += qtyToAdd;
        existing.date = dateStr;
    } else {
        cart.push({ ...product, quantity: qtyToAdd, date: dateStr });
    }
    updateCart();
}

function updateHeaderDate() {
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
        dateEl.innerText = new Date().toLocaleDateString();
    }
}

function updateCart() {
    localStorage.setItem('posCart', JSON.stringify(cart));
    cartContainer.innerHTML = '';
    let total = 0, count = 0;
    cart.forEach((item, idx) => {
        total += item.price * item.quantity;
        count += item.quantity;
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <div class="cart-item-info"><b>${item.name}</b><span>₱${item.price.toFixed(2)} — ${item.date}</span></div>
            <div class="qty-ctrl">
                <button class="q-btn" onclick="changeQty(${idx}, -1)">-</button>
                <input type="text" class="q-input" value="${item.quantity}" readonly>
                <button class="q-btn" onclick="changeQty(${idx}, 1)">+</button>
            </div>
        `;
        cartContainer.appendChild(div);
    });
    document.getElementById('totalCount').innerText = count;
    document.getElementById('subTotal').innerText = `₱${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
    document.getElementById('grandTotal').innerText = `₱${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
}

function changeQty(idx, delta) {
    cart[idx].quantity += delta;
    if (cart[idx].quantity <= 0) cart.splice(idx, 1);
    updateCart();
}

document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        displayProducts(btn.getAttribute('data-category'));
    });
});

document.addEventListener('DOMContentLoaded', () => {
    displayProducts("all");
    updateCart(); // Load and display existing cart from localStorage
    updateHeaderDate();
    setInterval(updateHeaderDate, 1000);

    // Fix "Proceed to Payment" button
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (cart.length === 0) {
                const modal = document.getElementById('cuteAlertModal');
                if (modal) {
                    modal.classList.add('show');
                } else {
                    alert("Your cart is empty! 🐾");
                }
                return;
            }

            let total = 0;
            cart.forEach(item => {
                total += item.price * item.quantity;
            });

            // Redirect to payment.php with the total amount
            window.location.href = `payment.php?total=${total}`;
        });
    }

    // Close Cute Modal
    const closeAlertBtn = document.getElementById('closeCuteAlert');
    if (closeAlertBtn) {
        closeAlertBtn.addEventListener('click', () => {
            document.getElementById('cuteAlertModal').classList.remove('show');
        });
    }
});

// Modal Logic
let currentModalProductId = null;
let currentModalQty = 1;

function openProductModal(productId) {
    const product = productDatabase.find(p => String(p.id) === String(productId));
    if (!product) return;
    
    currentModalProductId = productId;
    currentModalQty = 1;
    
    document.getElementById('modalProductImg').src = product.image || placeholderImage;
    document.getElementById('modalProductName').innerText = product.name;
    document.getElementById('modalProductPrice').innerText = `₱${product.price.toFixed(2)}`;
    document.getElementById('modalProductDesc').innerHTML = product.description ? product.description.replace(/\n/g, '<br>') : 'No description available.';
    document.getElementById('modalProductQty').value = currentModalQty;
    
    document.getElementById('productModal').classList.add('show');
}

function closeProductModal() {
    document.getElementById('productModal').classList.remove('show');
    currentModalProductId = null;
}

function changeModalQty(delta) {
    let newQty = currentModalQty + delta;
    if (newQty < 1) newQty = 1;
    currentModalQty = newQty;
    document.getElementById('modalProductQty').value = currentModalQty;
}

function modalAddToCart() {
    if (currentModalProductId) {
        addToCart(currentModalProductId, currentModalQty);
        closeProductModal();
    }
}

function modalBuyNow() {
    if (currentModalProductId) {
        addToCart(currentModalProductId, currentModalQty);
        closeProductModal();
        const checkoutBtn = document.querySelector('.checkout-btn');
        if (checkoutBtn) checkoutBtn.click();
    }
}

window.addEventListener('click', (e) => {
    const modal = document.getElementById('productModal');
    if (e.target === modal) {
        closeProductModal();
    }
});