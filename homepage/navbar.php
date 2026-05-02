<link rel="stylesheet" href="navbar-footer.css"> 

<style>
    /* 1. Logo Constraints: Fixed height para hindi na muling lumaki */
    .logo img {
        height: 55px !important; 
        width: auto;
        display: block;
    }

    /* 2. Layout Fix: 3-Column Flexbox para sa symmetry */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 60px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 10000;
        box-sizing: border-box;
    }

    .nav-section {
        display: flex;
        align-items: center;
        gap: 25px;
        flex: 1;
    }
    .nav-right { justify-content: flex-end; }
    .nav-left { justify-content: flex-start; }

    .nav-section a {
        text-decoration: none;
        color: #4D2412;
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .active-link { color: #C0572A !important; font-weight: 700; }

    /* 3. My Account Dropdown & Icon Styles */
    .account-dropdown { position: relative; display: inline-flex; align-items: center; }
    .account-dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.13);
        min-width: 175px;
        z-index: 9999;
        overflow: hidden;
        border: 1px solid #f0e8dc;
        padding-top: 6px;
        margin-top: -6px;
    }
    .account-dropdown-menu.dropdown-open { display: block; animation: fadeSlideDown 0.18s ease; }
    
    @keyframes fadeSlideDown { 
        from { opacity: 0; transform: translateY(-6px); } 
        to { opacity: 1; transform: translateY(0); } 
    }

    .account-dropdown-menu a { 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        padding: 11px 18px; 
        font-size: 13px; 
        color: #4D2412; 
        text-transform: none !important; 
        border-bottom: 1px solid #f5f0ea; 
        text-decoration: none;
    }
    .account-dropdown-menu a:hover { background: #FFF8ED; color: #C0572A; }
    
    /* Icon Styling */
    .account-dropdown-menu a svg { 
        width: 16px; 
        height: 16px; 
        flex-shrink: 0; 
        stroke: currentColor;
    }
    
    .account-btn-wrap { display: flex; align-items: center; gap: 4px; cursor: pointer; }
</style>

<nav class="navbar">
    <div class="nav-section nav-left">
        <a href="our-story.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'our-story.php') ? 'active-link' : ''; ?>">OUR STORY</a>
        <a href="products.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active-link' : ''; ?>">PRODUCTS</a>
        <a href="store1.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'store1.php') ? 'active-link' : ''; ?>">FIND A STORE</a>
    </div>

    <div class="logo">
        <a href="index.php"><img src="../images/logo.png" alt="Logo"></a>
    </div>

    <div class="nav-section nav-right">
        <a href="contact-us.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact-us.php') ? 'active-link' : ''; ?>">CONTACT US</a>

        <div class="auth-links" style="display: flex; align-items: center; gap: 12px; margin-left: 20px;">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="account-dropdown">
                    <div class="account-btn-wrap">
                        <a href="account.php" class="auth-btn">MY ACCOUNT</a>
                        <span class="account-caret">▾</span>
                    </div>
                    <div class="account-dropdown-menu">
                        <a href="account.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profile
                        </a>
                        <a href="orders.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                            My Orders
                        </a>
                        <a href="cart.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            My Cart
                        </a>
                        <a href="logout.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="auth-btn">LOGIN</a>
                <span style="color: #ccc;">|</span>
                <a href="signup.php" class="auth-btn">SIGN UP</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdown = document.querySelector('.account-dropdown');
        if (dropdown) {
            const menu = dropdown.querySelector('.account-dropdown-menu');
            dropdown.addEventListener('mouseenter', () => menu.classList.add('dropdown-open'));
            dropdown.addEventListener('mouseleave', () => menu.classList.remove('dropdown-open'));
            dropdown.querySelector('.account-btn-wrap').addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('dropdown-open');
            });
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) menu.classList.remove('dropdown-open');
            });
        }
    });
</script>