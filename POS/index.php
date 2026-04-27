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
    <link rel="stylesheet" href="style.css">
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
                        <li class="filter-btn" data-category="water-fountain"><i class="fa-solid fa-fountain"></i> Water Fountain</li>
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

            <section class="product-grid" id="productGrid">
                <?php
                $query = "SELECT * FROM tbl_products";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $category_slug = strtolower(str_replace(' ', '-', $row['prod_category']));
                        
                        $db_image = str_replace(' ', '_', $row['prod_image']);
                        $image_url = $cloudinary_base . $db_image;
                        ?>
                        
                        <div class="product-card" data-category="<?php echo $category_slug; ?>">
                            <div class="product-img-container">
                                <img src="<?php echo $image_url; ?>" onerror="this.src='logo.png'" alt="Product">
                            </div>
                            
                            <div class="product-name">
                                <span class="name"><?php echo $row['prod_name']; ?></span>
                            </div>
                            
                            <div class="product-footer">
                                <span class="price">₱<?php echo number_format($row['prod_price'], 2); ?></span>
                                <button class="add-btn">Add to Cart</button>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
                ?>
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
    <script src="script.js"></script>
</body>
</html>