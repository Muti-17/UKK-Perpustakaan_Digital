<?php
    session_start();
    //pengecekan SESSION login
    if(!isset($_SESSION['login'])){ //jika session tidak ada
        header('location:../login.php');
    }

     if(!isset($_GET['id'])){ //jika id tidak ada
        header('location:index.php');
    }

    include '../koneksi.php';

    $nis = $_SESSION['nis'];
    $id_siswa = $_SESSION['id_siswa'];

    $id_buku = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM tb_buku WHERE id_buku = '$id_buku'");
    $jmlBuku = mysqli_num_rows($query);
    if($jmlBuku == 0) {
        header('location:index.php');
    }

    $dataBuku = mysqli_fetch_assoc($query);
    if(isset($_POST['pinjam'])) {
     $jmlPinjam = $_POST['jumlah_pinjam'];

    if($jmlPinjam > $dataBuku['jumlah_buku']) {
      $alert = [
        'type' => 'error',
        'title' => 'Stok Tidak Cukup',
        'text' => 'Jumlah buku tersedia hanya' . $dataBuku['jumlah_buku']. 'buku.'
      ];
    }
    else if($jmlPinjam < 1) {
      $alert = [
        'type' => 'warning',
        'title' => 'Jumlah Tidak Valid',
        'text' => 'Jumlah pinjam minimal 1 buku.'
      ];
    }

    else {
      $date = date('y-m-d');
      $id_siswa = $_SESSION['id_siswa'];
      $query = mysqli_query($koneksi, "INSERT INTO tb_transaksi (tgl_peminjaman, jumlah_buku, id_buku, id_siswa)
      VALUES ('$date', '$jmlPinjam', '$id_buku', '$id_siswa')");

      $update = mysqli_query($koneksi, "UPDATE tb_buku SET jumlah_buku = jumlah_buku - '$jmlPinjam' WHERE id_buku = '$id_buku'");
       $alert = [
        'type' => 'success',
        'title' => 'Berhasil',
        'text' => 'Buku berhasil dipinjam.',
        'redirect' => 'transaksi.php'
       ];
    }
    }

    if(isset($_POST['kirim'])){
          
          // =====================
          // AMBIL DATA
          // =====================
          $ISBN    = trim($_POST['ISBN']);
          $judul   = htmlspecialchars($_POST['judul']);
          $penulis = htmlspecialchars($_POST['penulis']);
          $penerbit = htmlspecialchars($_POST['penerbit']);
          $tahun   = $_POST['tahun_terbit'];
          $jumlah  = $_POST['jumlah'];
          $tempat  = htmlspecialchars($_POST['tempat']);

          // =====================
          // CEK DUPLIKASI ISBN
          // =====================
          $cek = mysqli_query($koneksi, "SELECT ISBN FROM tb_buku WHERE ISBN='$ISBN'");
          if (mysqli_num_rows($cek) > 0) {
              header('location:kelola_buku.php?s=isbn_terdaftar');
              exit;
          }

          // =====================
          // VALIDASI COVER
          // =====================
          $cover = $_FILES['cover'];
          $maxSize = 512 * 1024;
          $allowedExt = ['jpg','jpeg','png'];

          $ext = strtolower(pathinfo($cover['name'], PATHINFO_EXTENSION));

          if ($cover['size'] > $maxSize) {
              header('location:kelola_buku.php?s=ukuran_file');
              exit;
          }

          if (!in_array($ext, $allowedExt)) {
              header('location:kelola_buku.php?s=file_gagal');
              exit;
          }

          // =====================
          // UPLOAD FILE
          // =====================
          $namaCover = uniqid('cover_', true) . '.' . $ext;
          move_uploaded_file($cover['tmp_name'], "../uploads/" . $namaCover);

          // =====================
          // INSERT DATABASE
          // =====================
          $query = "INSERT INTO tb_buku (ISBN, judul_buku, penulis, penerbit, tahun_terbit, jumlah_buku, tempat, cover) VALUES ('$ISBN','$judul','$penulis','$penerbit','$tahun','$jumlah','$tempat','$namaCover')";
          $insert = mysqli_query($koneksi, $query);

          header('location:kelola_buku.php?s=berhasil');
          exit;

        }
        if(isset($_POST['kirimEdit'])){
    $id      = trim($_POST['id_buku']);
    $judul   = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $penerbit = htmlspecialchars($_POST['penerbit']);
    $tahun   = $_POST['tahun_terbit'];
    $jumlah  = $_POST['jumlah'];
    $tempat  = htmlspecialchars($_POST['tempat']);

    if($_FILES['cover']['name'] != ""){
      $cover = $_FILES['cover'];
      $maxSize = 512 * 1024;
      $allowedExt = ['jpg','jpeg','png'];

      $ext = strtolower(pathinfo($cover['name'], PATHINFO_EXTENSION));

      if ($cover['size'] > $maxSize) {
          header('location:kelola_buku.php?s=ukuran_file');
          exit;
      }

      if (!in_array($ext, $allowedExt)) {
          header('location:kelola_buku.php?s=file_gagal');
          exit;
      }

      //ambil nama cover
      $queryBuku = mysqli_query($koneksi,"SELECT * FROM tb_buku WHERE id_buku = '$id'");
      $buku = mysqli_fetch_assoc($queryBuku);

      //hapus file lama
      unlink("../uploads/" . $buku['cover']);

      //upload file baru
      $namaCover = uniqid('cover_', true) . '.' . $ext;
      move_uploaded_file($cover['tmp_name'], "../uploads/" . $namaCover);

      $query = "UPDATE tb_buku SET
                judul_buku = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tahun_terbit = '$tahun',
                jumlah_buku = '$jumlah',
                tempat = '$tempat',
                cover = '$namaCover'
                WHERE id_buku = '$id'
                ";
      $update = mysqli_query($koneksi, $query);

      header('location:kelola_buku.php?s=update_berhasil');
      exit;
    }
    else{
      $query = "UPDATE tb_buku SET
                judul_buku = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tahun_terbit = '$tahun',
                jumlah_buku = '$jumlah',
                tempat = '$tempat'
                WHERE id_buku = '$id'
                ";
      $update = mysqli_query($koneksi, $query);

      header('location:kelola_buku.php?s=update_berhasil');
      exit;
    }
  }

?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../sneat/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title><?= $dataBuku['judul_buku']?> - Perpustakaan Digital SMKN 1 Lemahsugih</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../sneat/assets/img/favicon/logo.jpg" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../sneat/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../sneat/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../sneat/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../sneat/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../sneat/assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Page CSS -->
     <link rel="stylesheet" href="../sneat/assets/datatables/datatables.min.css">
     <link rel="stylesheet" href="../sneat/assets/datatables/datatables.css">

    <!-- Helpers -->
    <script src="../sneat/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../sneat/assets/js/config.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .swal2-container {
      z-index: 9999 !important;
    }
  </style>
  </head>

  <body>
    <?php
    if(isset($_GET['s'])){
      if($_GET['s'] == "isbn_terdaftar"){
        ?>
        <script>
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Gagal",
          text: "ISBN sudah terdaftar!",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
        <?php
      }
      else if($_GET['s'] == "ukuran_file"){
        ?>
        <script>
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "Perhatian",
          text: "Ukuran file maksimal 512kb!",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
        <?php
      }
      else if($_GET['s'] == "file_gagal"){
        ?>
        <script>
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Gagal",
          text: "Data gagal dikirim!",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
        <?php
      }
      else if($_GET['s'] == "berhasil"){
        ?>
        <script>
        Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data buku berhasil disimpan'
      }).then(() => {
        window.location.href='kelola_buku.php';
      });
      </script>
        <?php
      }
      else if($_GET['s'] == "update_berhasil"){
        ?>
        <script>
        Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data buku berhasil diupdate.'
      }).then(() => {
        window.location.href='kelola_buku.php';
      });
      </script>
        <?php
      }
      else if($_GET['s'] == "hapus_berhasil"){
        ?>
        <script>
        Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data buku telah dihapus.'
      }).then(() => {
        window.location.href='kelola_buku.php';
      });
      </script>
        <?php
      }
    }
    ?>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

               <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
          <img 
              src="../sneat/assets/img/favicon/logo.jpg"
              alt="Logo"
              style="width: 36px; height: 36px; border-radius: 70%;">


              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">
              <font color="#001b72">
                SMKN 1 <br>
                LEMAHSUGIH📚</font>
            </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="transaksi.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div data-i18n="Analytics">Transaksi</div>
              </a>
            </li>

            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
              <a
                href="profil.php"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Support">Profil</div>
              </a>
            </li>
            
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../sneat/assets/img/avatars/logo.jpg" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../sneat/assets/img/avatars/logo.jpg" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">
                             <?php echo $_SESSION['nama'] ?? 'Pengguna'; ?>
                            </span>
                            <small class="text-muted">Anggota</small>
                          </div>
                        </div>
                      </a>
                    </li>
                   
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <h2 class="card-title text-primary text-center">Pinjam Buku</h2>
                      <hr>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="../uploads/<?= $dataBuku['cover'] ?>" alt="" style="width: 100%; height:auto;">
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-8">
                                    <table class="table" style="font-size:1.2em">
                                        <tr>
                                            <td>ISBN</td>
                                            <td><b><?= $dataBuku['ISBN'] ?></b></td>
                                        </tr>
                                            <tr>
                                            <td>Judul Buku</td>
                                            <td><b><?= $dataBuku['judul_buku'] ?></b></td>
                                        </tr>
                                            <tr>
                                            <td>Penulis</td>
                                            <td><b><?= $dataBuku['penulis'] ?></b></td>
                                        </tr>
                                            <tr>
                                            <td>Penerbit</td>
                                            <td><b><?= $dataBuku['penerbit'] ?></b></td>
                                        </tr>
                                            <tr>
                                            <td>Tahun Terbit</td>
                                            <td><b><?= $dataBuku['tahun_terbit'] ?></b></td>
                                        </tr>
                                            <tr>
                                            <td>Rak Simpan</td>
                                            <td><b><?= $dataBuku['tempat'] ?></b></td>
                                        </tr>
                                            <tr>
                                            <td>Jumlah Tersedia</td>
                                            <td><b><?= $dataBuku['jumlah_buku'] ?></b></td>
                                        </tr>
                                            <form action="" method="post">
                                              <tr>
                                                <td>Jumlah Dipinjam</td>
                                                <td>
                                                  <input type="number" name="jumlah_pinjam" class="form-control"
                                                  required placeholder="Masukkan Jumlah Buku dipinjam">
                                                  <input type="hidden" name="pinjam" value="1">
                                                </td>
                                              </tr>
                                            
                                    </table>
                                     <button type="button" id="btnPinjam" class="btn btn-primary mt-3">Pinjam Buku</button>
                                  </form>
                                </div>
                            </div>
                        </div>
                    
                  </div>
                </div>
              </div>

            </div>
            <!-- / Content -->

          

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../sneat/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../sneat/assets/vendor/libs/popper/popper.js"></script>
    <script src="../sneat/assets/vendor/js/bootstrap.js"></script>
    <script src="../sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../sneat/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../sneat/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../sneat/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../sneat/assets/js/dashboards-analytics.js"></script>

    <script src="../sneat/assets/datatables/datatables.js"></script>
    <script src="../sneat/assets/datatables/datatables.min.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  
