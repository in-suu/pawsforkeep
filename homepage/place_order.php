<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['cart'])) {
    
    // 1. Kunin ang Data mula sa Form
    $delivery_type = mysqli_real_escape_string($conn, $_POST['delivery_type']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $instructions = mysqli_real_escape_string($conn, $_POST['delivery_instructions']);
    $total_amount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0; 

    // ── ERROR HANDLING: Invalid Amount ──
    if ($total_amount <= 0) {
        header("Location: payment_error.php?msg=" . urlencode("Invalid total amount. Please refresh your cart."));
        exit();
    }

    // 2. Insert muna sa tbl_orders
    $query_order = "INSERT INTO tbl_orders (total_amount, delivery_type, payment_method, delivery_instructions) 
                    VALUES ('$total_amount', '$delivery_type', '$payment_method', '$instructions')";
    
    if (mysqli_query($conn, $query_order)) {
        $order_id = mysqli_insert_id($conn);

        // 3. I-save ang items sa tbl_order_items
        foreach ($_SESSION['cart'] as $prod_id => $qty) {
            $res = mysqli_query($conn, "SELECT prod_price FROM tbl_products WHERE prod_id = '$prod_id'");
            $prod = mysqli_fetch_assoc($res);
            $price = $prod['prod_price'];

            $query_items = "INSERT INTO tbl_order_items (order_id, prod_id, quantity, price_at_time) 
                            VALUES ('$order_id', '$prod_id', '$qty', '$price')";
            mysqli_query($conn, $query_items);
        }

        // 4. CHECKING: Cash ba o Online Payment?
        if ($payment_method == 'cash') {
            unset($_SESSION['cart']);
            header("Location: success.php?order_id=" . $order_id);
            exit();
        } else {  
            // ── ONLINE PAYMENT VIA PAYMONGO ──
            $secret_key = 'sk_test_ScdQoyphKgldALejCDnM14TX'; 
            $amount_in_cents = round($total_amount * 100);

            $data = [
                'data' => [
                    'attributes' => [
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'description' => 'Paws for Keeps Order #' . $order_id,
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $amount_in_cents, 
                                'description' => 'Pet Supplies Purchase',
                                'quantity' => 1,
                                'name' => 'Order Total'
                            ]
                        ],
                        'payment_method_types' => ['gcash', 'paymaya', 'card', 'dob'],
                        'success_url' => 'http://localhost/PawsForKeeps/success.php?order_id=' . $order_id,
                        'cancel_url' => 'http://localhost/PawsForKeeps/checkout.php'
                    ]
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.paymongo.com/v1/checkout_sessions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($secret_key)
            ]);

            $response = curl_exec($ch);
            $result = json_decode($response, true);
            curl_close($ch);

            if (isset($result['data']['attributes']['checkout_url'])) {
                unset($_SESSION['cart']);
                header("Location: " . $result['data']['attributes']['checkout_url']);
                exit();
            } else {
                // ── REDIRECT SA CUSTOM ERROR PAGE IMBES NA ECHO ──
                $api_error = $result['errors'][0]['detail'] ?? 'PayMongo API Connection Issue';
                header("Location: payment_error.php?msg=" . urlencode($api_error));
                exit();
            }
        }

    } else {
        // ── DATABASE ERROR REDIRECT ──
        header("Location: payment_error.php?msg=" . urlencode("Database error: " . mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: products.php");
    exit();
}
?>