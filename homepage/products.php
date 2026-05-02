<?php 
session_start(); 
include '../homepage/db_connect.php';

$cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";

$limit = 8; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit; 

$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : 'All';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$brand = isset($_GET['brand']) ? mysqli_real_escape_string($conn, $_GET['brand']) : '';

$whereClause = " WHERE 1=1"; 
if ($category !== 'All') { $whereClause .= " AND prod_category = '$category'"; }
if ($brand !== '') { $whereClause .= " AND prod_name LIKE '%$brand%'"; }

$orderClause = "";
if ($sort === 'low') $orderClause = " ORDER BY prod_price ASC";
if ($sort === 'high') $orderClause = " ORDER BY prod_price DESC";

$total_query = "SELECT COUNT(*) as total FROM tbl_products" . $whereClause;
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="products.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="navbar-footer.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .dropdown { position: relative; display: flex; align-items: center; }
        .dropdown-content { display: none; position: absolute; background-color: #FFFFFF; min-width: 200px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 5000; top: 100%; left: 0; border-radius: 5px; }
        .dropdown:hover .dropdown-content { display: block; }
        .dropdown-content a { color: #4D2412 !important; padding: 12px 16px; text-decoration: none; display: block; text-align: left; font-size: 13px !important; border-bottom: 1px solid #eee; text-transform: none !important; }
        .dropdown-content a:hover { background-color: #FFBE3E; color: #fff !important; }
        .pagination { display: flex; justify-content: center; gap: 8px; margin: 40px 0; align-items: center; }
        .pagination a { padding: 10px 18px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #4D2412; background: #fff; transition: 0.3s; font-weight: bold; font-size: 18px; }
        .pagination a.active { background-color: #FFBE3E; color: white; border-color: #FFBE3E; }
        .card img { width: 100%; height: 160px; object-fit: contain; margin-bottom: 10px; }

        .cart-badge {
            background: #D32F2F;
            color: white;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            font-size: 11px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid white;
            padding: 0 3px;
            line-height: 1;
        }

        .sticky-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #FFBE3E;
            border: none;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 18px rgba(255,190,62,0.5), 0 2px 8px rgba(0,0,0,0.15);
            z-index: 9999;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            cursor: pointer;
        }
        .sticky-cart:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 24px rgba(255,190,62,0.6), 0 3px 10px rgba(0,0,0,0.2);
        }
        .sticky-cart svg { width: 30px; height: 30px; }
        .sticky-cart .cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 22px;
            height: 22px;
            font-size: 11px;
            font-weight: 700;
            border: 2px solid #fff;
            padding: 0 4px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }

        /* ── Mini Cart Panel ── */
        .mini-cart-panel {
            position: fixed;
            bottom: 105px;
            right: 25px;
            width: 320px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.18);
            z-index: 9998;
            overflow: hidden;
            display: none;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            animation: slideUp 0.22s ease;
        }
        .mini-cart-panel.open { display: flex; }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .mini-cart-header {
            background: #FFBE3E;
            padding: 12px 16px;
            font-weight: 600;
            font-size: 14px;
            color: #4D2412;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .mini-cart-header span { font-size: 18px; cursor: pointer; line-height: 1; color: #4D2412; }
        .mini-cart-items { max-height: 280px; overflow-y: auto; padding: 8px 0; }
        .mini-cart-items::-webkit-scrollbar { width: 4px; }
        .mini-cart-items::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }
        .mini-cart-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-bottom: 1px solid #f5f5f5;
        }
        .mini-cart-item:last-child { border-bottom: none; }
        .mini-cart-item img { width: 48px; height: 48px; object-fit: contain; border: 1px solid #eee; border-radius: 6px; flex-shrink: 0; }
        .mini-cart-item-info { flex: 1; min-width: 0; }
        .mini-cart-item-name { font-size: 12px; font-weight: 600; color: #222; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .mini-cart-item-price { font-size: 12px; color: #D32F2F; font-weight: 500; margin-top: 2px; }
        .mini-cart-item-qty { font-size: 11px; color: #888; background: #f5f5f5; border-radius: 10px; padding: 2px 8px; flex-shrink: 0; }
        .mini-cart-empty { padding: 30px 16px; text-align: center; color: #aaa; font-size: 13px; }
        .mini-cart-footer {
            padding: 12px 16px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .mini-cart-total { font-size: 13px; color: #333; font-weight: 600; }
        .mini-cart-total span { color: #D32F2F; }
        .mini-cart-view-btn {
            background: #D32F2F;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            transition: background 0.2s;
        }
        .mini-cart-view-btn:hover { background: #b71c1c; }

        /* ── Toast ── */
        .cart-toast {
            position: fixed;
            bottom: 105px;
            right: 25px;
            background: #333;
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            z-index: 10001;
            opacity: 0;
            transform: translateY(6px);
            transition: opacity 0.25s, transform 0.25s;
            pointer-events: none;
            white-space: nowrap;
        }
        .cart-toast.show { opacity: 1; transform: translateY(0); }
        .cart-toast .toast-check { color: #4CAF50; margin-right: 6px; font-size: 15px; }

        .cart-flight {
            position: fixed;
            background-color: #D32F2F;
            border-radius: 50%;
            z-index: 10000;
            pointer-events: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* ── SweetAlert custom styles ── */
        .swal-auth-btn-login {
            background: linear-gradient(135deg, #A35524, #FFBE3E) !important;
            color: #fff !important;
            font-weight: 600 !important;
            border-radius: 50px !important;
            padding: 10px 28px !important;
            font-size: 14px !important;
        }
        .swal-auth-btn-signup {
            background: #fff !important;
            color: #4D2412 !important;
            border: 2px solid #FFBE3E !important;
            font-weight: 600 !important;
            border-radius: 50px !important;
            padding: 10px 28px !important;
            font-size: 14px !important;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="sub-navbar">
        <div class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">PET FOOD ▾</a>
            <div class="dropdown-content">
                <a href="products.php?category=Cat Dry">Cat Dry Food</a>
                <a href="products.php?category=Cat Wet">Cat Wet Food</a>
                <hr style="border: 0.5px solid #eee; margin: 0;">
                <a href="products.php?category=Dog Dry">Dog Dry Food</a>
                <a href="products.php?category=Dog Wet">Dog Wet Food</a>
            </div>
        </div>
        <a href="products.php?category=Food %26 Water Bowls">FOOD & WATER BOWLS</a>
        <a href="products.php?category=Grooming %26 Tools">GROOMING & TOOLS</a>
        <a href="products.php?category=Pet Bedding %26 House">PET BEDDING & HOUSE</a>
        <a href="products.php?category=Pet Toys %26 Accessories">PET TOYS & ACCESSORIES</a>
        <a href="products.php?category=Safety Collar %26 Leash">SAFETY COLLAR & LEASH</a>
        <a href="products.php?category=Supplements">SUPPLEMENTS</a>
    </div>

    <div style="max-width: 1440px; margin: 20px auto 0; padding: 0 10px;">
        <div class="external-controls">
            <input type="text" id="productSearch" placeholder="Search Products" onkeyup="handleSearch('productSearch')">
            <div style="display: flex; gap: 10px;">
                <select id="sortSelect" onchange="applySort()">
                    <option value="default" <?php if($sort=='default') echo 'selected'; ?>>Sort by</option>
                    <option value="low" <?php if($sort=='low') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="high" <?php if($sort=='high') echo 'selected'; ?>>Price: High to Low</option>
                </select>
            </div>
        </div>
    </div>

    <div class="container">
        <aside class="sidebar">
            <h3 onclick="document.getElementById('brandList').classList.toggle('show-mobile');">
                Brand Collections <span class="sidebar-toggle-icon" style="float: right;">▾</span>
            </h3>
            <ul id="brandList">
                <li><a href="products.php">All Brands</a></li>
                <?php 
                $brands = ["Aozi", "Beef Pro", "Ciao", "Doggo", "EzyDog", "Holistic", "Inaba", "Infinity", "Kennel", "Lucky Dog", "Mewoo", "Morando", "Nutri Chunks", "Pedigree", "Sheba", "SmartHeart", "Special", "Vitality", "Whiskas", "Zee.Dog", "Zoi"];
                foreach($brands as $b) {
                    echo "<li><a href='products.php?brand=$b'>$b</a></li>";
                }
                ?>
            </ul>
        </aside>

        <main class="main" id="mainContent">
            <div class="banner" style="width: 100%; margin-bottom: 20px;">
                <img src="../images/banner.png" alt="Banner" style="width: 100%; border-radius: 10px; display: block;">
            </div>

            <div class="title-row">
                <div>
                    <h2><?php echo ($brand !== '') ? "Brand: $brand" : $category; ?></h2>
                    <p>Showing <?php echo ($total_products > 0) ? ($offset + 1) : 0; ?> - <?php echo min($offset + $limit, $total_products); ?> of <?php echo $total_products; ?> products</p>
                </div>
            </div>

            <div class="products-grid" id="productGrid">
                <?php
                $query = "SELECT * FROM tbl_products $whereClause $orderClause LIMIT $limit OFFSET $offset";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $db_image_path = trim($row['prod_image'], '/');
                        $image_url = $cloudinary_base . str_replace(' ', '%20', $db_image_path);
                ?>
                        <div class="card">
                            <button class="info-btn" onclick="openInfo('<?php echo addslashes($row['prod_name']); ?>', '<?php echo addslashes($row['prod_description']); ?>', '<?php echo $image_url; ?>')">i</button>
                            <img src="<?php echo $image_url; ?>" onerror="this.src='../images/logo.png'" alt="Product">
                            <div class="card-text-container">
                                <h4><?php echo $row['prod_name']; ?></h4>
                                <p>₱<?php echo number_format($row['prod_price'], 2); ?></p>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCart('<?php echo $row['prod_id']; ?>', this)">Add to Cart</button>
                        </div>
                <?php 
                    } 
                } else {
                    echo "<p style='grid-column: 1/-1; text-align: center; padding: 50px;'>No products found.</p>";
                }
                ?>
            </div>

            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if($page > 1): ?>
                    <a href="products.php?category=<?php echo urlencode($category); ?>&brand=<?php echo urlencode($brand); ?>&sort=<?php echo $sort; ?>&page=<?php echo ($page - 1); ?>">&laquo;</a>
                <?php endif; ?>
                <?php 
                $start_p = max(1, $page - 1);
                $end_p = min($total_pages, $page + 1);
                for($i = $start_p; $i <= $end_p; $i++): ?>
                    <a href="products.php?category=<?php echo urlencode($category); ?>&brand=<?php echo urlencode($brand); ?>&sort=<?php echo $sort; ?>&page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                <?php if($page < $total_pages): ?>
                    <a href="products.php?category=<?php echo urlencode($category); ?>&brand=<?php echo urlencode($brand); ?>&sort=<?php echo $sort; ?>&page=<?php echo ($page + 1); ?>">&raquo;</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <div id="modal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.8);">
        <div class="modal-content" style="background:#fff; margin:10% auto; padding:30px; width:550px; border-radius:15px; position:relative; box-shadow: 0 5px 30px rgba(0,0,0,0.3);">
            <span class="close" onclick="closeModal()" style="position:absolute; right:20px; top:15px; font-size:35px; cursor:pointer; color:#888;">&times;</span>
            <div style="display:flex; gap:30px; align-items:center; margin-top:10px;">
                <div style="flex:1; background:#f9f9f9; padding:10px; border-radius:10px;">
                    <img id="modal-img" src="" style="width:100%; height:200px; object-fit:contain;">
                </div>
                <div style="flex:1.5;">
                    <h3 id="modal-title" style="color:#4D2412; font-size:20px; margin-bottom:5px;"></h3>
                    <hr style="border:0; border-top:2px solid #FFBE3E; width:50px; margin:10px 0;">
                    <p id="modal-desc" style="color:#555; font-size:14px; line-height:1.6;"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-toast" id="cartToast"><span class="toast-check">✓</span><span id="toastMsg">Added to cart!</span></div>

    <div class="mini-cart-panel" id="miniCartPanel">
        <div class="mini-cart-header">
            🛒 My Cart
            <span onclick="closeMiniCart()" title="Close">×</span>
        </div>
        <div class="mini-cart-items" id="miniCartItems">
            <div class="mini-cart-empty">Your cart is empty</div>
        </div>
        <div class="mini-cart-footer">
            <div class="mini-cart-total">Total: <span id="miniCartTotal">₱0.00</span></div>
            <a href="cart.php" class="mini-cart-view-btn">View Cart</a>
        </div>
    </div>

    <div class="sticky-cart" id="stickyCart" title="View Cart" onclick="toggleMiniCart()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <span class="cart-badge" style="<?php echo ($cart_count > 0) ? '' : 'display:none;'; ?>"><?php echo $cart_count; ?></span>
    </div>

    <?php include 'footer.php'; ?>

<script>
    const isLoggedIn = <?php echo $is_logged_in ? 'true' : 'false'; ?>;
    let miniCart = <?php
        $mini = [];
        if (!empty($_SESSION['cart'])) {
            $mc_ids = [];
            foreach ($_SESSION['cart'] as $pid => $qty) {
                $mc_ids[] = "'" . mysqli_real_escape_string($conn, (string)$pid) . "'";
            }
            $mc_result = mysqli_query($conn, "SELECT prod_id, prod_name, prod_price, prod_image FROM tbl_products WHERE prod_id IN (" . implode(',', $mc_ids) . ")");
            while ($mc_row = mysqli_fetch_assoc($mc_result)) {
                $mpid = $mc_row['prod_id'];
                $enc  = str_replace('%2F', '/', rawurlencode($mc_row['prod_image']));
                $mini[] = [
                    'id'    => $mpid,
                    'name'  => $mc_row['prod_name'],
                    'price' => (float)$mc_row['prod_price'],
                    'qty'   => (int)$_SESSION['cart'][$mpid],
                    'img'   => $cloudinary_base . $enc
                ];
            }
        }
        echo json_encode($mini);
    ?>;

    function addToCart(productId, btnElement) {
        if (!isLoggedIn) { showAuthModal(); return; }
        const e = window.event;
        const startX = e ? e.clientX : window.innerWidth / 2;
        const startY = e ? e.clientY : window.innerHeight / 2;
        if (btnElement) { btnElement.disabled = true; btnElement.innerText = 'Adding...'; }
        flyToCart(startX, startY);
        fetch('cartLogic.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + encodeURIComponent(productId)
        })
        .then(r => r.json()).then(data => {
            if (data.status === 'success') {
                updateCartBadge(data.new_count);
                fetchMiniCartData(productId, btnElement ? btnElement.closest('.card') : null);
            } else if (data.status === 'auth_required') { showAuthModal(); }
        }).finally(() => {
            if (btnElement) { btnElement.disabled = false; btnElement.innerText = 'Add to Cart'; }
        });
    }

    function renderMiniCart() {
        const container = document.getElementById('miniCartItems');
        const totalEl   = document.getElementById('miniCartTotal');
        if (!miniCart.length) { container.innerHTML = '<div class="mini-cart-empty">Your cart is empty</div>'; totalEl.innerText = '₱0.00'; return; }
        let html = '', total = 0;
        miniCart.forEach(item => {
            const lineTotal = item.price * item.qty; total += lineTotal;
            /* 🛠️ Fixed fallback logo path in mini cart */
            html += `<div class="mini-cart-item"><img src="${item.img}" onerror="this.src='../images/logo.png'" alt=""><div class="mini-cart-item-info"><div class="mini-cart-item-name">${item.name}</div><div class="mini-cart-item-price">₱${lineTotal.toLocaleString('en-US',{minimumFractionDigits:2})}</div></div><div class="mini-cart-item-qty">x${item.qty}</div></div>`;
        });
        container.innerHTML = html;
        totalEl.innerText = '₱' + total.toLocaleString('en-US', { minimumFractionDigits: 2 });
    }

    // Other scripts remain exactly the same as provided
    function showAuthModal() {
        Swal.fire({
            title: '<span style="color:#4D2412; font-size:20px;">Login Required 🐾</span>',
            html: `<p style="color:#555; font-size:14px; line-height:1.6;">You need to log in before adding items.</p>`,
            icon: 'info', iconColor: '#FFBE3E', showCancelButton: true, showDenyButton: true, confirmButtonText: 'Login', denyButtonText: 'Sign Up', cancelButtonText: 'Maybe Later', confirmButtonColor: '#A35524', denyButtonColor: '#FFBE3E', cancelButtonColor: '#aaa'
        }).then((result) => { if (result.isConfirmed) window.location.href = 'login.php'; else if (result.isDenied) window.location.href = 'signup.php'; });
    }
    function fetchMiniCartData(addedId, cardEl) {
        let name = '(item)', price = 0, img = '';
        if (cardEl) { name = cardEl.querySelector('h4')?.innerText || name; price = parseFloat(cardEl.querySelector('p')?.innerText.replace('₱','').replace(/,/g,'')) || 0; img = cardEl.querySelector('img')?.src || ''; }
        const existing = miniCart.find(i => String(i.id) === String(addedId));
        if (existing) existing.qty++; else miniCart.push({ id: addedId, name, price, qty: 1, img });
        renderMiniCart(); showToast(name);
    }
    function toggleMiniCart() { const panel = document.getElementById('miniCartPanel'); panel.classList.contains('open') ? closeMiniCart() : (renderMiniCart(), panel.classList.add('open')); }
    function closeMiniCart() { document.getElementById('miniCartPanel').classList.remove('open'); }
    function showToast(name) { const toast = document.getElementById('cartToast'); document.getElementById('toastMsg').innerText = (name.length > 28 ? name.slice(0,28)+'…' : name) + ' added!'; toast.classList.add('show'); setTimeout(() => toast.classList.remove('show'), 2500); }
    function updateCartBadge(count) { document.querySelectorAll('.cart-badge').forEach(b => { b.innerHTML = count; b.style.display = count > 0 ? 'flex' : 'none'; }); }
    function flyToCart(x, y) { const stickyCart = document.getElementById('stickyCart'); if (!stickyCart) return; const r = stickyCart.getBoundingClientRect(); const destX = r.left + r.width/2-10, destY = r.top + r.height/2-10; const flight = document.createElement('div'); flight.className = 'cart-flight'; flight.style.cssText = `left:${x}px;top:${y}px;width:20px;height:20px;`; document.body.appendChild(flight); requestAnimationFrame(() => requestAnimationFrame(() => { flight.style.left = destX+'px'; flight.style.top = destY+'px'; flight.style.opacity = '0.2'; flight.style.transform = 'scale(0.5)'; })); setTimeout(() => { if (document.body.contains(flight)) document.body.removeChild(flight); stickyCart.style.transform = 'scale(1.2)'; setTimeout(() => stickyCart.style.transform = 'scale(1)', 200); }, 850); }
    function openInfo(t, d, s) { document.getElementById("modal").style.display = "block"; document.getElementById("modal-title").innerText = t; document.getElementById("modal-desc").innerText = d; document.getElementById("modal-img").src = s; }
    function closeModal() { document.getElementById("modal").style.display = "none"; }
    window.onclick = function(e) { if (e.target == document.getElementById("modal")) closeModal(); const panel = document.getElementById('miniCartPanel'), btn = document.getElementById('stickyCart'); if (panel && panel.classList.contains('open') && !panel.contains(e.target) && !btn.contains(e.target)) closeMiniCart(); }
    function applySort() { const sort = document.getElementById('sortSelect').value, p = new URLSearchParams(window.location.search); p.set('sort', sort); window.location.search = p.toString(); }
    renderMiniCart();
</script>
</body>
</html>