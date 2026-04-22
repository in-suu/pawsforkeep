<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
    exit;
}

$pid = isset($_POST['product_id']) ? trim($_POST['product_id']) : '';

if ($pid === '') {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
    exit;
}

// Initialize cart as associative array {prod_id => quantity}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Increment qty if exists, otherwise add new entry
if (isset($_SESSION['cart'][$pid])) {
    $_SESSION['cart'][$pid]++;
} else {
    $_SESSION['cart'][$pid] = 1;
}

// Total count = sum of all quantities
$total_count = array_sum($_SESSION['cart']);

echo json_encode([
    'status'    => 'success',
    'new_count' => $total_count
]);
exit;
?>