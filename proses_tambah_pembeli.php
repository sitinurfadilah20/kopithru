<?php
// ============================================
// File: proses_tambah_pembeli.php
// Deskripsi: Proses penyimpanan data pembeli baru
// ============================================

// 1. Koneksi ke database
include '../../../koneksi.php';

// 2. Pastikan form dikirim lewat tombol submit
if (isset($_POST['submit'])) {

    // 3. Ambil data dari form dan lindungi dari SQL injection
    $id_pembeli    = mysqli_real_escape_string($conn, trim($_POST['id_pembeli']));
    $nama_pembeli  = mysqli_real_escape_string($conn, trim($_POST['nama_pembeli']));
    $jenis_kelamin = mysqli_real_escape_string($conn, trim($_POST['jenis_kelamin']));
    $alamat        = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $usia          = mysqli_real_escape_string($conn, trim($_POST['usia']));

    // 4. Validasi dasar: ID & Nama wajib diisi
    if (empty($id_pembeli) || empty($nama_pembeli)) {
        $error_message = urlencode("ID Pembeli dan Nama Pembeli wajib diisi.");
        header("Location: tambah_pembeli.php?error=$error_message");
        exit();
    }

    // 5. Cek apakah ID Pembeli sudah ada (unik)
    $check_query = "SELECT Id_pembeli FROM pembeli WHERE Id_pembeli = '$id_pembeli'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika ID sudah terdaftar, kirim pesan error
        $error_message = urlencode("ID Pembeli '$id_pembeli' sudah terdaftar. Gunakan ID lain.");
        header("Location: tambah_pembeli.php?error=$error_message");
        exit();
    }

    // 6. Query untuk menambahkan data ke tabel pembeli
    $insert_query = "
        INSERT INTO pembeli (Id_pembeli, Nama_pembeli, Jenis_kelamin, Alamat, Usia)
        VALUES ('$id_pembeli', '$nama_pembeli', '$jenis_kelamin', '$alamat', '$usia')
    ";

    // 7. Eksekusi query
    if (mysqli_query($conn, $insert_query)) {
        // ✅ Jika berhasil: arahkan ke halaman daftar pembeli
        header("Location: lihat_pembeli.php?status=sukses_input");
        exit();
    } else {
        // ❌ Jika gagal insert
        $error_message = urlencode("Gagal menambahkan data: " . mysqli_error($conn));
        header("Location: tambah_pembeli.php?error=$error_message");
        exit();
    }

} else {
    // Jika file diakses langsung tanpa submit form
    header("Location: tambah_pembeli.php");
    exit();
}
?>
