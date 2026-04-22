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
        
        <div class="nav-right">
            <a href="contact-us.php">CONTACT US</a>
            
            <div class="auth-links">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="auth-btn">My Account</a>
                    <span class="divider">|</span>
                    <a href="logout.php" class="auth-btn">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="auth-btn">Login</a>
 
                <?php endif; ?>
            </div>
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