<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan pengaturan default Laragon/XAMPP
$db   = "db_ayu_kevin";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>