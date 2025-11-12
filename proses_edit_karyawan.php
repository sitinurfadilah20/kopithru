<?php
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_message = "";

if (isset($_POST['submit'])) {
    
    // 1. Ambil dan bersihkan data dari form
    $id_karyawan_lama = mysqli_real_escape_string($conn, $_POST['id_karyawan_lama']);
    $id_karyawan_baru = mysqli_real_escape_string($conn, $_POST['id_karyawan']);
    $nama_karyawan  = mysqli_real_escape_string($conn, $_POST['nama_karyawan']);
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $usia           = isset($_POST['usia']) ? intval($_POST['usia']) : null;
    $no_telp        = mysqli_real_escape_string($conn, $_POST['no_telp']);

    // 2. Validasi (Cek duplikasi ID baru jika ID diubah)
    if ($id_karyawan_baru != $id_karyawan_lama) {
        $query_cek_id = "SELECT Id_karyawan FROM karyawan WHERE Id_karyawan = '$id_karyawan_baru'";
        $result_cek_id = mysqli_query($conn, $query_cek_id);
        if ($result_cek_id && mysqli_num_rows($result_cek_id) > 0) {
            $error_message .= "ID Karyawan '$id_karyawan_baru' sudah terdaftar.<br>";
        }
    }
    
    if (empty($error_message)) {
        // 3. Buat Query SQL UPDATE (Tanpa kolom Alamat)
        $query = "UPDATE karyawan SET 
                    Id_karyawan = '$id_karyawan_baru',
                    Nama_karyawan = '$nama_karyawan', 
                    Jenis_kelamin = '$jenis_kelamin', 
                    Usia = $usia, 
                    No_telp = '$no_telp' 
                  WHERE Id_karyawan = '$id_karyawan_lama'";

        // 4. Eksekusi Query
        if (mysqli_query($conn, $query)) {
            header("Location: lihat_karyawan.php?status=sukses_edit");
            exit;
        } else {
            $error_message .= "Gagal mengubah data karyawan. Error: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: lihat_karyawan.php");
    exit;
}

// Jika terjadi error, tampilkan pesan error
if (!empty($error_message)) {
    echo "<h2>❌ Gagal!</h2>";
    echo "<p style='color: red;'>$error_message</p>";
    $id_karyawan_kembali = isset($id_karyawan_lama) ? $id_karyawan_lama : '';
    echo "<a href='edit_karyawan_form.php?id=$id_karyawan_kembali'>Kembali ke Form Edit</a>";
}

if (isset($conn) && is_object($conn)) {
    @mysqli_close($conn);
}
?>