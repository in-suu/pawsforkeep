<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 

    // FIX: Ginamit ang tamang columns: 'email' at 'password'
    $query = "SELECT * FROM tbl_users WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap' rel='stylesheet'>
          <style>
              body { 
                  background-color: #FFBE3E !important; 
                  font-family: 'Poppins', sans-serif !important;
              }
              .paws-popup { 
                  border-radius: 24px !important; 
                  padding: 2rem !important;
              }
              .paws-title { 
                  color: #4D2412 !important; 
                  font-weight: 700 !important; 
                  font-size: 24px !important;
              }
              .paws-confirm { 
                  background: linear-gradient(135deg, #A35524, #FFBE3E) !important; 
                  padding: 12px 40px !important; 
                  border-radius: 50px !important; 
                  border: none !important;
                  font-weight: 600 !important;
                  box-shadow: 0 4px 15px rgba(163, 85, 36, 0.3) !important;
              }
          </style>";

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        $_SESSION['user_id'] = $user['user_id'];
        // FIX: Ginamit ang 'first_name' column para sa session
        $_SESSION['user_name'] = $user['first_name'];
        $_SESSION['user_role'] = $user['user_role'];

        echo "
        <script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Welcome Back! 🐾',
                    text: 'Successfully logged in to your account.',
                    icon: 'success',
                    iconColor: '#4D2412',
                    customClass: {
                        popup: 'paws-popup',
                        title: 'paws-title',
                        confirmButton: 'paws-confirm'
                    },
                    confirmButtonText: 'Enter Shop',
                    backdrop: `rgba(77, 36, 18, 0.6)`
                }).then(() => {
                    window.location.href = 'index.php';
                });
            }, 100);
        </script>";
    } else {
        echo "
        <script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Login Failed!',
                    text: 'Invalid email or password. Please try again.',
                    icon: 'error',
                    iconColor: '#e74c3c',
                    customClass: {
                        popup: 'paws-popup',
                        title: 'paws-title',
                        confirmButton: 'paws-confirm'
                    },
                    confirmButtonText: 'Try Again',
                    backdrop: `rgba(77, 36, 18, 0.6)`
                }).then(() => {
                    window.location.href = 'login.php';
                });
            }, 100);
        </script>";
    }
}
?>