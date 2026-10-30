<?php
session_start(); // Memulai sesi
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek kecocokan di database
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika cocok, buat sesi login dan arahkan ke dashboard
        $_SESSION['status_login'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Jika salah, kembalikan ke halaman login dengan pesan error
        echo "<script>
                alert('Username atau Password salah!');
                window.location.href = 'index.php#admin-login';
              </script>";
    }
} else {
    header("Location: index.php");
}
?>