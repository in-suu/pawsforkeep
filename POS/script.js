const placeholderImage = "images/placeholder.svg";

const productDatabase = [
    // DRY DOG FOOD
    { id: 1, name: "Aozi Adult Dog Food (Lamb & Apple)", price: 180.00, category: "dog-dry", image: placeholderImage },
    { id: 2, name: "Aozi Puppy Dog Food (Beef & Liver)", price: 195.00, category: "dog-dry", image: placeholderImage },
    { id: 3, name: "Pedigree Adult Beef & Veggies", price: 165.00, category: "dog-dry", image: placeholderImage },
    { id: 4, name: "Vitality High Energy Dog Food", price: 210.00, category: "dog-dry", image: placeholderImage },
    { id: 23, name: "Pedigree Puppy Chicken & Milk", price: 175.00, category: "dog-dry", image: placeholderImage },
    { id: 24, name: "Vitality Classic Adult", price: 190.00, category: "dog-dry", image: placeholderImage },
    { id: 25, name: "TopBreed Adult Dog Meal", price: 170.00, category: "dog-dry", image: placeholderImage },
    { id: 26, name: "TopBreed Puppy Meal", price: 180.00, category: "dog-dry", image: placeholderImage },
    { id: 27, name: "Nutri Chunks Adult Liver Flavor", price: 165.00, category: "dog-dry", image: placeholderImage },
    { id: 28, name: "Nutri Chunks Puppy Hi-Protein", price: 175.00, category: "dog-dry", image: placeholderImage },
    { id: 29, name: "Holistic Recipe Adult Lamb & Rice", price: 220.00, category: "dog-dry", image: placeholderImage },
    { id: 30, name: "Holistic Recipe Puppy", price: 205.00, category: "dog-dry", image: placeholderImage },
    { id: 32, name: "Royal Canin Mini Adult", price: 185.00, category: "dog-dry", image: placeholderImage },
    { id: 33, name: "Morando Professional Adult Beef", price: 210.00, category: "dog-dry", image: placeholderImage },
    { id: 34, name: "Special Dog Excellence Adult", price: 195.00, category: "dog-dry", image: placeholderImage },
    // WET DOG FOOD
    { id: 5, name: "Zert Dentacare Fruit Flavor", price: 45.00, category: "dog-wet", image: placeholderImage },
    { id: 6, name: "Royal Canin Puppy Instinctive (Wet)", price: 95.00, category: "dog-wet", image: placeholderImage },
    { id: 31, name: "Zert Cheese Treats", price: 55.00, category: "dog-wet", image: placeholderImage },
    // DRY CAT FOOD
    { id: 7, name: "Whiskas Adult Ocean Fish", price: 160.00, category: "cat-dry", image: placeholderImage },
    { id: 8, name: "Special Cat Adult", price: 155.00, category: "cat-dry", image: placeholderImage },
    { id: 35, name: "Whiskas Junior Mackerel", price: 158.00, category: "cat-dry", image: placeholderImage },
    { id: 37, name: "Kitekat Cat Dry Food (Chicken)", price: 140.00, category: "cat-dry", image: placeholderImage },
    { id: 38, name: "Kitekat Tuna & Mackerel (Dry)", price: 142.00, category: "cat-dry", image: placeholderImage },
    { id: 40, name: "Special Cat Adult (All Life Stages)", price: 160.00, category: "cat-dry", image: placeholderImage },
    { id: 42, name: "Zoi Cat Food Mix Flavor", price: 155.00, category: "cat-dry", image: placeholderImage },
    { id: 43, name: "Aozi Cat Food (Salmon & Fruits)", price: 165.00, category: "cat-dry", image: placeholderImage },
    // WET CAT FOOD
    { id: 9, name: "Whiskas Tuna (Wet Pouch)", price: 35.00, category: "cat-wet", image: placeholderImage },
    { id: 10, name: "Ciao Churu Tuna with Collagen", price: 120.00, category: "cat-wet", image: placeholderImage },
    { id: 36, name: "Whiskas Grilled Reef Fish (Wet)", price: 38.00, category: "cat-wet", image: placeholderImage },
    { id: 39, name: "Ciao Churu Chicken Fillet", price: 125.00, category: "cat-wet", image: placeholderImage },
    { id: 41, name: "Princess Cat Tuna & Salmon", price: 145.00, category: "cat-wet", image: placeholderImage },
    { id: 44, name: "Inaba Grilled Skipjack", price: 130.00, category: "cat-wet", image: placeholderImage },
    { id: 45, name: "Sheba Melty Cat Treats", price: 95.00, category: "cat-wet", image: placeholderImage },
    { id: 46, name: "Meow Mix Seafood Livery", price: 132.00, category: "cat-wet", image: placeholderImage },
    // BOWLS & FEEDING
    { id: 11, name: "Automatic Dog Feeder (White)", price: 1500.00, category: "food-dispenser", image: placeholderImage },
    { id: 47, name: "Doggo Dog Food Dispenser (Blue)", price: 1350.00, category: "food-dispenser", image: placeholderImage },
    { id: 12, name: "Kennel Pro Pet Water Fountain", price: 950.00, category: "water-fountain", image: placeholderImage },
    { id: 48, name: "Ceramic Cat Bowl (Elevated)", price: 230.00, category: "bowls", image: placeholderImage },
    { id: 49, name: "Portable Travel Water Bottle", price: 590.00, category: "water-fountain", image: placeholderImage },
    { id: 50, name: "Double Pet Bowl with Stand", price: 380.00, category: "bowls", image: placeholderImage },
    { id: 13, name: "Stainless Steel Anti-Skid Bowl", price: 120.00, category: "bowls", image: placeholderImage },
    // GROOMING
    { id: 14, name: "Pleasant Pet Shampoo (Lavender)", price: 220.00, category: "shampoo-soap", image: placeholderImage },
    { id: 51, name: "Pleasant Pet Shampoo (Tick & Flea)", price: 230.00, category: "shampoo-soap", image: placeholderImage },
    { id: 15, name: "Pet Brush & Comb (Self-Cleaning)", price: 185.00, category: "brush-comb", image: placeholderImage },
    { id: 16, name: "Pet Grooming Nail Clipper", price: 120.00, category: "grooming-tools", image: placeholderImage },
    { id: 52, name: "Pet Wipes 100pcs (Alcohol-Free)", price: 190.00, category: "grooming-tools", image: placeholderImage },
    { id: 53, name: "M-Pets Ear Cleaner Solution", price: 145.00, category: "grooming-tools", image: placeholderImage },
    { id: 54, name: "PawTalk Slicker Brush", price: 210.00, category: "grooming-tools", image: placeholderImage },
    { id: 55, name: "MewooFun Bath Massage Brush", price: 175.00, category: "grooming-tools", image: placeholderImage },
    // TOYS
    { id: 17, name: "Interactive Cat Laser Toy", price: 150.00, category: "interactive-toys", image: placeholderImage },
    { id: 18, name: "Squeaky Rubber Chicken Toy", price: 95.00, category: "chew-toys", image: placeholderImage },
    { id: 58, name: "Absolute Holistic Dental Chew", price: 120.00, category: "chew-toys", image: placeholderImage },
    { id: 59, name: "MewooFun Cat Scratching Post", price: 350.00, category: "scratchers", image: placeholderImage },
    { id: 60, name: "Infinity Cotton Rope Toy", price: 110.00, category: "chew-toys", image: placeholderImage },
    // BEDDING
    { id: 19, name: "Orthopedic Dog Bed (Large)", price: 1850.00, category: "beddings", image: placeholderImage },
    { id: 20, name: "Soft Cat Cave Bed", price: 850.00, category: "beddings", image: placeholderImage },
    { id: 56, name: "Foldable Pet Playpen", price: 1250.00, category: "pet-bed-house", image: placeholderImage },
    { id: 57, name: "Cooling Mat for Summer", price: 390.00, category: "pet-bed-house", image: placeholderImage },
    // HEALTH
    { id: 21, name: "Multi-Vitamin Soft Chews", price: 580.00, category: "supplements-treatment", image: placeholderImage },
    { id: 22, name: "Flea & Tick Prevention Collar", price: 350.00, category: "supplements-treatment", image: placeholderImage },
    // SAFETY & COLLAR
    { id: 61, name: "Zee.Dog Adjustable Collar", price: 420.00, category: "collar", image: placeholderImage },
    { id: 62, name: "EzyDog Zero Shock Leash", price: 585.00, category: "harness-leash", image: placeholderImage },
    { id: 63, name: "Reflective Harness for Dogs", price: 670.00, category: "harness-leash", image: placeholderImage }
];

let cart = [];
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
            ? `<img src="${p.image}" alt="${p.name}">`
            : `<div class="product-placeholder"><i class="fa-solid fa-paw"></i><span>No Image</span></div>`;

        card.innerHTML = `
            <div class="product-img-container">${visual}</div>
            <div class="product-name">${p.name}</div>
            <div class="product-footer">
                <span class="price">₱${p.price.toFixed(2)}</span>
                <button class="add-btn" onclick="addToCart(${p.id})">Add to Cart</button>
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

function addToCart(productId) {
    const product = productDatabase.find(p => p.id === productId);
    const dateStr = new Date().toLocaleDateString();
    const existing = cart.find(item => item.id === productId);

    if (existing) {
        existing.quantity += 1;
        existing.date = dateStr;
    } else {
        cart.push({ ...product, quantity: 1, date: dateStr });
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
    updateHeaderDate();
    setInterval(updateHeaderDate, 1000);

    // Fix "Proceed to Payment" button
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (cart.length === 0) {
                alert("Your cart is empty! 🐾");
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
});