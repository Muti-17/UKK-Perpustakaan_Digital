<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Digital</title>

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
                <form class="row g-2" method="GET" action="cari.php">
                    <div class="col-md-9">
                        <input type="text" name="judul" class="form-control form-control-lg" placeholder="Cari judul buku ..." required>
                    </div>
                    <div class="col-md-3 d-grid">
                        <input class="btn btn-primary btn-lg" type="submit" value="🔍 Cari Buku">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Koleksi Buku -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4 text-center">Hasil Pencarian</h3>

        <?php
            include 'koneksi.php';
            $judul = $_GET['judul'];
            $query = mysqli_query($koneksi,"SELECT * FROM tb_buku WHERE status = 1 AND LOWER(judul_buku) LIKE LOWER('%$judul%');");
            
            if(mysqli_num_rows($query) == 0){
                ?>
                <br>
                <h3 class="text-center">Data yang Anda cari tidak ada.</h3>
                <br>
                <?php
            }
            else{
                ?>
                <div class="row">
                    <?php
                    while($d = mysqli_fetch_assoc($query)){
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="uploads/<?= $d['cover'] ?>" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="fw-bold"><?= $d['judul_buku'] ?></h6>
                                    <small class="text-muted"><?= $d['penerbit'] ?></small>
                                    <a href="detail.php?id=<?= $d['id_buku'] ?>" target="_blank" class="btn btn-primary btn-sm w-100 mt-2">Detail Buku</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
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
