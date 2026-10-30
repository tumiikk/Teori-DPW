<?php
// 1. Panggil file koneksi ke database
include 'koneksi.php';

// 2. Pastikan data dikirim melalui metode POST dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Tangkap data dari form dan bersihkan (mencegah SQL Injection)
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $konfirmasi = mysqli_real_escape_string($conn, $_POST['konfirmasi']);
    $kehadiran  = mysqli_real_escape_string($conn, $_POST['kehadiran']);
    $ucapan     = mysqli_real_escape_string($conn, $_POST['ucapan']);
    
    // 4. Siapkan query untuk memasukkan data ke tabel buku_tamu
    $query = "INSERT INTO buku_tamu (nama, konfirmasi_tambahan, kehadiran, ucapan) 
              VALUES ('$nama', '$konfirmasi', '$kehadiran', '$ucapan')";
              
    // 5. Eksekusi query dan cek apakah berhasil
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, tampilkan pesan sukses (alert) dan kembalikan ke halaman utama
        echo "<script>
                alert('Terima kasih! RSVP dan ucapan Anda berhasil dikirim.');
                window.location.href = 'index.php#wish';
              </script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>
                alert('Maaf, terjadi kesalahan saat menyimpan data: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
    
    // 6. Tutup koneksi (opsional tapi disarankan)
    mysqli_close($conn);
} else {
    // Jika file ini diakses langsung tanpa melalui form, kembalikan ke index
    header("Location: index.php");
    exit();
}
?>