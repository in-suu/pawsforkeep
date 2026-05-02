<?php
$servername = "127.0.0.1"; 
$username = "root";
$password = "";
$dbname = "petshop_db";
$port = 3306; // Subukan mong palitan ito ng 3307 kung ayaw pa rin

// Idagdag ang $port sa dulo ng connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>