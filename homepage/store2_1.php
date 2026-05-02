<?php 
// 1. Session start para sa login detection
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Visit Us | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="store2_1.css">
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
    
    <section class="container">

        <div class="card">
            <img src="../images/store.png" class="store-img">

            <div class="card-content">
                <h2>
                    <strong>Paws for Keeps - Alabang Branch</strong>
                </h2>
                <div class="line"></div>

                <div class="info">
                    <p>📍 Stall 179 2nd Floor Bldg. B Alabang Central Market, Alabang Muntinlupa City</p>
                    <p>📞 0977 231 4361</p>

                    <p>🕒 Monday-Friday | 6:00am - 7:00pm</p>
                    <p>🕒 Saturday | 7:00am - 7:00pm</p>
                    <p>🕒 Sunday | 7:00am - 6:00pm</p>

                    <p>🚚 7:00am - 6:30pm</p>
                </div>

                <a href="store1.php">
                    <button class="back-btn">Back</button>
                </a>
            </div>
        </div>

        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3864.444!2d121.045!3d14.417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTTCsDI1JzAxLjAiTiAxMjHCsDAyJzQyLjAiRQ!5e0!3m2!1sen!2sph!4v1620000000000!5m2!1sen!2sph"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </section>

  <?php include 'footer.php'; ?>
    <script src="search.js"></script>
</body>

</html>