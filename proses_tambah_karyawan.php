<?php
// Pastikan file koneksi.php ada dan variabel $koneksi berhasil dibuat di dalamnya
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek koneksi
if (!isset($conn) || mysqli_connect_errno()) {
    die("<p style='color:red; text-align:center;'>Gagal mendapatkan koneksi database. Mohon periksa file koneksi.php.</p>");
}

// Cek apakah form sudah disubmit
if (isset($_POST['submit'])) {
    
    // 1. Ambil dan bersihkan data dari form
    $id_karyawan    = mysqli_real_escape_string($conn, $_POST['id_karyawan']);
    $nama_karyawan  = mysqli_real_escape_string($conn, $_POST['nama_karyawan']);
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $usia           = mysqli_real_escape_string($conn, $_POST['usia']);     // <<< Data Usia
    // $alamat = mysqli_real_escape_string($conn, $_POST['alamat']); // <<< BAGIAN INI DIHAPUS
    $no_telp        = mysqli_real_escape_string($conn, $_POST['no_telp']);

    // 2. Buat Query SQL INSERT
    // Kolom Alamat telah dihapus dari daftar kolom dan VALUES
    $query = "INSERT INTO karyawan (Id_karyawan, Nama_karyawan, Jenis_kelamin, Usia, No_telp) 
              VALUES ('$id_karyawan', '$nama_karyawan', '$jenis_kelamin', '$usia', '$no_telp')";

    // 3. Eksekusi Query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, arahkan kembali ke halaman daftar karyawan dengan status sukses
        header("Location: lihat_karyawan.php?status=sukses_input");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<h2>❌ Gagal!</h2>";
        echo "<p>Gagal menambahkan data karyawan. Error: " . mysqli_error($conn) . "</p>";
        echo "<a href='tambah_karyawan_form.php'>Kembali ke Form</a>";
    }
} else {
    // Jika diakses tanpa submit form, arahkan kembali ke form
    header("Location: tambah_karyawan_form.php");
    exit;
}

// Tutup conn di akhir skrip
if (isset($conn) && is_object($conn)) {
    @mysqli_close($conn);
}
?>