<link rel="stylesheet" href="navbar-footer.css">
<nav class="navbar">
    <div class="logo">
        <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
    </div>
    
    <div class="hamburger-menu" id="mobileToggle" style="display:none; font-size: 28px; cursor: pointer;">☰</div>
    
    <div class="nav-links" id="navLinks" style="display:flex; width: 100%; justify-content: space-between;">
        <div class="nav-left">
            <a href="our-story.php">OUR STORY</a>
            <a href="products.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active-link' : ''; ?>">PRODUCTS</a>
            <a href="store1.php">FIND A STORE</a>
        </div>
        
        <div class="nav-right" style="padding-right: 40px; display:flex; align-items:center; gap:35px;">
            <a href="contact-us.php">CONTACT US</a>

            <?php $badge_count = array_sum($_SESSION['cart'] ?? []); ?>
            <a href="cart.php" style="position:relative; display:flex; align-items:center; color:#4D2412; text-decoration:none;" title="View Cart">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span class="cart-badge" style="
                    position: absolute;
                    top: -5px;
                    right: -8px;
                    background: #D32F2F;
                    color: white;
                    border-radius: 50%;
                    min-width: 18px;
                    height: 18px;
                    padding: 0 4px;
                    font-size: 11px;
                    font-weight: bold;
                    display: <?= $badge_count > 0 ? 'flex' : 'none' ?>;
                    justify-content: center;
                    align-items: center;
                    border: 1px solid white;
                    font-family: 'Poppins', sans-serif;
                "><?= $badge_count ?></span>
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var toggle = document.getElementById("mobileToggle");
        var navLinks = document.getElementById("navLinks");
        if(toggle) {
            toggle.addEventListener("click", function() {
                navLinks.classList.toggle("mobile-active");
            });
        }
    });
</script>