<?php
include '../koneksi.php';

$keyword = $_POST['keyword'];
$query = mysqli_query(
    $koneksi,
    "SELECT id_buku, judul_buku, jumlah_buku FROM tb_buku WHERE judul_buku LIKE '%$keyword%' AND status = 1 LIMIT 12"
);

if (mysqli_num_rows($query) > 0) {
    while ($b = mysqli_fetch_assoc($query)) {
        ?>
        <a href="index.php?cari=<?= $b['id_buku'] ?>"
        class="list-group-item list-group-item-action item-buku">
        <?= $b['judul_buku'] ?>
        <small class="text-muted">(Stok: <?= $b['jumlah_buku'] ?>) </small>
</a>
<?php
    }
} else {
    ?>
    <div class="list-group-item text-muted">Buku tidak ditemukan</div>
    <?php
}
?>