<?php
include '../../../koneksi.php';

$id = $_GET['id'];
$query = "DELETE FROM menu WHERE Id_menu='$id'";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('🗑️ Data berhasil dihapus!'); window.location='lihat_menu.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
