<?php
session_start();
include 'db_connect.php';

$cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";

// Cart is now stored as {prod_id => quantity}
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_total_count = array_sum($cart);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar-footer.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; padding-top: 155px; }

        /* Outer page wrapper */
        .cart-page { max-width: 1200px; margin: 30px auto 60px; padding: 0 15px; }

        /* Header bar — checkbox + column labels */
        .cart-container { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 15px; }

        .cart-header { background-color: #fff; display: grid; grid-template-columns: 50px 2fr 1fr 1fr 1fr 100px; padding: 14px 20px; border-bottom: 1px solid #e8e8e8; color: #555; font-weight: 500; font-size: 14px; }
        .cart-header div { text-align: center; }
        .cart-header .text-left { text-align: left; }

        /* White card wrapping the product rows */
        .cart-items-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            margin-bottom: 15px;
            overflow: hidden;
            padding: 10px 0;
        }

        .cart-item { display: grid; grid-template-columns: 50px 2fr 1fr 1fr 1fr 100px; padding: 18px 20px; align-items: center; border-bottom: 1px solid #f5f5f5; }
        .cart-item:last-child { border-bottom: none; }

        .product-info { display: flex; align-items: center; gap: 18px; }
        .img-box { width: 80px; height: 80px; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; padding: 5px; flex-shrink: 0; border-radius: 4px; }
        .img-box img { max-width: 100%; max-height: 100%; object-fit: contain; }

        .product-name { font-weight: 700; color: #222; text-transform: uppercase; font-size: 13px; line-height: 1.4; }

        .price, .total-price { font-size: 15px; color: #333; text-align: center; font-weight: 400; }
        .total-price { color: #333; }

        /* Quantity control — matches screenshot: [ − ] [ 1 ] [ + ] */
        .quantity-control { display: flex; align-items: center; justify-content: center; }
        .qty-btn {
            background: #fff;
            border: 1px solid #d9d9d9;
            width: 28px;
            height: 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #555;
            transition: background 0.15s;
            line-height: 1;
        }
        .qty-btn:first-child { border-radius: 2px 0 0 2px; }
        .qty-btn:last-child  { border-radius: 0 2px 2px 0; }
        .qty-btn:hover { background: #f0f0f0; }
        .qty-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .qty-input {
            width: 36px;
            height: 28px;
            border: 1px solid #d9d9d9;
            border-left: none;
            border-right: none;
            text-align: center;
            font-size: 13px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .delete-btn { color: #ff4d4d; border: none; background: none; cursor: pointer; font-weight: 400; text-align: center; font-family: 'Poppins', sans-serif; font-size: 14px; }
        .delete-btn:hover { text-decoration: underline; }

        /* Empty cart state */
        .empty-cart { padding: 80px 50px; text-align: center; color: #aaa; font-size: 15px; }
        .empty-cart p { margin: 0 0 12px; }
        .empty-cart a { color: #FFBE3E; text-decoration: none; font-weight: 600; }
        .empty-cart a:hover { text-decoration: underline; }

        input[type="checkbox"] { transform: scale(1.2); cursor: pointer; accent-color: #FFBE3E; }

        /* Checkout sticky bar */
        .checkout-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 14px 20px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            position: sticky;
            bottom: 15px;
            z-index: 100;
        }

        .checkout-left {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 14px;
            color: #555;
            font-weight: 400;
        }

        .delete-btn-bottom {
            background: none;
            border: none;
            color: #555;
            cursor: pointer;
            font-weight: 400;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }
        .delete-btn-bottom:hover { color: #ff4d4d; }

        .checkout-right { display: flex; align-items: center; gap: 16px; }

        .total-text { font-size: 14px; color: #555; font-weight: 400; }
        .total-price-val { color: #D32F2F; font-size: 17px; font-weight: 600; margin-left: 4px; }

        .checkout-btn {
            background-color: #D32F2F;
            color: white;
            border: none;
            padding: 11px 36px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Poppins', sans-serif;
            white-space: nowrap;
        }
        .checkout-btn:hover { background-color: #b71c1c; }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="cart-page">

        <div class="cart-container">
            <div class="cart-header">
                <div><input type="checkbox" id="selectAllTop" onclick="toggleSelectAll(this)"></div>
                <div class="text-left">Products</div>
                <div>Unit Price</div>
                <div>Quantity</div>
                <div>Total Price</div>
                <div>Action</div>
            </div>
        </div>

        <div class="cart-items-card" id="cart-items-list">
            <?php
            if (!empty($cart)) {
                $safe_ids = [];
                foreach ($cart as $prod_id => $qty) {
                    $safe_ids[] = "'" . mysqli_real_escape_string($conn, (string)$prod_id) . "'";
                }

                $query  = "SELECT * FROM tbl_products WHERE prod_id IN (" . implode(',', $safe_ids) . ")";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $prod_id = $row['prod_id'];
                        $qty = $cart[$prod_id] ?? $cart[(string)$prod_id] ?? 0;
                        if ($qty <= 0) continue;

                        $total_price  = $row['prod_price'] * $qty;
                        $encoded_path = rawurlencode($row['prod_image']);
                        $final_path   = str_replace('%2F', '/', $encoded_path);
                        $image_url    = $cloudinary_base . $final_path;
                ?>
                    <div class="cart-item" data-id="<?php echo htmlspecialchars($prod_id); ?>">
                        <div style="text-align:center;">
                            <input type="checkbox"
                                class="item-checkbox"
                                data-price="<?php echo $row['prod_price']; ?>"
                                data-qty="<?php echo $qty; ?>"
                                onchange="updateCheckoutBar()">
                        </div>
                        <div class="product-info">
                            <div class="img-box">
                                <img src="<?php echo $image_url; ?>" onerror="this.src='images/logo.png'" alt="<?php echo htmlspecialchars($row['prod_name']); ?>">
                            </div>
                            <span class="product-name"><?php echo htmlspecialchars($row['prod_name']); ?></span>
                        </div>
                        <div class="price">₱<?php echo number_format($row['prod_price'], 2); ?></div>
                        <div class="quantity-control">
                            <button class="qty-btn" onclick="updateQty('<?php echo $prod_id; ?>', -1, this)">−</button>
                            <input type="text" class="qty-input" value="<?php echo $qty; ?>" readonly>
                            <button class="qty-btn" onclick="updateQty('<?php echo $prod_id; ?>', 1, this)">+</button>
                        </div>
                        <div class="total-price" data-unit-price="<?php echo $row['prod_price']; ?>">
                            ₱<?php echo number_format($total_price, 2); ?>
                        </div>
                        <div style="text-align:center;">
                            <button class="delete-btn" onclick="removeItem('<?php echo $prod_id; ?>')">Delete</button>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo '<div class="empty-cart"><p>Your cart is empty.</p><a href="products.php">Shop now!</a></div>';
                }
            } else {
                echo '<div class="empty-cart"><p>Your cart is empty.</p><a href="products.php">Shop now!</a></div>';
            }
            ?>
        </div>

        <div class="checkout-bar">
            <div class="checkout-left">
                <div style="display:flex; align-items:center; gap:10px;">
                    <input type="checkbox" id="selectAllBottom" onclick="toggleSelectAll(this)">
                    <label for="selectAllBottom" style="cursor:pointer;">
                        Select All (<span id="selected-count">0</span>)
                    </label>
                </div>
                <button class="delete-btn-bottom" onclick="removeSelected()">Delete</button>
            </div>
            <div class="checkout-right">
                <span class="total-text">
                    Total (<span id="summary-items">0</span> item<span id="summary-items-s">s</span>):
                    <span class="total-price-val" id="grand-total">₱ 0.00</span>
                </span>
                
                <button class="checkout-btn" onclick="goToCheckout()">Check Out</button>
            </div>
        </div>

    </div><script>
    // ── Checkout Connection ───────────────────────────────────────
    function goToCheckout() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        if (checked.length === 0) {
            alert('Please select at least one item to checkout! 🐾');
            return;
        }
        // Dahil ang checkout.php mo ay binabasa ang $_SESSION['cart'],
        // dideretso na tayo doon.
        window.location.href = 'checkout.php';
    }

    // ── Select All ────────────────────────────────────────────────
    function toggleSelectAll(checkbox) {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = checkbox.checked);
        document.getElementById('selectAllTop').checked    = checkbox.checked;
        document.getElementById('selectAllBottom').checked = checkbox.checked;
        updateCheckoutBar();
    }

    // ── Recalculate totals in the sticky bar ──────────────────────
    function updateCheckoutBar() {
        let totalItems = 0, grandTotal = 0, allChecked = true;
        const checkboxes = document.querySelectorAll('.item-checkbox');
        
        if (checkboxes.length === 0) {
            allChecked = false;
        } else {
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const qty   = parseInt(cb.getAttribute('data-qty'));
                    const price = parseFloat(cb.getAttribute('data-price'));
                    totalItems += qty;
                    grandTotal += qty * price;
                } else {
                    allChecked = false;
                }
            });
        }

        document.getElementById('selectAllTop').checked    = allChecked;
        document.getElementById('selectAllBottom').checked = allChecked;
        document.getElementById('selected-count').innerText = totalItems;
        document.getElementById('summary-items').innerText  = totalItems;
        document.getElementById('summary-items-s').innerText = totalItems !== 1 ? 's' : '';
        document.getElementById('grand-total').innerText =
            '₱ ' + grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // ── +/− Quantity ──────────────────────────────────────────────
    function updateQty(id, delta, btnElement) {
        const row = document.querySelector(`.cart-item[data-id="${id}"]`);
        if (!row) return;
        row.querySelectorAll('.qty-btn').forEach(b => b.disabled = true);

        fetch('update_cart_qty.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + encodeURIComponent(id) + '&delta=' + delta
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'removed') {
                row.remove();
                if (typeof updateCartBadge === 'function') updateCartBadge(data.new_total);
                updateCheckoutBar();
                return;
            }

            if (data.status === 'updated') {
                const qtyInput  = row.querySelector('.qty-input');
                const totalCell = row.querySelector('.total-price');
                const unitPrice = parseFloat(totalCell.getAttribute('data-unit-price'));
                const newTotal  = unitPrice * data.new_qty;

                qtyInput.value = data.new_qty;
                totalCell.innerText = '₱' + newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                const cb = row.querySelector('.item-checkbox');
                if (cb) cb.setAttribute('data-qty', data.new_qty);

                if (typeof updateCartBadge === 'function') updateCartBadge(data.new_total);
                updateCheckoutBar();
            }
        })
        .catch(err => console.error('updateQty error:', err))
        .finally(() => {
            if (row) row.querySelectorAll('.qty-btn').forEach(b => b.disabled = false);
        });
    }

    // ── Delete single item ────────────────────────────────────────
    function removeItem(id) {
        if (!confirm('Remove this item from your cart?')) return;

        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + encodeURIComponent(id)
        })
        .then(r => r.json())
        .then(data => {
            document.querySelector(`.cart-item[data-id="${id}"]`)?.remove();
            if (typeof updateCartBadge === 'function') updateCartBadge(data.new_total);
            updateCheckoutBar();
        })
        .catch(err => console.error('removeItem error:', err));
    }

    // ── Delete selected items ─────────────────────────────────────
    function removeSelected() {
        const checked = [...document.querySelectorAll('.item-checkbox:checked')];
        if (!checked.length) { alert('Please select at least one item.'); return; }
        if (!confirm(`Remove ${checked.length} selected item(s)?`)) return;

        const ids = checked.map(cb => cb.closest('.cart-item').getAttribute('data-id'));

        Promise.all(ids.map(id =>
            fetch('remove_from_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + encodeURIComponent(id)
            }).then(r => r.json())
        ))
        .then(results => {
            ids.forEach(id => document.querySelector(`.cart-item[data-id="${id}"]`)?.remove());
            const lastTotal = results[results.length - 1]?.new_total ?? 0;
            if (typeof updateCartBadge === 'function') updateCartBadge(lastTotal);
            updateCheckoutBar();
        })
        .catch(err => console.error('removeSelected error:', err));
    }

    // Init on load
    updateCheckoutBar();
</script>

    <?php include 'footer.php'; ?>
</body>
</html>