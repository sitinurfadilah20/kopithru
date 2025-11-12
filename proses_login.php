<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Mulai sesi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'koneksi.php'; // Sertakan file koneksi database

    $username = mysqli_real_escape_string($conn, $_POST['amekk']); // Gunakan 'amekk'
    $password = $_POST['22']; // Gunakan '22'

    echo "Data login diterima:<br>";
    echo "Username: " . htmlspecialchars($username) . "<br>";
    echo "Password: " . htmlspecialchars($password) . "<br>";

    // Di sini Anda akan menambahkan logika validasi username dan password
    // dengan data yang ada di database.

    // Contoh sederhana (jangan gunakan ini untuk keamanan sebenarnya):
    if ($username === 'amekk' && $password === '22') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        echo "<br>Login berhasil!";
        // header("Location: index.html"); // Redirect setelah login berhasil
        // exit();
    } else {
        echo "<br>Login gagal. Username atau password salah.";
    }

    mysqli_close($conn);

} else {
    echo "Akses tidak valid. Silakan gunakan form login.";
}
?>