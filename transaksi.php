<?php
    session_start();
    //pengecekan SESSION login
    if(!isset($_SESSION['login'])){ //jika session tidak ada
        header('location:../login.php');
    }

    include '../koneksi.php';
    $id = $_SESSION['id_siswa'];

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

    <title>Transaksi - Perpustakaan Digital SMKN 1 Lemahsugih</title>

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
            <li class="menu-item ">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-item active">
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
                              <?php echo $_SESSION['nama']; ?>
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
                <div class="col-lg-12 mb-4 order-2 order-lg-1">
                  <div class="row">
                  
                    <div class="col-lg-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-book" style="font-size:2.5em; padding:5px"></i>
                                        </div>
                        </div>
                        <span class="d-block mb-1">Total Transaksi</span>
                        <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_siswa = 
                            '$id'");
                            $total = mysqli_num_rows($query);
                        ?>
                        <h3 class="card-title text-nowrap mb-2"><?= $total ?></h3>
                        </div>
                        </div>

                        </div>
                        <div class="col-lg-3 mb-4">
                            <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-repeat" style="font-size:2.5em; padding:5px"></i>
                                        </div>
                        </div>
                        <span class="d-block mb-1">Dalam Proses</span>
                        <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_transaksi  WHERE id_siswa = 
                            '$id' AND tgl_pengembalian is null");
                            $total = mysqli_num_rows($query);
                        ?>
                        <h3 class="card-title text-nowrap mb-2"><?= $total ?></h3>
                        </div>
                        </div>
                        

                        </div>
                        <div class="col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                        <i class="bx bx-info-circle" style="font-size:2.5em; padding:5px"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Pinjaman lebih dari 7 hari"></i>
                                    </div>
                                    </div>
                                    <span class="d-block mb-1">Terlambat</span>
                                  <?php
                                      $total = 0;
                                      $total_denda = 0; // Tambahkan variabel ini
                                      $query = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_siswa = '$id' AND tgl_pengembalian ");
                                      
                                      while($d = mysqli_fetch_assoc($query)) {
                                          $tgl_peminjaman = strtotime($d['tgl_peminjaman']);
                                          $hari_ini = time();
                                          $selisih_hari = floor(($hari_ini - $tgl_peminjaman) / (60 * 60 * 24));

                                          if ($selisih_hari > 7) {
                                              $total++;
                                              $hari_terlambat = $selisih_hari - 7;
                                              $total_denda += ($hari_terlambat * 1000); // Akumulasi denda
                                          }
                                      }
                                  ?>
                                  <h3 class="card-title text-nowrap mb-2"><?= $total ?></h3>
                                  <?php if($total_denda > 0): ?>
                                      <small class="text-danger fw-bold">Denda: Rp <?= number_format($total_denda, 0, ',', '.') ?></small>
                                  <?php endif; ?>
                                    </div>
                                    </div>

                        </div>
                        <div class="col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class="bx bx-badge-check" style="font-size:2.5em; padding:5px"></i>
                                        </div>

                                        </div>
                                        <span class="d-block mb-1">Transaksi Selesai</span>
                                        <?php
                                            $query = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_siswa = '$id' AND tgl_pengembalian is not null");
                                            $total = mysqli_num_rows($query);
                                        ?>
                                        <h3 class="card-title text-nowrap mb-2"><?= $total ?></h3>
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
                      <h3>Data Transaksi</h3>
                      <table id="example2" class="table table-bordered table-hover nowrap dt-responsive" style="width:100%">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Kode Transaksi</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Denda</th>
                            <th>Jumlah Dipinjam</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                       <tbody>
                          <?php
                          $query = mysqli_query($koneksi, "SELECT tb_transaksi.*, tb_buku.judul_buku, tb_siswa.nama, tb_siswa.nis 
                              FROM tb_transaksi INNER JOIN tb_buku ON tb_transaksi.id_buku = tb_buku.id_buku 
                              INNER JOIN tb_siswa ON tb_transaksi.id_siswa = tb_siswa.id_siswa WHERE tb_transaksi.id_siswa = '$id' ");

                          while($data = mysqli_fetch_assoc($query)) {
                              // Inisialisasi variabel denda
                              $denda_tampil = "-";
                              
                              if($data['tgl_pengembalian'] == null) {
                                  $tgl_peminjaman = strtotime($data['tgl_peminjaman']);
                                  $hari_ini = time();
                                  $selisih_hari = floor(($hari_ini - $tgl_peminjaman) / (60 * 60 * 24));

                                  if($selisih_hari > 7) {
                                      $hari_terlambat = $selisih_hari - 7;
                                      $nominal = $hari_terlambat * 1000; // Contoh: Rp 1.000 per hari
                                      $denda_tampil = "<b class='text-danger'>Rp " . number_format($nominal, 0, ',', '.') . "</b>";
                                  }
                              }
                          ?>
                          <tr>
                              <td></td>
                              <td><?= 'KDP-', $data['id_transaksi']?></td>
                              <td><?= $data['judul_buku']?></td>
                              <td><?= $data['tgl_peminjaman']?></td>
                              <td><?= $data['tgl_pengembalian'] ?? '-' ?></td>
                              <td><?= $denda_tampil ?></td> <td><?= $data['jumlah_buku']?></td>
                              <td>
                                  <?php if($data['tgl_pengembalian'] == null): ?>
                                      <?php if(isset($nominal)): ?>
                                          <button class="btn btn-danger btn-sm mb-1" title="Segera kembalikan!">Terlambat</button>
                                      <?php else: ?>
                                          <button class="btn btn-warning btn-sm mb-1">Dipinjam</button>
                                      <?php endif; ?>
                                  <?php else: ?>
                                      <button class="btn btn-success btn-sm mb-1">Selesai</button>
                                  <?php endif; ?>
                              </td>
                          </tr>
                          <?php } ?>
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


  </body>
</html>
