<?php
session_start();
include 'koneksi.php';

// Pastikan admin login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    header("Location: index.php#admin-login");
    exit();
}

// Pastikan form dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_tamu             = mysqli_real_escape_string($conn, $_POST['id_tamu']);
    $nama                = mysqli_real_escape_string($conn, $_POST['nama']);
    $kehadiran           = mysqli_real_escape_string($conn, $_POST['kehadiran']);
    $konfirmasi_tambahan = mysqli_real_escape_string($conn, $_POST['konfirmasi_tambahan']);
    $ucapan              = mysqli_real_escape_string($conn, $_POST['ucapan']);

    // Query untuk memperbarui data RSVP
    $query = "UPDATE buku_tamu SET 
                nama = '$nama', 
                kehadiran = '$kehadiran', 
                konfirmasi_tambahan = '$konfirmasi_tambahan', 
                ucapan = '$ucapan' 
              WHERE id_tamu = '$id_tamu'";

    // Eksekusi dan cek
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data RSVP tamu berhasil diperbarui!');
                window.location.href='admin_dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
} else {
    header("Location: admin_dashboard.php");
}
?>