<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login'])){
    header('location:../login_admin.php');
}
include '../koneksi.php';
    $id = $_GET['id'];
    //mengambil data id buku di tabel transaksi
    $query = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_buku = '$id'");
    $jmlBuku = mysqli_num_rows($query);

    if($jmlBuku > 0){
        mysqli_query($koneksi, "UPDATE tb_buku SET status = 0 WHERE id_buku = '$id'");
        header('location:kelola_buku.php?s=buku_nonaktif');
    }
    else {
    $queryBuku = mysqli_query($koneksi, "SELECT *FROM tb_buku WHERE id_buku = '$id'");
    $buku = mysqli_fetch_assoc($queryBuku);

    unlink("../uploads/" . $buku['cover']);
    mysqli_query($koneksi, "DELETE FROM tb_buku WHERE id_buku='$id'");
    header('location:kelola_buku.php?s=hapus_berhasil');
    }


?>