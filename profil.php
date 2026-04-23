<?php
    session_start();
    //pengecekan SESSION login
    if(!isset($_SESSION['login'])){ //jika session tidak ada
        header('location:../login.php');
    }

    include '../koneksi.php';
    $nis = $_SESSION['nis'];
    $id = $_SESSION['id_siswa'];

    if(isset($_POST['kirimEdit'])){
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $jk = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $password = $_POST['password'];

        $query = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE id_siswa = '$id'");
        $data = mysqli_fetch_assoc($query);

        if(password_verify($password, $data['password'])){
            mysqli_query($koneksi, "UPDATE tb_siswa SET nama = '$nama', kelas = '$kelas', jenis_kelamin = '$jk', alamat = '$alamat' WHERE id_siswa = '$id'");
            header('location:profil.php?s=update_berhasil');
        }
        else {
            header('location:profil.php?s=password_salah');
            exit;
        }
    }

     if(isset($_POST['updatePassword'])){
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $hashPassword = password_hash($password_baru, PASSWORD_DEFAULT);

        $query = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE id_siswa = '$id'");
        $data = mysqli_fetch_assoc($query);

        if(password_verify($password_lama, $data['password'])){
            mysqli_query($koneksi, "UPDATE tb_siswa SET password = '$hashPassword' WHERE id_siswa = '$id'");
            header('location:profil.php?s=update_password_berhasil');
        }
        else {
            header('location:profil.php?s=password_lama_salah');
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

    <title>Profil Siswa - Perpustakaan Digital SMKN 1 Lemahsugih</title>

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
      if($_GET['s'] == "password lama salah"){
        ?>
        <script>
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Gagal",
          text: "Password lama salah!",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
        <?php
      }
        else if($_GET['s'] == "update_password_berhasil"){
        ?>
        <script>
        Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Password berhasil diupdate.'
      }).then(() => {
        window.location.href='profil.php';
      });
      </script>
        <?php
      }
      else if($_GET['s'] == "password_lama_salah"){
        ?>
        <script>
        Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Password lama salah.'
      }).then(() => {
        window.location.href='profil.php';
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
        text: 'Data siswa berhasil diupdate.'
      }).then(() => {
        window.location.href='profil.php';
      });
      </script>
        <?php
      }
      else if($_GET['s'] == "password_salah"){
        ?>
        <script>
        Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Password salah.'
      }).then(() => {
        window.location.href='profil.php';
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
            <li class="menu-item">
              <a href="transaksi.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div data-i18n="Analytics">Transaksi</div>
              </a>
            </li>

            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item active">
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
                      <a class="dropdown-item" href="../index.php">
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
                      <h2 class="card-title text-primary text-center"> <font color="#001b72">Profil Anggota</h2>
                      <hr>

                      <?php
                      $query = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE id_siswa = '$id' ");
                      while($data = mysqli_fetch_assoc($query)){
                        ?>
                        <div class="col-lg-12">
                            <form action="" method="post" enctype="multipart/form-data">
                                              <div class="modal-body">
                                                <div class="card-body">
                                                  
                                                    <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">NIS</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" id="basic-default-name" placeholder="Masukan NIS" name="nis" required value="<?= $data['nis']?>" readonly/>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Nama</label>
                          <div class="col-sm-10">
                            <input
                              type="text"
                              class="form-control"
                              id="basic-default-company"
                              name="nama"
                              required
                              placeholder="Masukan Nama"
                              value="<?= $data['nama']?>" 
                            />
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Kelas</label>
                          <div class="col-sm-10">
                            <select name="kelas" id="" class="form-control" required value="<?= $data['kelas']?>">
                                <option value="" disabled>---Pilih Kelas---</option>
                                <option <?= $data['kelas']=="12 RPL A" ? "selected" :"" ?> value="12 RPL A">12 RPL A</option>
                                <option <?= $data['kelas']=="12 RPL B" ? "selected" :"" ?> value="12 RPL B">12 RPL B</option>
                                <option <?= $data['kelas']=="12 RPL C" ? "selected" :"" ?> value="12 RPL C">12 RPL C</option>
                                <option <?= $data['kelas']=="12 RPL D" ? "selected" :"" ?> value="12 RPL D">12 RPL D</option>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Jenis Kelamin</label>
                          <div class="col-sm-10">
                        <select name="jenis_kelamin" id="" class="form-control" required >
                            <option value="" disabled selected>---Pilih Jenis Kelamin---</option>
                            <option <?= $data['jenis_kelamin']=="L" ? "selected" :"" ?> value="L">Laki-laki</option>
                            <option <?= $data['jenis_kelamin']=="P" ? "selected" :"" ?> value="P">Perempuan</option>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat</label>
                          <div class="col-sm-10">
                            <textarea name="alamat" id="" 
                              class="form-control" required
                              placeholder="Masukan Alamat Siswa"> <?= $data['alamat']?>
                          </textarea>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Password</label>
                          <div class="col-sm-10">
                            <input
                              type="password"
                              class="form-control"
                              id="basic-default-company"
                              name="password"
                              required
                              placeholder="Masukan Password"
                            />
                          </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company"></label>
                          <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" name="kirimEdit" value="Edit Data">
                          </div>
                        </div>
                        </div>
                        </div>
                        </form>
                        </div>
                        

                            <div class="col-lg-12">
                        <form action ="" method="POST">
                            <div class="modal-body">
                                <div class="card-body">
                                    <h4 class="card-title text-primary text-center"> <font color="#001b72">Ganti Password</h4>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Password Lama</label>
                          <div class="col-sm-10">
                            <input
                              type="password"
                              class="form-control"
                              id="basic-default-company"
                              name="password_lama"
                              required
                              placeholder="Masukan Password Lama"
                            />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Password Baru</label>
                          <div class="col-sm-10">
                            <input
                              type="password"
                              class="form-control"
                              id="basic-default-company"
                              name="password_baru"
                              required
                              placeholder="Masukan Password Baru"
                            />
                          </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company"></label>
                          <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" name="updatePassword" value="Edit Password">
                          </div>
</form>
</div>
                        <?php
                      }
                      ?>
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
      let keyword = $(this).val();
      //alert(keyword);

  if(keyword.length < 2) {
    $('#hasil_buku').hide();
    return;
  }
  $.ajax ({
    url : 'proses_cari_buku.php',
    method : "POST",
    data : { keyword : keyword },
    success : function (data) {
      $('#hasil_buku').fadeIn().html(data);
    }
  });
    });
  });
</script>

  </body>
</html>