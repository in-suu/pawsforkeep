<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
$sales_res = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM tbl_sales");
$total_sales = mysqli_fetch_assoc($sales_res)['total'] ?? 0;

$trans_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_sales");
$total_transactions = mysqli_fetch_assoc($trans_res)['total'] ?? 0;

// Units Sold (Inasahan na may 'quantity' field ka sa database, if wala, default to count)
$units_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_sales"); // I-update base sa schema mo
$units_sold = mysqli_fetch_assoc($units_res)['total'] ?? 0;

$cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paws for Keeps | Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="SALES-FINAL.css">
</head>
<body>

<div class="container">
    <main class="main">

      <nav class="sidebar">
        <div class="logo-container">
            <img src="<?php echo $cloudinary_base; ?>logo.png" alt="Paws for Keeps Logo" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <h2 class="logo-fallback" style="display:none;">PAWS FOR KEEPS</h2>
        </div>
        
        <div class="divider"></div>
        
        <ul class="menu">
            <li><a href="overview.php"><i class="fa-solid fa-table-cells-large"></i> Overview</a></li>
            <li><a href="Inventory.php"><i class="fa-solid fa-box-archive"></i> Inventory</a></li>
            <li class="active"><a href="sales.php"><i class="fa-solid fa-chart-simple"></i> Sales</a></li>
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
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <div class="overview-text">
                    <h1>Sales</h1>
                    <p>Performance Update</p>
                </div>
            </div>
            
            <div class="clock">
                <div class="clock-time">
                    <span id="time"></span><span id="ampm" class="clock-ampm"></span>
                </div>
                <div id="date" class="clock-date"></div>
            </div>
        </div>

        <div class="metrics-row">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Total Sales</p>
                    <h2 class="stat-value">₱<?php echo number_format($total_sales, 2); ?></h2>
                </div>
            </div>

            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Transactions This Month</p>
                    <h2 class="stat-value"><?php echo $total_transactions; ?></h2>
                </div>
            </div>

            <div class="stat-card stat-revenue">
                <div class="stat-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Units Sold</p>
                    <h2 class="stat-value"><?php echo $units_sold; ?></h2>
                </div>
            </div>
        </div>

        <div class="sales-row card">
            <div class="sales-chart">
                <h3>Sales Trends</h3>
                <img id="salesGraph" src="images/graph_jan.jpg" alt="month_graph">
            </div>

            <div class="sales-filters">
                <div class="date-mode">
                    <label for="modeSelect">View by</label>
                    <select id="modeSelect" onchange="setMode()">
                        <option value="weekly">Weekly</option>
                        <option value="monthly" selected>Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>

                <div class="date-picker">
                    <div class="date-field" id="dayField">
                        <label for="daySelect">Week</label>
                        <select id="daySelect" onchange="changeGraph()">
                            <option>1</option><option>2</option><option>3</option><option>4</option>
                        </select>
                    </div>

                    <div class="date-field" id="monthField">
                        <label for="monthSelect">Month</label>
                        <select id="monthSelect" onchange="changeGraph()">
                            <option value="1">January</option><option value="2">February</option><option value="3">March</option>
                            <option value="4">April</option><option value="5">May</option><option value="6">June</option>
                            <option value="7">July</option><option value="8">August</option><option value="9">September</option>
                            <option value="10">October</option><option value="11">November</option><option value="12" selected>December</option>
                        </select>
                    </div>

                    <div class="date-field" id="yearField">
                        <label for="yearSelect">Year</label>
                        <select id="yearSelect" onchange="changeGraph()">
                            <option>2023</option><option>2024</option><option selected>2025</option>
                        </select>
                    </div>
                </div>

                <div class="transaction-footer">
                    <button class="download-btn-small" onclick="alert('Graph Report Downloaded')">Download Graph Report</button>
                </div>
            </div>
        </div>

        <div class="card transaction-container">
            <div class="transaction-header">
                <strong>Recent Transactions</strong>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search Transaction ID">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                </div>
            </div>

            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Products</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetching real transaction data
                        $query = "SELECT * FROM tbl_sales ORDER BY sale_date DESC LIMIT 10";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . date('Y-m-d', strtotime($row['sale_date'])) . "</td>";
                                echo "<td>OR-" . $row['sale_id'] . "</td>";
                                echo "<td>Order from User #" . $row['user_id'] . "</td>"; // Pwede lagyan ng join sa items if needed
                                echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center;'>No transactions found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="transaction-footer">
                <button class="download-btn-small" onclick="alert('Transaction Report Downloaded')">Download Transaction Report</button>
            </div>
        </div>
    </main>
</div>

<script>
// Logic ng Clock at Graph (Exactly as provided)
function updateClock() {
    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes().toString().padStart(2, "0");
    const ampm = hours >= 12 ? "PM" : "AM";
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    hours = hours % 12 || 12;
    document.getElementById("time").textContent = `${hours}:${minutes}`;
    document.getElementById("ampm").textContent = ampm;
    document.getElementById("date").textContent = now.toLocaleDateString('en-US', options);
}
setInterval(updateClock, 1000);
updateClock();

const modeSelect = document.getElementById('modeSelect');
const dayField = document.getElementById('dayField');
const monthField = document.getElementById('monthField');
const yearField = document.getElementById('yearField');
const daySelect = document.getElementById('daySelect');
const monthSelect = document.getElementById('monthSelect');
const yearSelect = document.getElementById('yearSelect');
const salesGraph = document.getElementById('salesGraph');

function setMode() {
    const mode = modeSelect.value;
    dayField.style.display = (mode === 'weekly') ? 'block' : 'none';
    monthField.style.display = (mode === 'yearly') ? 'none' : 'block';
    yearField.style.display = 'block';
    changeGraph();
}

function changeGraph() {
    const mode = modeSelect.value;
    const week = daySelect.value;
    const month = monthSelect.value;
    const year = yearSelect.value;
    const monthNames = {1:'jan',2:'feb',3:'mar',4:'apr',5:'may',6:'jun',7:'jul',8:'aug',9:'sep',10:'oct',11:'nov',12:'dec'};
    const monthShort = monthNames[Number(month)];

    if (mode === 'weekly') salesGraph.src = `images/graph-${year}-${monthShort}-week${week}.jpg`;
    else if (mode === 'monthly') salesGraph.src = `images/graph-${year}-${monthShort}.jpg`;
    else if (mode === 'yearly') salesGraph.src = `images/graph-${year}.jpg`;
}
setMode();
</script>

</body>
</html>