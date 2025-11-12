<?php
include '../../../includes/navba.php';
include '../../../koneksi.php';

$id_transaksi = $_GET['id'] ?? die("ID transaksi tidak ditemukan.");

// Ambil transaksi
$t = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'");
$transaksi = mysqli_fetch_assoc($t);

// Ambil karyawan, pembeli, menu, dan menu yang dipilih
$karyawan = mysqli_query($conn, "SELECT * FROM karyawan");
$pembeli  = mysqli_query($conn, "SELECT * FROM pembeli");
$menu     = mysqli_query($conn, "SELECT * FROM menu");
$menuTerpilih = mysqli_query($conn, "SELECT id_menu FROM transaksi_detail WHERE id_transaksi='$id_transaksi'");
$menuTerpilihArray = [];
while($m = mysqli_fetch_assoc($menuTerpilih)) $menuTerpilihArray[] = $m['id_menu'];
?>

<form action="proses_edit_transaksi.php" method="POST">
    <input type="hidden" name="id_transaksi" value="<?= $id_transaksi; ?>">

    <label>Tanggal Transaksi:</label>
    <input type="date" name="tanggal_transaksi" value="<?= $transaksi['tanggal_transaksi']; ?>" required>

    <label>Karyawan:</label>
    <select name="id_karyawan" required>
        <?php while($k = mysqli_fetch_assoc($karyawan)) : ?>
            <option value="<?= $k['Id_karyawan']; ?>" <?= $k['Id_karyawan']==$transaksi['id_karyawan']?'selected':''; ?>>
                <?= $k['Nama_karyawan']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Pembeli:</label>
    <select name="id_pembeli" required>
        <?php while($p = mysqli_fetch_assoc($pembeli)) : ?>
            <option value="<?= $p['Id_pembeli']; ?>" <?= $p['Id_pembeli']==$transaksi['id_pembeli']?'selected':''; ?>>
                <?= $p['Nama_pembeli']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Menu yang dipilih:</label>
    <?php while($m = mysqli_fetch_assoc($menu)) : ?>
        <input type="checkbox" name="menu[]" value="<?= $m['Id_menu']; ?>"
            <?= in_array($m['Id_menu'], $menuTerpilihArray)?'checked':''; ?>>
        <?= $m['Nama_Menu']; ?> (Rp <?= number_format($m['Harga'],0,',','.'); ?>)<br>
    <?php endwhile; ?>

    <button type="submit" name="submit">Simpan Perubahan</button>
</form>