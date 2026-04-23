<?php
    include 'koneksi.php';
    $id_buku = $_GET['id'];

    $query = mysqli_query($koneksi,"SELECT * FROM tb_buku WHERE id_buku = '$id_buku'");

    if(mysqli_num_rows($query) == 0){
        header('location:index.php');
    }

    $d = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $d['judul_buku'] ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Hero */
        .hero {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: white;
            padding: 80px 0;
        }

        /* Search */
        .search-box {
            margin-top: -40px;
            z-index: 5;
            position: relative;
        }

        /* Book Card */
        .book-card img {
            height: 260px;
            object-fit: cover;
        }

        /* Swiper */
        .swiper-button-next,
        .swiper-button-prev {
            color: #0d6efd;
        }

        footer {
            background: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">📚 Perpus Digital</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-outline-light btn-sm" href="register.php">Daftar</a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-light btn-sm text-primary" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Perpustakaan Digital</h1>
        <p>Akses ribuan buku digital dengan mudah, cepat, dan gratis</p>
    </div>
</section>

<!-- Search Buku -->
<section class="search-box">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <form class="row g-2">
                    <div class="col-md-9">
                        <input type="text" class="form-control form-control-lg" placeholder="Cari judul buku ...">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-primary btn-lg">🔍 Cari Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Koleksi Buku -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4 text-center">Detail Buku</h3>

        <?php
            
            $query = mysqli_query($koneksi,"SELECT * FROM tb_buku WHERE id_buku = '$id_buku'");

            while($buku = mysqli_fetch_assoc($query)){
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <img src="uploads/<?= $buku['cover'] ?>" alt="" style="width: 100%;height:auto;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                 <table style="font-size:1.1em;" class="table">
                                    <tr>
                                        <td>ISBN</td>
                                        <td class="fw-bold"><?= $buku['ISBN'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Judul Buku</td>
                                        <td class="fw-bold"><?= $buku['judul_buku'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Penulis</td>
                                        <td class="fw-bold"><?= $buku['penulis'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Penerbit</td>
                                        <td class="fw-bold"><?= $buku['penerbit'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tahun Terbit</td>
                                        <td class="fw-bold"><?= $buku['tahun_terbit'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rak Simpan</td>
                                        <td class="fw-bold"><?= $buku['tempat'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Tersedia</td>
                                        <td class="fw-bold"><?= $buku['jumlah_buku'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }

        ?>
        
    </div>
</section>

<!-- Footer -->
<footer class="py-4">
    <div class="container text-center">
        <p class="mb-0">&copy; 2026 Perpustakaan Digital</p>
        <small>Membaca tanpa batas, belajar sepanjang hayat</small>
    </div>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    new Swiper(".mySwiper", {
        spaceBetween: 16,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: { slidesPerView: 1.2 },
            576: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            992: { slidesPerView: 4 }
        }
    });
</script>

</body>
</html>
