<?php
session_start();
// include '../db_connect.php'; // Naka-comment out muna para sa bypass mode

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // TEMPORARY BYPASS MODE: Tinatanggap ang kahit anong input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // I-set ang session variables manual para makapasok sa dashboard
    $_SESSION['admin_id'] = 999; 
    $_SESSION['admin_name'] = "Admin Tester"; 
    
    header("Location: overview.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page | Paws for Keeps</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" />
    
    <style>
        /* Small addition para sa error message visibility */
        .error-msg {
            color: #C0572A;
            background: #fff0f0;
            padding: 10px;
            border-radius: 5px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: center;
            border: 1px solid #ffcccc;
        }
    </style>
</head>

<body>
    <div>
        <div class="container">

            <img src="images/logo.png" class="logo" alt="Logo">
            <h3 class="subtitle"><b>Sign In</b> to manage your store</h3>

            <?php if ($error != ""): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="post">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>

                <label for="password">Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    <i class="fa-solid fa-eye" style="cursor: pointer;"></i>
                </div>

                <a href="reset_pass.php" class="forgot">Forgot Password?</a>
                <div class="forgot-divider"></div>

                <button type="button" class="social google">
                    <img src="images/google.png" alt="Google"> Continue with Google
                </button>

                <p class="or">or</p>

                <button type="button" class="social facebook">
                    <img src="images/facebook.png" alt="Facebook"> Continue with Facebook
                </button>

                <p class="terms">
                    By continuing, you agree to Paws For Keep's Terms of Service and <br>Privacy Policy.
                </p>

                <button type="submit" class="login-btn">Log In</button>

            </form>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.password-wrap i.fa-eye');

        toggleIcon.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>

    <script>
        const fbBtn = document.querySelector('.social.facebook');

        const fbAppId = "899850412611662";
        const redirectUri = "http://localhost/PawsForKeeps/adminSide/login.php"; // In-update ang link

        fbBtn.addEventListener('click', () => {
            const fbLoginUrl = `https://www.facebook.com/v18.0/dialog/oauth?client_id=${fbAppId}&redirect_uri=${encodeURIComponent(redirectUri)}&response_type=token&scope=email,public_profile`;
            window.location.href = fbLoginUrl;
        });

        window.addEventListener("load", () => {
            if (window.location.hash.includes("access_token")) {
                const token = window.location.hash.split("access_token=")[1].split("&")[0];
                console.log("Facebook Token:", token);
                window.location.href = "overview.php";
            }
        });

        const client_id = '68023548656-ce2imj6lt8a5aos2348b0sok89nfb633.apps.googleusercontent.com';
        const redirect_uri = 'http://localhost/PawsForKeeps/adminSide/login.php'; // In-update ang link
        const scope = 'openid email profile';

        const googleBtn = document.querySelector('.social.google');

        googleBtn.addEventListener('click', () => {
            const oauth2_url = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${client_id}&redirect_uri=${encodeURIComponent(redirect_uri)}&response_type=token&scope=${encodeURIComponent(scope)}`;
            window.location.href = oauth2_url;
        });
    </script>

</body>

</html>