<script>
  $(document).ready(function(){
    $('#cari_buku').on('keyup', function(){
      let keyword=$(this).val();
      appplert(keyword);
    });
  });
</script>

<?php if (isset($alert)) : ?>
  <script>
    Swal.fire({
      icon : '<?= $alert['type']; ?>',
      title : '<?= $alert['title']; ?>',
      text : '<?= $alert['title']; ?>',
      confirmButtonColor : 'rgba(3, 103, 143, 0.73)'
    }).then((result) => {
      <?php if (isset($alert['redirect'])) : ?>
        if (result.isConfirmed) {
          window.location.href = '<?= $alert['redirect']; ?>';
        }
        <?php endif; ?>
    });
  </script>
  <?php endif; ?>

<script>
  document.getElementById('btnPinjam').addEventListener('click', function(){
    
      Swal.fire({
        title : 'Konfirmasi Peminjaman',
        text : 'Yakin Ingin Meminjam Buku Ini?',
        icon : 'question',
        showCancelButton : true,
        confirmButtonText : 'Ya, Pinjam',
        cancelButtonText : 'Batal',
        confirmButtonColor : '#0E6309',
        cancelButtonColor : '#9E1800'
      }).then((result) => {
        if (result.isConfirmed) {
          document.querySelector('form').submit();
        }
      })
  });
</script>

  </body>
</html>
