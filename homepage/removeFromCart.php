<?php
session_start();
header('Content-Type: application/json');

// Support both POST (AJAX) and GET (redirect fallback)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = trim($_POST['product_id'] ?? '');
} else {
    $pid = trim($_GET['id'] ?? '');
}

if ($pid !== '' && isset($_SESSION['cart'][$pid])) {
    unset($_SESSION['cart'][$pid]);
}

$new_total = array_sum($_SESSION['cart'] ?? []);

// If called via AJAX, return JSON; otherwise redirect back to cart
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) ||
           (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
           $_SERVER['REQUEST_METHOD'] === 'POST';

if ($is_ajax) {
    echo json_encode(['status' => 'removed', 'new_total' => $new_total]);
} else {
    header('Location: cart.php');
}
exit;
?>