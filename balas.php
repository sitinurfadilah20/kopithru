<?php
include('../../../koneksi.php');

$id = $_GET['id'] ?? 0;

// Ambil data komentar berdasarkan ID
$komentar = mysqli_query($conn, "
  SELECT k.*, p.nama_pembeli 
  FROM komentar k
  JOIN pembeli p ON k.id_pembeli = p.id_pembeli
  WHERE id_komentar = '$id'
");
$data = mysqli_fetch_assoc($komentar);

// Simpan balasan admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $balasan = mysqli_real_escape_string($conn, $_POST['balasan']);
  mysqli_query($conn, "UPDATE komentar SET balasan='$balasan' WHERE id_komentar='$id'");
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Balas Komentar | Admin Kopi Thru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">Balas Komentar Pembeli</h3>
    <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
      <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama_pembeli']) ?></p>
      <p><strong>Komentar:</strong><br><?= nl2br(htmlspecialchars($data['komentar'])) ?></p>

      <form method="post">
        <div class="mb-3">
          <label for="balasan" class="form-label">Balasan Admin:</label>
          <textarea name="balasan" id="balasan" rows="4" class="form-control" required><?= htmlspecialchars($data['balasan'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Balasan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</body>
</html>
