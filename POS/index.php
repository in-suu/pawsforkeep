<?php 
include 'db_connect.php'; 

// 1. CLOUDINARY BASE URL
$cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paws&Keeps POS</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="<?php echo $cloudinary_base; ?>logo.png" alt="Paws&Keeps Logo" class="brand-logo">
            </div>

            <nav class="nav-menu">
                <div class="nav-header">
                    <a href="online_orders.php" class="online-orders-link">
                        <h2 class="online-orders"><i class="fa-solid fa-cart-shopping"></i> Online Orders</h2>
                    </a>
                    <hr class="nav-divider">
                </div>

                <div class="nav-group all-products-group">
                    <li class="filter-btn active" data-category="all"><i class="fa-solid fa-house"></i> All Products</li>
                </div>

                <div class="nav-group">
                    <h3>Dog & Cat Food</h3>
                    <ul>
                        <li class="filter-btn" data-category="dog-dry"><i class="fa-solid fa-utensils"></i> Dry Dog Food</li>
                        <li class="filter-btn" data-category="dog-wet"><i class="fa-solid fa-utensils"></i> Wet Dog Food</li>
                        <li class="filter-btn" data-category="cat-dry"><i class="fa-solid fa-utensils"></i> Dry Cat Food</li>
                        <li class="filter-btn" data-category="cat-wet"><i class="fa-solid fa-utensils"></i> Wet Cat Food</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Food & Water Bowls</h3>
                    <ul>
                        <li class="filter-btn" data-category="food-dispenser"><i class="fa-solid fa-faucet-drip"></i> Food Dispenser</li>
                        <li class="filter-btn" data-category="water-fountain"><i class="fa-solid fa-water"></i> Water Fountain</li>
                        <li class="filter-btn" data-category="bowls"><i class="fa-solid fa-bowl-rice"></i> Bowls</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Grooming & Tools</h3>
                    <ul>
                        <li class="filter-btn" data-category="shampoo-soap"><i class="fa-solid fa-pump-soap"></i> Shampoo & Soap</li>
                        <li class="filter-btn" data-category="brush-comb"><i class="fa-solid fa-broom"></i> Pet Brush & Comb</li>
                        <li class="filter-btn" data-category="grooming-tools"><i class="fa-solid fa-scissors"></i> Grooming Tools</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Pet Toys and Accessories</h3>
                    <ul>
                        <li class="filter-btn" data-category="chew-toys"><i class="fa-solid fa-bone"></i> Chew Toys</li>
                        <li class="filter-btn" data-category="interactive-toys"><i class="fa-solid fa-lightbulb"></i> Interactive Toys</li>
                        <li class="filter-btn" data-category="plush-toys"><i class="fa-solid fa-paw"></i> Plush Toys</li>
                        <li class="filter-btn" data-category="scratchers"><i class="fa-solid fa-rug"></i> Scratchers</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Safety Collar & Leash</h3>
                    <ul>
                        <li class="filter-btn" data-category="collar"><i class="fa-solid fa-dog"></i> Collar</li>
                        <li class="filter-btn" data-category="harness-leash"><i class="fa-solid fa-link"></i> Harness and Leash</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Pet Bedding & House</h3>
                    <ul>
                        <li class="filter-btn" data-category="beddings"><i class="fa-solid fa-bed"></i> Beddings</li>
                        <li class="filter-btn" data-category="pet-bed-house"><i class="fa-solid fa-house-chimney-window"></i> Pet bed and House</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3 class="clickable-header filter-btn" data-category="supplements-treatment">Pet Supplements & Treatment</h3>
                </div>
            </nav>
        </aside>

        <main class="main-wrapper">
            <header class="top-bar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search product name...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </header>

            <script>
            // Pass the database products directly to JavaScript
            window.dbProducts = [
                <?php
                $query = "SELECT * FROM tbl_products";
                $result = mysqli_query($conn, $query);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $fallback_id = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $category_slug = strtolower(str_replace(' ', '-', $row['prod_category']));
                        
                        $db_image = str_replace(' ', '_', $row['prod_image']);
                        $image_url = $cloudinary_base . $db_image;
                        
                        $id = isset($row['prod_id']) ? $row['prod_id'] : (isset($row['id']) ? $row['id'] : $fallback_id++);
                        
                        $product_array = [
                            'id' => $id,
                            'name' => $row['prod_name'],
                            'price' => floatval($row['prod_price']),
                            'category' => $category_slug,
                            'image' => $image_url,
                            'description' => $row['prod_description']
                        ];
                        echo json_encode($product_array) . ",\n";
                    }
                }
                ?>
            ];
            </script>
            
            <section class="product-grid" id="productGrid">
                <!-- Products will be dynamically generated by script.js using window.dbProducts -->
            </section>
        </main>

        <aside class="cart-panel">
            <h1 class="cart-title">Cart</h1>
            <div class="cart-header-labels">
                <span>Purchased List</span>
                <span id="currentDate"></span>
            </div>
            <div class="cart-items-scroll" id="cartItems"></div>
            <div class="cart-summary-box">
                <div class="summary-line"><span>Total Items</span><span id="totalCount">0</span></div>
                <div class="summary-line"><span>SubTotal</span><span id="subTotal">₱0.00</span></div>
                <div class="summary-total"><span>TOTAL</span><span id="grandTotal">₱0.00</span></div>
                <button class="checkout-btn">Proceed to Payment</button>
            </div>
        </aside>
    </div>

    <!-- Product Details Modal -->
    <div id="productModal" class="pos-modal-overlay">
        <div class="pos-modal-content">
            <span class="pos-modal-close" onclick="closeProductModal()"><i class="fa-solid fa-xmark"></i></span>
            <div class="pos-modal-body">
                <div class="pos-modal-img-container">
                    <img id="modalProductImg" src="" alt="Product Image">
                </div>
                <div class="pos-modal-details">
                    <h3 id="modalProductNameContainer"><i class="fa-solid fa-paw" style="color: var(--primary-orange); margin-right: 8px;"></i><span id="modalProductName"></span></h3>
                    <h4 id="modalProductPrice"></h4>
                    <div class="pos-modal-desc" id="modalProductDesc"></div>
                    
                    <div class="pos-modal-controls">
                        <div class="pos-qty-selector">
                            <button onclick="changeModalQty(-1)"><i class="fa-solid fa-minus" style="font-size: 14px;"></i></button>
                            <input type="text" id="modalProductQty" value="1" readonly>
                            <button onclick="changeModalQty(1)"><i class="fa-solid fa-plus" style="font-size: 14px;"></i></button>
                        </div>
                    </div>
                    
                    <div class="pos-modal-actions">
                        <button class="modal-add-btn" onclick="modalAddToCart()"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                        <button class="modal-buy-btn" onclick="modalBuyNow()"><i class="fa-solid fa-bag-shopping"></i> Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cute Alert Modal -->
    <div id="cuteAlertModal" class="cute-modal-overlay">
        <div class="cute-modal-content">
            <div class="cute-modal-icon">🐾</div>
            <h3 class="cute-modal-title">Oops!</h3>
            <p class="cute-modal-text">Your cart is empty!</p>
            <button class="cute-modal-btn" id="closeCuteAlert">OK</button>
        </div>
    </div>

    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>