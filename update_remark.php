<?php
include 'config.php'; // Pastikan path ke config.php benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $soid = $_POST['soid'];
    $remark = $_POST['remark'];

    $query = "UPDATE stockopname SET remark='$remark', cek='NO' WHERE SOID='$soid'";
    if (mysqli_query($connection, $query)) {
        echo "Remark updated successfully";
    } else {
        echo "Error updating remark: " . mysqli_error($connection);
    }
}
?>
