<?php
include '../../../koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['submit'])){
    $id_transaksi = $_POST['id_transaksi'];
    $id_pembeli = $_POST['id_pembeli'];
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal_transaksi'];
    $menuDipilih = $_POST['menu'] ?? [];

    if(empty($menuDipilih)) die("Harap pilih minimal satu menu.");

    // Hapus detail lama
    mysqli_query($conn, "DELETE FROM transaksi_detail WHERE id_transaksi='$id_transaksi'");

    // Hitung total harga baru & simpan detail
    $total_harga = 0;
    foreach($menuDipilih as $id_menu){
        $q = mysqli_query($conn, "SELECT Harga FROM menu WHERE Id_menu='$id_menu'");
        $r = mysqli_fetch_assoc($q);
        $total_harga += $r['Harga'];
        mysqli_query($conn, "INSERT INTO transaksi_detail (id_transaksi, id_menu, jumlah_harga)
                             VALUES ('$id_transaksi','$id_menu','".$r['Harga']."')");
    }

    // Update transaksi
    mysqli_query($conn, "UPDATE transaksi 
                         SET id_pembeli='$id_pembeli', id_karyawan='$id_karyawan', 
                             tanggal_transaksi='$tanggal', total_harga='$total_harga'
                         WHERE id_transaksi='$id_transaksi'");
    header("Location: index.php?status=update_sukses");
    exit();
}
