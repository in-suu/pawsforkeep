<?php
session_start();
include 'db_connect.php';

// --- DIAGNOSTIC START ---
$check = mysqli_query($conn, "SHOW TABLES LIKE 'tbl_orders'");
if (mysqli_num_rows($check) == 0) {
    $all_tables = mysqli_query($conn, "SHOW TABLES");
    echo "<div style='background:red; color:white; padding:10px;'>";
    echo "<b>ERROR:</b> Hindi makita ang 'tbl_orders'. Ang mga tables na nakikita ko lang ay: ";
    while($row = mysqli_fetch_array($all_tables)) { echo $row[0] . ", "; }
    echo "</div>";
}
// --- DIAGNOSTIC END ---

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'All';

// Logic para sa Filtering Tabs
$query = "SELECT * FROM tbl_orders WHERE user_id = '$user_id'";
if ($status_filter !== 'All') {
    $query .= " AND order_status = '$status_filter'";
}
$query .= " ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar-footer.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html { overflow-y: scroll; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; margin: 0; padding-top: 155px; }

        .orders-container { max-width: 1000px; margin: 0 auto 60px; padding: 0 20px; }
        
        /* ── Navigation Tabs ── */
        .order-tabs { 
            display: flex; 
            background: #fff; 
            margin-bottom: 20px; 
            border-radius: 8px; 
            overflow-x: auto; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .tab-item { 
            flex: 1; 
            text-align: center; 
            padding: 15px 10px; 
            font-size: 14px; 
            color: #555; 
            text-decoration: none; 
            border-bottom: 3px solid transparent; 
            white-space: nowrap;
            transition: 0.3s;
        }
        .tab-item.active { color: #4D2412; border-bottom: 3px solid #FFBE3E; font-weight: 600; }
        .tab-item:hover { background: #fffcf5; }

        /* ── Order Card UI ── */
        .order-card { 
            background: #fff; 
            border-radius: 12px; 
            padding: 20px; 
            margin-bottom: 15px; 
            box-shadow: 0 1px 4px rgba(0,0,0,0.05); 
        }
        .order-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 1px solid #f0f0f0; 
            padding-bottom: 12px; 
            margin-bottom: 15px; 
        }
        .order-id { font-weight: 700; color: #4D2412; font-size: 15px; }
        .status-badge { 
            font-size: 12px; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background: #fff3e0; color: #ef6c00; }
        .status-completed { background: #e8f5e9; color: #2e7d32; }

        .order-body { display: flex; gap: 20px; align-items: center; }
        .prod-preview { width: 80px; height: 80px; border-radius: 8px; border: 1px solid #eee; object-fit: contain; }
        .order-info { flex: 1; }
        .order-total { text-align: right; }
        .total-price { color: #D32F2F; font-size: 18px; font-weight: 700; }

        .btn-view { 
            background: none; 
            border: 1px solid #4D2412; 
            color: #4D2412; 
            padding: 8px 20px; 
            border-radius: 50px; 
            cursor: pointer; 
            font-size: 13px; 
            font-weight: 600; 
            transition: 0.3s;
        }
        .btn-view:hover { background: #4D2412; color: #fff; }

        .empty-orders { text-align: center; padding: 60px 0; background: #fff; border-radius: 12px; }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>
    

    <div class="orders-container">
        <div class="order-tabs">
            <?php 
            $tabs = ['All', 'To Pay', 'To Ship', 'To Receive', 'Completed', 'Cancelled'];
            foreach ($tabs as $tab) {
                $active = ($status_filter == $tab) ? 'active' : '';
                echo "<a href='orders.php?status=$tab' class='tab-item $active'>$tab</a>";
            }
            ?>
        </div>

        <div class="order-list">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($order = mysqli_fetch_assoc($result)): 
                    $oid = $order['order_id'];
                    // Get preview of first item
                    $item_query = "SELECT p.prod_image, p.prod_name, COUNT(oi.item_id) as total_items 
                                   FROM tbl_order_items oi 
                                   JOIN tbl_products p ON oi.prod_id = p.prod_id 
                                   WHERE oi.order_id = '$oid' LIMIT 1";
                    $item_res = mysqli_query($conn, $item_query);
                    $item_data = mysqli_fetch_assoc($item_res);
                ?>
                    <div class="order-card">
                        <div class="order-header">
                            <span class="order-id">#PFK-<?= date('Y', strtotime($order['order_date'])) ?>-<?= sprintf('%03d', $oid) ?></span>
                            <span class="status-badge status-<?= strtolower($order['order_status']) ?>">
                                <?= $order['order_status'] ?>
                            </span>
                        </div>
                        <div class="order-body">
                            <img src="https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/<?= $item_data['prod_image'] ?>" class="prod-preview">
                            <div class="order-info">
                                <div style="font-weight: 600; font-size: 14px;"><?= $item_data['prod_name'] ?></div>
                                <div style="font-size: 12px; color: #888;">
                                    <?= ($item_data['total_items'] > 1) ? "+ " . ($item_data['total_items'] - 1) . " more items" : "1 Item" ?>
                                </div>
                                <div style="font-size: 11px; color: #bbb; margin-top: 5px;">Ordered on: <?= date('M d, Y', strtotime($order['order_date'])) ?></div>
                            </div>
                            <div class="order-total">
                                <div style="font-size: 12px; color: #888;">Order Total</div>
                                <div class="total-price">₱<?= number_format($order['total_amount'], 2) ?></div>
                                <button class="btn-view" onclick="viewOrder(<?= $oid ?>)">View Details</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-orders">
                    <p style="color: #888;">No orders found in this section.</p>
                    <a href="products.php" style="color: #FFBE3E; font-weight: 700; text-decoration: none;">Shop now!</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // UX: Senior Dev Modal for Order Details
        function viewOrder(id) {
            Swal.fire({
                title: 'Order Details 🐾',
                width: '800px',
                html: `<div id="order-details-content" style="text-align: left; padding: 10px;">Loading details...</div>`,
                showConfirmButton: false,
                customClass: { popup: 'paws-popup', title: 'paws-title' },
                didOpen: () => {
                    fetch(`view_order_details.php?id=${id}`)
                    .then(r => r.text())
                    .then(html => {
                        document.getElementById('order-details-content').innerHTML = html;
                    });
                }
            });
        }
    </script>
</body>
</html>