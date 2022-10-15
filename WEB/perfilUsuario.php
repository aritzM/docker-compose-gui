<?php
session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
require 'funciones.php';
$conn = conn();
$result = "";
if(isset($_POST["actualizar"]))
{
  actualizarUsuario($conn,$_POST["nombre"],$_POST["apellido1"],$_POST["apellido2"],$_POST["email"],$_POST["username"],$_SESSION["password"],$_SESSION["user"]);
  unset($_SESSION["password"]);
  $_SESSION['user'] = $_POST["username"];
  $_SESSION["nombre"] = $_POST["nombre"] . " " . $_POST["apellido1"] . " " . $_POST["apellido2"];
  $result = "Datos del perfil actualizados";
}
if(isset($_POST["actualizarPasswd"]))
{
  if($_POST["newpassword"] == $_POST["renewpassword"])
  {
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $sentence = $conn->prepare($sql);
    $sentence->bind_param('ss',$_SESSION["user"],$_POST["password"]);
    $sentence->execute();
    $result = $sentence->get_result();
    $user = $result->fetch_assoc();  
    $numUser = count($user);
    if($numUser != 0)
    {
      $sql = "UPDATE users SET password = ? WHERE username = ?";  
      $sentence = $conn->prepare($sql);
      $sentence->bind_param('ss', $_POST["newpassword"],$_SESSION["user"]);
      $sentence->execute();
      $result = "Contraseña cambiada satisfactoriamente";
    }
    else
    {
      $result = "La contraseña actual no coincide";
    }
  }
  else
  {
    $result = "La nueva contraseña no coincide";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Mi perfil Webmin Docker Compose</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <?php 
    include 'header.php';
    include 'menu.html';
  ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Perfil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item">Usuario</a></li>
          <li class="breadcrumb-item active">Perfil</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <?php echo '<h3>' . $result . '</h3>'; ?>
        <div class="col-xl-4">
        <?php
          $sql = "SELECT * FROM users WHERE username = ?";
          $sentence = $conn->prepare($sql);
          $sentence->bind_param("s", $_SESSION["user"]);
          $sentence->execute();
          $result = $sentence->get_result();
          $user = $result->fetch_assoc();
          $_SESSION["password"] = $user["password"];
        ?>
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
              <h2><?php echo $user['nombre'] . " " . $user["apellido1"] . " " . $user["apellido2"]; ?></h2>
              <?php 
                if($user["role"] == 1)
                {
                  echo '<h3>Super Administrador</h3>';
                }
                if($user["role"] == 2)
                {
                  echo '<h3>Administrador</h3>';
                }
              ?>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Resumen</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Cambiar Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nombre</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user["nombre"]; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Apellido 1</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user["apellido1"]; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Apellido 2</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user["apellido2"]; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user["email"]; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nombre de Usuario</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user["username"]; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Rol</div>
                    <?php 
                    if($user["role"] == 1)
                    {
                      echo '<div class="col-lg-9 col-md-8">Super Administrador</div>';
                    }
                    if($user["role"] == 2)
                    {
                      echo '<div class="col-lg-9 col-md-8">Administrador</div>';
                    }
                  ?>
                  </div>
                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="perfilUsuario.php" method="POST">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="assets/img/profile-img.jpg" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                      <div class="col-md-8 col-lg-9">
                        <?php echo '<input name="nombre" type="text" class="form-control" id="fullName" value="' . $user["nombre"] . '">'; ?> 
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">Apellido 1</label>
                      <div class="col-md-8 col-lg-9">
                        <?php echo '<input name="apellido1" type="text" class="form-control" id="apellido1" value="' . $user["apellido1"] . '">'; ?>
                        
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Apellido 2</label>
                      <div class="col-md-8 col-lg-9">
                        <?php echo '<input name="apellido2" type="text" class="form-control" id="company" value="' . $user["apellido2"] . '">'; ?>
                        
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <?php echo '<input name="email" type="text" class="form-control" id="Job" value="' . $user["email"] . '">'; ?>
                        
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Nombre de Usuario</label>
                      <div class="col-md-8 col-lg-9">
                          <?php echo '<input name="username" type="text" class="form-control" id="Country" value="' . $user["username"] . '">'; ?>
                      </div>
                    </div><!--
                    <?php 
                      /*if($_SESSION["role"] == 1)
                      {*/
                    ?>
                        <div class="row mb-3">
                          <label for="Address" class="col-md-4 col-lg-3 col-form-label">Rol</label>
                          <div class="col-md-8 col-lg-9">

                            <?php
                              /*if($user["role"] == 1)
                              echo '<input name="address" type="text" class="form-control" id="Address" value="A108 Adam Street, New York, NY 535022">'; */
                             ?>
                          </div>
                        </div>
                    <?php 
                      //}
                    ?>
                    -->
                    <div class="text-center">
                      <button type="submit" name="actualizar" value="actualizar" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="perfilUsuario.php" method="POST">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Actual</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Repite Nueva Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="actualizarPasswd" value="actualizarPasswd" class="btn btn-primary">Cambiar Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>AkaEnterprises</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>