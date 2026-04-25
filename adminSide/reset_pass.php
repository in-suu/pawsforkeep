<?php
session_start();
include '../db_connect.php'; 

$message = "";
$message_type = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new-password']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm-password']);

    if ($new_pass !== $confirm_pass) {
        $message = "Passwords do not match!";
        $message_type = "error";
    } else {
        $check_email = "SELECT * FROM tbl_admin WHERE email = '$email'";
        $res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($res) > 0) {
            $update_query = "UPDATE tbl_admin SET password = '$new_pass' WHERE email = '$email'";
            if (mysqli_query($conn, $update_query)) {
                $message = "Password reset successful! You can now log in.";
                $message_type = "success";
            } else {
                $message = "Error updating password. Please try again.";
                $message_type = "error";
            }
        } else {
            $message = "Email address not found in our records.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | Paws for Keeps</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="reset_pass.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" />
    
    <style>
        .msg-box {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 13px;
        }
        .error { background: #fff0f0; color: #C0572A; border: 1px solid #ffcccc; }
        .success { background: #f0fff4; color: #2d5a27; border: 1px solid #ccffda; }
    </style>
</head>

<body>
    <div class="container">

        <img src="images/logo.png" class="logo" alt="Logo">

        <?php if ($message != ""): ?>
            <div class="msg-box <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="reset_pass.php" method="post">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter email address" required>

            <label for="new-password">New Password <span style="color:red;">*</span></label>
            <div class="password-wrap">
                <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
                <i class="fa fa-eye toggle-password" style="cursor:pointer;"></i> 
            </div>

            <label for="confirm-password">Confirm Password <span style="color:red;">*</span></label>
            <div class="password-wrap">
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>
                <i class="fa fa-eye toggle-password" style="cursor:pointer;"></i> 
            </div>

            <div style="margin-bottom: 15px;">
                <a href="login.php" style="text-decoration:none; font-size: 12px; color: #888;">Back to Login</a>
            </div>

            <button type="submit" class="submit-btn">Submit</button>

        </form>
    </div>

    <script>
        const togglePassword = document.querySelectorAll('.toggle-password');

        togglePassword.forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.previousElementSibling; 
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>

</body>

</html>