<?php
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($conn) || mysqli_connect_errno()) {
    die("<p style='color:red; text-align:center;'>Gagal mendapatkan koneksi database. Mohon periksa file koneksi.php.</p>");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: lihat_karyawan.php");
    exit;
}

$id_karyawan = mysqli_real_escape_string($conn, $_GET['id']);

// Query DELETE
$query = "DELETE FROM karyawan WHERE Id_karyawan = '$id_karyawan'";

if (mysqli_query($conn, $query)) {
    header("Location: lihat_karyawan.php?status=sukses_hapus");
    exit;
} else {
    echo "<h2>❌ Gagal Menghapus Data!</h2>";
    echo "<p>Gagal menghapus data karyawan. Error: " . mysqli_error($conn) . "</p>";
    echo "<a href='lihat_karyawan.php'>Kembali ke Daftar Karyawan</a>";
}

if (isset($conn) && is_object($conn)) {
    @mysqli_close($conn);
}
?>