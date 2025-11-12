<?php
include '../../../includes/navbar.php';
include '../../../koneksi.php';

// Periksa apakah ID pembeli ada di URL
if (isset($_GET['id'])) {
    // Penggunaan mysqli_real_escape_string sudah benar untuk keamanan
    $id_pembeli = mysqli_real_escape_string($conn, $_GET['id']);

    // Ambil data pembeli berdasarkan ID
    $query = "SELECT * FROM pembeli WHERE Id_pembeli = '$id_pembeli'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $data_pembeli = mysqli_fetch_assoc($result);
    } else {
        // Jika data tidak ditemukan, redirect ke halaman daftar dengan pesan error (opsional)
        header("Location: lihat_pembeli.php?status=gagal_ambil");
        exit();
    }
} else {
    header("Location: lihat_pembeli.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pembeli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <!--link href="style.css" rel="stylesheet"-->
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Edit Data Pembeli</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="proses_edit_pembeli.php">
                            <input type="hidden" name="id_pembeli_lama" value="<?php echo $data_pembeli['Id_pembeli']; ?>">

                            <div class="mb-3">
                                <label for="id_pembeli" class="form-label">ID Pembeli:</label>
                                <input type="text" id="id_pembeli" name="id_pembeli" class="form-control" value="<?php echo $data_pembeli['Id_pembeli']; ?>" required>
                                <div class="form-text">ID Pembeli harus unik.</div>
                            </div>

                            <div class="mb-3">
                                <label for="nama_pembeli" class="form-label">Nama Pembeli:</label>
                                <input type="text" id="nama_pembeli" name="nama_pembeli" class="form-control" value="<?php echo $data_pembeli['Nama_pembeli']; ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" <?php if ($data_pembeli['Jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
                                        <option value="P" <?php if ($data_pembeli['Jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="usia" class="form-label">Usia:</label>
                                    <input type="number" id="usia" name="usia" class="form-control" value="<?php echo $data_pembeli['Usia']; ?>" min="1" max="120">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat:</label>
                                <textarea id="alamat" name="alamat" class="form-control" rows="3"><?php echo $data_pembeli['Alamat']; ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="lihat_pembeli.php" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                                </a>
                                <button type="submit" name="submit" class="btn btn-success">
                                    <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>