<?php
include '../../../includes/navbar.php';
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($conn) || mysqli_connect_errno()) {
    die("<p style='color:red; text-align:center;'>Gagal mendapatkan koneksi database. Mohon periksa file koneksi.php.</p>");
}

// Ambil ID Karyawan dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: lihat_karyawan.php");
    exit;
}

$id_karyawan = $_GET['id'];

// Prepared statement untuk mengambil data karyawan
$stmt = $conn->prepare("SELECT Id_karyawan, Nama_karyawan, Jenis_kelamin, Usia, No_telp FROM karyawan WHERE Id_karyawan = ?");
$stmt->bind_param("s", $id_karyawan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='color:red; text-align:center;'>Data karyawan dengan ID tersebut tidak ditemukan.</p>";
    exit;
}

$data_karyawan = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Karyawan</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('p.png');
            background-color: #f2f2f2;
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            max-width: 500px;
            background: #fff;
            padding: 30px;
            margin: 50px auto;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 25px; color: #007bff; }
        label { font-weight: 500; }
        button[type="submit"] { width: 100%; }
        .kembali-link { display: block; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>

<!--nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">☕ Kopi Thru</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../Fase2/about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="../menu/index.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="../karyawan/lihat_karyawan.php">Karyawan</a></li>
                <li class="nav-item"><a class="nav-link" href="../transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="../Pembeli/pembeli.html">Pembeli</a></li>
            </ul>
        </div>
    </div>
</nav-->

<div class="form-container">
    <h2>Edit Data Karyawan</h2>
    <form method="POST" action="proses_edit_karyawan.php">
        <input type="hidden" name="id_karyawan_lama" value="<?= htmlspecialchars($data_karyawan['Id_karyawan']); ?>">

        <div class="mb-3">
            <label for="id_karyawan" class="form-label">ID Karyawan</label>
            <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" value="<?= htmlspecialchars($data_karyawan['Id_karyawan']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" value="<?= htmlspecialchars($data_karyawan['Nama_karyawan']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="L" <?= $data_karyawan['Jenis_kelamin']=='L'?'selected':''; ?>>Laki-laki</option>
                <option value="P" <?= $data_karyawan['Jenis_kelamin']=='P'?'selected':''; ?>>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="usia" class="form-label">Usia</label>
            <input type="number" class="form-control" id="usia" name="usia" min="18" max="65" value="<?= htmlspecialchars($data_karyawan['Usia']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= htmlspecialchars($data_karyawan['No_telp']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>
    </form>
    <a href="lihat_karyawan.php" class="kembali-link">Batalkan & Kembali ke Daftar Karyawan</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>