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
          $nis    = trim($_POST['nis']);
          $nama   = htmlspecialchars($_POST['nama']);
          $kelas = htmlspecialchars($_POST['kelas']);
          $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
          $alamat   = htmlspecialchars($_POST['alamat']);
          $password = 12345;
          $hashPassword = password_hash($password, PASSWORD_DEFAULT);
          
          // =====================
          // CEK DUPLIKASI NIS
          // =====================
          $cek = mysqli_query($koneksi, "SELECT nis FROM tb_siswa WHERE nis='$nis'");
          if (mysqli_num_rows($cek) > 0) {
              header('location:kelola_anggota.php?s=nis_terdaftar');
              exit;
          }

          // =====================
          // INSERT DATABASE
          // =====================
          $status = 1;
          $query = "INSERT INTO tb_siswa (nis,password,nama,kelas,jenis_kelamin,alamat,status) VALUES ('$nis','$hashPassword','$nama','$kelas','$jenis_kelamin','$alamat','$status')";
          $insert = mysqli_query($koneksi, $query);

          header('location:kelola_anggota.php?s=berhasil');
          exit;

        }
        if(isset($_POST['kirimEdit'])){
          $nis    = trim($_POST['nis']);
          $nama   = htmlspecialchars($_POST['nama']);
          $kelas = htmlspecialchars($_POST['kelas']);
          $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
          $alamat   = htmlspecialchars($_POST['alamat']);
          $status = $_POST['status'];

        $query = "UPDATE tb_siswa SET
          nama = '$nama',
          kelas = '$kelas',
          jenis_kelamin = '$jenis_kelamin',
          alamat = '$alamat',
          status = '$status'
          WHERE nis = '$nis'
          ";
        mysqli_query($koneksi, $query);
        header('location:kelola_anggota.php?s=update_berhasil');

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

    <title>Kelola Data Anggota - Perpustakaan Digital SMKN 1 Lemahsugih</title>

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
      if($_GET['s'] == "nis_terdaftar"){
        ?>
        <script>
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Gagal",
          text: "NIS sudah terdaftar!",
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
        text: 'Data anggota berhasil disimpan'
      }).then(() => {
        window.location.href='kelola_anggota.php';
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
        text: 'Data anggota berhasil diupdate.'
      }).then(() => {
        window.location.href='kelola_anggota.php';
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
        text: 'Data anggota telah dihapus.'
      }).then(() => {
        window.location.href='kelola_anggota.php';
      });
      </script>
        <?php
      }
      else if($_GET['s'] == "siswa_nonaktif"){
        ?>
        <script>
        Swal.fire({
        icon: 'warning',
        title: 'Siswa Nonaktif',
        text: 'Pernah terjadi transaksi pada siswa. Siswa dinonaktifkan.'
      }).then(() => {
        window.location.href='kelola_anggota.php';
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
            <li class="menu-item ">
              <a href="kelola_buku.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Analytics">Kelola Buku</div>
              </a>
            </li>
            <li class="menu-item active">
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
                          <h2 class="card-title text-primary">Pengelolaan Data Anggota 👥</h2>
                          <p class="mb-4">
                            Halaman ini digunakan untuk mengelola seluruh data anggota yang tersedia dalam sistem. Melalui halaman ini, pengguna dapat menambahkan, melihat, mengubah, dan menghapus data anggota dengan mudah dan praktis.
                          </p>

                          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                              <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah Anggota
                            </button>

                            <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Anggota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
      <div class="modal-body">
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">NIS</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" id="basic-default-name" placeholder="Masukan NIS" name="nis" required />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">NAMA</label>
                          <div class="col-sm-10">
                            <input
                              type="text"
                              class="form-control"
                              id="basic-default-company"
                              name="nama"
                              required
                              placeholder="Masukan Nama Siswa"
                            />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">KELAS</label>
                          <div class="col-sm-10">
                            <select  name="kelas" id="" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                <option value="12 RPL A">12 RPL A</option>
                                <option value="12 RPL B">12 RPL B</option>
                                <option value="12 RPL C">12 RPL C</option>
                                <option value="12 RPL D">12 RPL D</option>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">JENIS KELAMIN</label>
                          <div class="col-sm-10">
                            <select  name="jenis_kelamin" id="" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="L">LAKI LAKI</option>
                                <option value="P">PEREMPUAN</option>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">ALAMAT</label>
                        <div class="col-sm-10">
                            <textarea name="alamat" id="" class="form-control" required></textarea>
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
                      <h3>Data Anggota</h3>
                      <table id="example2" class="table table-bordered table-hover nowrap dt-responsive" style="width:100%">
                        <thead>
                          <tr>
                            <th></th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas </th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          $dataAnggota = mysqli_query($koneksi,"SELECT * FROM tb_siswa");
                          while($data = mysqli_fetch_assoc($dataAnggota)){
                            $no++;
                            ?>
                            <tr>
                              <td></td>
                              <td><?= $data['nis'] ?></td>
                              <td><?= $data['nama'] ?></td>
                              <td><?= $data['kelas'] ?></td>
                              <td><?= $data['jenis_kelamin'] ?></td>
                              <td><?= $data['alamat'] ?></td>
                              <td>
                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $no?>">
                                  <span class="tf-icons bx bx-edit"></span>&nbsp; Edit
                                </button>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="<?= $data['id_siswa']; ?>" data-nama="<?= htmlspecialchars($data['nama']); ?>">
                                  <span class="tf-icons bx bx-trash"></span>&nbsp; Hapus
                                </button>
                              </td>
                            </tr>
                            <!-- Modal Edit-->
                            <div class="modal fade" id="editModal<?= $no ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span class="tf-icons bx bx-edit"></span>&nbsp; Edit Data Anggota</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="" method="post" enctype="multipart/form-data">
                                              <div class="modal-body">
                                                <div class="card-body">
                                                  
                                                    <div class="row mb-3">
                                                  <label class="col-sm-2 col-form-label" for="basic-default-name">NIS</label>
                                                  <div class="col-sm-10">
                                                    <input type="number" class="form-control" 
                                                    id="basic-default-name" 
                                                    placeholder="Masukan NIS" name="nis" 
                                                    required value="<?= $data['nis']?>" 
                                                    readonly />
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                  <label class="col-sm-2 col-form-label" 
                                                  for="basic-default-company">NAMA</label>
                                                  <div class="col-sm-10">
                                                    <input
                                                      type="text"
                                                      class="form-control"
                                                      id="basic-default-company"
                                                      name="nama"
                                                      required
                                                      placeholder="Masukan Nama Siswa"
                                                      value="<?= $data['nama'] ?>"
                                                    />
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                  <label class="col-sm-2 col-form-label" 
                                                  for="basic-default-name">KELAS</label>
                                                  <div class="col-sm-10">
                                                    <select  name="kelas" id="" class="form-control" required>
                                                        <option value="" disabled >-- Pilih Kelas --</option>
                                                        <option <?= $data['kelas'] =="12 RPL A"? "selected" :"" ?>
                                                        value="12 RPL A">12 RPL A</option>
                                                        <option <?= $data['kelas'] =="12 RPL B"? "selected" :"" ?>
                                                        value="12 RPL B">12 RPL B</option>
                                                        <option <?= $data['kelas'] =="12 RPL C"? "selected" :"" ?>
                                                        value="12 RPL C">12 RPL C</option>
                                                        <option <?= $data['kelas'] =="12 RPL D"? "selected" :"" ?>
                                                        value="12 RPL D">12 RPL D</option>
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                  <label class="col-sm-2 col-form-label" for="basic-default-name">JENIS KELAMIN</label>
                                                  <div class="col-sm-10">
                                                    <select  name="jenis_kelamin" id="" class="form-control" required>
                                                        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                                        <option <?= $data['jenis_kelamin'] =="L"? "selected" :"" ?>
                                                        value="L">LAKI LAKI</option>
                                                        <option <?= $data['jenis_kelamin'] =="P"? "selected" :"" ?>
                                                        value="P">PEREMPUAN</option>
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="basic-default-name">ALAMAT</label>
                                                <div class="col-sm-10">
                                                  <textarea name="alamat" id="" class="form-control" required placeholder="Masukan Alamat Siswa"><?= $data['alamat'] ?></textarea>
                                                </div>
                                                </div>

                                                <div class="row mb-3">
                                                  <label class="col-sm-2 col-form-label" for="basic-default-name">Status</label>
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
  const nama = $(this).data('nama');

  Swal.fire({
    title: 'Yakin ingin menghapus?',
    html: `<b>${nama}</b> akan dihapus permanen`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `proses_hapus_anggota.php?id=${id}`;
    }
  });
});
</script>
  </body>
</html>
