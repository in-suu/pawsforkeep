<?php session_start(); include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Paws For Keeps</title>
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
            padding-bottom: 50px;
            display: flex;
            flex-direction: column;
        }
        
        /* FIXED CONTAINER SIZE PARA KAPAREHO NI LOGIN */
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
            margin: auto;
        }

        .subtitle { 
            font-size: 13px; 
            font-weight: 500; 
            color: #525252; 
            margin-bottom: 15px; 
            text-align: center; 
        }

        form { 
            width: 100%; 
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Pinupuno ang space sa loob */
            justify-content: space-around;
        }

        .input-group { margin-bottom: 8px; }

        label { 
            display: block; 
            text-align: left; 
            font-size: 12px; 
            margin-bottom: 3px; 
            font-weight: 600; 
            color: #4D2412; 
        }

        input { 
            width: 100%; 
            padding: 10px; 
            border-radius: 10px; 
            border: 1px solid #949B9E; 
            font-size: 13px; 
        }
        
        .password-wrap { position: relative; }
        .password-wrap i { 
            position: absolute; 
            top: 50%; 
            transform: translateY(-50%); 
            right: 12px; 
            color: #484E51; 
            font-size: 14px; 
            cursor: pointer; 
        }
        
        .login-text { 
            text-align: center; 
            font-size: 12px; 
            margin: 10px 0; 
            color: #525252; 
        }
        
        .login-text a { 
            color: #4D2412; 
            font-weight: 700; 
            text-decoration: none; 
        }

        .login-btn { 
            width: 100%; 
            padding: 14px; 
            border-radius: 50px; 
            border: none; 
            background: linear-gradient(135deg, #A35524, #FFBE3E); 
            color: white; 
            font-size: 15px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: 0.2s; 
            margin-top: auto; /* Laging nasa dulo ng container */
        }
        .login-btn:hover { transform: scale(1.02); }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="main-wrapper">
        <div class="container">
        <p class="subtitle"><b>Create Account</b> to start your journey</p>
        
        <form action="signup_logic.php" method="POST">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="fullname" placeholder="Enter full name" required>
            </div>

            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <div class="password-wrap">
                    <input type="password" id="p1" name="password" placeholder="Create password" required>
                    <i class="fa-solid fa-eye" onclick="toggle('p1')"></i>
                </div>
            </div>

            <div class="input-group">
                <label>Confirm Password</label>
                <div class="password-wrap">
                    <input type="password" id="p2" name="confirm_password" placeholder="Confirm password" required>
                    <i class="fa-solid fa-eye" onclick="toggle('p2')"></i>
                </div>
            </div>
            
            <p class="login-text">Already have an account? <a href="login.php">Login here</a></p>

            <button type="submit" class="login-btn">Sign Up</button>
        </form>
    </div>
    </div>

    <script>
        function toggle(id) {
            const x = document.getElementById(id);
            x.type = x.type === "password" ? "text" : "password";
        }
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>