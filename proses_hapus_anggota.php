<?php
session_start();

if(!isset($_SESSION['login'])){
    header('location:../login_admin.php');
}
include '../koneksi.php';
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_siswa = '$id'");

    $jmlAnggota = mysqli_num_rows($query);

    if($jmlAnggota > 0) {
        mysql_query($koneksi, "UPDATE tb_siswa SET status = 0 WHERE id_siswa = '$id'");
        header('location:kelola_anggota.php?s=siswa_nonaktif');
    }
    else {
        mysqli_query($koneksi, "DELETE FROM tb_siswa WHERE id_siswa = '$id'");
        header('location:kelola_anggota.php?s=hapus_berhasil');
    }

?>