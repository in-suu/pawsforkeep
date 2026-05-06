<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'No data received.']);
    exit;
}

$payment_method = mysqli_real_escape_string($conn, $input['payment_method']);
$total_amount = (float)$input['total_amount'];
$cart = $input['cart'];

if (empty($cart) || $total_amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty or invalid amount.']);
    exit;
}

// Map frontend mode to backend if needed
$payment_method_db = strtolower($payment_method) === 'cash' ? 'cash' : 'wallet';

// Insert into tbl_orders
// Status is 'Finished' since it's an immediate POS transaction
// Delivery Type is 'Walk-in'
$query_order = "INSERT INTO tbl_orders (total_amount, delivery_type, payment_method, order_status, delivery_instructions) 
                VALUES ('$total_amount', 'Walk-in', '$payment_method_db', 'Finished', 'POS Transaction')";

if (mysqli_query($conn, $query_order)) {
    $order_id = mysqli_insert_id($conn);

    // Insert items
    foreach ($cart as $item) {
        $prod_id = mysqli_real_escape_string($conn, $item['id']);
        $qty = (int)$item['quantity'];
        $price = (float)$item['price'];

        $query_items = "INSERT INTO tbl_order_items (order_id, prod_id, quantity, price_at_time) 
                        VALUES ('$order_id', '$prod_id', '$qty', '$price')";
        mysqli_query($conn, $query_items);
    }

    echo json_encode(['success' => true, 'order_id' => $order_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
