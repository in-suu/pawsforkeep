<?php
session_start();
include 'db_connect.php'; 

$cloudinary_base = "https://res.cloudinary.com/dnsnpr8hu/image/upload/f_auto,q_auto/";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html { overflow-y: scroll; } 
        /* 🛠️ Fixed gap: Binabaan sa 100px para sumunod sa sukat ng navbar.php */
        body { font-family: 'Poppins', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; padding-top: 100px; }

        /* --- CART STYLES --- */
        .cart-page { max-width: 1200px; margin: 30px auto 60px; padding: 0 15px; }
        .cart-container { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 15px; }
        .cart-header { background-color: #fff; display: grid; grid-template-columns: 50px 2fr 1fr 1fr 1fr 100px; padding: 14px 20px; border-bottom: 1px solid #e8e8e8; color: #555; font-weight: 500; font-size: 14px; }
        .cart-header div { text-align: center; }
        .cart-header .text-left { text-align: left; }

        .cart-items-card { 
            background: #fff; 
            border-radius: 8px; 
            box-shadow: 0 1px 4px rgba(0,0,0,0.08); 
            margin-bottom: 15px; 
            overflow: hidden; 
            padding: 10px 0; 
            min-height: 140px; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
        }

        .cart-item { display: grid; grid-template-columns: 50px 2fr 1fr 1fr 1fr 100px; padding: 18px 20px; align-items: center; border-bottom: 1px solid #f5f5f5; }
        .cart-item:last-child { border-bottom: none; }

        .product-info { display: flex; align-items: center; gap: 18px; }
        .img-box { width: 80px; height: 80px; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; padding: 5px; flex-shrink: 0; border-radius: 4px; }
        .img-box img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .product-name { font-weight: 700; color: #222; text-transform: uppercase; font-size: 13px; line-height: 1.4; }

        .price, .total-price { font-size: 15px; color: #333; text-align: center; font-weight: 400; }
        .quantity-control { display: flex; align-items: center; justify-content: center; }
        .qty-btn { background: #fff; border: 1px solid #d9d9d9; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #555; line-height: 1; }
        .qty-input { width: 36px; height: 28px; border: 1px solid #d9d9d9; border-left: none; border-right: none; text-align: center; font-size: 13px; outline: none; color: #333; }

        .delete-btn { color: #ff4d4d; border: none; background: none; cursor: pointer; font-size: 14px; }
        .delete-btn-bottom { color: #ff4d4d; border: none; background: none; cursor: pointer; font-size: 14px; margin-left: 10px; }

        .checkout-bar { display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 14px 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); position: sticky; bottom: 15px; z-index: 100; }
        .total-price-val { color: #D32F2F; font-size: 17px; font-weight: 600; margin-left: 4px; }
        .checkout-btn { background-color: #D32F2F; color: white; border: none; padding: 11px 36px; font-size: 14px; font-weight: 600; border-radius: 4px; cursor: pointer; }

        .empty-cart-msg { text-align: center; padding: 20px 0; }
        .empty-cart-msg p { font-size: 16px; color: #888; margin-bottom: 2px; }
        .empty-cart-msg a { color: #FFBE3E; text-decoration: none; font-weight: 700; }
        .empty-cart-msg a:hover { text-decoration: underline; }
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

        <div class="cart-items-card">
            <?php
            if (!empty($cart)) {
                $safe_ids = array_map(function($id) use ($conn) { return "'" . mysqli_real_escape_string($conn, (string)$id) . "'"; }, array_keys($cart));
                $query  = "SELECT * FROM tbl_products WHERE prod_id IN (" . implode(',', $safe_ids) . ")";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $prod_id = $row['prod_id'];
                        $qty = $cart[$prod_id] ?? 0;
                        $image_url = $cloudinary_base . str_replace('%2F', '/', rawurlencode($row['prod_image']));
                ?>
                    <div class="cart-item" data-id="<?php echo htmlspecialchars($prod_id); ?>">
                        <div style="text-align:center;"><input type="checkbox" class="item-checkbox" data-price="<?php echo $row['prod_price']; ?>" data-qty="<?php echo $qty; ?>" onchange="updateCheckoutBar()"></div>
                        <div class="product-info">
                            <div class="img-box"><img src="<?php echo $image_url; ?>" onerror="this.src='../images/logo.png'"></div>
                            <span class="product-name"><?php echo htmlspecialchars($row['prod_name']); ?></span>
                        </div>
                        <div class="price">₱<?php echo number_format($row['prod_price'], 2); ?></div>
                        <div class="quantity-control">
                            <button class="qty-btn" onclick="updateQty('<?php echo $prod_id; ?>', -1)">−</button>
                            <input type="text" class="qty-input" value="<?php echo $qty; ?>" readonly>
                            <button class="qty-btn" onclick="updateQty('<?php echo $prod_id; ?>', 1)">+</button>
                        </div>
                        <div class="total-price">₱<?php echo number_format($row['prod_price'] * $qty, 2); ?></div>
                        <div style="text-align:center;"><button class="delete-btn" onclick="removeItem('<?php echo $prod_id; ?>')">Delete</button></div>
                    </div>
                <?php
                    }
                } else {
                    echo '<div class="empty-cart-msg"><p>Your cart is empty.</p><a href="products.php">Shop now!</a></div>';
                }
            } else {
                echo '<div class="empty-cart-msg"><p>Your cart is empty.</p><a href="products.php">Shop now!</a></div>';
            }
            ?>
        </div>

        <div class="checkout-bar">
            <div class="checkout-left">
                <input type="checkbox" id="selectAllBottom" onclick="toggleSelectAll(this)">
                <label for="selectAllBottom">Select All (<span id="selected-count">0</span>)</label>
                <button class="delete-btn-bottom" onclick="removeSelected()">Delete</button>
            </div>
            <div class="checkout-right">
                <span class="total-text">Total: <span class="total-price-val" id="grand-total">₱ 0.00</span></span>
                <button class="checkout-btn" onclick="window.location.href='checkout.php'">Check Out</button>
            </div>
        </div>
    </div>

    <script>
        function updateQty(id, delta) {
            fetch('cartLogic.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${encodeURIComponent(id)}&delta=${delta}`
            }).then(() => location.reload());
        }

        function removeItem(id) {
            Swal.fire({
                title: 'Remove item? 🐾',
                text: "Are you sure you want to remove this treat from your cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4D2412', 
                cancelButtonColor: '#ff4d4d',  
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, keep it',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('cartLogic.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `product_id=${encodeURIComponent(id)}&action=remove`
                    }).then(() => location.reload());
                }
            });
        }

        function removeSelected() {
            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            if (checkedBoxes.length === 0) {
                Swal.fire('No items selected!', 'Please select treats to remove.', 'info');
                return;
            }

            Swal.fire({
                title: 'Remove selected items? 🐾',
                text: `Are you sure you want to remove ${checkedBoxes.length} items from your cart?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4D2412',
                cancelButtonColor: '#ff4d4d',
                confirmButtonText: 'Yes, remove them!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const ids = Array.from(checkedBoxes).map(cb => cb.closest('.cart-item').dataset.id);
                    fetch('cartLogic.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `product_ids=${JSON.stringify(ids)}&action=remove_selected`
                    }).then(() => location.reload());
                }
            });
        }

        function toggleSelectAll(checkbox) {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = checkbox.checked);
            updateCheckoutBar();
        }

        function updateCheckoutBar() {
            let totalItems = 0, grandTotal = 0;
            document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
                const qty = parseInt(cb.getAttribute('data-qty'));
                const price = parseFloat(cb.getAttribute('data-price'));
                totalItems += qty;
                grandTotal += qty * price;
            });
            document.getElementById('selected-count').innerText = totalItems;
            document.getElementById('grand-total').innerText = '₱ ' + grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2 });
        }
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>