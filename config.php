<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_db";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
$connection = $conn;
// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
