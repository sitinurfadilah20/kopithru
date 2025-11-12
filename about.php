<?php 
include '../../../includes/navba.php';
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$members = $conn->query("SELECT * FROM team_members ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Kopi Thru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
  </head>
<body>

<!-- Alert -->
<div class="alert alert-warning alert-dismissible fade show mt-3 mx-3" role="alert">
  <strong>Hai!</strong> Selamat datang di halaman About Us Kopi Thru ☕
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<!-- NAVBAR 
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">☕ Kopi Thru</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon bg-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="../../../home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="../menu/index.php">Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="../karyawan/lihat_karyawan.php">Karyawan</a></li>
          <li class="nav-item"><a class="nav-link" href="../Transaksi/index.php">Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="../Pembeli/pembeli.html">Pembeli</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
        </ul>
      </div>
    </div>
  </nav> <br> -->

<section class="about-section text-center py-5">
  <div class="container">
    <h2 class="fw-bold mb-3 text-secondary">Tentang Kami</h2>
    <p class="text-muted mb-5">
      Kami adalah tim <strong>PTIK G 24</strong> yang mengembangkan website <strong>Kopi Thru</strong>. Yuk kenalan dengan anggota tim kami ☕✨
    </p>

    <!-- Carousel -->
     <div id="carouselExampleCaptions" class="carousel slide mx-auto" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-indicators">
        <?php foreach($members as $i => $m): ?>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $i ?>" class="<?= $i===0?'active':'' ?>"></button>
        <?php endforeach; ?>
      </div>
      <div class="carousel-inner">
        <?php foreach($members as $i => $m): ?>
        <div class="carousel-item <?= $i===0?'active':'' ?>">
          <img src="<?= $m['image'] ?>" class="d-block w-100" alt="<?= $m['name'] ?>">
          <div class="carousel-caption d-none d-md-block">
            <h5><?= $m['name'] ?></h5>
            <p><?= $m['role'] ?> — <?= $m['description'] ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Cards -->
    <div class="row mt-5">
      <h3 class="fw-bold mb-4 text-secondary">Tim Kami 💼</h3>
      <?php foreach($members as $m): ?>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <img src="<?= $m['image'] ?>" class="card-img-top" alt="<?= $m['name'] ?>">
          <div class="card-body">
            <h5 data-bs-toggle="tooltip" title="<?= $m['tooltip'] ?>"><?= $m['name'] ?></h5>
            <p class="card-text text-muted"><?= $m['role'] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<footer class="text-center py-3">
  <p>&copy; 2025 Kopi Thru | PTIK G 24</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
</script>
</body>
</html>
