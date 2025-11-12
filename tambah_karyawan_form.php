<?php
// Sertakan file koneksi database
include '../../../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Karyawan</title>
    <style>
        body {
            /* Background Gambar Kopi */
            background-image: url('p.png'); /* GUNAKAN NAMA FILE YANG ANDA UPLOAD */
            background-size: cover; 
            background-position: center center;
            background-repeat: no-repeat; 
            background-attachment: fixed;
            min-height: 100vh;
            display: flex; 
            align-items: center;
            justify-content: center;
            position: relative;
        }
        /* CSS diseragamkan dengan styling proyek Anda */
        body { font-family: sans-serif; margin: 20px; }
        h2 { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select { /* textarea dihilangkan karena Alamat dihapus */
            width: 300px; padding: 8px; margin-bottom: 15px; border: 1px solid #007bff; box-sizing: border-box; border-radius: 3px;
        }
        button[type="submit"] {
            background-color: #28a745; /* Hijau */
            color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; font-weight: bold;
        }
        button[type="submit"]:hover { opacity: 0.8; }
        .kembali-link { display: block; margin-top: 20px; color: #007bff; text-decoration: none; }
        .kembali-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <h2>Tambah Data Karyawan Baru 🧑‍💼</h2>

    <form method="POST" action="proses_tambah_karyawan.php">
        
        <label for="id_karyawan">ID Karyawan:</label>
        <input type="number" id="id_karyawan" name="id_karyawan" placeholder="Contoh: 101" required>

        <label for="nama_karyawan">Nama Karyawan:</label>
        <input type="text" id="nama_karyawan" name="nama_karyawan" placeholder="Masukkan nama lengkap" required>
        
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="L">Laki-laki (L)</option>
            <option value="P">Perempuan (P)</option>
        </select>

        <label for="usia">Usia (Tahun):</label>
        <input type="number" id="usia" name="usia" placeholder="Contoh: 25" min="18" max="65" required>
        
        <label for="no_telp">No. Telepon:</label>
        <input type="text" id="no_telp" name="no_telp" placeholder="Contoh: 08123456789" required>

        <button type="submit" name="submit">Simpan Karyawan</button>
    </form>

    <a href="lihat_karyawan.php" class="kembali-link">Kembali ke Daftar Karyawan</a>

</body>
</html>