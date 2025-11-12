<?php
include '../../../includes/navbar.php';
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Folder tempat menyimpan gambar
$targetDir = "../../../assets/uploads/";

// Tambah anggota (VERSI AMAN)
if(isset($_POST['add'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $desc = $_POST['description'];
    $tooltip = $_POST['tooltip'];

    // ... (Logika upload gambar Anda tetap sama) ...
    $image = "";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $filename = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $filename;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)){
            $image = $targetFilePath;
        }
    }

    // Gunakan prepared statements
    $stmt = $conn->prepare("INSERT INTO team_members (name, role, image, description, tooltip) VALUES (?, ?, ?, ?, ?)");
    // 'sssss' berarti 5 variabel adalah tipe string
    $stmt->bind_param("sssss", $name, $role, $image, $desc, $tooltip);
    $stmt->execute();

    header("Location: manage.php");
    exit;
}

// Hapus anggota (VERSI AMAN)
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // 1. Dapatkan path gambar (AMAN)
    $stmt_select = $conn->prepare("SELECT image FROM team_members WHERE id=?");
    // 'i' berarti variabel adalah tipe integer
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $res = $stmt_select->get_result();
    $row = $res->fetch_assoc();

    // Hapus file gambar dari server
    if($row && file_exists($row['image'])){
        unlink($row['image']);
    }

    // 2. Hapus data dari database (AMAN)
    $stmt_delete = $conn->prepare("DELETE FROM team_members WHERE id=?");
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();
    
    header("Location: about.php");
    exit;
}

// Ambil data anggota
$result = $conn->query("SELECT * FROM team_members");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manage Team - Kopi Thru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body class="p-4">

<!-- NAVBAR 
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">☕ Kopi Thru</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon bg-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="../home/home.php">Home</a></li>  
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="../menu/index.php">Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="../karyawan/lihat_karyawan.php">karyawan</a></li>
          <li class="nav-item"><a class="nav-link" href="../transaksi.php">Transaksi</a></li>
      <li class="nav-item"><a class="nav-link" href="../Pembeli/pembeli.html">Pembeli</a></li>
        </ul>
      </div>
    </div>
  </nav> <br> -->

<h2>Manage Team Members</h2>

<form method="post" enctype="multipart/form-data" class="mb-4">
  <input type="text" name="name" placeholder="Nama" required class="form-control mb-2">
  <input type="text" name="role" placeholder="Role" required class="form-control mb-2">
  <input type="file" name="image" class="form-control mb-2">
  <input type="text" name="tooltip" placeholder="Tooltip" class="form-control mb-2">
  <textarea name="description" placeholder="Deskripsi" class="form-control mb-2"></textarea>
  <button type="submit" name="add" class="btn btn-primary">Tambah</button>
</form>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Role</th>
      <th>Gambar</th>
      <th>Tooltip</th>
      <th>Deskripsi</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['role'] ?></td>
      <td>
        <?php if($row['image']): ?>
          <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>" width="80">
        <?php endif; ?>
      </td>
      <td><?= $row['tooltip'] ?></td>
      <td><?= $row['description'] ?></td>
      <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="manage.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>