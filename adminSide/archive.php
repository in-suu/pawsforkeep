<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
$query = "SELECT * FROM tbl_archive ORDER BY date_archived DESC";
$result = mysqli_query($conn, $query);
$db_archives = [];
while($row = mysqli_fetch_assoc($result)) {
    $db_archives[] = [
        "id" => $row['archive_id'],
        "name" => $row['prod_name'],
        "cat" => $row['prod_category'],
        "sn" => $row['prod_serial'],
        "stock" => $row['prod_stock'],
        "price" => $row['prod_price'],
        "archiveStatus" => $row['archive_status'],
        "dateArchived" => date('m/d/Y', strtotime($row['date_archived']))
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png" type="image/png">
    <title>Archive History | Paws for Keeps</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="archive.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
                    <li><a href="expiry.php"><i class="fa-solid fa-calendar"></i> Product Expiration</a></li>
                    <li class="active"><a href="archive.php"><i class="fa-solid fa-trash-arrow-up"></i> Archive History</a></li>
                </ul>
            </li>

            <li><a href="sales.php"><i class="fa-solid fa-chart-simple"></i> Sales</a></li>
            <li><a href="account.php"><i class="fa-solid fa-user"></i> Account</a></li>
        </ul>

        <div class="spacer"></div>
        <div class="divider"></div>

        <div class="logout-section">
            <a href="login.php" class="logout-btn">
                <i class="fas fa-arrow-right-from-bracket"></i> Log Out
            </a>
        </div>
    </nav>

    <div class="overview-card">
        <div class="header-left">
            <div class="overview-icon-box" style="background: #F9A825;">
                <i class="fa-solid fa-trash-arrow-up" style="color: white;"></i>
            </div>
            <div class="overview-text">
                <h1 style="color: #CD6B2D;">Archive History</h1>
                <p>Pet Foods, Accessories, Medicines & Wellness</p>
            </div>
        </div>

        <div class="clock">
            <div class="clock-time"><span id="time"></span><span id="ampm" class="clock-ampm"></span></div>
            <div id="date" class="clock-date"></div>
        </div>
    </div>

    <div class="input-group">
        <input type="search" id="searchInput" placeholder="Search Products">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <div class="cat">
        <button class="cat-btn">Categories <i class="fa-solid fa-filter"></i></button>
        <ul class="cat-menu">
            <li><a href="#" class="filter-cat" data-cat="all">All Categories</a></li>
            <li class="cat-submenu">
                <a href="#" class="submenu-toggle">Food <span>▶</span></a>
                <ul class="cat-submenu-list">
                    <li><a href="#" class="filter-cat" data-cat="Dog Dry Food">Dog Dry Food</a></li>
                    <li><a href="#" class="filter-cat" data-cat="Dog Wet Food">Dog Wet Food</a></li>
                    <li><a href="#" class="filter-cat" data-cat="Cat Dry Food">Cat Dry Food</a></li>
                    <li><a href="#" class="filter-cat" data-cat="Cat Wet Food">Cat Wet Food</a></li>
                </ul>
            </li>
            <li><a href="#" class="filter-cat" data-cat="Food & Water Bowls">Food & Water Bowls</a></li>
            <li><a href="#" class="filter-cat" data-cat="Pet Grooming & Tools">Pet Grooming & Tools</a></li>
            <li><a href="#" class="filter-cat" data-cat="Pet Toys & Accessories">Pet Toys & Accessories</a></li>
            <li><a href="#" class="filter-cat" data-cat="Safety Collar & Leash">Safety Collar & Leash</a></li>
            <li><a href="#" class="filter-cat" data-cat="Pet Bedding & House">Pet Bedding & House</a></li>
            <li><a href="#" class="filter-cat" data-cat="Pet Supplements & Treatments">Pet Supplements</a></li>
        </ul>
    </div>

    <div class="status-dropdown">
        <button class="status-btn">All Status <i class="fa-solid fa-caret-down"></i></button>
        <ul class="status-menu">
            <li><a href="#" class="filter-status" data-status="all">All Status</a></li>
            <li><a href="#" class="filter-status" data-status="Expired">Expired</a></li>
            <li><a href="#" class="filter-status" data-status="Deleted">Deleted</a></li>
            <li><a href="#" class="filter-status" data-status="Discontinued">Discontinued</a></li>
        </ul>
    </div>

    <button class="report" id="generateReportBtn">
        <span>Generate Report</span>
        <i class="fa-solid fa-download"></i>
    </button>

    <div class="table-container">
        <table class="main-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Serial Number</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Date Archived</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>

        <div class="modal-overlay" id="actionModal">
            <div class="modal-box">
                <div class="modal-icon" id="modalIcon"><i class="fas fa-exclamation-triangle"></i></div>
                <h2 class="modal-title" id="modalTitle">Are you sure?</h2>
                <p class="modal-desc" id="modalDesc">This action cannot be undone.</p>
                <div class="modal-actions">
                    <button class="btn-cancel" onclick="closeActionModal()">Cancel</button>
                    <button class="btn-delete" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.min.js"></script>
    <script>
        let dbArchives = <?php echo json_encode($db_archives); ?>;
        let localArchives = JSON.parse(localStorage.getItem("pawsArchives")) || [];
        let allArchived = dbArchives.length > 0 ? dbArchives : localArchives;
        let archivedItems = [...allArchived];
        let selectedCategory = "all";
        let selectedStatus = "all";
        let currentPage = 1;
        const rowsPerPage = 8;

        let currentAction = null;
        let currentData = null;
        let currentRow = null;

        function applyFilters() {
            const search = $("#searchInput").val().toLowerCase();
            archivedItems = allArchived.filter(item => {
                const matchCategory = selectedCategory === "all" || (item.cat || "").toLowerCase() === selectedCategory.toLowerCase();
                const matchStatus = selectedStatus === "all" || (item.archiveStatus || "").toLowerCase() === selectedStatus.toLowerCase();
                const matchSearch = (item.name || "").toLowerCase().includes(search) || (item.sn || "").toLowerCase().includes(search);
                return matchCategory && matchStatus && matchSearch;
            });
            currentPage = 1;
            renderTable();
        }

        function renderTable() {
            const tbody = $("#tableBody");
            tbody.empty();
            if (!archivedItems.length) {
                tbody.html(`<tr><td colspan="9" style="text-align:center;">No data found</td></tr>`);
                updatePagination();
                return;
            }
            const start = (currentPage - 1) * rowsPerPage;
            const pageItems = archivedItems.slice(start, start + rowsPerPage);
            pageItems.forEach((item, i) => {
                const id = (start + i + 1).toString().padStart(3, "0");
                const price = item.price ? `₱${Number(item.price).toLocaleString()}` : "₱0";
                const dateArchived = item.dateArchived || "N/A";
                const stockColor = item.stock <= 5 ? "red" : (item.stock <= 10 ? "orange" : "black");
                let catClass = "Food";
                const catGroup = ["Dog Dry Food", "Dog Wet Food", "Cat Dry Food", "Cat Wet Food"];
                if (!catGroup.includes(item.cat)) {
                    const map = { "Food & Water Bowls": "FWB", "Pet Grooming & Tools": "PGT", "Pet Toys & Accessories": "PTA", "Safety Collar & Leash": "SCL", "Pet Bedding & House": "PBH", "Pet Supplements & Treatments": "PST" };
                    catClass = map[item.cat] || "Food";
                }
                tbody.append(`
                <tr data-id="${item.id}">
                    <td><strong>${id}</strong></td>
                    <td>${item.name || ""}</td>
                    <td><span class="Category ${catClass}">${item.cat || ""}</span></td>
                    <td>${item.sn || ""}</td>
                    <td><span style="color:${stockColor}; font-weight:600;">${item.stock || 0}</span></td>
                    <td>${price}</td>
                    <td>
                        <div class="status-action-dropdown">
                            <button class="status-action-btn">${item.archiveStatus || "Choose"} <i class="fa-solid fa-caret-down"></i></button>
                            <ul class="status-action-menu">
                                <li><a href="#" class="status-item" data-status="Expired">Expired</a></li>
                                <li><a href="#" class="status-item" data-status="Deleted">Deleted</a></li>
                                <li><a href="#" class="status-item" data-status="Discontinued">Discontinued</a></li>
                            </ul>
                        </div>
                    </td>
                    <td>${dateArchived}</td>
                    <td>
                        <div class="action-dropdown">
                            <button class="action-btn">Choose <i class="fa-solid fa-caret-down"></i></button>
                            <ul class="action-menu">
                                <li><a href="#" class="action-item" data-action="Remove">Remove</a></li>
                                <li><a href="#" class="action-item" data-action="Restore">Restore</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>`);
            });
            updatePagination();
        }

        function updateClock() {
            const now = new Date();
            let h = now.getHours(), m = now.getMinutes().toString().padStart(2, "0"), ampm = h >= 12 ? "PM" : "AM";
            h = h % 12 || 12;
            $('#time').text(`${h}:${m}`); $('#ampm').text(ampm);
            $('#date').text(now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
        }
        setInterval(updateClock, 1000); updateClock();

        function closeActionModal() { $("#actionModal").hide(); }
        $("#searchInput").on("input", applyFilters);
        $("#nextBtn").click(() => { if (currentPage < Math.ceil(archivedItems.length / rowsPerPage)) { currentPage++; renderTable(); } });
        $("#prevBtn").click(() => { if (currentPage > 1) { currentPage--; renderTable(); } });

        renderTable();
    </script>

</body>
</html>