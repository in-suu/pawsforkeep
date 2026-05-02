<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../homepage/db_connect.php'; 
$total_products_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_products");
$total_products = mysqli_fetch_assoc($total_products_res)['total'];

$low_stock_res = mysqli_query($conn, "SELECT COUNT(*) as low FROM tbl_products WHERE prod_stock <= 10");
$low_stock = mysqli_fetch_assoc($low_stock_res)['low'];

$revenue_res = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM tbl_orders WHERE DATE(order_date) = CURDATE()");
$revenue = mysqli_fetch_assoc($revenue_res)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png" type="image/png">
    <title>Dashboard | Paws for Keeps</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="overview.css">
</head>

<body>
    <div class="container">
        <main class="main">
            <nav class="sidebar">
                <div class="logo-container">
                    <img src="https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/logo.png" alt="Paws for Keeps Logo"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <h2 class="logo-fallback" style="display:none;">PAWS FOR KEEPS</h2>
                </div>

                <div class="divider"></div>

                <ul class="menu">
                    <li class="active"><a href="overview.php"><i class="fa-solid fa-table-cells-large"></i> Overview</a></li>
                    <li class="has-submenu">
                        <a href="inventory.php"><i class="fa-solid fa-box-archive"></i> Inventory</a>
                        <ul class="submenu">
                            <li><a href="expiry.php"><i class="fa-solid fa-calendar"></i> Product Expiration</a></li>
                            <li><a href="archive.php"><i class="fa-solid fa-trash-arrow-up"></i> Archive History</a></li>
                        </ul>
                    </li>
                    <li><a href="sales.php"><i class="fa-solid fa-chart-simple"></i> Sales</a></li>
                    <li><a href="account.php"><i class="fa-solid fa-user"></i> Account</a></li>
                </ul>
                <div class="spacer"></div>
                <div class="divider"></div>
                <div class="logout-section">
                    <a href="login.php" class="logout-btn"><i class="fas fa-arrow-right-from-bracket"></i> Log Out</a>
                </div>
            </nav>

            <div class="overview-card">
                <div class="header-left">
                    <div class="overview-icon-box">
                        <i class="fa-solid fa-table-cells-large" style="color: white;"></i>
                    </div>
                    <div class="overview-text">
                        <h1>Overview</h1>
                        <p>Welcome back, <?php echo $_SESSION['admin_name']; ?>!</p>
                    </div>
                </div>

                <div class="clock">
                    <div class="clock-time">
                        <span id="time"></span><span id="ampm" class="clock-ampm"></span>
                    </div>
                    <div id="date" class="clock-date"></div>
                </div>
            </div>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon stat-blue"><i class="fas fa-paw"></i></div>
                    <div class="stat-content">
                        <p class="stat-label">Total Products</p>
                        <h2 class="stat-value"><?php echo $total_products; ?></h2>
                        <p class="stat-trend up"><i class="fas fa-arrow-up"></i> Active Stock</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-red"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-content">
                        <p class="stat-label">Low Stock Alerts</p>
                        <h2 class="stat-value"><?php echo $low_stock; ?></h2>
                        <p class="stat-trend down">Items need restock</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-green"><i class="fas fa-coins"></i></div>
                    <div class="stat-content">
                        <p class="stat-label">Today's Revenue</p>
                        <h2 class="stat-value">₱<?php echo number_format($revenue, 2); ?></h2>
                        <p class="stat-trend up"><i class="fas fa-arrow-up"></i> Live sales data</p>
                    </div>
                </div>
                <div class="stat-card" id="nearExpiryCard" style="cursor: pointer;">
                    <div class="stat-icon stat-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="width: 1em; height: 1em;">
                            <mask id="cal-mask3">
                                <rect x="2" y="3" width="20" height="19" rx="3" fill="white" />
                                <rect x="2" y="8" width="20" height="1.5" fill="black" />
                                <rect x="8" y="9.5" width="1.5" height="12.5" fill="black" />
                                <rect x="14.5" y="9.5" width="1.5" height="12.5" fill="black" />
                                <rect x="2" y="14.5" width="20" height="1.5" fill="black" />
                                <circle cx="18" cy="18" r="6" fill="black" />
                            </mask>
                            <rect x="2" y="3" width="20" height="19" rx="3" fill="currentColor" mask="url(#cal-mask3)" />
                            <mask id="badge-mask3">
                                <circle cx="18" cy="18" r="5" fill="white" />
                                <path d="M15.5 15.5 L20.5 20.5 M20.5 15.5 L15.5 20.5" stroke="black" stroke-width="1.8" stroke-linecap="round" />
                            </mask>
                            <circle cx="18" cy="18" r="5" fill="currentColor" mask="url(#badge-mask3)" />
                            <rect x="6" y="1" width="2" height="4" rx="1" fill="currentColor" />
                            <rect x="16" y="1" width="2" height="4" rx="1" fill="currentColor" />
                        </svg>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Near Expiry</p>
                        <h2 class="stat-value">20</h2>
                        <p class="stat-trend alert"><i class="fa-solid fa-circle-exclamation"></i> High Priority</p>
                    </div>
                </div>
            </section>

            <div class="bottom-row">
                <div class="info-card">
                    <div class="card-header">
                        <h2>Sales Performance</h2>
                        <span class="header-subtitle">Revenue last 14 days</span>
                    </div>
                    <div class="chart-container">
                        <img src="images/graph-2025-dec.jpg" alt="Sales Chart"
                            onerror="this.src='https://via.placeholder.com/600x250?text=Sales+Chart+Visualization'">
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item"><i class="fas fa-circle legend-dot current"></i> Current</div>
                        <div class="legend-item"><i class="fas fa-circle legend-dot prev"></i> Previous</div>
                    </div>
                </div>

                <div class="info-card product-info-card">
                    <div class="card-header">
                        <h2>Top Products</h2>
                    </div>

                    <div class="product-carousel-container">
                        <div class="carousel-row">
                            <button class="nav-btn" id="prevBtn"><i class="fas fa-chevron-left"></i></button>

                            <div class="product-wrapper">
                                <div class="white-circle-bg">
                                    <img src="https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/dentastix.jpg" id="prod-img" alt="Product"
                                        onerror="this.src='https://via.placeholder.com/150'">
                                </div>
                                <div class="yellow-card-cutout">
                                    <div class="prod-name-text" id="prod-name">PEDIGREE<br>DENTASTIX</div>
                                    <div class="prod-price-text" id="prod-price">₱158.00</div>
                                </div>
                            </div>

                            <button class="nav-btn" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="dots-row" id="dotsContainer"></div>
                    </div>
                </div>
            </div>

            <div id="expiryModal" class="modal-overlay">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Near Expiring Products</h2>
                    </div>
                    <div class="modal-body">
                        <table class="expiry-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>SKU</th>
                                    <th>Expiry Date</th>
                                    <th>Stocks</th>
                                    <th>Days Left</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Purina Chow (5kg)</td>
                                    <td>SKU440001</td>
                                    <td>Jan 31, 2025</td>
                                    <td>10</td>
                                    <td><span class="badge red">&lt; 7 days</span></td>
                                </tr>
                                <tr>
                                    <td>Taste of the Wild (Salmon)</td>
                                    <td>SKU440003</td>
                                    <td>Feb 5, 2025</td>
                                    <td>30</td>
                                    <td><span class="badge orange">&lt; 14 days</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="manage-btn" onclick="location.href='expiry.php'">Manage Expiry Details</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            const ampm = hours >= 12 ? "PM" : "AM";
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

            hours = hours % 12 || 12;
            minutes = minutes.toString().padStart(2, "0");

            document.getElementById("time").textContent = `${hours}:${minutes}`;
            document.getElementById("ampm").textContent = ampm;
            document.getElementById("date").textContent = now.toLocaleDateString('en-US', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // CLOUDINARY PRODUCT UPDATES
        const products = [
            { brand: "PEDIGREE", name: "PEDIGREE<br>DENTASTIX", price: "₱158.00", img: "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/dentastix.jpg" },
            { brand: "WHISKAS", name: "WHISKAS<br>TUNA", price: "₱149.00", img: "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/whiskas.jpg" },
            { brand: "KITEKAT", name: "WET<br>FOOD", price: "₱135.00", img: "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/kitekat.jpg" },
            { brand: "SAINT ROCHE", name: "PREMIUM<br>SHAMPOO", price: "₱280.00", img: "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/shampoo.jpg" },
            { brand: "ABSOLUTE HOLISTIC", name: "DENTAL<br>CHEW", price: "₱85.00", img: "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/absolute%20dental%20chew.jpg" }
        ];

        let currentIndex = 0;
        const prodImg = document.getElementById('prod-img');
        const prodName = document.getElementById('prod-name');
        const prodPrice = document.getElementById('prod-price');
        const dotsContainer = document.getElementById('dotsContainer');

        function createDots() {
            dotsContainer.innerHTML = '';
            products.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.classList.add('dot');
                if (index === 0) dot.classList.add('active');
                dot.addEventListener('click', () => {
                    currentIndex = index;
                    updateProduct(currentIndex);
                });
                dotsContainer.appendChild(dot);
            });
        }

        function updateProduct(index) {
            const p = products[index];
            prodName.innerHTML = p.name;
            prodPrice.textContent = p.price;
            prodImg.src = p.img;
            const dots = document.querySelectorAll('.dot');
            dots.forEach(dot => dot.classList.remove('active'));
            if (dots[index]) dots[index].classList.add('active');
        }

        createDots();

        document.getElementById('nextBtn').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % products.length;
            updateProduct(currentIndex);
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + products.length) % products.length;
            updateProduct(currentIndex);
        });

        const nearExpiryCard = document.getElementById('nearExpiryCard');
        const expiryModal = document.getElementById('expiryModal');

        nearExpiryCard.addEventListener('click', () => {
            expiryModal.classList.add('active');
        });

        window.addEventListener('click', (e) => {
            if (e.target === expiryModal) {
                expiryModal.classList.remove('active');
            }
        });
    </script>
</body>

</html>