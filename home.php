<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Kopi Thru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
    .navbar { background-color: #007bc8; }
    .navbar-brand, .nav-link { color: #fff !important; }
    .nav-link:hover { color: #ffd700 !important; }
    .card { border-radius: 10px; transition: transform 0.3s; }
    .card:hover { transform: translateY(-5px); }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand fs-4" href="#">Kopi Thru Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="modules/admin/menu/index.php"><i class="fa-solid fa-coffee"></i> Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="modules/admin/karyawan/lihat_karyawan.php"><i class="fa-solid fa-users"></i> Karyawan</a></li>
          <li class="nav-item"><a class="nav-link" href="modules/admin/Transaksi/index.php"><i class="fa-solid fa-receipt"></i> Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="modules/admin/Pembeli/pembeli.html"><i class="fa-solid fa-user-tag"></i> Pembeli</a></li>
          <li class="nav-item"><a class="nav-link" href="modules/admin/komentar/index.php"><i class="fa-solid fa-comments"></i> Komentar</a></li>
          <li class="nav-item"><a class="nav-link" href="modules/admin/About/about.php"><i class="fa-solid fa-circle-info"></i> About</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa-solid fa-circle-info"></i>Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Dashboard Cards -->
  <div class="container my-5">
    <h3 class="mb-4 text-primary">Dashboard Admin</h3>
    <div class="row g-4">

      <!-- Total Menu -->
      <?php 
        $menuCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM menu"))['total'];
      ?>
      <div class="col-md-3">
        <div class="card text-center p-3 shadow-sm">
          <i class="fa-solid fa-coffee fa-2x text-primary mb-2"></i>
          <h5>Total Menu</h5>
          <p class="mb-0 fs-5"><?= $menuCount; ?></p>
          <a href="modules/admin/menu/index.php" class="btn btn-sm btn-primary mt-2">Lihat Menu</a>
        </div>
      </div>

      <!-- Total Karyawan -->
      <?php 
        $karyawanCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM karyawan"))['total'];
      ?>
      <div class="col-md-3">
        <div class="card text-center p-3 shadow-sm">
          <i class="fa-solid fa-users fa-2x text-success mb-2"></i>
          <h5>Total Karyawan</h5>
          <p class="mb-0 fs-5"><?= $karyawanCount; ?></p>
          <a href="modules/admin/karyawan/lihat_karyawan.php" class="btn btn-sm btn-success mt-2">Lihat Karyawan</a>
        </div>
      </div>

      <!-- Total Transaksi -->
      <?php 
        $transaksiCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi"))['total'];
      ?>
      <div class="col-md-3">
        <div class="card text-center p-3 shadow-sm">
          <i class="fa-solid fa-receipt fa-2x text-warning mb-2"></i>
          <h5>Total Transaksi</h5>
          <p class="mb-0 fs-5"><?= $transaksiCount; ?></p>
          <a href="modules/admin/Transaksi/index.php" class="btn btn-sm btn-warning mt-2">Lihat Transaksi</a>
        </div>
      </div>

      <!-- Total Pembeli -->
      <?php 
        $pembeliCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pembeli"))['total'];
      ?>
      <div class="col-md-3">
        <div class="card text-center p-3 shadow-sm">
          <i class="fa-solid fa-user-tag fa-2x text-danger mb-2"></i>
          <h5>Total Pembeli</h5>
          <p class="mb-0 fs-5"><?= $pembeliCount; ?></p>
          <a href="modules/admin/Pembeli/pembeli.html" class="btn btn-sm btn-danger mt-2">Lihat Pembeli</a>
        </div>
      </div>

    </div>
  </div>

  <!--komentar-->
  <section class="container my-5">
    <h3 class="text-center mb-5 text-primary">Apa Kata Mereka ☕</h3>
    <div class="row g-4 justify-content-center">
    <?php
    // Query untuk mengambil 3 komentar terbaru, beserta nama pembeli dan balasan Admin
    $queryKomentar = "
        SELECT 
            k.komentar, k.balasan, k.tanggal, p.nama_pembeli 
        FROM komentar k
        JOIN pembeli p ON k.id_pembeli = p.id_pembeli
        ORDER BY k.tanggal DESC
        LIMIT 3
    ";
    $resultKomentar = mysqli_query($conn, $queryKomentar);
    
    // Cek apakah ada komentar yang ditemukan
    if (mysqli_num_rows($resultKomentar) > 0) {
        while ($row = mysqli_fetch_assoc($resultKomentar)) {
            $nama = htmlspecialchars($row['nama_pembeli']);
            $komentar_text = htmlspecialchars($row['komentar']);
            $balasan_text = htmlspecialchars($row['balasan']);
            $tanggal = date('d M Y', strtotime($row['tanggal']));

            echo '<div class="col-md-4">';
            echo '<div class="testimonial text-center">';
            
            // Komentar Pembeli
            echo '<p class="lead fst-italic">"' . $komentar_text . '"</p>';
            echo '<h6 class="text-primary mt-3 mb-0">– ' . $nama . '</h6>';
            echo '<small class="text-muted d-block">' . $tanggal . '</small>';

            // Tampilkan Balasan Admin jika ada
            if (!empty($balasan_text)) {
                echo '<div class="admin-reply rounded">';
                echo '<strong><i class="fa-solid fa-crown me-1"></i> Balasan Admin:</strong>';
                echo '<p class="mb-0 small">' . $balasan_text . '</p>';
                echo '</div>';
            }
            
            echo '</div>'; // Tutup testimonial
            echo '</div>'; // Tutup col-md-4
        }
    } else {
        // Tampilkan pesan jika tidak ada komentar di database
        echo '<div class="col-12"><p class="text-center text-muted">Belum ada ulasan atau komentar dari pembeli. Silakan <a href="login/login.php">Login</a> untuk memberi ulasan!</p></div>';
    }
    ?>
    </div>
   
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>