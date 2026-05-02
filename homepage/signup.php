<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup.php');
    exit;
}

$full_name        = trim($_POST['full_name']        ?? '');
$email            = trim($_POST['email']            ?? '');
$password         = $_POST['password']              ?? '';
$confirm_password = $_POST['confirm_password']      ?? '';

// ── Basic validation ──────────────────────────────────────────────
if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['signup_error']         = 'All fields are required.';
    $_SESSION['prefill_name']         = $full_name;
    $_SESSION['prefill_email_signup'] = $email;
    header('Location: signup.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['signup_error']         = 'Please enter a valid email address.';
    $_SESSION['prefill_name']         = $full_name;
    $_SESSION['prefill_email_signup'] = $email;
    header('Location: signup.php');
    exit;
}

if ($password !== $confirm_password) {
    $_SESSION['signup_error']         = 'Passwords do not match.';
    $_SESSION['prefill_name']         = $full_name;
    $_SESSION['prefill_email_signup'] = $email;
    header('Location: signup.php');
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['signup_error']         = 'Password must be at least 6 characters.';
    $_SESSION['prefill_name']         = $full_name;
    $_SESSION['prefill_email_signup'] = $email;
    header('Location: signup.php');
    exit;
}

// ── Check for duplicate email ─────────────────────────────────────
$check = mysqli_prepare($conn, "SELECT user_id FROM tbl_users WHERE user_email = ? LIMIT 1");
mysqli_stmt_bind_param($check, 's', $email);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    // Email already exists → redirect to LOGIN with pre-filled email and notice
    $_SESSION['signup_notice'] = 'This email is already registered. Please log in instead.';
    $_SESSION['prefill_email'] = $email;   // login.php reads this
    header('Location: login.php');
    exit;
}
mysqli_stmt_close($check);

// ── Insert new user ───────────────────────────────────────────────
$hashed = password_hash($password, PASSWORD_DEFAULT);

$insert = mysqli_prepare($conn, "INSERT INTO tbl_users (user_fullname, user_email, user_password) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($insert, 'sss', $full_name, $email, $hashed);

if (mysqli_stmt_execute($insert)) {
    $new_id = mysqli_insert_id($conn);

    // Auto-login after signup
    $_SESSION['user_id']    = $new_id;
    $_SESSION['user_name']  = $full_name;
    $_SESSION['user_email'] = $email;

    header('Location: products.php');
    exit;
} else {
    $_SESSION['signup_error']         = 'Something went wrong. Please try again.';
    $_SESSION['prefill_name']         = $full_name;
    $_SESSION['prefill_email_signup'] = $email;
    header('Location: signup.php');
    exit;
}
?>