<?php
include 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $order_id = isset($input['order_id']) ? intval($input['order_id']) : 0;
    $status = isset($input['status']) ? mysqli_real_escape_string($conn, $input['status']) : '';

    if ($order_id > 0 && $status !== '') {
        $query = "UPDATE tbl_orders SET order_status = '$status' WHERE order_id = $order_id";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
