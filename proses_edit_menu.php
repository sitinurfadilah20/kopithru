<?php
include '../../../koneksi.php';

$id    = $_POST['id_menu'];
$nama  = $_POST['nama_menu'];
$harga = $_POST['harga'];

$query = "UPDATE menu SET Nama_Menu='$nama', Harga='$harga' WHERE Id_menu='$id'";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('✅ Data berhasil diperbarui!'); window.location='lihat_menu.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
