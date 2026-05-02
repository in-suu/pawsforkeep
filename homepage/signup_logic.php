<?php
session_start();

if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
    session_start(); 
}
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_input = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    
    $name_parts = explode(' ', $full_input, 2);
    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
    
    $username = strstr($email, '@', true); 

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap' rel='stylesheet'>
    <style>
        body { background-color: #FFBE3E !important; font-family: 'Poppins', sans-serif !important; }
        .paws-popup { border-radius: 24px !important; padding: 2rem !important; }
        .paws-title { color: #4D2412 !important; font-weight: 700 !important; font-size: 24px !important; }
        .paws-content { color: #525252 !important; font-size: 15px !important; }
        .paws-confirm { 
            background: linear-gradient(135deg, #A35524, #FFBE3E) !important; 
            padding: 12px 40px !important; 
            border-radius: 50px !important; 
            border: none !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px rgba(163, 85, 36, 0.3) !important;
        }
        .paws-cancel { background: #6c757d !important; border-radius: 50px !important; padding: 12px 30px !important; }
    </style>";

    try {
        $check_email = mysqli_query($conn, "SELECT * FROM tbl_users WHERE email = '$email'");
        
        if (mysqli_num_rows($check_email) > 0) {
            // --- MODAL: ACCOUNT EXISTS ---
            echo "
            <script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Account Exists! 🐾',
                        text: 'It looks like you already have an account with us.',
                        icon: 'info',
                        iconColor: '#FFBE3E',
                        showCancelButton: true,
                        confirmButtonText: 'Go to Login',
                        cancelButtonText: 'Try another Email',
                        customClass: {
                            popup: 'paws-popup',
                            title: 'paws-title',
                            htmlContainer: 'paws-content',
                            confirmButton: 'paws-confirm',
                            cancelButton: 'paws-cancel'
                        },
                        backdrop: `rgba(77, 36, 18, 0.6)`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'login.php'; 
                        } else {
                            window.location.href = 'index.php'; // Balik sa Sign Up form
                        }
                    });
                }, 100);
            </script>";
        } else {
            $query = "INSERT INTO tbl_users (first_name, last_name, username, email, password, user_role) 
                      VALUES ('$first_name', '$last_name', '$username', '$email', '$password', 'customer')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['user_name'] = $first_name;

                // --- MODAL: SUCCESS SIGNUP ---
                echo "
                <script>
                    setTimeout(function() {
                        Swal.fire({
                            title: 'Welcome to the Pack! 🐾',
                            text: 'Your account is ready for treats!',
                            icon: 'success',
                            iconColor: '#4D2412',
                            confirmButtonText: 'Let\'s Shop!',
                            customClass: {
                                popup: 'paws-popup',
                                title: 'paws-title',
                                htmlContainer: 'paws-content',
                                confirmButton: 'paws-confirm'
                            },
                            backdrop: `rgba(77, 36, 18, 0.6)`
                        }).then((result) => {
                            window.location.href = 'index.php';
                        });
                    }, 100);
                </script>";
            }
        }
        
    } catch (mysqli_sql_exception $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>