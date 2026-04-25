<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
$query = "SELECT * FROM tbl_products WHERE prod_category LIKE '%Food%' OR prod_category LIKE '%Supplements%' ORDER BY prod_expiry ASC";
$result = mysqli_query($conn, $query);

$db_products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $db_products[] = [
        "name" => $row['prod_name'],
        "cat" => $row['prod_category'],
        "sn" => $row['prod_id'], 
        "stock" => (int)$row['prod_stock'],
        "date" => $row['prod_expiry'],
        "price" => (float)$row['prod_price']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png" type="image/png">
    <title>Product Expiration | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="expiry.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <nav class="sidebar">
        <div class="logo-container">
            <img src="images/logo.png" alt="Paws for Keeps Logo">
        </div>
        <div class="divider"></div>
        <ul class="menu">
            <li><a href="overview.php"><i class="fa-solid fa-table-cells-large"></i> Overview</a></li>
            <li class="has-submenu">
                <a href="Inventory.php"><i class="fa-solid fa-box-archive"></i> Inventory</a>
                <ul class="submenu">
                    <li class="active"><a href="expiry.php"><i class="fa-solid fa-calendar"></i> Product Expiration</a></li>
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
            <div class="overview-icon-box" style="background: #F9A825;"><i class="fa-solid fa-calendar" style="color: white;"></i></div>
            <div class="overview-text">
                <h1 style="color: #CD6B2D;">Product Expiration</h1>
                <p>Monitor and manage perishable items efficiently.</p>
            </div>
        </div>
        <div class="clock">
            <div class="clock-time"><span id="time"></span><span id="ampm" class="clock-ampm"></span></div>
            <div id="date" class="clock-date"></div>
        </div>
    </div>

    <button class="report" id="generateReportBtn">
        <span class="btn-dow">Generate Report</span>
        <i class="fa-solid fa-download"></i>
    </button>

    <div class="cat">
        <button class="cat-btn">Categories&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-filter"></i></button>
        <ul class="cat-menu">
            <li><a href="#" class="filter-cat active" data-cat="all">All Categories</a></li>
            <li><a href="#" class="filter-cat" data-cat="Dog Dry Food">Dog Dry Food</a></li>
            <li><a href="#" class="filter-cat" data-cat="Dog Wet Food">Dog Wet Food</a></li>
            <li><a href="#" class="filter-cat" data-cat="Cat Dry Food">Cat Dry Food</a></li>
            <li><a href="#" class="filter-cat" data-cat="Cat Wet Food">Cat Wet Food</a></li>
            <li><a href="#" class="filter-cat" data-cat="Pet Supplements & Treatments">Pet Supplements & Treatments</a></li>
        </ul>
    </div>

    <div class="status-dropdown">
        <button class="status-btn">All Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-caret-down"></i></button>
        <ul class="status-menu">
            <li><a href="#" class="filter-status" data-status="all">All Status</a></li>
            <li><a href="#" class="filter-status" data-status="Expired">Expired</a></li>
            <li><a href="#" class="filter-status" data-status="Near Expiry">Near Expiry</a></li>
            <li><a href="#" class="filter-status" data-status="Up-to-Date">Up-to-Date</a></li>
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
                    <th>Price</th>
                    <th>Expiry Date</th>
                    <th>Days Left</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>

        <div class="pagination-wrapper">
            <div class="mini-pagination">
                <div class="page-numbers">
                    <span id="currentPageNum" class="current">1</span><span class="sep">/</span><span id="totalPageNum">1</span>
                </div>
                <div class="page-btns">
                    <button id="prevBtn" class="p-ctrl"><i class="fa-solid fa-chevron-left"></i></button>
                    <button id="nextBtn" class="p-ctrl"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon remove" id="modalIcon"><i class="fa-solid fa-trash-arrow-up"></i></div>
            <h2 class="modal-title" id="modalTitle">Archive Product?</h2>
            <p class="modal-desc" id="modalDesc">Are you sure you want to move this product to archive?</p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button id="confirmActionBtn" class="btn-delete">Confirm</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function () {
            const products = <?php echo json_encode($db_products); ?>;

            let currentPage = 1;
            const rowsPerPage = 8;
            let filteredData = [];
            let selectedCategory = "all";
            let selectedStatus = "all";

            function isPerishable(cat) { return true; } 

            function getStatus(diffDays) {
                if (diffDays <= 0) return "Expired";
                if (diffDays <= 30) return "Near Expiry";
                return "Up-to-Date";
            }

            function getPriority(status) {
                if (status === "Expired") return 1;
                if (status === "Near Expiry") return 2;
                return 3;
            }

            function sortByStatus(data) {
                const today = new Date(); today.setHours(0,0,0,0);
                return data.sort((a, b) => {
                    const diffA = Math.ceil((new Date(a.date) - today) / 86400000);
                    const diffB = Math.ceil((new Date(b.date) - today) / 86400000);
                    return getPriority(getStatus(diffA)) - getPriority(getStatus(diffB));
                });
            }

            function renderTable() {
                const tbody = $('#tableBody');
                tbody.html("");
                let start = (currentPage - 1) * rowsPerPage;
                let pageItems = filteredData.slice(start, start + rowsPerPage);

                if (filteredData.length === 0) {
                    tbody.html('<tr><td colspan="8" style="padding:40px; text-align:center;">No matching products found</td></tr>');
                    return;
                }

                pageItems.forEach(item => {
                    const expDate = new Date(item.date);
                    const today = new Date(); today.setHours(0,0,0,0);
                    let diffDays = Math.ceil((expDate - today) / 86400000);
                    if (diffDays < 0) diffDays = 0;

                    let currentStatus = getStatus(diffDays);
                    let statusClass = currentStatus.toLowerCase().replace(" ", "-");
                    let daysBadge = `<span class="days-left-badge days-${diffDays <= 0 ? 'red' : (diffDays <= 30 ? 'orange' : 'green')}">${diffDays} days</span>`;

                    tbody.append(`
                        <tr>
                            <td>${item.name}</td>
                            <td><span class="Category Food">${item.cat}</span></td>
                            <td>${item.sn}</td>
                            <td>${item.stock}</td>
                            <td>₱${item.price.toLocaleString()}</td>
                            <td>${new Date(item.date).toLocaleDateString()}</td>
                            <td>${daysBadge}</td>
                            <td><span class="badge ${statusClass}">${currentStatus}</span></td>
                        </tr>
                    `);
                });

                $('#currentPageNum').text(currentPage);
                $('#totalPageNum').text(Math.ceil(filteredData.length / rowsPerPage) || 1);
            }

            function applyFilters() {
                const search = $('#searchInput').val().toLowerCase();
                const today = new Date(); today.setHours(0,0,0,0);

                filteredData = products.filter(item => {
                    const diff = Math.ceil((new Date(item.date) - today) / 86400000);
                    const status = getStatus(diff);
                    const matchCategory = selectedCategory === "all" || item.cat === selectedCategory;
                    const matchStatus = selectedStatus === "all" || status === selectedStatus;
                    const matchSearch = item.name.toLowerCase().includes(search) || item.sn.toString().includes(search);
                    return matchCategory && matchStatus && matchSearch;
                });

                filteredData = sortByStatus(filteredData);
                currentPage = 1;
                renderTable();
            }

            $('#searchInput').on('input', applyFilters);
            $('.filter-cat').click(function(e) { e.preventDefault(); selectedCategory = $(this).data('cat'); $('.filter-cat').removeClass('active'); $(this).addClass('active'); applyFilters(); });
            $('.filter-status').click(function(e) { e.preventDefault(); selectedStatus = $(this).data('status'); $('.filter-status').removeClass('active'); $(this).addClass('active'); applyFilters(); });
            $('#prevBtn').click(() => { if (currentPage > 1) { currentPage--; renderTable(); } });
            $('#nextBtn').click(() => { if (currentPage < Math.ceil(filteredData.length / rowsPerPage)) { currentPage++; renderTable(); } });

            applyFilters();
        });

        function updateClock() {
            const now = new Date();
            let h = now.getHours(), m = now.getMinutes().toString().padStart(2, "0"), ampm = h >= 12 ? "PM" : "AM";
            h = h % 12 || 12;
            $('#time').text(`${h}:${m}`); $('#ampm').text(ampm);
            $('#date').text(now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
        }
        setInterval(updateClock, 1000); updateClock();
    </script>
</body>
</html>