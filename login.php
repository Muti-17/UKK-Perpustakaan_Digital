<?php

include "koneksi.php";

if(isset($_POST['kirim'])){
    $nis = $_POST['nis'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE nis = '$nis' ");

    if (mysqli_num_rows($query) > 0){
        $user = mysqli_fetch_assoc($query);
    if (password_verify($password, $user['password'])) {

    if($user['status'] == 0) {
      header('location:login.php?s=nonaktif');
      exit;
    }
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['id_siswa'] = $user['id_siswa'];
        $_SESSION['nis'] = $user['nis'];
        $_SESSION['nama'] = $user['nama'];

        header('location:siswa/index.php');
    } else {
        header('location:login.php?s=password_salah');
    }
    } else {
        header('location:login.php?s=nis_notfound');
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

    <title>Login - Perpustakaan Digital SMKN 1 Lemahsugih</title>

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
              <h4 class="mb-2 text-center">Login</h4>
              <p class="mb-4 text-center">Perpustakaan Digital SMKN 1 Lemahsugih</p>

              <?php
                if(isset($_GET['s'])){
                  if($_GET['s'] == "password_salah"){
                    ?>
                    <div class="alert alert-danger" role="alert">
                      Password Salah
                    </div>
                  <?php
                  }
                  else if($_GET['s'] == "nis_notfound"){
                    ?>
                    <div class="alert alert-danger" role="alert">
                    NIS belum terdaftar!
                    </div>
              <?php
                  }
                  else if($_GET['s'] == "nonaktif") {
                    ?>
                    <div class="alert alert-danger text-center" role="alert">
                      Akun belum diaktifkan! Segera hubungi Administrator.
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
                <input type="submit" name="kirim" value="Login" class="btn btn-primary d-grid w-100">
              </form>

              <p class="text-center">
                <span>Belum Punya Akun?</span>
                <a href="register.php">
                  <span>Daftar Di sini</span>
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
