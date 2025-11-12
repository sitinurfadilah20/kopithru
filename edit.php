<?php
include '../../../koneksi.php';

$targetDir = "../../../assets/uploads/";

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


// Proses update
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $desc = $_POST['description'];
    $tooltip = $_POST['tooltip'];
    $image = $_POST['current_image_path'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        if ($image && file_exists($image)) {
            unlink($image);
        }
        $filename = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $image = $targetFilePath;
        }
    }

    $stmt = $conn->prepare("UPDATE team_members SET name=?, role=?, image=?, description=?, tooltip=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $role, $image, $desc, $tooltip, $id);
    $stmt->execute();

    header("Location: edit.php?id=$id&success=1");
    exit;
}

// Ambil data anggota
$stmt_select = $conn->prepare("SELECT * FROM team_members WHERE id=?");
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$data = $stmt_select->get_result()->fetch_assoc();

if (!$data) {
    die("Error: Data anggota tim tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Team - Kopi Thru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body class="p-4">

<!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">☕ Kopi Thru</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon bg-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="../index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="../menu/index.php">Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="../karyawan/lihat_karyawan.php">karyawan</a></li>
          <li class="nav-item"><a class="nav-link" href="../transaksi.php">Transaksi</a></li>
      <li class="nav-item"><a class="nav-link" href="../Pembeli/pembeli.html">Pembeli</a></li>
        </ul>
      </div>
    </div>
  </nav> 

<div class="container py-5">
  <div class="card edit-card shadow-lg border-0 rounded-4 mx-auto">
    <div class="card-body p-4">
      <h2 class="mb-3 text-center text-primary fw-bold">Edit Team Member</h2>
      <p class="text-center text-muted mb-4">
        Mengedit data untuk: <strong><?= htmlspecialchars($data['name']) ?></strong>
      </p>

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle"></i> Data berhasil diperbarui!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        
        <div class="mb-3">
          <label for="name" class="form-label">Nama:</label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($data['name']) ?>" required class="form-control">
          </div>
        </div>

        <div class="mb-3">
          <label for="role" class="form-label">Role:</label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
            <input type="text" id="role" name="role" value="<?= htmlspecialchars($data['role']) ?>" required class="form-control">
          </div>
        </div>

        <div class="mb-3 text-center">
          <label class="form-label d-block">Gambar Saat Ini:</label>
          <?php if ($data['image'] && file_exists($data['image'])): ?>
            <img src="<?= htmlspecialchars($data['image']) ?>" 
                 alt="<?= htmlspecialchars($data['name']) ?>" 
                 width="130" 
                 class="img-thumbnail rounded-circle shadow-sm mb-2">
          <?php else: ?>
            <p class="text-muted fst-italic">Tidak ada gambar</p>
          <?php endif; ?>
          <input type="hidden" name="current_image_path" value="<?= htmlspecialchars($data['image']) ?>">
        </div>

        <div class="mb-3">
          <label for="image" class="form-label">Ganti Gambar (Opsional):</label>
          <input type="file" id="image" name="image" class="form-control">
          <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>

        <div class="mb-3">
          <label for="tooltip" class="form-label">Tooltip (Teks singkat saat hover):</label>
          <input type="text" id="tooltip" name="tooltip" value="<?= htmlspecialchars($data['tooltip']) ?>" class="form-control">
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Deskripsi (Untuk Carousel):</label>
          <textarea id="description" name="description" class="form-control" rows="3"><?= htmlspecialchars($data['description']) ?></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" name="update" class="btn btn-primary rounded-3">
            <i class="bi bi-save"></i> Simpan Perubahan
          </button>
          <a href="about.php" class="btn btn-outline-secondary rounded-3">
            <i class="bi bi-x-circle"></i> Batal
          </a>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
