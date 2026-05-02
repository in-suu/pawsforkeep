<?php
session_start();
$order_id = $_GET['order_id'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .success-card { background: white; padding: 50px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 450px; }
        .check-icon { width: 80px; height: 80px; background: #FFBE3E; color: white; font-size: 40px; line-height: 80px; border-radius: 50%; margin: 0 auto 20px; }
        h1 { color: #4D2412; margin: 0; font-size: 28px; }
        p { color: #666; margin: 15px 0 30px; line-height: 1.6; }
        .order-tag { background: #fffdf5; padding: 10px 20px; border-radius: 8px; border: 1px dashed #FFBE3E; font-weight: 700; color: #4D2412; }
        .back-btn { display: inline-block; background: #4D2412; color: white; text-decoration: none; padding: 15px 35px; border-radius: 10px; font-weight: 700; transition: 0.3s; margin-top: 30px; }
        .back-btn:hover { background: #FFBE3E; transform: translateY(-3px); }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="check-icon">✓</div>
        <h1>Order Received! 🐾</h1>
        <p>Thank you for shopping with us! Your order has been successfully placed and is now being prepared for delivery.</p>
        <div class="order-tag">Reference Number: #PFK-<?= $order_id ?></div>
        <br>
        <a href="products.php" class="back-btn">Return to Shop</a>
    </div>
</body>
</html>