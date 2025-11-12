<?php
include "koneksi.php";

// Ambil data menu dari database
$data = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY Id_menu ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pembeli | Kopi Thru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-image: url('../menu/kopithru copy.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.75);
      min-height: 100vh;
      padding: 60px 0;
    }

    .navbar {
      backdrop-filter: blur(10px);
      background-color: rgba(16, 107, 211, 0.9);
      box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    }

    .card-menu {
      background: rgba(19, 124, 236, 0.1);
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.5);
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .card-menu:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 10px 25px rgba(0,0,0,0.7);
    }

    .card-menu img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 2px solid rgba(255,255,255,0.2);
    }

    .card-body {
      text-align: center;
      padding: 15px 10px;
    }

    .card-title {
      font-size: 1.3rem;
      font-weight: 700;
      color: #f5deb3;
    }

    .harga {
      font-size: 1.1rem;
      color: #ffe4b5;
      font-weight: 600;
    }

    .btn-pesan {
      background-color: #f5deb3;
      color: #0d6efd;
      border: none;
      border-radius: 25px;
      transition: 0.3s;
      font-weight: 600;
    }

    .btn-pesan:hover {
      background-color: #0d6efd;
      color: white;
      transform: scale(1.05);
    }

    h2 {
      font-weight: 700;
      color: #ffebcd;
      text-shadow: 2px 2px 4px #000;
      margin-bottom: 25px;
    }

    footer {
      background-color: rgba(16,107,211,0.9);
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: 60px;
    }
  </style>
</head>
<body>
<div class="overlay">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-white" href="#"><i class="fa-solid fa-mug-hot"></i> Kopi Thru</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon bg-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link text-white" href="../index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="../Fase2/about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="../menu/index.php">Menu</a></li>
          <li class="nav-item"><a class="nav-link text-white active" href="#">Dashboard Pembeli</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten -->
  <div class="container mt-5 pt-5">
    <h2 class="text-center">☕ Rekomendasi Menu Kami</h2>
    <p class="text-center text-light mb-5">Pilih menu favoritmu dan segera pesan sekarang!</p>

    <div class="row g-4">
      <?php while($d = mysqli_fetch_array($data)) { ?>
      <div class="col-md-4 col-sm-6">
        <div class="card card-menu">
          <?php 
            // Pilih gambar berdasarkan nama menu
            $gambar = "../menu/kopi.jpg";
            if (stripos($d['Nama_Menu'], "Es Kopi Aren") !== false) $gambar = "../menu/kopiaren.png";
            else if (stripos($d['Nama_Menu'], "Es kopi Pandan") !== false) $gambar = "../menu/pandan.png";
            else if (stripos($d['Nama_Menu'], "Es Kopi Susu") !== false) $gambar = "../menu/kopsus.png";
            else if (stripos($d['Nama_Menu'], "Es Coklat") !== false) $gambar = "../menu/coklatt.png";
            else if (stripos($d['Nama_Menu'], "Es Matcha") !== false) $gambar = "../menu/matcha.jpg";
            else if (stripos($d['Nama_Menu'], "Es Red Velvet") !== false) $gambar = "../menu/redvelvet.png";
          ?>
          <img src="<?= $gambar ?>" alt="<?= $d['Nama_Menu']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?= $d['Nama_Menu']; ?></h5>
            <p class="harga">Rp <?= number_format($d['Harga'], 0, ',', '.'); ?></p>
            <a href="tambah_pembeli_form.php?menu=<?= urlencode($d['Nama_Menu']); ?>" 
               class="btn btn-pesan px-4 mt-2">
              <i class="fa-solid fa-cart-plus me-2"></i> Pesan Ini
            </a>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>

  <footer>
    <p class="mb-0">&copy; 2025 Kopi Thru | PTIK G 24</p>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
