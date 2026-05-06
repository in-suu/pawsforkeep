<?php
session_start();
include 'db_connect.php';

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$is_modal = isset($_GET['modal']) && $_GET['modal'] == 1;
$cash_tendered = isset($_GET['tendered']) ? (float)$_GET['tendered'] : 0;

if ($order_id <= 0) {
    echo "Invalid Order ID.";
    exit;
}

// Fetch order details
$query = "SELECT * FROM tbl_orders WHERE order_id = '$order_id'";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    echo "Order not found.";
    exit;
}

// Fetch order items
$items_query = "SELECT oi.*, p.prod_name 
                FROM tbl_order_items oi 
                JOIN tbl_products p ON oi.prod_id = p.prod_id 
                WHERE oi.order_id = '$order_id'";
$items_result = mysqli_query($conn, $items_query);
$items = [];
while ($row = mysqli_fetch_assoc($items_result)) {
    $items[] = $row;
}

// Calculate VAT (assuming 12% VAT inclusive in total)
// Total Amount = VATable Sales + VAT Amount
// VAT Amount = Total Amount - (Total Amount / 1.12)
$total_amount = (float)$order['total_amount'];
$vatable_sales = $total_amount / 1.12;
$vat_amount = $total_amount - $vatable_sales;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order #<?php echo $order_id; ?></title>
    <style>
        /* Thermal Printer Receipt Styles */
        body {
            background: #e0e0e0;
            font-family: 'Courier New', Courier, monospace; /* Monospace is best for receipts */
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .receipt-container {
            background: #fff;
            width: 300px; /* 80mm roughly equals 300px on screen */
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: #000;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 15px;
        }

        .receipt-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .receipt-header p {
            margin: 3px 0;
            font-size: 12px;
        }

        .receipt-meta {
            margin-bottom: 15px;
            font-size: 12px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .receipt-meta p {
            margin: 3px 0;
            display: flex;
            justify-content: space-between;
        }

        .item-table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
        }

        .item-table th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            font-weight: normal;
        }

        .item-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .col-qty { width: 15%; text-align: center; }
        .col-desc { width: 55%; }
        .col-price { width: 30%; text-align: right; }

        .totals {
            font-size: 12px;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .totals .row {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
        }

        .totals .grand-total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 8px;
        }

        .receipt-footer {
            text-align: center;
            font-size: 11px;
            margin-top: 15px;
        }

        /* Screen-only Action Buttons */
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-family: sans-serif;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #FFBE3E;
            color: #4D2412;
        }

        .btn-return {
            background: #4D2412;
            color: #fff;
        }

        /* Hide buttons and body background when printing */
        @media print {
            body {
                background: none;
                padding: 0;
                align-items: flex-start;
            }
            .receipt-container {
                box-shadow: none;
                width: 100%;
                max-width: 300px;
                padding: 0;
                margin: 0;
            }
            .actions {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <div class="receipt-header">
            <h2>Paws for Keeps</h2>
            <p>Pet Supplies and Accessories</p>
            <p>123 Pet Avenue, Cityville</p>
            <p>TIN: 123-456-789-000</p>
        </div>

        <div class="receipt-meta">
            <p><span>Order No:</span> <span>#<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?></span></p>
            <p><span>Date:</span> <span><?php echo date('m/d/Y H:i', strtotime($order['order_date'])); ?></span></p>
            <p><span>Cashier:</span> <span>Admin</span></p>
            <p><span>Payment:</span> <span><?php echo strtoupper($order['payment_method']); ?></span></p>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th class="col-qty">Qty</th>
                    <th class="col-desc">Item</th>
                    <th class="col-price">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td class="col-qty"><?php echo $item['quantity']; ?></td>
                    <td class="col-desc"><?php echo $item['prod_name']; ?></td>
                    <td class="col-price"><?php echo number_format($item['price_at_time'] * $item['quantity'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="totals">
            <div class="row">
                <span>Subtotal (VAT Inc.)</span>
                <span><?php echo number_format($total_amount, 2); ?></span>
            </div>
            <div class="row">
                <span>VATable Sales</span>
                <span><?php echo number_format($vatable_sales, 2); ?></span>
            </div>
            <div class="row">
                <span>VAT (12%)</span>
                <span><?php echo number_format($vat_amount, 2); ?></span>
            </div>
            <div class="row grand-total">
                <span>TOTAL</span>
                <span>PHP <?php echo number_format($total_amount, 2); ?></span>
            </div>
            <div class="row">
                <span>Amount Tendered</span>
                <span>PHP <?php echo ($cash_tendered > 0) ? number_format($cash_tendered, 2) : number_format($total_amount, 2); ?></span>
            </div>
            <div class="row">
                <span>Change</span>
                <span>PHP <?php echo ($cash_tendered > 0) ? number_format($cash_tendered - $total_amount, 2) : '0.00'; ?></span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Thank you for shopping with us!</p>
            <p>Please come again.</p>
            <p style="margin-top: 10px;">THIS SERVES AS AN OFFICIAL RECEIPT</p>
        </div>
    </div>

    <?php if (!$is_modal): ?>
    <div class="actions">
        <button class="btn btn-print" onclick="window.print()">Print Receipt</button>
        <a href="index.php" class="btn btn-return">Return to POS</a>
    </div>

    <script>
        // Automatically open the print dialog when the page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
    <?php endif; ?>
</body>
</html>
