<?php
$servername = "localhost"; // Sesuaikan dengan konfigurasi server MySQL Anda
$db_username = "root"; // Sesuaikan dengan username MySQL Anda
$db_password = ""; // Sesuaikan dengan password MySQL Anda
$dbname = "database_name"; // Sesuaikan dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari POST request
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$password = $data['password'];

// Validasi input
if (empty($username) || empty($password)) {
    $response = array('success' => false, 'message' => 'Username or Password cannot be empty');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Query untuk memeriksa username dan password
$sql = "SELECT * FROM akun WHERE username = $username AND password = $password";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    $response = array('success' => false, 'message' => 'Query preparation failed: ' . $conn->error);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Jika login berhasil
    $response = array('success' => true);
} else {
    // Jika login gagal
    $response = array('success' => false);
}

// Mengembalikan response sebagai JSON
header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
