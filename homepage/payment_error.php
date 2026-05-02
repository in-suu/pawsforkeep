<?php
$msg = $_GET['msg'] ?? 'The system is currently unavailable. Please try again later.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Failed | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .error-card { background: white; padding: 50px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 450px; }
        .sad-icon { font-size: 60px; margin-bottom: 20px; }
        h1 { color: #C0572A; margin: 0; font-size: 24px; }
        p { color: #666; margin: 15px 0 30px; line-height: 1.6; }
        .error-msg { font-size: 11px; color: #999; background: #f1f1f1; padding: 10px; border-radius: 5px; font-family: monospace; }
        .retry-btn { display: inline-block; background: #FFBE3E; color: #4D2412; text-decoration: none; padding: 15px 35px; border-radius: 10px; font-weight: 700; transition: 0.3s; margin-top: 30px; }
        .retry-btn:hover { background: #4D2412; color: white; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="sad-icon">🐶🦴</div>
        <h1>Payment Unsuccessful</h1>
        <p>We were unable to process your transaction at this time. Don't worry, your account has not been charged.</p>
        <div class="error-msg">System Log: <?= htmlspecialchars($msg) ?></div>
        <br>
        <a href="checkout.php" class="retry-btn">Try Again</a>
    </div>
</body>
</html>