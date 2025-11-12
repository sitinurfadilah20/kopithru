<?php
session_start();
include '../koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_admin = '';
$error_pembeli = '';

// Login Admin/Karyawan
if (isset($_POST['login_admin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1");
    if ($query && mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../home.php");
        exit();
    } else {
        $error_admin = "Username atau password salah!";
    }
}

// Login Pembeli
if (isset($_POST['login_pembeli'])) {
    $nama_pembeli = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);

    if (!empty($nama_pembeli)) {
        // Masukkan pembeli baru
        $insert = mysqli_query($conn, "INSERT INTO pembeli (Nama_pembeli) VALUES ('$nama_pembeli')");
        if ($insert) {
            $id_pembeli = mysqli_insert_id($conn);
            $_SESSION['role'] = 'pembeli';
            $_SESSION['id_pembeli'] = $id_pembeli;
            $_SESSION['nama_pembeli'] = $nama_pembeli;

            header("Location: ../modules/pembeli/index.php");
            exit();
        } else {
            $error_pembeli = "Terjadi kesalahan saat menyimpan data pembeli.";
        }
    } else {
        $error_pembeli = "Nama pembeli harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - Kopi Thru</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #e8f4ff; font-family: Poppins, sans-serif; }
.login-container { width: 400px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);}
h3 { margin-bottom: 20px; }
hr { margin: 20px 0; }
</style>
</head>
<body>
<div class="login-container text-center">
    <!-- Login Admin/Karyawan -->
    <h3>Login Admin/Karyawan</h3>
    <?php if($error_admin) echo "<div class='alert alert-danger'>$error_admin</div>"; ?>
    <form method="POST">
        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button type="submit" name="login_admin" class="btn btn-primary w-100 mb-3">Login</button>
    </form>

    <hr>

    <!-- Login Pembeli -->
    <h3>Masuk Sebagai Pembeli</h3>
    <?php if($error_pembeli) echo "<div class='alert alert-danger'>$error_pembeli</div>"; ?>
    <form method="POST">
        <input type="text" name="nama_pembeli" class="form-control mb-3" placeholder="Masukkan nama Anda" required>
        <button type="submit" name="login_pembeli" class="btn btn-success w-100">Masuk</button>
    </form>
</div>
</body>
</html>