<?php
include '../../../includes/navbar.php';
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($conn) || mysqli_connect_errno()) {
    die("<p style='color:red; text-align:center;'>Gagal mendapatkan koneksi database. Mohon periksa file koneksi.php.</p>");
}

// Ambil semua data karyawan
$query = "SELECT Id_karyawan, Nama_karyawan, Jenis_kelamin, No_telp, Usia FROM karyawan ORDER BY Id_karyawan ASC";
$result = mysqli_query($conn, $query);

// Periksa status dari halaman lain
$pesan_sukses = "";
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'sukses_input': $pesan_sukses = "Data karyawan berhasil ditambahkan."; break;
        case 'sukses_edit': $pesan_sukses = "Data karyawan berhasil diubah."; break;
        case 'sukses_hapus': $pesan_sukses = "Data karyawan berhasil dihapus."; break;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Karyawan</title>
<link rel="stylesheet" href="../../../assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; padding: 20px; }
    h2 { margin-bottom: 20px; color: #007bff; }
    .aksi a { margin-right: 5px; }
</style>
</head>
<body>
<div class="container">
    <h2>Daftar Karyawan 🧑‍💼</h2>

    <?php if ($pesan_sukses): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($pesan_sukses); ?></div>
    <?php endif; ?>

    <a href="tambah_karyawan_form.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Tambah Karyawan Baru</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Jenis Kelamin</th>
                    <th>No. Telepon</th>
                    <th>Usia</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Id_karyawan']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nama_karyawan']); ?></td>
                            <td><?php echo htmlspecialchars($row['Jenis_kelamin']); ?></td>
                            <td><?php echo htmlspecialchars($row['No_telp']); ?></td>
                            <td><?php echo htmlspecialchars($row['Usia']); ?></td>
                            <td class="aksi">
                                <a href="edit_karyawan_form.php?id=<?php echo urlencode($row['Id_karyawan']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="hapus_karyawan.php?id=<?php echo urlencode($row['Id_karyawan']); ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan <?php echo htmlspecialchars($row['Nama_karyawan']); ?>?')">
                                   <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">Tidak ada data karyawan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (isset($conn) && is_object($conn)) { mysqli_close($conn); } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>