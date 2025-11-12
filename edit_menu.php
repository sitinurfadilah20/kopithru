<?php
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM menu WHERE Id_menu='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Menu | Bisnis Kopi Keliling</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('kopithru.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }

    .overlay {
      background-color: rgba(0,0,0,0.6);
      min-height: 100vh;
      padding-top: 80px;
    }

    .navbar {
      backdrop-filter: blur(10px);
      background-color: rgba(16, 107, 211, 0.9);
      box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }

    .card {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(15px);
      border-radius: 25px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.4);
      color: #fff;
    }

    label {
      font-weight: 600;
      color: #f5deb3;
    }

    input {
      border-radius: 15px !important;
      background-color: rgba(255,255,255,0.8) !important;
      border: none !important;
    }

    .btn-update {
      background-color: #c69c6d;
      color: #fff;
      border-radius: 25px;
      transition: 0.3s;
      border: none;
    }

    .btn-update:hover {
      background-color: #a67c52;
      transform: scale(1.05);
    }

    h2 {
      color: #ffebcd;
      text-shadow: 2px 2px 4px #000;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
      animation: fadeIn 1s ease forwards;
    }
  </style>
</head>
<body>

<div class="overlay">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">☕ Bisnis Kopi Keliling</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Edit Menu</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Form Edit -->
  <div class="container fade-in mt-5">
    <div class="card p-5 mx-auto" style="max-width: 600px;">
      <h2 class="text-center mb-4">Edit Data Menu</h2>
      <form action="proses_edit_menu.php" method="POST">
        <input type="hidden" name="id_menu" value="<?= $d['Id_menu']; ?>">
        <div class="mb-3">
          <label>Nama Menu</label>
          <input type="text" name="nama_menu" value="<?= $d['Nama_Menu']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Harga</label>
          <input type="number" name="harga" value="<?= $d['Harga']; ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-update w-100 py-2 mt-3">🔁 Update</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
