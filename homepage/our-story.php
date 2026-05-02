<?php 
// 1. Session start para sa login detection
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Story | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="our-story.css">
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

    <header class="story-hero">
        <div class="hero-overlay"></div>
    </header>

    <main>
        <section class="story-white-center" id="mission">
            <div class="container-narrow">
                <p>Founded in 2021, Paws for Keeps Pet Supplies and Accessories began with a simple but powerful mission: to provide a one-stop shop for premium pet essentials while fostering a community that truly cares for animals.</p>
            </div>
        </section>

        <section class="bg-gray" id="store-vibe">
            <div class="story-flex">
                <div class="story-img-frame">
                    <img src="../images/store-front.jpg" alt="Store Front">
                </div>
                <div class="story-text">
                    <h2 class="section-heading">More Than Just a Store</h2>
                    <p>We believe that a pet shop should be a happy place. That's why we designed our space with vibrant shades of orange, yellow, blue, and white—colors that radiate energy and warmth. We've kept our theme 'universal' and open, ensuring that both pets and their humans feel comfortable and welcome.</p>
                </div>
            </div>
        </section>

        <section class="story-white-center" id="founders">
            <div class="container-narrow">
                <p>What started as a shared dream is now a family-driven reality. Led by our owner, <strong>Joshua Coquia</strong>, together with <strong>Jasmin 'Ate Jas' Coquia</strong> and our two dedicated helpers, we work hand-in-hand to ensure that every pet parent who walks through our doors feels right at home.</p>
            </div>
        </section>

        <section class="bg-gray" id="community">
            <div class="story-flex">
                <div class="story-text">
                    <h2 class="section-heading">A Community Collaborator</h2>
                    <p>Since our college days, we have always opened our doors to collaboration. From working with BA Communication students on meaningful events to partnering with local pet lovers, we believe in the power of 'us.'</p><br>
                    <p>We are big believers in being 'good and nice to our strays,' and we strive to inspire our customers to do the same.</p>
                </div>
                <div class="collage-container">
                    <div class="top-row">
                        <img src="../images/collab-1.jpg" alt="Collab 1">
                        <img src="../images/collab-2.jpg" alt="Collab 2">
                    </div>
                    <div class="bottom-row">
                        <img src="../images/maligayang-agosto.jpg" alt="Maligayang Agosto" class="full-width-img">
                    </div>
                </div>
            </div>
        </section>

        <section class="story-white-center">
            <div class="container-narrow">
                <h3 class="final-quote">Join us in our journey. Because here, we don't just treat them as pets—they are family, and they are for keeps.</h3>
            </div>
        </section>
    </main>

   <?php include 'footer.php'; ?>
    <script src="search.js"></script>
</body>

</html>