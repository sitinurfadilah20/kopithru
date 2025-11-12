<?php
include('../../../koneksi.php');
$id_komentar = $_POST['id_komentar'];
$balasan = $_POST['balasan'];

// Update balasan ke database
$query = "UPDATE komentar SET balasan='$balasan' WHERE id_komentar='$id_komentar'";
mysqli_query($conn, $query);

// Setelah berhasil update, langsung balik ke halaman daftar komentar
header("Location: ../../admin/komentar/index.php");
exit;
?>