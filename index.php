<?php 
// 1. Importante para sa Account Interaction
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
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

    <section class="hero-section">
        <div class="hero-content">
            <h1>Your one-stop shop for premium pet essentials!</h1>
        </div>
    </section>

    <section class="welcome-section" id="welcome">
        <div class="welcome-text">
            <h2>Welcome, Pet Lovers!</h2>
            <p>Paws for Keeps is thrilled to bring premium pet essentials straight to your home. We believe that high-quality nutrition and stylish accessories should be accessible to every furry friend.</p>
            <a href="our-story.php" class="btn-primary">Our Story</a>
        </div>
        <div class="welcome-image-container">
            <img src="images/pets.png" alt="Pets Group" class="main-pets-img">
        </div>
    </section>

    <section class="products-section" id="top-products">
        <h2 class="section-title">Top Products for Your Furry Family</h2>
        <div class="carousel-wrapper">
            <button id="prevBtn" class="carousel-nav">❮</button>
            <div class="product-grid" id="productGrid">
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/dentastix.jpg" alt="Pedigree" class="floating-img">
                        <div class="card-text">
                            <h3>PEDIGREE DENTASTIX</h3>
                            <p>₱158.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/kitekat.jpg" alt="Kitekat" class="floating-img">
                        <div class="card-text">
                            <h3>KITEKAT CAT DRY FOOD</h3>
                            <p>₱80.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/shampoo.jpg" alt="Shampoo" class="floating-img">
                        <div class="card-text">
                            <h3>PLEASANT PET SHAMPOO</h3>
                            <p>₱120.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/absolute dental chew.jpg" alt="Dental Chew" class="floating-img">
                        <div class="card-text">
                            <h3>ABSOLUTE HOLISTIC DENTAL CHEW</h3>
                            <p>₱90.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/kitekat.jpg" alt="Whiskas" class="floating-img">
                        <div class="card-text">
                            <h3>WHISKAS WET FOOD</h3>
                            <p>₱60.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/dentastix.jpg" alt="Royal Canin" class="floating-img">
                        <div class="card-text">
                            <h3>ROYAL CANIN PUPPY</h3>
                            <p>₱350.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/shampoo.jpg" alt="Pet Wipes" class="floating-img">
                        <div class="card-text">
                            <h3>PET WIPES 100PCS</h3>
                            <p>₱150.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/kitekat.jpg" alt="SmartHeart" class="floating-img">
                        <div class="card-text">
                            <h3>SMARTHEART ADULT</h3>
                            <p>₱95.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/absolute dental chew.jpg" alt="Flea Collar" class="floating-img">
                        <div class="card-text">
                            <h3>FLEA & TICK COLLAR</h3>
                            <p>₱220.00</p>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="card-bg">
                        <img src="images/kitekat.jpg" alt="Meow Mix" class="floating-img">
                        <div class="card-text">
                            <h3>MEOW MIX SEAFOOD</h3>
                            <p>₱110.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <button id="nextBtn" class="carousel-nav">❯</button>
        </div>
        <a href="products.php" class="btn-primary mt-8">Discover More</a>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const grid = document.getElementById("productGrid");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            const getStepWidth = () => {
                const card = grid.querySelector(".product-card");
                return card ? card.offsetWidth + 32 : 312;
            };

            prevBtn.addEventListener("click", () => {
                grid.scrollBy({ left: -getStepWidth(), behavior: 'smooth' });
            });

            nextBtn.addEventListener("click", () => {
                grid.scrollBy({ left: getStepWidth(), behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>