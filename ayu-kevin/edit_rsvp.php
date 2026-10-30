<?php
session_start();
include 'koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    header("Location: index.php#admin-login");
    exit();
}

// Cek apakah ada parameter ID yang dikirim
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id_tamu = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM buku_tamu WHERE id_tamu = '$id_tamu'";
$result = mysqli_query($conn, $query);

// Jika data tidak ditemukan di database
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data tamu tidak ditemukan!'); window.location.href='admin_dashboard.php';</script>";
    exit();
}

$tamu = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Tamu RSVP</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #faf8f5; }
        .dashboard-wrapper { padding: 50px 20px; display: flex; justify-content: center; }
        .admin-card { width: 100%; max-width: 600px; }
        .btn-back { display: inline-block; margin-bottom: 20px; color: #b79d5e; text-decoration: none; font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; }
        .select-box { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; font-family: inherit; font-size: 1rem; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <div class="edit-card admin-card">
            <a href="admin_dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
            <h1>Edit Data RSVP Tamu</h1>
            
            <form method="POST" action="proses_edit_rsvp.php">
                <!-- ID Tamu disembunyikan tapi wajib dikirim untuk update -->
                <input type="hidden" name="id_tamu" value="<?= $tamu['id_tamu'] ?>">
                
                <div class="form-section">
                    <h2 style="font-size: 1.2rem;">Nama Tamu</h2>
                    <input type="text" name="nama" value="<?= htmlspecialchars($tamu['nama']) ?>" required>
                    
                    <h2 style="font-size: 1.2rem;">Konfirmasi Kehadiran</h2>
                    <select name="kehadiran" class="select-box" required>
                        <option value="hadir" <?= ($tamu['kehadiran'] == 'hadir') ? 'selected' : '' ?>>Hadir</option>
                        <option value="tidak-hadir" <?= ($tamu['kehadiran'] == 'tidak-hadir') ? 'selected' : '' ?>>Tidak Hadir</option>
                    </select>
                    
                    <h2 style="font-size: 1.2rem;">Detail Tambahan (Misal: 2 Orang)</h2>
                    <input type="text" name="konfirmasi_tambahan" value="<?= htmlspecialchars($tamu['konfirmasi_tambahan']) ?>">
                    
                    <h2 style="font-size: 1.2rem;">Ucapan</h2>
                    <textarea name="ucapan" required><?= htmlspecialchars($tamu['ucapan']) ?></textarea>
                </div>

                <button type="submit" class="button save-button">
                    ✉ &nbsp; Simpan Perubahan Data Tamu
                </button>
            </form>
        </div>
    </div>
</body>
</html>