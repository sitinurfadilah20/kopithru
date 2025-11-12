<?php
include '../../../koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nama_menu = $_POST['nama_menu'];
$harga     = $_POST['harga'];

$uploadDir = "../../../assets/uploads/menu/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$gambar = "";

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $allowed_types = ['jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $file_size = $_FILES['gambar']['size'];

    if (!in_array($file_ext, $allowed_types)) {
        die("❌ Format file tidak didukung. Hanya JPG, JPEG, atau PNG.");
    }

    if ($file_size > 2 * 1024 * 1024) {
        die("❌ Ukuran file terlalu besar. Maksimal 2MB.");
    }

    $newFileName = uniqid('menu_', true) . '.' . $file_ext;
    $targetFilePath = $uploadDir . $newFileName;
    $webPath = "assets/uploads/menu/" . $newFileName;

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFilePath)) {
        $gambar = $webPath;
    } else {
        die("❌ Gagal mengupload gambar.");
    }
} else {
    $gambar = null; // jika tidak upload
}

$stmt = $conn->prepare("INSERT INTO menu (Nama_Menu, Harga, gambar) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $nama_menu, $harga, $gambar);


if ($stmt->execute()) {
    header("Location: lihat_menu.php?status=sukses");
    exit();
} else {
    die("❌ Gagal menyimpan data: " . $stmt->error);
}
?>