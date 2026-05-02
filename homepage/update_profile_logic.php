<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    // ── ADDED: PASSWORD UPDATE LOGIC ──
    if (isset($_POST['current_pw'])) {
        $current_pw = mysqli_real_escape_string($conn, $_POST['current_pw']);
        $new_pw = mysqli_real_escape_string($conn, $_POST['new_pw']);

        // Kunin ang stored password para i-verify
        $res = mysqli_query($conn, "SELECT password FROM tbl_users WHERE user_id = '$uid'");
        $user = mysqli_fetch_assoc($res);

        if ($user['password'] === $current_pw) {
            $update_pw_sql = "UPDATE tbl_users SET password = '$new_pw' WHERE user_id = '$uid'";
            if (mysqli_query($conn, $update_pw_sql)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database error during password update.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
        }
        exit(); // Tapusin ang script dito kapag password ang in-update
    }

    // ── EXISTING: GENERAL PROFILE UPDATE ──
    $fname = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $street = mysqli_real_escape_string($conn, $_POST['street_address']);
    $brgy = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $prov = mysqli_real_escape_string($conn, $_POST['province']);
    $zip = mysqli_real_escape_string($conn, $_POST['postal_code']);

    $sql = "UPDATE tbl_users SET 
            first_name='$fname', last_name='$lname', email='$email', phone='$phone',
            street_address='$street', barangay='$brgy', city='$city', province='$prov', postal_code='$zip'
            WHERE user_id='$uid'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['user_name'] = $fname; // Update session name in real-time
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>