<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status'  => 'auth_required',
        'message' => 'You need to log in or create an account before managing your cart.'
    ]);
    exit;
}

$pid   = isset($_POST['product_id']) ? trim($_POST['product_id']) : '';
$delta = isset($_POST['delta'])      ? (int)$_POST['delta']        : null;
$action = isset($_POST['action'])    ? $_POST['action']            : '';

// FIX: Handle multiple removals for "Delete Selected"
if ($action === 'remove_selected') {
    $pids = isset($_POST['product_ids']) ? json_decode($_POST['product_ids'], true) : [];
    if (is_array($pids)) {
        foreach ($pids as $id) {
            unset($_SESSION['cart'][$id]);
        }
    }
    echo json_encode(['status' => 'success', 'new_count' => array_sum($_SESSION['cart'] ?? [])]);
    exit;
}

if ($pid === '' && $action !== 'remove_selected') {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($action === 'remove') {
    unset($_SESSION['cart'][$pid]);
    $status = 'success';
} 
else if ($delta !== null) {
    if (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid] += $delta;
        if ($_SESSION['cart'][$pid] <= 0) {
            unset($_SESSION['cart'][$pid]);
            $status = 'removed';
        } else {
            $status = 'success';
        }
    }
} 
else {
    if (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid]++;
    } else {
        $_SESSION['cart'][$pid] = 1;
    }
    $status = 'success';
}

$total_count = array_sum($_SESSION['cart']);

echo json_encode([
    'status'    => $status,
    'new_count' => $total_count,
    'new_qty'   => isset($_SESSION['cart'][$pid]) ? $_SESSION['cart'][$pid] : 0
]);
exit;
?>