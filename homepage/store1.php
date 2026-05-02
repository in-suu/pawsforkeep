<?php 
// 1. Session start para sa login detection
session_start(); 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Find a Store | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="store1.css">
    <style>
        /* Shopee Style Auth Links Consistency */
        .auth-links {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }
        .auth-btn {
            text-decoration: none;
            color: #4D2412;
            font-weight: 500;
            transition: 0.3s;
        }
        .auth-btn:hover {
            color: #FFBE3E;
        }
        .divider {
            color: #ccc;
            font-weight: 300;
        }
    </style>
</head>

<body>
  <?php include 'navbar.php'; ?>
    <section class="visit-hero">
        <img src="../images/visit.png" alt="Visit Us Banner">
    </section>

    <section class="container1">
        <img src="../images/store.png" class="branch-img">

        <div class="card1">
            <div class="card-content1">
                <h2><b>PAWS FOR KEEPS - ALABANG BRANCH</b></h2>
                <div class="line"></div>

                <div class="info1">
                    <p>Stall 179 2nd Floor Bldg. B</p>
                    <p>Alabang Central Market,</p>
                    <p>Alabang Muntinlupa City</p>
                </div>

                <a href="store2_1.php" class="back-btn1">See More ></a>
            </div>
        </div>
    </section>

    <section class="container2">
        <div class="card2">
            <div class="card-content2">
                <h2><b>PAWS FOR KEEPS - TUNASAN BRANCH</b></h2>
                <div class="line"></div>

                <div class="info2">
                    <p>Aragon Bldg. National Road</p>
                    <p>Parkhomes Commercial Tunasan</p>
                    <p>Muntinlupa City</p>
                </div>

                <a href="store2_2.php" class="back-btn2">See More ></a>
            </div>
        </div>

        <img src="../images/tunasan.png" class="branch-img">

    </section>

    <?php include 'footer.php'; ?>
    <script src="search.js"></script>
</body>

</html>