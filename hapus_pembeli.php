<?php
include '../../../koneksi.php';

// Periksa apakah ID pembeli telah diterima melalui GET
if (isset($_GET['id'])) {
    $id_pembeli = $_GET['id'];

    // Query untuk menghapus data pembeli
    $query_hapus = "DELETE FROM pembeli WHERE Id_pembeli = '$id_pembeli'";

    if (mysqli_query($conn, $query_hapus)) {
        // Jika penghapusan berhasil, redirect kembali ke halaman daftar pembeli dengan pesan sukses
        header("Location: lihat_pembeli.php?status=sukses_hapus");
        exit();
    } else {
        // Jika terjadi kesalahan saat menghapus data
        echo "Terjadi kesalahan saat menghapus data: " . mysqli_error($conn);
        echo "<br><a href='lihat_pembeli.php'>Kembali ke Daftar Pembeli</a>"; // Tambahkan link kembali
    }
} else {
    // Jika tidak ada ID yang diterima, redirect ke halaman daftar pembeli
    header("Location: lihat_pembeli.php");
    exit();
}

// Tutup koneksi database
mysqli_close($conn);
?>