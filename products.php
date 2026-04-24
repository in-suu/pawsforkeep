<?php 
session_start(); 
include 'db_connect.php'; 

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

// Current cart total count from associative cart
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
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

        .auth-links { display: flex; align-items: center; gap: 12px; font-size: 14px; }
        .auth-btn { text-decoration: none; color: #4D2412; font-weight: 500; transition: 0.3s; }
        .auth-btn:hover { color: #FFBE3E; }
        .divider { color: #ccc; font-weight: 300; }

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
        }
        .sticky-cart:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 24px rgba(255,190,62,0.6), 0 3px 10px rgba(0,0,0,0.2);
        }
        .sticky-cart svg { width: 28px; height: 28px; fill: #ffffff; }

        .cart-flight {
            position: fixed;
            background-color: #D32F2F;
            border-radius: 50%;
            z-index: 10000;
            pointer-events: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
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
                <img src="banner.png" alt="Banner" style="width: 100%; border-radius: 10px; display: block;">
            </div>

            <div class="mobile-only-controls" style="display: none; padding: 15px; background: #E1E1E1; margin: -20px -10px 15px -10px;">
                <div style="display: flex; gap: 15px; margin-bottom: 15px; align-items: center;">
                    <input type="text" id="mobileProductSearch" placeholder="Search Product" onkeyup="handleSearch('mobileProductSearch')" style="flex: 1; padding: 10px; border: none; border-radius: 0; outline: none; font-size: 14px;">
                    <a href="profile.php" style="color: #4D2412;"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></a>
                </div>
                <div style="display: flex; gap: 10px;">
                    <select class="mobile-select" onchange="if(this.value) window.location.href='products.php?brand=' + this.value" style="flex: 1; padding: 10px; border: none; border-radius: 0; font-weight: 600; font-size: 13px; color: #333; outline: none; appearance: none; background: #fff url('data:image/svg+xml;utf8,<svg fill=%22black%22 height=%2224%22 viewBox=%220 0 24 24%22 width=%2224%22 xmlns=%22http://www.w3.org/2000/svg%22><path d=%22M7 10l5 5 5-5z%22/><path d=%22M0 0h24v24H0z%22 fill=%22none%22/></svg>') no-repeat right 5px center;">
                        <option value="">Brand Collections</option>
                        <?php foreach($brands as $b) { echo "<option value='$b' ".($brand==$b?'selected':'').">$b</option>"; } ?>
                    </select>
                    <select class="mobile-select" onchange="if(this.value) window.location.href='products.php?category=' + this.value" style="flex: 1; padding: 10px; border: none; border-radius: 0; font-weight: 600; font-size: 13px; color: #333; outline: none; appearance: none; background: #fff url('data:image/svg+xml;utf8,<svg fill=%22black%22 height=%2224%22 viewBox=%220 0 24 24%22 width=%2224%22 xmlns=%22http://www.w3.org/2000/svg%22><path d=%22M7 10l5 5 5-5z%22/><path d=%22M0 0h24v24H0z%22 fill=%22none%22/></svg>') no-repeat right 5px center;">
                        <option value="">Category</option>
                        <option value="Cat Dry">Cat Dry Food</option>
                        <option value="Cat Wet">Cat Wet Food</option>
                        <option value="Dog Dry">Dog Dry Food</option>
                        <option value="Dog Wet">Dog Wet Food</option>
                        <option value="Food & Water Bowls">Food & Water Bowls</option>
                        <option value="Grooming & Tools">Grooming & Tools</option>
                        <option value="Pet Bedding & House">Pet Bedding & House</option>
                        <option value="Pet Toys & Accessories">Pet Toys & Accessories</option>
                        <option value="Safety Collar & Leash">Safety Collar & Leash</option>
                        <option value="Supplements">Supplements</option>
                    </select>
                </div>
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
                        // FIX: Pagbuo ng Cloudinary URL na kumpleto at dynamic
                        $db_image_path = trim($row['prod_image'], '/');
                        $image_url = $cloudinary_base . str_replace(' ', '%20', $db_image_path);
                ?>
                        <div class="card">
                            <button class="info-btn" onclick="openInfo('<?php echo addslashes($row['prod_name']); ?>', '<?php echo addslashes($row['prod_description']); ?>', '<?php echo $image_url; ?>')">i</button>
                            
                            <img src="<?php echo $image_url; ?>" onerror="this.src='images/logo.png'" alt="Product">
                            
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

    <a href="cart.php" class="sticky-cart" id="stickyCart" title="View Cart">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <span class="cart-badge" style="<?php echo ($cart_count > 0) ? '' : 'display:none;'; ?>"><?php echo $cart_count; ?></span>
    </a>

    <?php include 'footer.php'; ?>

<script>
    function openInfo(t, d, s) {
        document.getElementById("modal").style.display = "block";
        document.getElementById("modal-title").innerText = t;
        document.getElementById("modal-desc").innerText = d; 
        document.getElementById("modal-img").src = s;
    }
    function closeModal() { document.getElementById("modal").style.display = "none"; }
    window.onclick = function(event) { if (event.target == document.getElementById("modal")) closeModal(); }

    function applySort() {
        const sort = document.getElementById('sortSelect').value;
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sort);
        window.location.search = urlParams.toString();
    }

    function addToCart(productId, btnElement) {
        const e = window.event;
        const startX = e ? e.clientX : window.innerWidth / 2;
        const startY = e ? e.clientY : window.innerHeight / 2;

        if (btnElement) {
            btnElement.disabled = true;
            btnElement.innerText = 'Adding...';
        }

        flyToCart(startX, startY);

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
                console.error('Backend error:', data.message);
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
        })
        .finally(() => {
            if (btnElement) {
                btnElement.disabled = false;
                btnElement.innerText = 'Add to Cart';
            }
        });
    }

    function updateCartBadge(count) {
        document.querySelectorAll('.cart-badge').forEach(b => {
            b.innerHTML = count;
            b.style.display = count > 0 ? 'flex' : 'none';
            b.classList.remove('pulse-animation');
            void b.offsetWidth;
            b.classList.add('pulse-animation');
        });
    }

    function flyToCart(x, y) {
        const stickyCart = document.getElementById('stickyCart');
        if (!stickyCart) return;

        const cartRect = stickyCart.getBoundingClientRect();
        const destX = cartRect.left + (cartRect.width / 2) - 10;
        const destY = cartRect.top + (cartRect.height / 2) - 10;

        const flight = document.createElement('div');
        flight.className = 'cart-flight';
        flight.style.left = x + 'px';
        flight.style.top = y + 'px';
        flight.style.width = '20px';
        flight.style.height = '20px';
        document.body.appendChild(flight);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                flight.style.left = destX + 'px';
                flight.style.top = destY + 'px';
                flight.style.opacity = '0.2';
                flight.style.transform = 'scale(0.5)';
            });
        });

        setTimeout(() => {
            if (document.body.contains(flight)) document.body.removeChild(flight);
            stickyCart.style.transform = 'scale(1.2)';
            setTimeout(() => stickyCart.style.transform = 'scale(1)', 200);
        }, 850);
    }
</script>
</body>
</html>