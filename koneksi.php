<?php
// koneksi.php
$servername = "localhost";
$username = "root";
$password = "";
$database = "kopithru"; // <<< UBAH NAMA DATABASE DI SINI

// Buat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>