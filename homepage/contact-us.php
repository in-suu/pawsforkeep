<?php
// 1. Session start para sa login detection
session_start(); 
include 'db_connect.php'; 

if (isset($_POST['submit_pitch'])) {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['pitch_message']);

    $query = "INSERT INTO tbl_pitches (client_name, client_email, pitch_message) VALUES ('$name', '$email', '$message')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pawsitive! We have received your pitch.'); window.location='contact-us.php';</script>";
    } else {
        echo "<script>alert('Oops! There was an error submitting your pitch.'); window.location='contact-us.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="contact-us.css">
    <style>
        /* Maintain design consistency for auth links */
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
    <header class="contact-hero">
        <div class="hero-overlay"></div>
    </header>

    <main>
        <section class="bg-gray" id="team">
            <div class="content-flex">
                <div class="img-frame">
                    <img src="../images/team-photo.png" alt="Our Team">
                </div>
                <div class="text-side">
                    <h2 class="section-heading">Be Part of Our Team</h2>
                    <p>Passionate about pets and making a difference? Join the Paws For Keeps family! We're always looking for dedicated, caring individuals who share our love for animals.</p>
                    <button class="btn-yellow">Contact Us</button>
                </div>
            </div>
        </section>

        <section class="bg-white" id="bulk-purchase">
            <div class="content-flex reverse">
                <div class="img-frame">
                    <img src="../images/bulk-delivery.png" alt="Bulk Delivery">
                </div>
                <div class="text-side">
                    <h2 class="section-heading">Bulk Purchase or Vouchers</h2>
                    <p>Whether you're purchasing in bulk for an event or corporate gifting, Paws For Keeps has options to suit your needs. Reach out for customized packages!</p>
                    <button class="btn-yellow">Contact Us</button>
                </div>
            </div>
        </section>

        <section class="bg-gray" id="pitch-ideas">
            <div class="content-flex">
                <div class="logo-side">
                    <img src="../images/logo-badge.png" alt="Paws for Keeps Badge" class="pitch-logo">
                </div>
                <div class="form-side">
                    <h2 class="section-heading">Pitch your Ideas</h2>
                    <p>Got a pawsome idea? We'd love to hear it! Whether it's a creative event or a new service, we're all ears!</p>
                    <form class="pitch-form" action="contact-us.php" method="POST">
                        <div class="form-row">
                            <input type="text" name="full_name" placeholder="Your Name" required>
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                        <textarea name="pitch_message" placeholder="Your Pitch" required></textarea>
                        <button type="submit" name="submit_pitch" class="btn-yellow submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </section>

        <?php include 'footer.php'; ?>
    </main>
    <script src="search.js"></script>
</body>
</html>