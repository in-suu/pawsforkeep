<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
$count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_products");
$total_products = mysqli_fetch_assoc($count_res)['total'];

$stock_res = mysqli_query($conn, "SELECT SUM(prod_stock) as total_stock FROM tbl_products");
$total_stock = mysqli_fetch_assoc($stock_res)['total_stock'] ?? 0;

$low_res = mysqli_query($conn, "SELECT COUNT(*) as low FROM tbl_products WHERE prod_stock <= 10");
$low_stock = mysqli_fetch_assoc($low_res)['low'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | Paws for Keeps</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Inventory.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

    <nav class="sidebar">
        <div class="logo-container">
            <img src="https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/logo.png" alt="Paws for Keeps Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <h2 class="logo-fallback" style="display:none;">PAWS FOR KEEPS</h2>
        </div>
        <div class="divider"></div>
        <ul class="menu">
            <li><a href="overview.php"><i class="fa-solid fa-table-cells-large"></i> Overview</a></li>
            <li class="active"><a href="Inventory.php"><i class="fa-solid fa-box-archive"></i> Inventory</a></li>
            <li class="has-submenu">
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
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div class="overview-text">
                <h1>Inventory</h1>
                <p>Manage Pet Foods, Accessories, and Wellness products.</p>
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
                <p class="stat-trend up"><i class="fas fa-arrow-up"></i> Registered items</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-brown"><i class="fa-solid fa-box"></i></div>
            <div class="stat-content">
                <p class="stat-label">Total Stocks</p>
                <h2 class="stat-value"><?php echo number_format($total_stock); ?></h2>
                <p class="stat-trend">Current physical count</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-red"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-content">
                <p class="stat-label">Low Stocks</p>
                <h2 class="stat-value"><?php echo $low_stock; ?></h2>
                <p class="stat-trend alert"><i class="fa-solid fa-circle-exclamation"></i> Below threshold</p>
            </div>
        </div>
    </section>

    <button popovertarget="addProductModal" type="button" class="btn btn-white btn-nimate">
        <span class="btnn-text">Add Product</span>
        <i class="fa-solid fa-plus"></i>
    </button>

    <button class="report" id="generateReportBtn">
        <span class="btn-dow">Generate Report</span>
        <i class="fa-solid fa-download"></i>
    </button>

    <div class="cat">
        <button class="cat-btn">Categories&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-filter"></i></button>
        <ul class="cat-menu">
            <li><a href="#" class="filter-cat" data-cat="all">All Categories</a></li>
            <li class="cat-submenu">
                <a href="#" class="submenu-toggle">Food <span class="caret">▶</span></a>
                <ul class="cat-submenu-list">
                    <li><a href="#" class="filter-cat" data-cat="Dog Dry Food">Dog Dry Food</a></li>
                    <li><a href="#" class="filter-cat" data-cat="Dog Wet Food">Dog Wet Food</a></li>
                    <li><a href="#" class="filter-cat" data-cat="Cat Dry Food">Cat Dry Food</a></li>
                    <li><a href="#" class="filter-cat" data-cat="Cat Wet Food">Cat Wet Food</a></li>
                </ul>
            </li>
            <li><a href="#" class="filter-cat" data-cat="Food & Water Bowls">Food & Water Bowls</a></li>
            <li><a href="#" class="filter-cat" data-cat="Grooming">Grooming & Tools</a></li>
            <li><a href="#" class="filter-cat" data-cat="Toys">Toys & Accessories</a></li>
            <li><a href="#" class="filter-cat" data-cat="Safety">Safety Collar & Leash</a></li>
        </ul>
    </div>

    <div class="input-group">
        <input type="search" id="searchInput" placeholder="Search Products">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <div class="table-container">
        <table class="main-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Serial Number</th>
                    <th>Stock</th>
                    <th>Exp Date</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php
                // CLOUDINARY INTEGRATION
                $cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";
                $query = "SELECT * FROM tbl_products ORDER BY prod_name ASC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $stock_color = ($row['prod_stock'] <= 0) ? 'red' : (($row['prod_stock'] <= 10) ? 'orange' : 'inherit');
                    $exp_date = ($row['prod_expiry'] == '0000-00-00' || !$row['prod_expiry']) ? 'N/A' : date('m/d/Y', strtotime($row['prod_expiry']));
                    
                    // Build full Cloudinary URL
                    $db_image_path = trim($row['prod_image'], '/');
                    $image_url = $cloudinary_base . str_replace(' ', '%20', $db_image_path);
                ?>
                    <tr>
                        <td style="display:flex; align-items:center; gap:10px;">
                            <img src="<?php echo $image_url; ?>" onerror="this.src='images/logo.png'" style="width:40px; height:40px; object-fit:contain; background:#f9f9f9; border-radius:5px;">
                            <?php echo $row['prod_name']; ?>
                        </td>
                        <td><p class="Category Food"><?php echo $row['prod_category']; ?></p></td>
                        <td><?php echo $row['prod_id']; ?></td>
                        <td><span style="color:<?php echo $stock_color; ?>;"><?php echo $row['prod_stock']; ?></span></td>
                        <td><?php echo $exp_date; ?></td>
                        <td>₱<?php echo number_format($row['prod_price'], 2); ?></td>
                        <td class="action-cell">
                            <button class="icon-btn edit-btn" popovertarget="editModal"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="icon-btn delete-btn" popovertarget="deleteModal"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <p id="noResultsMessage" style="display:none; text-align:center; margin-top:15px; font-weight:bold; color:#888;">No results found</p>

        <div class="pagination-wrapper">
            <div class="mini-pagination">
                <div class="page-numbers"><span id="currentPageNum" class="current">1</span> / <span id="totalPageNum">1</span></div>
                <button id="prevBtn" class="p-ctrl" onclick="prevPage()"><i class="fas fa-chevron-left"></i></button>
                <button id="nextBtn" class="p-ctrl" onclick="nextPage()"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

    <div id="addProductModal" popover>
        <div class="add-form">
            <h2 class="form-title">Add Product</h2>
            <button class="close-modal" popovertarget="addProductModal">&times;</button>
            <form class="form-grid" action="process_add_product.php" method="POST" enctype="multipart/form-data">
                <div class="left-col">
                    <label>Category</label>
                    <select class="input-box" name="category" required>
                        <option value="">Select Category</option>
                        <option>Dog Dry Food</option><option>Dog Wet Food</option><option>Cat Dry Food</option><option>Cat Wet Food</option>
                        <option>Food & Water Bowls</option><option>Grooming & Tools</option><option>Pet Toys and Accessories</option>
                    </select>
                    <label>Name</label><input type="text" class="input-box" name="name" required>
                    <label>Stock</label><input type="number" class="input-box" name="stock" required>
                    <label>Expiration Date</label><input type="date" class="input-box" name="expiry">
                    <label>Price</label><input type="number" step="0.01" class="input-box" name="price" required>
                </div>
                <div class="right-col">
                    <label>Insert Image</label>
                    <div class="image-upload-box" id="imageBox">
                        <span class="plus">+</span><button type="button" id="removeButton">×</button>
                        <input type="file" id="imageInput" name="prod_image" accept="image/*">
                    </div>
                    <br><label>Description</label>
                    <textarea class="description-box" name="description" placeholder="Short description..." required></textarea>
                </div>
                <br>
                <div class="actions">
                    <button type="reset" class="reset-button">Reset</button>
                    <button type="submit" class="save-button">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            const ampm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            minutes = minutes.toString().padStart(2, "0");
            document.getElementById("time").textContent = `${hours}:${minutes}`;
            document.getElementById("ampm").textContent = ampm;
            document.getElementById("date").textContent = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }
        setInterval(updateClock, 1000); updateClock();
    </script>

</body>
</html>