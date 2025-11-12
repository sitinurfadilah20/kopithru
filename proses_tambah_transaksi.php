<?php
include '../../../koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $tanggal = $_POST['tanggal_transaksi'];
    $id_karyawan = $_POST['id_karyawan'];
    $id_pembeli  = $_POST['id_pembeli'];
    $menuDipilih = $_POST['menu'] ?? [];

    if (empty($menuDipilih)) die("Error: Harap pilih minimal satu menu.");

    $total_harga = 0;
    foreach ($menuDipilih as $id_menu) {
        $q = mysqli_query($conn, "SELECT Harga FROM menu WHERE Id_menu='$id_menu'");
        $r = mysqli_fetch_assoc($q);
        $total_harga += $r['Harga'];
    }

    $insert_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_pembeli, id_karyawan, tanggal_transaksi, total_harga)
                                             VALUES ('$id_pembeli', '$id_karyawan', '$tanggal', '$total_harga')");
    if ($insert_transaksi) {
        $id_transaksi = mysqli_insert_id($conn);
        foreach ($menuDipilih as $id_menu) {
            $q = mysqli_query($conn, "SELECT Harga FROM menu WHERE Id_menu='$id_menu'");
            $r = mysqli_fetch_assoc($q);
            mysqli_query($conn, "INSERT INTO transaksi_detail (id_transaksi, id_menu, jumlah_harga) 
                                 VALUES ('$id_transaksi','$id_menu','".$r['Harga']."')");
        }
        header("Location: index.php?status=sukses");
        exit();
    } else {
        die("Gagal menyimpan transaksi: " . mysqli_error($conn));
    }
} else {
    header("Location: tambah_transaksi.php");
    exit();
}
