<?php
// ====== PROSES TAMBAH DATA PEMBELI ======

// 1. Sertakan koneksi ke database
include '../../../koneksi.php';
include '../../../includes/navba.php';

// 2. Cek apakah form disubmit
if (isset($_POST['submit'])) {
    $id_pembeli    = mysqli_real_escape_string($conn, trim($_POST['id_pembeli']));
    $nama_pembeli  = mysqli_real_escape_string($conn, trim($_POST['nama_pembeli']));
    $jenis_kelamin = mysqli_real_escape_string($conn, trim($_POST['jenis_kelamin']));
    $alamat        = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $usia          = mysqli_real_escape_string($conn, trim($_POST['usia']));

    // Validasi wajib isi
    if (empty($id_pembeli) || empty($nama_pembeli)) {
        $error_message = urlencode("ID Pembeli dan Nama Pembeli wajib diisi.");
        header("Location: tambah_pembeli.php?error=$error_message");
        exit();
    }

    // Cek apakah ID pembeli sudah ada
    $check_query = "SELECT Id_pembeli FROM pembeli WHERE Id_pembeli = '$id_pembeli'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = urlencode("ID Pembeli '$id_pembeli' sudah terdaftar. Gunakan ID lain.");
        header("Location: tambah_pembeli.php?error=$error_message");
        exit();
    }

    // Simpan data ke tabel pembeli
    $insert_query = "
        INSERT INTO pembeli (Id_pembeli, Nama_pembeli, Jenis_kelamin, Alamat, Usia)
        VALUES ('$id_pembeli', '$nama_pembeli', '$jenis_kelamin', '$alamat', '$usia')
    ";

    if (mysqli_query($conn, $insert_query)) {
        // ✅ Jika sukses, langsung ke halaman transaksi
        header("Location: ../Transaksi/tambah_transaksi.php?status=sukses_input");
        exit();
    } else {
        // ❌ Jika gagal
        $error_message = urlencode("Gagal menambahkan data: " . mysqli_error($conn));
        header("Location: tambah_pembeli.php?error=$error_message");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pembeli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6"> 
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i> Tambah Data Pembeli Baru</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            
                            <div class="mb-3">
                                <label for="id_pembeli" class="form-label">ID Pembeli <span class="text-danger">*</span>:</label>
                                <input type="text" id="id_pembeli" name="id_pembeli" class="form-control" placeholder="Masukkan ID unik pembeli" required>
                                <div class="form-text">ID Pembeli harus unik</div>
                            </div>

                            <div class="mb-3">
                                <label for="nama_pembeli" class="form-label">Nama Pembeli <span class="text-danger">*</span>:</label>
                                <input type="text" id="nama_pembeli" name="nama_pembeli" class="form-control" placeholder="Nama lengkap pembeli" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="usia" class="form-label">Usia:</label>
                                    <input type="number" id="usia" name="usia" class="form-control" placeholder="Usia (Tahun)" min="1" max="120">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="form-label">Alamat:</label>
                                <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap pembeli"></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="lihat_pembeli.php" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                                </a>
                                <button type="submit" name="submit" class="btn btn-success">
                                    <i class="bi bi-floppy-fill me-1"></i> Simpan Data
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
