<?php
    session_start();
    //pengecekan SESSION login
    if(!isset($_SESSION['login'])){ //jika session tidak ada
        header('location:../login_admin.php');
    }

    include '../koneksi.php';

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
          $status = 1;
          $query = "INSERT INTO tb_buku (ISBN, judul_buku, penulis, penerbit, tahun_terbit, jumlah_buku, tempat, cover, status)
          VALUES ('$ISBN','$judul','$penulis','$penerbit','$tahun','$jumlah','$tempat','$namaCover', '$status')";
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
          $status = $_POST['status'];

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
                cover = '$namaCover',
                status =n'$status'
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
                tempat = '$tempat',
                status = '$status'
                WHERE id_buku = '$id'
                ";
      $updMutite = mysqli_query($koneksi, $query);

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

    <title>Kelola Data Buku - Perpustakaan Digital SMKN 1 Lemahsugih</title>

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
      else if($_GET['s'] == "buku_nonaktif"){
        ?>
        <script>
        Swal.fire({
        icon: 'warning',
        title: 'Buku nonaktif',
        text: 'Buku dinonaktifkan.'
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
            <li class="menu-item">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-item active">
              <a href="kelola_buku.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Analytics">Kelola Buku</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="kelola_anggota.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Kelola Anggota</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="transaksi.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div data-i18n="Analytics">Transaksi</div>
              </a>
            </li>

            <!-- Misc -->
            
              <a
                href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                target="_blank"
                class="menu-link"
              >
                
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
                      <img src="../sneat/assets/img/avatars/Muti.jpg" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../sneat/assets/img/avatars/Muti.jpg" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">
                              <?php echo $_SESSION['username']; ?>
                            </span>
                            <small class="text-muted">Admin</small>
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
                <div class="col-lg-12 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-12">
                        <div class="card-body">
                          <h2 class="card-title text-primary">Pengelolaan Data Buku 📚</h2>
                          <p class="mb-4">
                            Pusat kendali koleksi pustaka untuk memantau inventaris buku secara real-time.
                            Halaman ini memfasilitasi pembaruan data, pendaftaran judul baru,
                            hingga penghapusan koleksi lama demi keakuratan database perpustakaan.
                          </p>

                          <button type="button" class="btn rounded-pill btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah Buku
                  </button>

                            <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
      <div class="modal-body">
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">ISBN</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" id="basic-default-name" placeholder="Masukan Nomor Seri" name="ISBN" required />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Judul Buku</label>
                          <div class="col-sm-10">
                            <input
                              type="text"
                              class="form-control"
                              id="basic-default-company"
                              name="judul"
                              required
                              placeholder="Masukan Judul Buku"
                            />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Cover</label>
                          <div class="col-sm-10">
                            <input
                              type="file"
                              class="form-control"
                              id="basic-default-company"
                              name="cover"
                              required
                            />
                            <div class="form-text">Maksimal file yang bisa diupload adalah 512KB (.jpg, .jpeg., .png)</div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Penulis</label>
                          <div class="col-sm-10">
                            <input 
                              type="text" 
                              class="form-control" 
                              id="basic-default-name" 
                              placeholder="Masukan Nama Penulis Buku" 
                              name="penulis" 
                              required />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Penerbit</label>
                          <div class="col-sm-10">
                            <input 
                              type="text" 
                              class="form-control" 
                              id="basic-default-name" 
                              placeholder="Masukan Penerbit Buku" 
                              name="penerbit" 
                              required />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Tahun Terbit</label>
                          <div class="col-sm-10">
                            <input 
                              type="number" 
                              class="form-control" 
                              id="basic-default-name" 
                              placeholder="Masukan Tahun Terbit" 
                              name="tahun_terbit" 
                              required />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Jumlah Buku</label>
                          <div class="col-sm-10">
                            <input 
                              type="number" 
                              class="form-control" 
                              id="basic-default-name" 
                              placeholder="Masukan Banyaknya Buku" 
                              name="jumlah" 
                              required />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Tempat</label>
                          <div class="col-sm-10">
                            <input 
                              type="text" 
                              class="form-control" 
                              id="basic-default-name" 
                              placeholder="Masukan Tempat Penyimpanan Buku" 
                              name="tempat" 
                              required />
                          </div>
                        </div>

                       
                          
                     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="kirim" value="Simpan Data">
      </div>
       </form>
    </div>
  </div>
</div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <h3>Data Buku</h3>
                      <table id="example2" class="table table-bordered table-hover nowrap dt-responsive" style="width:100%">
                        <thead>
                          <tr>
                            <th></th>
                            <th>ISBN</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Jumlah Buku</th>
                            <th>Tempat</th>
                            <th>Cover</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          $dataBuku = mysqli_query($koneksi,"SELECT * FROM tb_buku");
                          while($data = mysqli_fetch_assoc($dataBuku)){
                            $no++;
                            ?>
                            <tr>
                              <td></td>
                              <td><?= $data['ISBN'] ?></td>
                              <td><?= $data['judul_buku'] ?></td>
                              <td><?= $data['penulis'] ?></td>
                              <td><?= $data['penerbit'] ?></td>
                              <td><?= $data['tahun_terbit'] ?></td>
                              <td><?= $data['jumlah_buku'] ?></td>
                              <td><?= $data['tempat'] ?></td>
                              <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $no?>">
                                Lihat Cover
                              </button>
                              </td>
                              <td>
                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $no?>">
                                  <span class="tf-icons bx bx-edit"></span>&nbsp; Edit
                                </button>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="<?= $data['id_buku']; ?>" data-judul="<?= htmlspecialchars($data['judul_buku']); ?>">
                                  <span class="tf-icons bx bx-trash"></span>&nbsp; Hapus
                                </button>
                              </td>
                            </tr>
                            <!-- Modal Edit-->
                            <div class="modal fade" id="editModal<?= $no ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span class="tf-icons bx bx-edit"></span>&nbsp; Edit Data Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="" method="post" enctype="multipart/form-data">
                                              <div class="modal-body">
                                                <div class="card-body">
                                                  
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-name">ISBN</label>
                                                      <div class="col-sm-10">
                                                        <input type="text"
                                                          name="ISBN"
                                                          class="form-control"
                                                          placeholder="Nomor Seri Buku"
                                                          required
                                                          value="<?= $data['ISBN'] ?>"
                                                          readonly
                                                          pattern="[0-9]{10,13}"
                                                          title="ISBN harus berupa angka 10–13 digit">
                                                        <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
                                                      </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-company">Judul Buku</label>
                                                      <div class="col-sm-10">
                                                        <input
                                                          type="text"
                                                          name="judul"
                                                          required
                                                          class="form-control"
                                                          value="<?= $data['judul_buku'] ?>"
                                                          id="basic-default-company"
                                                          placeholder="Pemrograman Web Kelas 11"
                                                        />
                                                      </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-company">Cover</label>
                                                      <div class="col-sm-10">
                                                        <input class="form-control"
                                                          type="file"
                                                          name="cover"
                                                          id="formFile"
                                                          accept="image/png, image/jpeg, image/jpg" />
                                                        <div class="form-text">Ukuran file maksimal 512 KB (jpg, jpeg, png)</div>
                                                      </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-company">Penulis</label>
                                                      <div class="col-sm-10">
                                                        <input
                                                          type="text"
                                                          name="penulis"
                                                          required
                                                          value="<?= $data['penulis'] ?>"
                                                          class="form-control"
                                                          id="basic-default-company"
                                                          placeholder="Joko Anwar"
                                                        />
                                                      </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-company">Penerbit</label>
                                                      <div class="col-sm-10">
                                                        <input
                                                          type="text"
                                                          name="penerbit"
                                                          required
                                                          value="<?= $data['penerbit'] ?>"
                                                          class="form-control"
                                                          id="basic-default-company"
                                                          placeholder="Rumah Pendidikan"
                                                        />
                                                      </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-company">Tahun Terbit</label>
                                                      <div class="col-sm-10">
                                                        <input
                                                          type="number"
                                                          name="tahun_terbit"
                                                          required
                                                          value="<?= $data['tahun_terbit'] ?>"
                                                          class="form-control"
                                                          id="basic-default-company"
                                                          placeholder="Pemrograman Web Kelas 11"
                                                        />
                                                      </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-company">Jumlah</label>
                                                      <div class="col-sm-10">
                                                        <input
                                                          type="number"
                                                          name="jumlah"
                                                          required
                                                          value="<?= $data['jumlah_buku'] ?>"
                                                          class="form-control"
                                                          id="basic-default-company"
                                                          placeholder="Banyak Buku Tersedia"
                                                        />
                                                      </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      <label class="col-sm-2 col-form-label" for="basic-default-company">Tempat</label>
                                                      <div class="col-sm-10">
                                                        <input
                                                          type="text"
                                                          name="tempat"
                                                          required
                                                          value="<?= $data['tempat'] ?>"
                                                          class="form-control"
                                                          id="basic-default-company"
                                                          placeholder="Rak Nomor 11A"
                                                        />
                                                      </div>
                                                    </div>

                                                     <div class = "row mb-3">
                                                      <label for="" class = "col-sm-2">Status</label>
                                                      <div class="col-sm-10">
                                                        <select name="status" class="form-control" required>
                                                          <option <?= $data['status'] == 0 ? "selected" : "" ?> value="0">Tidak Aktif</option>
                                                          <option <?= $data['status'] == 1 ? "selected" : "" ?> value="1">Aktif</option>
                                                        </select>
                                                        </div>
                                                        </div>
                                                  
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" name="kirimEdit" class="btn btn-primary" value="Edit Data">
                                              </div>
                                              </form>
                                </div>
                              </div>
                            </div>
                            <!-- Modal Cover-->
                            <div class="modal fade" id="exampleModal<?php echo $no?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body mb-4">
                                    <center>
                                      <img src="../uploads/<?= $data['cover'] ?>?>" alt="" style="width:50%;height:auto">
                                    </center>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php
                          }
                          ?>
                        </tbody>
                      </table>
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
$(function () {
  $('#example2').DataTable({
    responsive: {
      details: {
        type: 'column',
        target: 0
      }
    },
    columnDefs: [
      {
        className: 'control',
        orderable: false,
        targets: 0
      },
      {
        responsivePriority: 1,
        targets: -1 // kolom AKSI selalu tampil
      }
    ],
    order: [[1, 'asc']],
    autoWidth: false
  });
});
</script>

<script>
$(document).on('click', '.btn-hapus', function () {
  const id = $(this).data('id');
  const judul = $(this).data('judul');

  Swal.fire({
    title: 'Yakin ingin menghapus?',
    html: `<b>${judul}</b> akan dihapus permanen`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `proses_hapus_buku.php?id=${id}`;
    }
  });
});
</script>
  </body>
</html>
