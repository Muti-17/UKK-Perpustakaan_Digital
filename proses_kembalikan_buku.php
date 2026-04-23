<?php
include '../koneksi.php';

$id_transaksi = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'");
$data = mysqli_fetch_assoc($query);

$jml_dipinjam = $data['jumlah_buku'];

//mengubah tanggal pengembalian
$tgl = date('Y-m-d');
mysqli_query($koneksi, "UPDATE tb_transaksi SET tgl_pengembalian = '$tgl' WHERE id_transaksi = '$id_transaksi'");

//menambah jumlah buku
$id_buku = $data['id_buku'];
mysqli_query($koneksi, "UPDATE tb_buku SET jumlah_buku = jumlah_buku + '$jml_dipinjam' WHERE id_buku = '$id_buku'");

header('location:transaksi.php?s=berhasil_dikembalikan');
?>