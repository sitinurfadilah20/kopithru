<?php 
session_start(); // penting agar bisa ambil data login
include '../../../koneksi.php';
include '../../../includes/navba.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil semua data karyawan, pembeli, dan menu dari database
$karyawan = mysqli_query($conn, "SELECT * FROM karyawan");
$pembeli  = mysqli_query($conn, "SELECT * FROM pembeli");
$menu     = mysqli_query($conn, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Transaksi | Kopi Thru</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../../assets/css/style.css">
<style>
    body { font-family: "Poppins", sans-serif; background-color: #e8f4ff; padding: 20px; }
    form { background: #fff; padding: 20px; border-radius: 10px; width: 700px; max-width: 100%; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { text-align: center; color: #007bff; margin-bottom: 20px; }
    label { display: block; margin-top: 10px; font-weight: 500; }
    input, select { width: 100%; padding: 8px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc; }

    /* Tombol simpan */
    button { background: #007bff; color: white; border: none; padding: 10px; width: 100%; margin-top: 15px; border-radius: 8px; }
    button:hover { background: #0056b3; cursor: pointer; }

    /* Grid menu */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        margin-top: 10px;
    }

    .menu-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 10px;
        background: #f9f9f9;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .menu-item input[type="checkbox"] {
        margin-bottom: 10px;
        transform: scale(1.2);
        cursor: pointer;
    }

    .menu-item img {
        width: 100px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .menu-item label {
        text-align: center;
        cursor: pointer;
    }

    .menu-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .menu-info {
        font-size: 14px;
    }
</style>
</head>
<body>

<h2>Tambah Transaksi</h2>

<form action="proses_tambah_transaksi.php" method="POST">
    <label for="tanggal_transaksi">Tanggal Transaksi:</label>
    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" required>

    <label for="id_karyawan">Karyawan:</label>
    <select id="id_karyawan" name="id_karyawan" required>
        <option value="">-- Pilih Karyawan --</option>
        <?php while ($k = mysqli_fetch_assoc($karyawan)) : ?>
            <option value="<?= $k['Id_karyawan']; ?>"><?= htmlspecialchars($k['Nama_karyawan']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="id_pembeli">Pembeli:</label>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'pembeli'): ?>
        <!-- Jika pembeli yang login -->
        <input type="hidden" name="id_pembeli" value="<?= $_SESSION['id_pembeli']; ?>">
        <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['nama_pembeli']); ?>" readonly>
    <?php else: ?>
        <!-- Jika admin/karyawan -->
        <select id="id_pembeli" name="id_pembeli" class="form-control" required>
            <option value="">-- Pilih Pembeli --</option>
            <?php while ($p = mysqli_fetch_assoc($pembeli)) : ?>
                <option value="<?= $p['Id_pembeli']; ?>"><?= htmlspecialchars($p['Nama_pembeli']); ?></option>
            <?php endwhile; ?>
        </select>
    <?php endif; ?>

    <label>Menu yang dipilih:</label>
    <div class="menu-grid">
        <?php while ($m = mysqli_fetch_assoc($menu)) : ?>
            <?php 
                $gambar = !empty($m['gambar']) ? "../../../".$m['gambar'] : "../../../assets/images/kopi.jpg"; 
            ?>
            <div class="menu-item">
                <input type="checkbox" name="menu[]" value="<?= $m['Id_menu']; ?>" id="menu_<?= $m['Id_menu']; ?>">
                <label for="menu_<?= $m['Id_menu']; ?>">
                    <img src="<?= htmlspecialchars($gambar); ?>" alt="<?= htmlspecialchars($m['Nama_Menu']); ?>">
                    <div class="menu-info">
                        <?= htmlspecialchars($m['Nama_Menu']); ?> <br>
                        <small>Rp <?= number_format($m['Harga'],0,',','.'); ?></small>
                    </div>
                </label>
            </div>
        <?php endwhile; ?>
    </div>

    <button type="submit" name="submit">Simpan Transaksi</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>