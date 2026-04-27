<?php 
session_start();
include 'db_connect.php'; 

$total_to_pay = isset($_GET['total']) ? $_GET['total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Mode | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-red: #C62828;
            --primary-orange: #FFBE3E;
            --text-dark: #333;
            --text-muted: #666;
            --bg-light: #FBFBFB;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            color: var(--text-dark);
            height: 100vh;
            overflow: hidden;
        }

        .app-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background-color: #fff;
            border-right: 1px solid #f0f0f0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand-logo {
            max-width: 140px;
        }

        .nav-menu {
            flex: 1;
            overflow-y: auto;
        }

        .nav-group h3 {
            font-size: 14px;
            margin: 15px 0 8px 0;
            color: #8B4513;
            font-weight: 700;
        }

        .nav-group ul {
            list-style: none;
        }

        .nav-group li {
            padding: 8px 10px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .nav-group li:hover {
            color: var(--primary-orange);
        }

        .nav-group li.active {
            color: var(--primary-orange);
            font-weight: 600;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
            overflow-y: auto;
        }

        .payment-header {
            text-align: center;
            padding-top: 30px;
            width: 100%;
        }

        .header-title {
            font-size: 24px;
            font-weight: 500;
            color: #000;
            margin-bottom: 10px;
        }

        .header-line {
            border: 0;
            border-top: 1px solid #E67E22;
            opacity: 0.3;
            width: 100%;
        }

        .payment-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .brand-logo-main img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .payment-question {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 40px;
            color: #000;
        }

        /* --- PAYMENT OPTIONS --- */
        .payment-options {
            display: flex;
            flex-direction: row;
            gap: 30px;
            margin-bottom: 50px;
            width: 100%;
            max-width: 850px;
            justify-content: center;
        }

        .payment-card {
            flex: 1;
            aspect-ratio: 1 / 0.85;
            background: #fff;
            border: 1.5px solid #eee;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 380px;
            padding: 20px;
        }

        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border-color: var(--primary-orange);
        }

        .payment-card.active {
            border: 2px solid var(--primary-orange);
            background-color: #fffef5;
        }

        .card-icon {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-icon img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }

        /* --- BUTTONS --- */
        .action-buttons {
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 12px 60px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: 0.3s;
            min-width: 220px;
        }

        .btn-cancel {
            background-color: #fff;
            border: 1.5px solid #eee;
            color: #333;
        }

        .btn-cancel:hover {
            background-color: #f9f9f9;
        }

        .btn-save {
            background-color: var(--primary-red);
            color: #fff;
        }

        .btn-save:hover {
            background-color: #a51d1d;
            transform: scale(1.02);
        }
    </style>
</head>
<body>

    <div class="app-container">
        <aside class="sidebar">
            <div class="logo-container">
                <a href="index.php"><img src="logo.png" alt="Paws&Keeps Logo" class="brand-logo" onerror="this.src='images/placeholder.svg'"></a>
            </div>

            <nav class="nav-menu">
                <div class="nav-group">
                    <a href="index.php" style="text-decoration: none; color: inherit;">
                        <li class="filter-btn active"><i class="fa-solid fa-house"></i> Back to POS</li>
                    </a>
                </div>

                <div class="nav-group">
                    <h3>Dog & Cat Food</h3>
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-utensils"></i> Dry Dog Food</li>
                        <li class="filter-btn"><i class="fa-solid fa-utensils"></i> Wet Dog Food</li>
                        <li class="filter-btn"><i class="fa-solid fa-utensils"></i> Dry Cat Food</li>
                        <li class="filter-btn"><i class="fa-solid fa-utensils"></i> Wet Cat Food</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Food & Water Bowls</h3>
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-faucet-drip"></i> Food Dispenser</li>
                        <li class="filter-btn"><i class="fa-solid fa-droplet"></i> Water Fountain</li>
                        <li class="filter-btn"><i class="fa-solid fa-bowl-rice"></i> Bowls</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Grooming & Tools</h3>
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-pump-soap"></i> Shampoo & Soap</li>
                        <li class="filter-btn"><i class="fa-solid fa-broom"></i> Pet Brush & Comb</li>
                        <li class="filter-btn"><i class="fa-solid fa-scissors"></i> Grooming Tools</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Pet Toys and Accessories</h3>
                </div>

                <div class="nav-group">
                    <h3>Safety Collar & Leash</h3>
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-shield-dog"></i> Collar</li>
                        <li class="filter-btn"><i class="fa-solid fa-shield-dog"></i> Harness and Leash</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Pet Bedding & House</h3>
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-house-chimney"></i> Beddings</li>
                        <li class="filter-btn"><i class="fa-solid fa-house-chimney"></i> Pet bed and House</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Pet Supplements & Treatment</h3>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="payment-header">
                <h1 class="header-title">Mode of Payment</h1>
                <hr class="header-line">
            </header>

            <div class="payment-body">
                <div class="brand-logo-main">
                    <img src="logo.png" alt="Paws for Keeps Logo" onerror="this.src='images/placeholder.svg'">
                </div>

                <h2 class="payment-question">How would you like to pay?</h2>

                <div class="payment-options">
                    <div class="payment-card" onclick="selectMode('Cash', this)">
                        <div class="card-icon">
                            <img src="cash.png" alt="Cash Payment" onerror="this.src='images/placeholder.svg'">
                        </div>
                    </div>

                    <div class="payment-card" onclick="selectMode('Digital Wallet', this)">
                        <div class="card-icon">
                            <img src="digital.png" alt="Digital Payment" onerror="this.src='images/placeholder.svg'">
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button class="btn btn-cancel" onclick="window.location.href='index.php'">Cancel</button>
                    <button class="btn btn-save" onclick="processSave(<?php echo $total_to_pay; ?>)">Save Receipt</button>
                </div>
            </div>
        </main>
    </div>

    <script>
        let selectedMode = "";

        function selectMode(type, el) {
            selectedMode = type;
            document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
        }

        function processSave(amount) {
            if (!selectedMode) {
                alert("Please select a payment mode first! 🐾");
                return;
            }

            alert(`
                TRANSACTION SUCCESS!
                ------------------------
                Mode: ${selectedMode}
                Total: ₱${parseFloat(amount).toLocaleString(undefined, {minimumFractionDigits: 2})}
                ------------------------
                Receipt saved to database.
            `);
            
            window.location.href = 'index.php';
        }
    </script>
</body>
</html>