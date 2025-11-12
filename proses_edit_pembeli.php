<?php
include '../../../koneksi.php'; 

// Inisialisasi variabel pesan error
$error_message = "";

// Proses formulir saat tombol submit ditekan
if (isset($_POST['submit'])) {
    // Sanitize input untuk mencegah SQL injection
    $id_pembeli_lama = mysqli_real_escape_string($conn, $_POST['id_pembeli_lama']);
    $id_pembeli_baru = mysqli_real_escape_string($conn, $_POST['id_pembeli']);
    $nama_pembeli = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $usia = isset($_POST['usia']) ? intval($_POST['usia']) : null;

    // Validasi input
    if (empty($id_pembeli_baru)) {
        $error_message .= "ID Pembeli harus diisi.<br>";
    }
    if (empty($nama_pembeli)) {
        $error_message .= "Nama Pembeli harus diisi.<br>";
    }
    if ($usia !== null && $usia < 0) {
        $error_message .= "Usia tidak boleh negatif.<br>";
    }

    // Periksa duplikasi ID baru (jika ID diubah)
    if ($id_pembeli_baru != $id_pembeli_lama) {
        $query_cek_id = "SELECT Id_pembeli FROM pembeli WHERE Id_pembeli = '$id_pembeli_baru'";
        $result_cek_id = mysqli_query($conn, $query_cek_id);
        if (mysqli_num_rows($result_cek_id) > 0) {
            $error_message .= "ID Pembeli '$id_pembeli_baru' sudah terdaftar.<br>";
        }
    }

    if (empty($error_message)) {
        // Query untuk memperbarui data pembeli
        $query_update = "UPDATE pembeli SET
                            Id_pembeli = '$id_pembeli_baru',
                            Nama_pembeli = '$nama_pembeli',
                            Jenis_kelamin = '$jenis_kelamin',
                            Alamat = '$alamat',
                            Usia = $usia
                         WHERE Id_pembeli = '$id_pembeli_lama'";

        if (mysqli_query($conn, $query_update)) {
            // Jika pembaruan berhasil, redirect kembali ke halaman daftar pembeli dengan pesan sukses
            header("Location: lihat_pembeli.php?status=sukses_edit");
            exit();
        } else {
            // Jika terjadi kesalahan saat memperbarui data, tampilkan pesan error MySQL
            $error_message .= "Terjadi kesalahan saat menyimpan perubahan: " . mysqli_error($conn);
        }
    }
} else {
    // Jika halaman ini diakses tanpa melalui form submit, redirect ke halaman daftar pembeli
    header("Location: lihat_pembeli.php");
    exit();
}

// Jika terjadi error, tampilkan pesan error dan link kembali ke form edit
if (!empty($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
    echo "<a href='edit_pembeli.php?id=$id_pembeli_lama'>Kembali ke Form Edit</a>";
}
?>