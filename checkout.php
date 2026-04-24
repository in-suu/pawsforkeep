<?php
session_start();
include 'db_connect.php';

if (empty($_SESSION['cart'])) {
    header("Location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar-footer.css">
    <style>
        /* ── SENIOR FRONTEND CORE STYLES ── */
        body { margin: 0; padding: 0; padding-top: 155px; font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }

        /* ── SUB-NAVBAR: YELLOW, FLUSH, LEFT-ALIGNED ── */
        .sub-nav-yellow { background-color: #FFBE3E; padding: 15px 0; width: 100%; margin-top: 0; display: block; }
        .sub-nav-container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        .sub-nav-yellow h1 { margin: 0; font-size: 20px; font-weight: 700; color: #4D2412; text-transform: uppercase; text-align: left; }

        /* ── MAIN LAYOUT ── */
        .checkout-wrapper {
            max-width: 1200px; margin: 30px auto 80px; padding: 0 15px;
            display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 30px;
            align-items: start;
        }

        /* ── CONTAINER NAVBAR HEADERS ── */
        .section-block {
            background: #fff; border-radius: 12px; overflow: hidden;
            border: 1px solid #ddd; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .section-navbar-header {
            background-color: #FFBE3E; padding: 12px 20px; font-size: 13px;
            font-weight: 700; color: #4D2412; text-transform: uppercase; border-bottom: 1px solid #e6a82e;
        }
        .section-body { padding: 25px; }

        /* ── BUTTON GROUPS: 10PX RADIUS, WHITE UNSELECTED ── */
        .btn-group { display: flex; gap: 10px; width: 100%; margin-bottom: 25px; }
        .toggle-btn {
            flex: 1; padding: 14px; border-radius: 10px; border: 1.5px solid #ddd;
            background: #fff; color: #888; font-weight: 600; font-size: 12px;
            cursor: pointer; transition: 0.2s; font-family: 'Poppins';
        }
        .toggle-btn.active { background: #FFBE3E; color: #fff; border-color: #FFBE3E; }

        /* ── SIDEBAR (NON-STICKY) ── */
        .summary-sidebar {
            position: relative; 
            top: 0;
        }

        /* ── MODERN INPUTS & FOCUS STATES ── */
        .modern-input {
            width: 100%; padding: 12px; border: 1.5px solid #ddd; border-radius: 8px;
            font-size: 14px; outline: none; font-family: 'Poppins'; transition: 0.2s; box-sizing: border-box;
        }
        .modern-input:focus { border-color: #FFBE3E; background: #fffdf5; box-shadow: 0 0 5px rgba(255, 190, 62, 0.2); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px; }
        .full { grid-column: span 2; }
        label { font-size: 11px; font-weight: 600; color: #888; text-transform: uppercase; margin-bottom: 5px; display: block; }

        /* ── PAYMENT LOGOS (FIXED CDN LINKS) ── */
        .method-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 15px; }
        .method-item input { display: none; }
        .method-button {
            height: 75px; background: #fff; border: 1.5px solid #eee; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;
        }
        .method-button img { max-height: 35px; max-width: 85%; object-fit: contain; }
        .method-item input:checked + .method-button { border-color: #FFBE3E; background: #fffdf5; }

        /* ── MODAL & ACCORDION ── */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center;
        }
        .modal-content { background: #fff; width: 95%; max-width: 500px; padding: 25px; border-radius: 15px; max-height: 85vh; overflow-y: auto; }
        .addr-list-item { padding: 15px; border: 2.2px solid #eee; border-radius: 10px; display: flex; gap: 15px; cursor: pointer; margin-bottom: 10px; transition: 0.2s; }
        .addr-list-item.selected { border-color: #FFBE3E; background: #fffdf5; }
        .add-new-addr-trigger { font-size: 13px; font-weight: 700; color: #4D2412; cursor: pointer; margin: 15px 0; display: inline-block; }
        #newAddressForm { display: none; border-top: 1px solid #eee; padding-top: 20px; margin-top: 10px; }

        /* ── PROCESSING OVERLAY ── */
        #loadingOverlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.95); z-index: 10000;
            justify-content: center; align-items: center; flex-direction: column;
        }
        .paw-pulse { font-size: 60px; animation: pulse 1.2s infinite; margin-bottom: 20px; }
        @keyframes pulse { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.7; } 100% { transform: scale(1); opacity: 1; } }
        #loadingOverlay p { font-weight: 700; color: #4D2412; font-size: 18px; }

        .place-order-btn {
            width: 100%; background: #C0572A; color: #fff; border: none; padding: 16px;
            border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s;
        }
        .place-order-btn:hover { background: #4D2412; transform: translateY(-2px); }

        @media (max-width: 992px) { .checkout-wrapper { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

<div id="loadingOverlay">
    <div class="paw-pulse">🐾</div>
    <p>Please wait... We're processing your order.</p>
</div>

    <div class="sub-nav-yellow">
        <div class="sub-nav-container"><h1>Checkout</h1></div>
    </div>

    <form action="place_order.php" method="POST" class="checkout-wrapper" onsubmit="document.getElementById('loadingOverlay').style.display='flex';">
        <input type="hidden" name="delivery_type" id="delivery_type_input" value="delivery">
        <input type="hidden" name="payment_method" id="payment_method_input" value="cash">

        <div class="checkout-main">
            <div class="section-block">
                <div class="section-navbar-header">Delivery Options</div>
                <div class="section-body">
                    <div class="btn-group">
                        <button type="button" class="toggle-btn active" id="btnDelivery" onclick="selectDelivery('delivery')">Delivery</button>
                        <button type="button" class="toggle-btn" id="btnPickup" onclick="selectDelivery('pickup')">Pick Up</button>
                    </div>
                </div>
            </div>

            <div id="deliveryInfoSection" class="section-block">
                <div class="section-navbar-header">Delivery Address</div>
                <div class="section-body">
                    <div style="display:flex; align-items:center; gap:20px; padding:18px; border:1.5px solid #eee; border-radius:12px; cursor:pointer;" onclick="toggleAddressModal(true)">
                        <div style="font-size:24px;">📍</div>
                        <div style="flex-grow:1;">
                            <div style="font-weight:700; color:#4D2412;" id="main_addr_label">HOME <span style="font-weight:400; color:#888;">(Default)</span></div>
                            <div style="font-size:13px; color:#666;" id="main_addr_text">204 Challengert ST., Southside, Makati City, 1200</div>
                        </div>
                        <div style="font-size:18px; color:#ccc;">›</div>
                    </div>
                    <div style="margin-top:20px;">
                        <label>delivery instructions</label>
                        <textarea name="delivery_instructions" class="modern-input" rows="2" placeholder="Note to rider - e.g. Gate color"></textarea>
                    </div>
                </div>
            </div>

            <div class="section-block">
                <div class="section-navbar-header">Payment Method</div>
                <div class="section-body">
                    <div class="btn-group">
                        <button type="button" id="payCash" class="toggle-btn active" onclick="selectPayment('cash')">Cash on Delivery</button>
                        <button type="button" id="payCard" class="toggle-btn" onclick="selectPayment('card')">Card/PayPal</button>
                        <button type="button" id="payWallet" class="toggle-btn" onclick="selectPayment('wallet')">E-Wallet</button>
                    </div>

                    <div id="cardDetailsForm" style="display:none;">
                        <div class="method-grid">
                            <label class="method-item"><input type="radio" name="card_type" checked><div class="method-button"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Visa_2021.svg/512px-Visa_2021.svg.png"></div></label>
                            <label class="method-item"><input type="radio" name="card_type"><div class="method-button"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/512px-Mastercard-logo.svg.png"></div></label>
                            <label class="method-item"><input type="radio" name="card_type"><div class="method-button"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/512px-PayPal.svg.png"></div></label>
                        </div>
                        <div class="form-grid">
                            <div class="full"><label>card number</label><input type="text" class="modern-input" placeholder="0000 0000 0000 0000"></div>
                            <div><label>expiry</label><input type="text" class="modern-input" placeholder="MM/YY"></div>
                            <div><label>cvv</label><input type="password" class="modern-input" placeholder="***"></div>
                        </div>
                    </div>

                    <div id="walletOptions" style="display:none;">
                        <div class="method-grid" style="grid-template-columns: 1fr 1fr;">
                            <label class="method-item"><input type="radio" name="wallet_type" checked><div class="method-button"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/52/GCash_logo.svg/1280px-GCash_logo.svg.png"></div></label>
                            <label class="method-item"><input type="radio" name="wallet_type"><div class="method-button"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Maya_Philippines_Logo.png/800px-Maya_Philippines_Logo.png"></div></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="summary-sidebar">
            <div class="section-block">
                <div class="section-navbar-header">Order Summary</div>
                <div class="section-body">
                    <?php
                    $cart = $_SESSION['cart']; $sub = 0;
                    foreach($cart as $id => $qty) {
                        $res = mysqli_query($conn, "SELECT prod_price FROM tbl_products WHERE prod_id = '$id'");
                        $row = mysqli_fetch_assoc($res);
                        $sub += ($row['prod_price'] * $qty);
                    }
                    ?>
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:14px;"><span>Subtotal</span><span>₱<?= number_format($sub, 2) ?></span></div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:14px;"><span>Delivery Fee</span><span>₱50.00</span></div>
                    <div style="display:flex; justify-content:space-between; margin-top:20px; padding-top:20px; border-top:2px dashed #eee; font-size:20px; font-weight:800; color:#4D2412;">
                        <span>Total Bill</span><span>₱<?= number_format($sub + 50, 2) ?></span>
                    </div>

                    <input type="hidden" name="total_amount" value="<?php echo $sub + 50; ?>">

                    <button type="submit" class="place-order-btn">Place Order</button>
                </div>
            </div>
        </div>
    </form>

    <div class="modal-overlay" id="addressModal">
        <div class="modal-content">
            <div style="font-weight:700; color:#4D2412; margin-bottom:20px; text-transform:uppercase;">Select Address</div>
            <div id="modalAddressList">
                <div class="addr-list-item selected" onclick="selectThisAddress(this, 'HOME', '204 Challengert ST., Southside, Makati City, 1200')">
                    <div style="font-size:20px;">🏠</div>
                    <div style="flex-grow:1;">
                        <div style="font-weight:700; color:#4D2412; font-size:14px;">HOME</div>
                        <div style="font-size:12px; color:#666;">204 Challengert ST., Southside, Makati City, 1200</div>
                    </div>
                </div>
            </div>
            <div class="add-new-addr-trigger" onclick="toggleNewAddressForm()">+ add New Address</div>
            <div id="newAddressForm">
                <div class="form-grid">
                    <div class="full"><label>label (e.g. work)</label><input type="text" id="new_label" class="modern-input" placeholder="Work"></div>
                    <div class="full"><label>full address</label><input type="text" id="new_addr" class="modern-input" placeholder="Unit, Street, Brgy"></div>
                    <div><label>city</label><input type="text" id="new_city" class="modern-input" placeholder="Makati"></div>
                    <div><label>zip code</label><input type="text" id="new_zip" class="modern-input" placeholder="1200"></div>
                </div>
                <div style="overflow:hidden;"><button type="button" style="background:#FFBE3E; color:#fff; border:none; padding:10px 20px; border-radius:8px; margin-top:15px; float:right; cursor:pointer; font-weight:700;" onclick="saveNewAddressToList()">Save Address</button></div>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:30px; border-top:1px solid #eee; padding-top:20px;">
                <button type="button" class="toggle-btn" style="flex:none; width:100px; background:#eee;" onclick="toggleAddressModal(false)">Cancel</button>
                <button type="button" class="toggle-btn active" style="flex:none; width:100px;" onclick="confirmSelectedAddress()">Save</button>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

<script>
    let tempLabel = "HOME", tempText = "204 Challengert ST., Southside, Makati City, 1200";

    function toggleAddressModal(show) { document.getElementById('addressModal').style.display = show ? 'flex' : 'none'; }
    function toggleNewAddressForm() {
        const f = document.getElementById('newAddressForm');
        f.style.display = (f.style.display === 'block') ? 'none' : 'block';
    }

    function selectThisAddress(element, label, text) {
        document.querySelectorAll('.addr-list-item').forEach(item => item.classList.remove('selected'));
        element.classList.add('selected');
        tempLabel = label; tempText = text;
    }

    function saveNewAddressToList() {
        const label = document.getElementById('new_label').value;
        const addr = document.getElementById('new_addr').value;
        const city = document.getElementById('new_city').value;
        const zip = document.getElementById('new_zip').value;
        if(!label || !addr) return alert("Please fill fields");

        const fullText = `${addr}, ${city}, ${zip}`;
        const list = document.getElementById('modalAddressList');
        const newItem = document.createElement('div');
        newItem.className = 'addr-list-item';
        newItem.onclick = function() { selectThisAddress(this, label, fullText); };
        newItem.innerHTML = `<div style="font-size:20px;">📍</div><div style="flex-grow:1;"><div style="font-weight:700; color:#4D2412; font-size:14px;">${label.toUpperCase()}</div><div style="font-size:12px; color:#666;">${fullText}</div></div>`;
        list.appendChild(newItem);
        toggleNewAddressForm();
        newItem.click();
    }

    function confirmSelectedAddress() {
        document.getElementById('main_addr_label').innerHTML = tempLabel;
        document.getElementById('main_addr_text').innerHTML = tempText;
        toggleAddressModal(false);
    }

    function selectDelivery(type) {
        document.getElementById('delivery_type_input').value = type;
        const btnD = document.getElementById('btnDelivery'), btnP = document.getElementById('btnPickup');
        if (type === 'delivery') {
            btnD.classList.add('active'); btnP.classList.remove('active');
            document.getElementById('deliveryInfoSection').style.display = 'block';
        } else {
            btnP.classList.add('active'); btnD.classList.remove('active');
            document.getElementById('deliveryInfoSection').style.display = 'none';
        }
    }

    function selectPayment(method) {
        document.getElementById('payment_method_input').value = method;
        ['payCash','payCard','payWallet'].forEach(id => document.getElementById(id).classList.remove('active'));
        document.getElementById('pay' + method.charAt(0).toUpperCase() + method.slice(1)).classList.add('active');
        document.getElementById('walletOptions').style.display = (method === 'wallet') ? 'block' : 'none';
        document.getElementById('cardDetailsForm').style.display = (method === 'card') ? 'block' : 'none';
    }
</script>
</body>
</html>