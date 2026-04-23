<?php

include "koneksi.php";

   if(isset($_POST['kirim'])){
        echo $nis = $_POST['nis'];
        echo $nama = $_POST['nama'];
        echo $kelas = $_POST['kelas'];
        echo $jenis_kelamin = $_POST['jenis_kelamin'];
        echo $alamat = $_POST['alamat'];
        echo $password = $_POST['password'];
        $status = 0;

        $cekNIS = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE nis = '$nis'");
        if(mysqli_num_rows($cekNIS) > 0){
          header('location:register.php?s=nis_terdaftar');
        }
        else{
          $hashPassword = password_hash($password, PASSWORD_DEFAULT);
          $query = "INSERT INTO tb_siswa (nis, nama, kelas, jenis_kelamin, alamat, password, status) VALUES ('$nis', '$nama', '$kelas', '$jenis_kelamin', '$alamat', '$hashPassword', '$status')";
          mysqli_query($koneksi, $query);
          header('location:register.php?s=berhasil_daftar');
        }
    }
?>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="sneat/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Daftar Anggota - Perpustakaan Digital SMKN 1 Lemahsugih</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="sneat/assets/img/favicon/logo.jpg" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="sneat/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="sneat/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="sneat/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="sneat/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="sneat/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="sneat/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="sneat/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                   <img src="sneat/assets/img/favicon/logo.jpg" width="70" alt="Logo Sekolah">
                     
                   
                  </span>
                  
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2 text-center">Daftar Anggota</h4>
              <p class="mb-4 text-center">Perpustakaan Digital SMKN 1 Lemahsugih</p>

              <?php
                if(isset($_GET['s'])){
                  if($_GET['s'] == "berhasil_daftar"){
                    ?>
                    <div class="alert alert-success" role="alert">
                      Selamat, pendaftaran berhasil_daftar
                    </div>
                  <?php
                  }
                  else if($_GET['s'] == "nis_terdaftar"){
                    ?>
                    <div class="alert alert-danger" role="alert">
                    NIS sudah terdaftar!
                    </div>
              <?php
                  }
                }
              ?>

              <form id="formAuthentication" class="mb-3" action="" method="POST">
              <div class="mb-3">
                  <label for="nis" class="form-label">NIS</label>
                  <input type="number" required class="form-control" id="nis" name="nis" placeholder="Masukkan nis" />
                </div>

              <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" required class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" />
                </div>

                <div class="mb-3">
                  <label for="kelas" class="form-label">Kelas</label>
                  <select name="kelas" id="" class="form-control" required>
                      <option value="" disabled selected>---Pilih Kelas---</option>
                      <option value="12 RPL A">12 RPL A</option>
                      <option value="12 RPL B">12 RPL B</option>
                      <option value="12 RPL C">12 RPL C</option>
                      <option value="12 RPL D">12 RPL D</option>
                  </select>
                </div>

                  <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" id="" class="form-control" required>
                      <option value="" disabled selected>---Pilih Jenis Kelamin---</option>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                  </select>
                  </div>
                  
                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <textarea name="alamat" class="form-control" id="alamat" name="alamat" required></textarea>
                </div> 

                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                      required
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>

               <br>
                <input type="submit" name="kirim" value="Daftar" class="btn btn-primary d-grid w-100">
              </form>

              <p class="text-center">
                <span>Sudah Punya Akun?</span>
                <a href="login.php">
                  <span>Login Di sini</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="sneat/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="sneat/assets/vendor/libs/popper/popper.js"></script>
    <script src="sneat/assets/vendor/js/bootstrap.js"></script>
    <script src="sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="sneat/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="sneat/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
