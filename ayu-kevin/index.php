<?php
// 1. Panggil file koneksi
include 'koneksi.php';

// 2. Ambil data profil mempelai (karena id_mempelai selalu 1)
$result_mempelai = mysqli_query($conn, "SELECT * FROM mempelai WHERE id_mempelai = 1");
$mempelai = mysqli_fetch_assoc($result_mempelai);

// 3. Ambil data acara (Akad dan Resepsi)
$result_akad = mysqli_query($conn, "SELECT * FROM acara WHERE id_mempelai = 1 AND jenis_acara = 'Akad Nikah'");
$akad = mysqli_fetch_assoc($result_akad);

$result_resepsi = mysqli_query($conn, "SELECT * FROM acara WHERE id_mempelai = 1 AND jenis_acara = 'Resepsi'");
$resepsi = mysqli_fetch_assoc($result_resepsi);

// 4. Ambil data galeri dan love story untuk di-loop (diulang) nantinya
$result_galeri = mysqli_query($conn, "SELECT * FROM galeri ORDER BY tanggal_upload DESC");
$result_story = mysqli_query($conn, "SELECT * FROM love_story WHERE id_mempelai = 1 ORDER BY tahun ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $mempelai['nama_wanita'] ?> & <?= $mempelai['nama_pria'] ?> Wedding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- =====================================================
         01. COVER
    ====================================================== -->
    <section class="page cover" id="cover">
        <div class="cover-card">
            <div class="small-caps">THE WEDDING OF</div>
            <h1 class="script cover-name">
                <?= $mempelai['nama_wanita'] ?> & <?= $mempelai['nama_pria'] ?>
            </h1>
            <div class="date-caps">
                <?= strtoupper($akad['tanggal_acara']) ?>
            </div>
            <p class="guest-text">Kepada Yth. Tamu Undangan</p>
            <button id="btn-buka" class="button light-button">
                ♡ &nbsp; BUKA UNDANGAN
            </button>
        </div>
    </section>

    <!-- BUNGKUS KONTEN UTAMA -->
    <div id="main-content">
        
        <!-- =====================================================
             02. DOA
        ====================================================== -->
        <section class="page doa" id="doa">
            <div class="doa-decoration">─────── ✦ ───────</div>
            <div class="quote-card">
                <p>
                    Dan di antara tanda-tanda kekuasaan-Nya diciptakan-Nya untukmu pasangan hidup dari
                    jenismu sendiri supaya kamu dapat ketenangan hati dan dijadikannya kasih sayang di antara
                    kamu. Sesungguhnya yang demikian menjadi tanda-tanda kebesaran-Nya bagi orang-orang yang berpikir.
                </p>
                <span>— QS. Ar-Rum: 21 —</span>
            </div>
        </section>

        <!-- =====================================================
             03. COUPLE
        ====================================================== -->
        <section class="page couple" id="couple">
            <div class="section-heading">
                <h2 class="script">Bride & Groom</h2>
                <p>Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan.</p>
                <div class="gold-rule"></div>
            </div>

            <div class="couple-grid">
                <!-- AYU -->
                <div class="person-card">
                    <img src="images/couple/<?= $mempelai['foto_wanita'] ?>" alt="<?= $mempelai['nama_wanita'] ?>" class="person-photo">
                    <div class="person-info">
                        <h3 class="script"><?= $mempelai['nama_wanita'] ?></h3>
                        <div class="tiny-rule">─── ◇ ───</div>
                        <p>
                            PUTRI DARI<br>
                            <?= strtoupper($mempelai['ortu_wanita']) ?>
                        </p>
                    </div>
                </div>

                <div class="ampersand">&amp;</div>

                <!-- KEVIN -->
                <div class="person-card">
                    <img src="images/couple/<?= $mempelai['foto_pria'] ?>" alt="<?= $mempelai['nama_pria'] ?>" class="person-photo">
                    <div class="person-info">
                        <h3 class="script"><?= $mempelai['nama_pria'] ?></h3>
                        <div class="tiny-rule">─── ◇ ───</div>
                        <p>
                            PUTRA DARI<br>
                            <?= strtoupper($mempelai['ortu_pria']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             04. AKAD
        ====================================================== -->
        <section class="page event-page" id="akad">
            <div class="event-grid">
                <div class="event-info">
                    <h2 class="script event-title">Save the Date</h2>
                    <div class="gold-rule"></div>
                    <p class="event-intro">
                        Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i,
                        untuk menghadiri acara pernikahan kami:
                    </p>

                    <div class="event-box">
                        <h3 class="script">Akad nikah</h3>
                        <p><?= $akad['tanggal_acara'] ?></p>
                        <p>Pukul <?= $akad['waktu_acara'] ?></p>
                    </div>

                    <h4><?= strtoupper($akad['nama_tempat']) ?></h4>
                    <p class="address"><?= $akad['alamat'] ?></p>

                    <a href="<?= $akad['link_maps'] ?>" target="_blank">
                        <button class="button outline-button">LIHAT LOKASI</button>
                    </a>
                </div>
                <div class="photo-frame">
                    <img src="images/akad/foto-akad.jpg" alt="Foto Akad">
                    <div class="photo-seal">✦</div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             05. RESEPSI
        ====================================================== -->
        <section class="page event-page" id="reception">
            <div class="event-grid">
                <div class="event-info">
                    <div class="mini-decoration">─── ♡ ───</div>
                    <h2 class="script event-title">Resepsi</h2>
                    <div class="gold-rule"></div>

                    <div class="event-box">
                        <p><?= $resepsi['tanggal_acara'] ?></p>
                        <p>Pukul <?= $resepsi['waktu_acara'] ?></p>
                    </div>

                    <h4><?= strtoupper($resepsi['nama_tempat']) ?></h4>
                    <p class="address"><?= $resepsi['alamat'] ?></p>

                    <a href="<?= $resepsi['link_maps'] ?>" target="_blank">
                        <button class="button outline-button">LIHAT LOKASI</button>
                    </a>
                </div>
                <div class="photo-frame">
                    <img src="images/reception/foto-reception.jpg" alt="Foto Resepsi">
                    <div class="photo-seal">✦</div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             06. GALLERY
        ====================================================== -->
        <section class="page gallery-page" id="gallery">
            <div class="gallery-content">
                <h2 class="normal-title">Our Moments</h2>
                <p class="gallery-subtitle">Momen bahagia yang kami abadikan dalam lensa</p>
                <div class="gold-rule gallery-rule"></div>

                <div class="gallery-grid">
                    <?php while ($foto = mysqli_fetch_assoc($result_galeri)) : ?>
                        <div class="gallery-photo">
                            <img src="images/galery/<?= $foto['nama_file'] ?>" alt="Momen Galeri">
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <!-- =====================================================
             07. LOVE STORY
        ====================================================== -->
        <section class="page story-page" id="love-story">
            <div class="story-content">
                <h2 class="normal-title">Our Love Story</h2>
                <p class="story-intro">
                    Dan di antara tanda-tanda kekuasaan-Nya diciptakan-Nya untukmu <strong>pasangan hidup.</strong>
                </p>

                <div class="timeline">
                    <?php while ($story = mysqli_fetch_assoc($result_story)) : ?>
                        <div class="timeline-item">
                            <div class="timeline-year"><?= $story['tahun'] ?></div>
                            <div class="timeline-middle">
                                <div class="timeline-dot"></div>
                            </div>
                            <div class="timeline-text">
                                <h3><?= strtoupper($story['judul']) ?></h3>
                                <p><?= nl2br($story['deskripsi']) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <!-- =====================================================
             08. WISH / RSVP
        ====================================================== -->
        <section class="page wish-page" id="wish">
            <div class="wish-card">
                <div class="wish-symbol">✦</div>
                <h2 class="normal-title">Pray For Us</h2>
                <div class="gold-rule"></div>

                <form class="wish-form" method="POST" action="simpan_rsvp.php">
                    <label>NAMA</label>
                    <input type="text" name="nama" placeholder="Nama" required>

                    <label>KONFIRMASI KEHADIRAN (Jumlah Orang/Detail)</label>
                    <input type="text" name="konfirmasi" placeholder="Misal: Hadir 2 orang">

                    <label>PILIH KEHADIRAN</label>
                    <select name="kehadiran" required>
                        <option value="">Pilih Kehadiran</option>
                        <option value="hadir">Hadir</option>
                        <option value="tidak-hadir">Tidak Hadir</option>
                    </select>

                    <label>UCAPAN</label>
                    <textarea name="ucapan" placeholder="Tulis ucapan..." required></textarea>

                    <button type="submit" class="button confirm-button">KONFIRMASI</button>
                </form>
            </div>
        </section>

        <!-- =====================================================
             09. ADMIN LOGIN
        ====================================================== -->
        <section class="page admin-login" id="admin-login">
            <div class="admin-login-card">
                <div class="small-caps">THE WEDDING OF</div>
                <h2 class="script"><?= $mempelai['nama_wanita'] ?> & <?= $mempelai['nama_pria'] ?></h2>
                <div class="admin-symbol">✦</div>
                <h1>Admin Login</h1>
                <div class="gold-rule"></div>

                <form class="login-form" method="POST" action="proses_login.php">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="login-button">
                        ✦ &nbsp; Login &nbsp; ✦
                    </button>
                </form>
            </div>
        </section>

    </div> <!-- PENUTUP MAIN CONTENT -->

    <!-- Script Animasi Pembuka Undangan -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnBuka = document.getElementById("btn-buka");
            const cover = document.getElementById("cover");
            const mainContent = document.getElementById("main-content");

            btnBuka.addEventListener("click", function() {
                cover.style.opacity = "0";
                setTimeout(function() {
                    cover.style.display = "none";
                    mainContent.style.display = "block";
                    window.scrollTo(0, 0);
                    setTimeout(function() {
                        mainContent.style.opacity = "1";
                    }, 50);
                }, 800);
            });
        });
    </script>
</body>
</html>