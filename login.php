<?php session_start(); include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Paws For Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="navbar-footer.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins'; }
        
        body { 
            background: #FFBE3E; 
            margin: 0;
        }
        
        .main-wrapper {
            min-height: 100vh;
            padding-top: 80px; /* Space for the fixed navbar */
            padding-bottom: 40px;
            display: flex;
            flex-direction: column;
        }
        
        .container { 
            background: #f2f2f2; 
            width: 450px; 
            border-radius: 20px; 
            padding: 25px 35px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            height: auto; 
            margin: auto; /* Ensures it stays centered without overflowing top */
        }


        .subtitle { 
            font-size: 13px; 
            font-weight: 500; 
            color: #525252; 
            margin-bottom: 15px; /* Binawasan ang margin */
            text-align: center; 
        }

        form { width: 100%; }

        label { 
            display: block; 
            text-align: left; 
            font-size: 12px; 
            margin-bottom: 4px; 
            font-weight: 600; 
            color: #4D2412; 
        }

        input { 
            width: 100%; 
            padding: 10px; /* Binawasan ang vertical padding ng input */
            border-radius: 10px; 
            border: 1px solid #949B9E; 
            margin-bottom: 12px; /* Mas siksik na spacing */
            font-size: 13px; 
        }
        
        .password-wrap { position: relative; }
        .password-wrap i { 
            position: absolute; 
            top: 50%; 
            transform: translateY(-85%); 
            right: 15px; 
            color: #484E51; 
            font-size: 16px; 
            cursor: pointer; 
        }
        
        .forgot { 
            display: block; 
            text-align: right; 
            margin-bottom: 10px; 
            font-size: 11px; 
            color: #525252; 
            text-decoration: none; 
        }

        .forgot-divider { 
            width: 100%; 
            height: 1px; 
            background-color: #ddd; 
            margin: 8px 0; 
        }
        
        .social { 
            width: 100%; 
            padding: 10px; 
            border-radius: 100px; 
            border: 1px solid #949B9E; 
            background: #fff; 
            font-size: 13px; 
            font-weight: 600; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer; 
            margin-bottom: 8px; 
        }

        .social img { margin-right: 10px; width: 18px; }

        .terms { 
            font-size: 10px; 
            color: #484E51; 
            margin: 10px 0; 
            text-align: center; 
            line-height: 1.4; 
        }

        .login-btn { 
            width: 100%; 
            padding: 12px; 
            border-radius: 50px; 
            border: none; 
            background: linear-gradient(135deg, #A35524, #FFBE3E); 
            color: white; 
            font-size: 15px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: 0.2s; 
        }
        .login-btn:hover { transform: scale(1.03); }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="main-wrapper">
        <div class="container">
    
        <p class="subtitle"><b>Sign In</b> to manage your store</p>
        <form action="login_logic.php" method="POST">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter email address" required>
            <label>Password</label>
            <div class="password-wrap">
                <input type="password" id="pass" name="password" placeholder="Enter Password" required>
                <i class="fa-solid fa-eye" onclick="toggle('pass')"></i>
            </div>
            <a href="#" class="forgot">Forgot Password?</a>
            <div class="forgot-divider"></div>
            <button type="button" class="social"><img src="images/google.png"> Continue with Google</button>
            <button type="button" class="social"><img src="images/facebook.png"> Continue with Facebook</button>
            <p class="subtitle" style="margin-top:8px; font-size:11px;">Don't have an account? <a href="signup.php" style="color:#4D2412; font-weight:700; text-decoration:none;">Create one here</a></p>
            <p class="terms">By continuing, you agree to Paws For Keep's Terms and Privacy Policy.</p>
            <button type="submit" class="login-btn">Log In</button>
        </form>
    </div>
    </div>
    <script>function toggle(id){ const x = document.getElementById(id); x.type = x.type === "password" ? "text" : "password"; }</script>
    <?php include 'footer.php'; ?>
</body>
</html>