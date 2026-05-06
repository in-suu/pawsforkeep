<?php 
session_start();
include 'db_connect.php'; 

$total_to_pay = isset($_GET['total']) ? $_GET['total'] : 0;
$cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Mode | Paws for Keeps</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-red: #C62828;
        }

        /* Override main content background for payment page */
        .main-content {
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
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
            flex-direction: column;
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
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-label {
            font-size: 24px;
            font-weight: 700;
            color: #000;
            margin-top: 15px;
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

        /* --- RECEIPT POPUP MODAL --- */
        .receipt-modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.55);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .receipt-modal-overlay.show {
            display: flex;
        }
        .receipt-modal-box {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            width: 380px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .receipt-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #FFBE3E;
            border-radius: 18px 18px 0 0;
        }
        .receipt-modal-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #4D2412;
        }
        .receipt-modal-body {
            flex: 1;
            overflow-y: auto;
        }
        .receipt-modal-body iframe {
            width: 100%;
            border: none;
            min-height: 480px;
            display: block;
        }
        .receipt-modal-footer {
            display: flex;
            gap: 10px;
            padding: 14px 20px;
            border-top: 1px solid #eee;
            justify-content: center;
        }
        .receipt-modal-footer .btn {
            min-width: 130px;
            padding: 10px 20px;
            font-size: 14px;
        }
        .btn-receipt-print {
            background: #FFBE3E;
            color: #4D2412;
        }
        .btn-receipt-return {
            background: #4D2412;
            color: #fff;
        }

        /* --- CASH TENDERED PANEL --- */
        .cash-input-panel {
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            background: #fffef5;
            border: 2px solid #FFBE3E;
            border-radius: 14px;
            padding: 20px 30px;
            width: 100%;
            max-width: 420px;
            margin-bottom: 8px;
            animation: fadeInUp 0.25s ease;
        }
        .cash-input-panel.show { display: flex; }
        .cash-input-panel label {
            font-size: 14px;
            font-weight: 600;
            color: #4D2412;
            align-self: flex-start;
        }
        .cash-input-row {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }
        .cash-input-row span {
            font-size: 20px;
            font-weight: 700;
            color: #4D2412;
        }
        #cashTendered {
            flex: 1;
            padding: 10px 14px;
            border: 1.5px solid #FFBE3E;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #222;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }
        #cashTendered:focus { border-color: #e6a800; box-shadow: 0 0 0 3px rgba(255,190,62,0.2); }
        .cash-summary {
            width: 100%;
            background: #fff;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 14px;
        }
        .cash-summary .row {
            display: flex;
            justify-content: space-between;
        }
        .cash-summary .row.total-row {
            font-weight: 700;
            font-size: 15px;
            color: #4D2412;
            border-top: 1px dashed #eee;
            padding-top: 6px;
            margin-top: 2px;
        }
        .cash-summary .row.change-row {
            font-weight: 700;
            font-size: 16px;
            color: #2e7d32;
        }
        .change-insufficient { color: #c62828 !important; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="app-container">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="<?php echo $cloudinary_base; ?>logo.png" alt="Paws&Keeps Logo" class="brand-logo">
            </div>

            <nav class="nav-menu">
                <div class="nav-header">
                    <a href="online_orders.php" class="online-orders-link">
                        <h2 class="online-orders"><i class="fa-solid fa-cart-shopping"></i> Online Orders</h2>
                    </a>
                    <hr class="nav-divider">
                </div>

                <div class="nav-group all-products-group">
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
                        <li class="filter-btn"><i class="fa-solid fa-fountain"></i> Water Fountain</li>
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
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-bone"></i> Chew Toys</li>
                        <li class="filter-btn"><i class="fa-solid fa-lightbulb"></i> Interactive Toys</li>
                        <li class="filter-btn"><i class="fa-solid fa-paw"></i> Plush Toys</li>
                        <li class="filter-btn"><i class="fa-solid fa-rug"></i> Scratchers</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Safety Collar & Leash</h3>
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-dog"></i> Collar</li>
                        <li class="filter-btn"><i class="fa-solid fa-link"></i> Harness and Leash</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3>Pet Bedding & House</h3>
                    <ul>
                        <li class="filter-btn"><i class="fa-solid fa-bed"></i> Beddings</li>
                        <li class="filter-btn"><i class="fa-solid fa-house-chimney-window"></i> Pet bed and House</li>
                    </ul>
                </div>

                <div class="nav-group">
                    <h3 class="clickable-header filter-btn">Pet Supplements & Treatment</h3>
                </div>
            </nav>
        </aside>

        <main class="main-content" style="position: relative;">
            <header class="payment-header">
                <h1 class="header-title">Mode of Payment</h1>
                <hr class="header-line">
            </header>

            <div class="payment-body">
                <div class="brand-logo-main">
                    <img src="<?php echo $cloudinary_base; ?>logo.png" alt="Paws for Keeps Logo" onerror="this.src='images/placeholder.svg'">
                </div>

                <h2 class="payment-question">How would you like to pay?</h2>

                <div class="payment-options">
                    <div class="payment-card" onclick="selectMode('Cash', this)">
                        <div class="card-icon">
                            <img src="../images/cash.png?v=<?php echo time(); ?>" alt="Cash Payment">
                        </div>
                        <div class="card-label">Cash</div>
                    </div>

                    <div class="payment-card" onclick="selectMode('Digital Wallet', this)">
                        <div class="card-icon">
                            <img src="../images/e-wallet.png?v=<?php echo time(); ?>" alt="Digital Payment">
                        </div>
                        <div class="card-label">E-Wallet</div>
                    </div>
                </div>
            </div>

            <!-- Cash Input Modal -->
            <div id="cashModal" class="receipt-modal-overlay" style="position: absolute;">
                <div class="receipt-modal-box" style="width: 420px;">
                    <div class="receipt-modal-header">
                        <h3>🐾 Cash Payment</h3>
                    </div>
                    <div class="receipt-modal-body" style="padding: 20px; overflow: visible;">
                        <div class="cash-input-panel" id="cashInputPanel" style="display: flex; border: none; padding: 0; animation: none;">
                            <label>Amount Received from Customer</label>
                            <div class="cash-input-row">
                                <span>₱</span>
                                <input type="number" id="cashTendered" min="0" step="0.01" placeholder="0.00" oninput="calcChange(<?php echo $total_to_pay; ?>)">
                            </div>
                            <div class="cash-summary" id="cashSummary">
                                <div class="row">
                                    <span>VATable Sales</span>
                                    <span>₱<?php echo number_format($total_to_pay / 1.12, 2); ?></span>
                                </div>
                                <div class="row">
                                    <span>VAT (12%)</span>
                                    <span>₱<?php echo number_format($total_to_pay - ($total_to_pay / 1.12), 2); ?></span>
                                </div>
                                <div class="row total-row">
                                    <span>TOTAL DUE</span>
                                    <span>₱<?php echo number_format($total_to_pay, 2); ?></span>
                                </div>
                                <div class="row change-row" id="changeRow">
                                    <span>Change</span>
                                    <span id="changeAmount">—</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="receipt-modal-footer">
                        <button class="btn btn-cancel" onclick="closeCashModal()" style="min-width: 130px; padding: 10px 20px; font-size: 14px;">Cancel</button>
                        <button class="btn btn-save" onclick="processSave(<?php echo $total_to_pay; ?>)" style="min-width: 130px; padding: 10px 20px; font-size: 14px;">Save Receipt</button>
                    </div>
                </div>
            </div>

            <!-- Cute Alert Modal (for errors) -->
            <div id="cuteAlertModal" class="cute-modal-overlay" style="position: absolute;">
                <div class="cute-modal-content">
                    <div class="cute-modal-icon" id="cuteModalIcon">🐾</div>
                    <h3 class="cute-modal-title" id="cuteModalTitle">Oops!</h3>
                    <p class="cute-modal-text" id="cuteModalText">Please select a payment mode first!</p>
                    <button class="cute-modal-btn" id="closeCuteAlert">OK</button>
                </div>
            </div>

            <!-- Receipt Popup Modal -->
            <div id="receiptModal" class="receipt-modal-overlay" style="position: absolute;">
                <div class="receipt-modal-box">
                    <div class="receipt-modal-header">
                        <h3>🐾 Transaction Receipt</h3>
                    </div>
                    <div class="receipt-modal-body">
                        <iframe id="receiptFrame" src="" scrolling="auto"></iframe>
                    </div>
                    <div class="receipt-modal-footer">
                        <button class="btn btn-receipt-print" onclick="printReceipt()">🖨️ Print</button>
                        <button class="btn btn-receipt-return" onclick="returnToPOS()">Return to POS</button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        let selectedMode = "";
        let cashTenderedAmount = 0;

        document.addEventListener('DOMContentLoaded', () => {
            const closeAlertBtn = document.getElementById('closeCuteAlert');
            if (closeAlertBtn) {
                closeAlertBtn.addEventListener('click', () => {
                    document.getElementById('cuteAlertModal').classList.remove('show');
                });
            }
        });

        function showCuteModal(title, text, icon) {
            document.getElementById('cuteModalTitle').innerText = title;
            document.getElementById('cuteModalText').innerHTML = text;
            document.getElementById('cuteModalIcon').innerText = icon;
            document.getElementById('cuteAlertModal').classList.add('show');
        }

        function selectMode(type, el) {
            selectedMode = type;
            document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            if (type === 'Cash') {
                document.getElementById('cashModal').classList.add('show');
                setTimeout(() => document.getElementById('cashTendered').focus(), 100);
            } else {
                // E-Wallet selected, process immediately
                processSave(<?php echo $total_to_pay; ?>);
            }
        }

        function closeCashModal() {
            document.getElementById('cashModal').classList.remove('show');
            selectedMode = '';
            document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('active'));
            document.getElementById('cashTendered').value = '';
            cashTenderedAmount = 0;
            document.getElementById('changeAmount').textContent = '—';
        }

        function calcChange(total) {
            const tendered = parseFloat(document.getElementById('cashTendered').value) || 0;
            cashTenderedAmount = tendered;
            const change = tendered - total;
            const changeEl = document.getElementById('changeAmount');
            const changeRow = document.getElementById('changeRow');

            if (tendered === 0) {
                changeEl.textContent = '—';
                changeRow.classList.remove('change-insufficient');
            } else if (change < 0) {
                changeEl.textContent = '-₱' + Math.abs(change).toLocaleString(undefined, {minimumFractionDigits: 2});
                changeRow.classList.add('change-insufficient');
            } else {
                changeEl.textContent = '₱' + change.toLocaleString(undefined, {minimumFractionDigits: 2});
                changeRow.classList.remove('change-insufficient');
            }
        }

        function printReceipt() {
            const iframe = document.getElementById('receiptFrame');
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }

        function returnToPOS() {
            window.location.href = 'index.php';
        }

        async function processSave(amount) {
            if (!selectedMode) {
                showCuteModal("Oops!", "Please select a payment mode first!", "🐾");
                return;
            }

            // Validate cash tendered
            if (selectedMode === 'Cash') {
                const tendered = parseFloat(document.getElementById('cashTendered').value) || 0;
                if (tendered <= 0) {
                    showCuteModal("Oops!", "Please enter the amount received from the customer!", "💵");
                    return;
                }
                if (tendered < amount) {
                    showCuteModal("Insufficient!", "Cash received is less than the total amount due!", "❗");
                    return;
                }
                cashTenderedAmount = tendered;
            }

            const cartData = JSON.parse(localStorage.getItem('posCart') || '[]');
            if (cartData.length === 0) {
                showCuteModal("Oops!", "Cart is empty!", "🐾");
                return;
            }

            const payload = {
                payment_method: selectedMode,
                total_amount: amount,
                cash_tendered: cashTenderedAmount,
                cart: cartData
            };

            try {
                const response = await fetch('process_payment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.success) {
                    localStorage.removeItem('posCart');
                    
                    // Close the cash modal if it's open
                    document.getElementById('cashModal').classList.remove('show');
                    
                    const frame = document.getElementById('receiptFrame');
                    frame.src = 'print_receipt.php?order_id=' + result.order_id + '&modal=1'
                        + '&tendered=' + cashTenderedAmount;
                    document.getElementById('receiptModal').classList.add('show');
                } else {
                    showCuteModal("Error", "Failed to save order: " + result.message, "❌");
                }
            } catch (err) {
                console.error(err);
                showCuteModal("Error", "Server connection failed.", "❌");
            }
        }
    </script>
</body>
</html>