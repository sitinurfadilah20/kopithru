<?php 
include '../../../koneksi.php';
include '../../../includes/navba.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil semua data menu dari database
$data = mysqli_query($conn, "SELECT * FROM menu");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lihat Menu | Bisnis Kopi Keliling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <style>
        body {
            background-image: url('image.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.7);
            min-height: 100vh;
            padding-top: 90px;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(16, 107, 211, 0.9);
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        .card-menu {
            background: rgba(19, 124, 236, 0.1);
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-menu:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0,0,0,0.7);
        }

        .card-menu img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .card-body {
            text-align: center;
            padding: 15px 10px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #f5deb3;
        }

        .harga {
            font-size: 1.1rem;
            color: #ffe4b5;
            font-weight: 600;
        }

        .btn-edit {
            background-color: #c69c6d;
            color: #fff;
            border-radius: 20px;
            transition: 0.3s;
            border: none;
        }
        .btn-edit:hover {
            background-color: #0f89f4ff;
            transform: scale(1.05);
        }

        .btn-delete {
            background-color: #8b4513;
            color: #fff;
            border-radius: 20px;
            border: none;
            transition: 0.3s;
        }
        .btn-delete:hover {
            background-color: #5a3210;
            transform: scale(1.05);
        }
        
        h2 {
            font-weight: 700;
            color: #ffebcd;
            text-shadow: 2px 2px 4px #000;
            margin-bottom: 25px;
        }

        .fade-in { animation: fadeIn 1s ease forwards; }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .btn-tambah {
            background-color: #f5deb3;
            color: #0c76e8ff;
            font-weight: bold;
            border-radius: 10px;
            transition: 0.3s;
            border: none;
        }
        .btn-tambah:hover {
            background-color: #0e67d5ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="container fade-in">
        <h2 class="text-center">☕ Daftar Menu Kopi Keliling</h2>

        <div class="row g-4">
            <?php while($d = mysqli_fetch_array($data)) { ?>
            <div class="col-md-4 col-sm-6">
                <div class="card card-menu">
                    <?php 
                        // ✅ Path gambar dari database
                        if (!empty($d['gambar'])) {
                            // Tambahkan ../ agar naik ke folder project root
                            $gambar = "../../../" . $d['gambar'];
                        } else {
                            // Gambar default jika tidak ada
                            $gambar = "../../../assets/images/kopi.jpg";
                        }
                    ?>
                    <img src="<?= htmlspecialchars($gambar); ?>" alt="<?= htmlspecialchars($d['Nama_Menu']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($d['Nama_Menu']); ?></h5>
                        <p class="harga">Rp <?= number_format($d['Harga'], 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>