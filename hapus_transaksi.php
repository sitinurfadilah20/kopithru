<?php
include '../../../koneksi.php';
$id_transaksi = $_GET['id'] ?? die("ID transaksi tidak ditemukan.");

// Hapus transaksi + detail (ON DELETE CASCADE)
mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'");
header("Location: index.php?status=hapus_sukses");
exit();
