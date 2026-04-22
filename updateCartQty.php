<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
    exit;
}

$pid   = trim($_POST['product_id'] ?? '');
$delta = (int)($_POST['delta'] ?? 0); // expects +1 or -1

if ($pid === '' || $delta === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Missing product_id or delta']);
    exit;
}

if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$pid])) {
    echo json_encode(['status' => 'error', 'message' => 'Item not in cart']);
    exit;
}

$_SESSION['cart'][$pid] += $delta;

if ($_SESSION['cart'][$pid] <= 0) {
    unset($_SESSION['cart'][$pid]);
    echo json_encode([
        'status'    => 'removed',
        'new_total' => array_sum($_SESSION['cart'])
    ]);
} else {
    echo json_encode([
        'status'    => 'updated',
        'new_qty'   => $_SESSION['cart'][$pid],
        'new_total' => array_sum($_SESSION['cart'])
    ]);
}
exit;
?>