<?php
session_start();
include 'koneksi.php';

// Proteksi Halaman: Cek apakah admin sudah login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    header("Location: index.php#admin-login");
    exit();
}

// Ambil data undangan saat ini untuk diisikan ke form
$mempelai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mempelai WHERE id_mempelai = 1"));
$akad     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM acara WHERE id_mempelai = 1 AND jenis_acara = 'Akad Nikah'"));
$resepsi  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM acara WHERE id_mempelai = 1 AND jenis_acara = 'Resepsi'"));

// Ambil data RSVP / Buku Tamu
$result_tamu = mysqli_query($conn, "SELECT * FROM buku_tamu ORDER BY waktu_kirim DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= htmlspecialchars($mempelai['nama_wanita']) ?> & <?= htmlspecialchars($mempelai['nama_pria']) ?></title>
    
    <!-- Mengambil Font yang sama dengan halaman depan -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <!-- Memanggil style.css utama -->
    <link rel="stylesheet" href="style.css">

    <style>
        .btn-edit {
            background-color: #b79d5e;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.85rem;
            font-family: sans-serif;
            transition: background 0.3s;
        }
        .btn-edit:hover {
            background-color: #8c7343;
        }
        /* CSS Tambahan khusus untuk layout Dashboard dan Tabel agar estetis */
        body {
            background-color: #faf8f5; /* Warna background soft/krem */
        }
        .dashboard-wrapper {
            padding: 50px 20px;
            min-height: 100vh;
        }
        .nav-admin {
            text-align: center;
            margin-bottom: 40px;
        }
        .nav-admin h2 {
            font-size: 3.5rem;
            margin-bottom: 5px;
            color: #333;
        }
        .btn-logout {
            display: inline-block;
            padding: 8px 25px;
            border: 1px solid #b79d5e;
            color: #b79d5e;
            text-decoration: none;
            letter-spacing: 2px;
            font-size: 0.9rem;
            font-family: 'Cormorant Garamond', serif;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #b79d5e;
            color: #fff;
        }
        
        /* Modifikasi Card agar tidak bentrok dengan page index */
        .admin-section {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
        }
        .admin-card {
            width: 100%;
            max-width: 1000px; /* Diperlebar sedikit untuk tabel */
        }

        /* Style Tabel RSVP Estetik */
        .table-container {
            overflow-x: auto;
            margin-top: 30px;
        }
        .rsvp-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            color: #4a4a4a;
        }
        .rsvp-table th, .rsvp-table td {
            border: 1px solid #e8e1d3;
            padding: 15px;
            text-align: left;
        }
        .rsvp-table th {
            background-color: #f4efe6;
            color: #8c7343;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1.5px;
        }
        .rsvp-table tbody tr:nth-child(even) {
            background-color: #fdfbf7;
        }
        .badge-hadir { color: #5a7d5a; font-weight: 600; }
        .badge-absen { color: #a05a5a; font-weight: 600; }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        
        <!-- HEADER ADMIN -->
        <div class="nav-admin">
            <h2 class="script">Dashboard Admin</h2>
            <div class="gold-rule" style="margin: 0 auto 20px auto;"></div>
            <a href="logout.php" class="btn-logout">✦ &nbsp; Keluar (Logout) &nbsp; ✦</a>
        </div>

        <!-- 1. FORM EDIT INFORMASI UNDANGAN -->
        <div class="admin-section">
            <!-- Meminjam class 'edit-card' dari style.css Anda -->
            <div class="edit-card admin-card">
                <h1>Edit Informasi Undangan</h1>

                <form method="POST" action="proses_edit.php" enctype="multipart/form-data">
                    <div class="form-section">
                        <h2>Informasi Mempelai</h2>
                        <input type="text" name="nama_wanita" value="<?= htmlspecialchars($mempelai['nama_wanita']) ?>" placeholder="Nama mempelai wanita">
                        <input type="text" name="nama_pria" value="<?= htmlspecialchars($mempelai['nama_pria']) ?>" placeholder="Nama mempelai pria">
                        <input type="text" name="ortu_wanita" value="<?= htmlspecialchars($mempelai['ortu_wanita']) ?>" placeholder="Nama orang tua mempelai wanita">
                        <input type="text" name="ortu_pria" value="<?= htmlspecialchars($mempelai['ortu_pria']) ?>" placeholder="Nama orang tua mempelai pria">
                    </div>

                    <div class="form-section">
                        <h2>Informasi Acara (Akad)</h2>
                        <input type="text" name="tanggal_akad" value="<?= htmlspecialchars($akad['tanggal_acara']) ?>" placeholder="Tanggal acara akad">
                        <input type="text" name="waktu_akad" value="<?= htmlspecialchars($akad['waktu_acara']) ?>" placeholder="Waktu acara akad">
                        <input type="text" name="tempat_akad" value="<?= htmlspecialchars($akad['nama_tempat']) ?>" placeholder="Nama tempat akad">
                        <input type="text" name="alamat_akad" value="<?= htmlspecialchars($akad['alamat']) ?>" placeholder="Alamat acara akad">
                        <input type="url" name="maps_akad" value="<?= htmlspecialchars($akad['link_maps']) ?>" placeholder="Link lokasi Google Maps akad">
                    </div>

                    <div class="form-section">
                        <h2>Pesan / Aturan</h2>
                        <textarea name="pesan_aturan" placeholder="Tulis pesan atau aturan undangan..."><?= htmlspecialchars($mempelai['pesan_aturan']) ?></textarea>
                    </div>

                    <!-- Meminjam class 'button' dan 'save-button' dari style.css Anda -->
                    <button type="submit" class="button save-button">
                        ✉ &nbsp; Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- 2. TABEL DATA RSVP -->
        <div class="admin-section">
            <div class="edit-card admin-card">
                <h1>Data Kehadiran Tamu (RSVP)</h1>
                
                <div class="table-container">
                    <table class="rsvp-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kehadiran</th>
                                <th>Detail Tambahan</th>
                                <th>Ucapan</th>
                                <th>Waktu Kirim</th>
                                <th>Aksi</th> <!-- Kolom Baru -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($tamu = mysqli_fetch_assoc($result_tamu)) : 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($tamu['nama']) ?></strong></td>
                                <td>
                                    <?php if($tamu['kehadiran'] == 'hadir') : ?>
                                        <span class="badge-hadir">Hadir</span>
                                    <?php else : ?>
                                        <span class="badge-absen">Tidak Hadir</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($tamu['konfirmasi_tambahan']) ?></td>
                                <td><i>"<?= htmlspecialchars($tamu['ucapan']) ?>"</i></td>
                                <td style="font-size: 0.9rem;"><?= date('d M Y, H:i', strtotime($tamu['waktu_kirim'])) ?></td>
                                <!-- Tombol Edit Baru -->
                                <td>
                                    <a href="edit_rsvp.php?id=<?= $tamu['id_tamu'] ?>" class="btn-edit">Edit</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>
</html>