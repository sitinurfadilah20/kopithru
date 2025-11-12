<?php
include '../../koneksi.php'; 
session_start();

// Cek apakah pembeli sudah login
if (!isset($_SESSION['id_pembeli'])) {
  // Jika belum login, arahkan ke halaman login
  header("Location: ../../login/");
  exit;
}
// Simpan komentar ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['komentar'])) {
  $id_pembeli = $_SESSION['id_pembeli'];
  $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
  $tanggal = date('Y-m-d H:i:s');

  $sql = "INSERT INTO komentar (id_pembeli, komentar, tanggal) VALUES ('$id_pembeli', '$komentar', '$tanggal')";
  mysqli_query($conn, $sql);
}

// pastikan path sesuai
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil menu untuk carousel dan semua menu
$carouselMenu = mysqli_query($conn, "SELECT * FROM menu ORDER BY Id_menu ASC");
$terlarisMenu = mysqli_query($conn, "
    SELECT m.Id_menu, m.Nama_Menu, m.Harga, m.gambar, COUNT(td.id_menu) AS total_terjual
    FROM menu m
    LEFT JOIN transaksi_detail td ON m.Id_menu = td.id_menu
    GROUP BY m.Id_menu
    ORDER BY total_terjual DESC
    LIMIT 3
");
$allMenu = mysqli_query($conn, "SELECT * FROM menu ORDER BY Nama_Menu ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopi Thru | Menu Pembeli ☕</title>

  <!-- Google Fonts & Bootstrap -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    :root {
      --primary-color: #1879d3ff;
      --secondary-color: #007bc8;
      --background-color: #fffaf5;
      --text-dark: #333333;
    }

    body {
      background-color: var(--background-color);
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
    }

    h1, h2, h3, h4, .navbar-brand {
      font-family: 'Cormorant Garamond', serif;
      font-weight: 700;
    }

    /* Navbar */
    .navbar {
      background-color: var(--secondary-color) !important;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .nav-link, .navbar-brand { color: white !important; transition: color 0.3s; }
    .nav-link:hover { color: #ffd700 !important; }

    /* Carousel */
    .carousel-item img {
      height: 500px;
      object-fit: cover;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    /* Hero Text */
    .hero-text {
      background: #fff;
      border-left: 5px solid var(--primary-color);
      border-radius: 12px;
      padding: 50px 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      margin-top: 50px;
    }

    .btn-outline-dark {
      border-color: var(--primary-color);
      color: var(--primary-color);
    }
    .btn-outline-dark:hover {
      background-color: var(--primary-color);
      color: white;
    }

    /* Cards */
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: all 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .card-img-top {
      height: 220px;
      object-fit: cover;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    /* Footer */
    footer {
      background-color: var(--primary-color);
      color: #fff;
      padding: 40px 0;
      margin-top: 80px;
    }
    footer a { color: #fff; }
    footer a:hover { color: #ffd700; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand fs-3" href="../../../home.php">
      <i class="fa-solid fa-mug-hot me-2 text-warning"></i> Kopi Thru
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon bg-light rounded"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../index.php"><i class="fa-solid fa-house me-1"></i> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="menu/lihat_menu.php"><i class="fa-solid fa-coffee me-1"></i> Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="Transaksi/index.php"><i class="fa-solid fa-receipt me-1"></i> Transaksi</a></li>
        <li class="nav-item"><a class="nav-link" href="About/about.php"><i class="fa-solid fa-circle-info me-1"></i> About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="../../index.php"><i class="fa-solid fa-house me-1"></i> LogOut</a></li>
      </ul>
    </div>
  </div>
</nav>
<br>

<!-- Carousel -->
<div class="container mt-4">
  <div id="carouselMenu" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner rounded-4 shadow-lg">
      <?php $first=true; while($row=mysqli_fetch_assoc($carouselMenu)):
        $img = !empty($row['gambar']) ? "../../".$row['gambar'] : "../../assets/images/kopi.jpg";
      ?>
      <div class="carousel-item <?= $first ? 'active' : '' ?>">
        <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100" alt="<?= htmlspecialchars($row['Nama_Menu']) ?>">
        <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2">
          <h5><?= htmlspecialchars($row['Nama_Menu']) ?></h5>
          <p>Rp <?= number_format($row['Harga'],0,',','.') ?></p>
        </div>
      </div>
      <?php $first=false; endwhile; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMenu" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselMenu" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<!-- Hero Section -->
<section class="container my-5">
  <div class="hero-text text-center">
    <h2 class="display-5 mb-4"><i class="fa-solid fa-star me-2"></i> Selamat Datang di Kopi Thru!</h2>
    <p class="lead text-dark">
      Nikmati sensasi ngopi keliling dengan cita rasa khas Indonesia! Kami menyajikan varian kopi seperti <em>Kopi Pandan</em> & <em>Kopi Aren</em> yang dikombinasikan dengan bahan premium.
    </p>
    <a href="#" class="btn btn-outline-dark btn-lg mt-3"><i class="fa-solid fa-list-check me-2"></i> Jelajahi Menu</a>
  </div>
</section>

<!-- Menu Terlaris -->
<section class="container py-5">
  <h3 class="text-center mb-5 display-6 text-primary">Menu Pilihan Terlaris ✨</h3>
  <div class="row g-4 justify-content-center">
    <?php while($m=mysqli_fetch_assoc($terlarisMenu)):
      $img = !empty($m['gambar']) ? "../../".$m['gambar'] : "../../assets/images/kopi.jpg";
    ?>
    <div class="col-lg-4 col-md-6">
      <div class="card h-100">
        <img src="<?= htmlspecialchars($img) ?>" class="card-img-top" alt="<?= htmlspecialchars($m['Nama_Menu']) ?>">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($m['Nama_Menu']) ?></h5>
          <p class="text-muted small">Rp <?= number_format($m['Harga'],0,',','.') ?> | Terjual: <?= $m['total_terjual'] ?>x</p>
          <div class="d-flex justify-content-between align-items-center">
            <a href="Transaksi/index.php" class="btn btn-sm btn-success"><i class="fa-solid fa-cart-plus me-1"></i> Pesan</a>
          </div>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Semua Menu -->
<section class="container py-5">
  <h3 class="text-center mb-5 text-primary">Daftar Menu Kopi Thru ☕</h3>
  <div class="row g-4">
    <?php if(mysqli_num_rows($allMenu)>0): while($row=mysqli_fetch_assoc($allMenu)):
      $img = !empty($row['gambar']) ? "../../".$row['gambar'] : "../../assets/images/kopi.jpg";
    ?>
    <div class="col-md-4">
      <div class="card h-100">
        <img src="<?= htmlspecialchars($img) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['Nama_Menu']) ?>">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($row['Nama_Menu']) ?></h5>
          <p class="card-text">Harga: Rp <?= number_format($row['Harga'],0,',','.') ?></p>
          <a href="" class="btn btn-primary"><i class="fa-solid fa-cart-plus me-1"></i> Pesan Sekarang</a>
        </div>
      </div>
    </div>
    <?php endwhile; else: ?>
      <p class="text-center">Belum ada menu tersedia.</p>
    <?php endif; ?>
  </div>
</section>

<!-- Testimoni -->
<section class="container my-5">
  <h3 class="text-center mb-5 text-primary">Apa Kata Mereka ☕</h3>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="testimonial text-center p-4 bg-white rounded shadow">
        <p>"Rasa kopinya mantap banget, dan pelayanan super ramah!"</p>
        <h6 class="text-primary mt-3">– Dwi, Bandung</h6>
      </div>
    </div>
    <div class="col-md-4">
      <div class="testimonial text-center p-4 bg-white rounded shadow">
        <p>"Konsep kopi kelilingnya keren, cocok buat nongkrong outdoor."</p>
        <h6 class="text-primary mt-3">– Rafi, Jakarta</h6>
      </div>
    </div>
    <div class="col-md-4">
      <div class="testimonial text-center p-4 bg-white rounded shadow">
        <p>"Red Velvet-nya lembut banget! Favorit aku setiap sore."</p>
        <h6 class="text-primary mt-3">– Mira, Bogor</h6>
      </div>
    </div>
  </div>
</section>
<!-- Komentar Pembeli -->
<section class="container my-5">
  <h3 class="text-center mb-4 text-primary">Tinggalkan Komentar Anda 💬</h3>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form method="POST" action="">
        <div class="mb-3">
          <textarea name="komentar" class="form-control" rows="4" placeholder="Tulis komentar Anda..." required></textarea>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary px-4">Kirim Komentar</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Daftar Komentar -->
<section class="container mb-5">
  <h4 class="text-center mb-4 text-primary">Komentar & Balasan</h4>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <?php
      $queryKomentar = "
        SELECT k.*, p.nama_pembeli 
        FROM komentar k
        JOIN pembeli p ON k.id_pembeli = p.id_pembeli
        ORDER BY k.tanggal DESC
      ";
      $resultKomentar = mysqli_query($conn, $queryKomentar);

      if (mysqli_num_rows($resultKomentar) > 0) {
        while ($row = mysqli_fetch_assoc($resultKomentar)) {
          echo '<div class="card mb-3 shadow-sm">';
          echo '<div class="card-body">';
          echo '<h6 class="text-primary mb-1">' . htmlspecialchars($row['nama_pembeli']) . '</h6>';
          echo '<p class="mb-2">' . htmlspecialchars($row['komentar']) . '</p>';
          echo '<small class="text-muted">' . $row['tanggal'] . '</small>';

          // tampilkan balasan admin jika ada
          if (!empty($row['balasan'])) {
            echo '<div class="mt-3 p-3 bg-light border-start border-3 border-primary rounded">';
            echo '<strong>Balasan Admin:</strong>';
            echo '<p class="mb-0">' . htmlspecialchars($row['balasan']) . '</p>';
            echo '</div>';
          }

          echo '</div></div>';
        }
      } else {
        echo '<p class="text-center text-muted">Belum ada komentar.</p>';
      }
      ?>
    </div>
  </div>
</section>


<!-- Footer -->
<footer class="text-center">
  <div class="container">
    <p class="fw-bold fs-5 mb-1"><i class="fa-solid fa-mug-hot"></i> Kopi Thru</p>
    <p class="mb-2">Kopi Keliling Nikmat Setiap Saat | <a href="#" class="text-decoration-none">Hubungi Kami</a></p>
    <p class="mb-0">
      <a href="#"><i class="fa-brands fa-instagram fa-lg mx-2"></i></a>
    </p>
    <small class="d-block mt-3">© 2025 Kopi Thru. All rights reserved.</small>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
mysqli_close($conn);
?>
</body>
</html>