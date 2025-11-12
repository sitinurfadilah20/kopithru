<?php
include '../../../includes/navbar.php';
include '../../../koneksi.php'; 

// Query untuk mengambil semua data pembeli dari database
$query = "SELECT Id_pembeli, Nama_pembeli, Jenis_kelamin, Alamat, Usia FROM pembeli";
$result = mysqli_query($conn, $query);

// Periksa apakah ada parameter status dari halaman lain (misalnya, setelah tambah atau edit)
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'sukses_input') {
        $pesan_sukses = "Data pembeli berhasil ditambahkan.";
    } elseif ($status == 'sukses_edit') {
        $pesan_sukses = "Data pembeli berhasil diubah.";
    } elseif ($status == 'sukses_hapus') {
        $pesan_sukses = "Data pembeli berhasil dihapus.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembeli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>

    <!--nav class="navbar navbar-expand-lg **fixed-top bg-dark**">
        <div class="container">
            <a class="navbar-brand fw-bold **text-light**" href="#">☕ Kopi Thru</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon bg-light"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link **text-light**" href="../home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link **text-light**" href="../Fase2/about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link **text-light**" href="../menu/index.php">Menu</a></li>
                    <li class="nav-item"><a class="nav-link **text-light**" href="../karyawan/lihat_karyawan.php">Karyawan</a></li>
                    <li class="nav-item"><a class="nav-link **text-light**" href="../transaksi.php">Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link **active text-warning**" aria-current="page" href="lihat_pembeli.php">Pembeli</a></li>
                </ul>
            </div>
        </div>
    </nav-->

    <div class="container mt-5">
        <h2 class="mb-4 text-center text-primary fw-bold">Daftar Pembeli</h2> 
        
        <?php if (isset($pesan_sukses)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $pesan_sukses; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Pembeli</h5>
                <a href="tambah_pembeli_form.php" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Pembeli Baru
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID Pembeli <i class="bi bi-hash"></i></th>
                                <th scope="col">Nama Pembeli <i class="bi bi-person-fill"></i></th>
                                <th scope="col">Jenis Kelamin <i class="bi bi-gender-ambiguous"></i></th>
                                <th scope="col">Alamat <i class="bi bi-geo-alt-fill"></i></th>
                                <th scope="col">Usia <i class="bi bi-calendar-date-fill"></i></th>
                                <th scope="col" class="text-center">Aksi <i class="bi bi-gear-fill"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0):
                                while ($row = mysqli_fetch_assoc($result)):
                            ?>
                                <tr>
                                    <td><?php echo $row['Id_pembeli']; ?></td>
                                    <td><?php echo $row['Nama_pembeli']; ?></td>
                                    <td><?php echo $row['Jenis_kelamin']; ?></td>
                                    <td><?php echo $row['Alamat']; ?></td>
                                    <td><?php echo $row['Usia']; ?></td>
                                    <td class="text-center action-buttons">
                                        <a href="edit_pembeli_form.php?id=<?php echo $row['Id_pembeli']; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="#" 
                                            class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#hapusModal" 
                                            data-id="<?php echo $row['Id_pembeli']; ?>">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <tr><td colspan="6" class="text-center py-4">Tidak ada data pembeli.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="hapusModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda YAKIN ingin menghapus data pembeli ini? Aksi ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="modalHapusLink" class="btn btn-danger">Ya, Hapus Data</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Logika untuk mengisi link hapus pada modal konfirmasi
        const hapusModal = document.getElementById('hapusModal');
        
        hapusModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id_pembeli = button.getAttribute('data-id');
            const hapusLink = 'hapus_pembeli.php?id=' + id_pembeli;
            
            const modalLink = hapusModal.querySelector('#modalHapusLink');
            modalLink.href = hapusLink;
        });
    </script>
</body>
</html>