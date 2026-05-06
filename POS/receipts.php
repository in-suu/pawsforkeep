<?php
include 'db_connect.php';
$cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";

// Fetch all finished orders
$orders_query = mysqli_query($conn, "SELECT * FROM tbl_orders ORDER BY order_date DESC");
$orders = [];
if ($orders_query) {
    while ($row = mysqli_fetch_assoc($orders_query)) {
        $orders[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipts | Paws for Keeps</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }

        .receipts-wrapper {
            padding: 30px 40px;
            flex: 1;
            overflow-y: auto;
            background: #fafafa;
        }

        .receipts-title {
            font-size: 22px;
            font-weight: 700;
            color: #4D2412;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .receipts-table-wrapper {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .receipts-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .receipts-table thead tr {
            background: #FFBE3E;
            color: #4D2412;
        }

        .receipts-table th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
        }

        .receipts-table td {
            padding: 13px 16px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .receipts-table tr:last-child td {
            border-bottom: none;
        }

        .receipts-table tr:hover td {
            background: #fffef5;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-walkin { background: #e8f5e9; color: #2e7d32; }
        .badge-delivery { background: #e3f2fd; color: #1565c0; }
        .badge-pickup { background: #fff3e0; color: #e65100; }

        .badge-cash { background: #f3e5f5; color: #6a1b9a; }
        .badge-wallet { background: #e0f7fa; color: #00695c; }
        .badge-digital { background: #e0f7fa; color: #00695c; }

        .btn-view-receipt {
            background: #FFBE3E;
            color: #4D2412;
            border: none;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-view-receipt:hover {
            background: #e6a800;
            transform: scale(1.04);
        }

        /* Receipt Popup Modal */
        .receipt-modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.55);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .receipt-modal-overlay.show { display: flex; }
        .receipt-modal-box {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            width: 400px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .receipt-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #FFBE3E;
            border-radius: 18px 18px 0 0;
        }
        .receipt-modal-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #4D2412;
        }
        .btn-close-modal {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #4D2412;
        }
        .receipt-modal-body { flex: 1; overflow-y: auto; }
        .receipt-modal-body iframe {
            width: 100%;
            border: none;
            min-height: 500px;
            display: block;
        }
        .receipt-modal-footer {
            display: flex;
            gap: 10px;
            padding: 14px 20px;
            border-top: 1px solid #eee;
            justify-content: center;
        }
        .btn-modal {
            padding: 9px 24px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }
        .btn-modal-print { background: #FFBE3E; color: #4D2412; }
        .btn-modal-close { background: #4D2412; color: #fff; }
    </style>
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="logo-container">
                <a href="index.php"><img src="<?php echo $cloudinary_base; ?>logo.png" alt="Paws&Keeps Logo" class="brand-logo"></a>
            </div>
            <nav class="nav-menu">
                <div class="nav-header">
                    <a href="index.php" class="online-orders-link">
                        <h2 class="online-orders" style="color:#000;"><i class="fa-solid fa-arrow-left"></i> Back to POS</h2>
                    </a>
                    <hr class="nav-divider">
                </div>
                <div class="nav-group all-products-group">
                    <a href="online_orders.php" style="text-decoration:none;color:inherit;">
                        <li class="filter-btn"><i class="fa-solid fa-cart-shopping"></i> Online Orders</li>
                    </a>
                </div>
                <div class="nav-group all-products-group">
                    <li class="filter-btn active"><i class="fa-solid fa-receipt"></i> Receipts</li>
                </div>
            </nav>
        </aside>

        <main class="main-wrapper orders-wrapper receipts-wrapper">
            <div class="receipts-header-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div class="receipts-title" style="margin-bottom: 0;">
                    <i class="fa-solid fa-receipt"></i> Transaction Receipts
                </div>
                <div class="receipts-controls" style="display: flex; gap: 15px;">
                    <div class="search-box" style="position: relative;">
                        <input type="text" id="searchInput" placeholder="Search receipts..." style="padding: 8px 15px; padding-left: 35px; border: 1px solid #ddd; border-radius: 20px; outline: none; font-family: inherit; font-size: 13px;">
                        <i class="fa-solid fa-search" style="position: absolute; left: 12px; top: 10px; color: #aaa; font-size: 13px;"></i>
                    </div>
                    <select id="typeFilter" style="padding: 8px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none; font-family: inherit; font-size: 13px; color: #444; background: white; cursor: pointer;">
                        <option value="all">All Types</option>
                        <option value="Walk-in">Walk-in</option>
                        <option value="Delivery">Delivery</option>
                        <option value="Pick Up">Pick Up</option>
                    </select>
                </div>
            </div>

            <div class="receipts-table-wrapper">
                <table class="receipts-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Payment</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px;color:#aaa;">
                                No transactions found.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($orders as $i => $order): ?>
                        <?php
                            $raw_type = strtolower($order['delivery_type'] ?? 'delivery');
                            if ($raw_type === 'walk-in') {
                                $type_label = 'Walk-in';
                                $type_badge = 'badge-walkin';
                            } elseif ($raw_type === 'pickup' || $raw_type === 'pick up') {
                                $type_label = 'Pick Up';
                                $type_badge = 'badge-pickup';
                            } else {
                                $type_label = 'Delivery';
                                $type_badge = 'badge-delivery';
                            }
                            $pm = strtolower($order['payment_method'] ?? 'cash');
                            $pm_badge = ($pm === 'wallet' || $pm === 'digital wallet') ? 'badge-wallet' : 'badge-cash';
                            $pm_label = ($pm === 'wallet' || $pm === 'digital wallet') ? 'E-Wallet' : 'Cash';
                        ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><strong>#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></strong></td>
                            <td><?php echo date('M j, Y g:i A', strtotime($order['order_date'])); ?></td>
                            <td><span class="badge <?php echo $type_badge; ?>"><?php echo $type_label; ?></span></td>
                            <td><span class="badge <?php echo $pm_badge; ?>"><?php echo $pm_label; ?></span></td>
                            <td><strong>₱<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                            <td><?php echo ucfirst($order['order_status'] ?? 'Pending'); ?></td>
                            <td>
                                <button class="btn-view-receipt" onclick="openReceipt(<?php echo $order['order_id']; ?>)">
                                    <i class="fa-solid fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Receipt Popup Modal -->
    <div id="receiptModal" class="receipt-modal-overlay">
        <div class="receipt-modal-box">
            <div class="receipt-modal-header">
                <h3>🐾 Transaction Receipt</h3>
                <button class="btn-close-modal" onclick="closeReceipt()">✕</button>
            </div>
            <div class="receipt-modal-body">
                <iframe id="receiptFrame" src="" scrolling="auto"></iframe>
            </div>
            <div class="receipt-modal-footer">
                <button class="btn-modal btn-modal-print" onclick="printReceipt()">🖨️ Print</button>
                <button class="btn-modal btn-modal-close" onclick="closeReceipt()">Close</button>
            </div>
        </div>
    </div>

    <script>
        function openReceipt(orderId) {
            document.getElementById('receiptFrame').src = 'print_receipt.php?order_id=' + orderId + '&modal=1';
            document.getElementById('receiptModal').classList.add('show');
        }
        function closeReceipt() {
            document.getElementById('receiptModal').classList.remove('show');
            document.getElementById('receiptFrame').src = '';
        }
        function printReceipt() {
            const iframe = document.getElementById('receiptFrame');
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }

        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('typeFilter').addEventListener('change', filterTable);

        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const typeValue = document.getElementById('typeFilter').value;
            const rows = document.querySelectorAll('.receipts-table tbody tr');

            rows.forEach(row => {
                if (row.cells.length < 8) return; // Skip "No transactions found" row

                const rowText = row.textContent.toLowerCase();
                const type = row.cells[3].textContent.trim();

                const matchesSearch = rowText.includes(searchValue);
                const matchesType = typeValue === 'all' || type === typeValue;

                if (matchesSearch && matchesType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
