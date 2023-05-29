<?php
session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
if(isset($_POST["actualizar"]))
{
    require 'comunes/funciones.php';
    $conn = conn();
    //Falta recojer el rol para la actualizacion, implementacion mas adelante
    actualizarUsuario($conn,$_POST["nombre"],$_POST["apellido1"],$_POST["apellido2"],$_POST["email"],$_POST["username"],$_POST["password"],$_SESSION["usuarioActualizar"]);
    unset($_SESSION["usuarioActualizar"]);
    header('Location: verUsuario.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Actualizar Usuario Webmin Docker Compose</title>
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

  <?php 
    include 'header.php';
    include 'menu.html';
  ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Actualizar Usuario</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="verUsuario.php">Usuarios</a></li>
          <li class="breadcrumb-item active">Actualizar Usuario</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <div class="card">
            <div class="card-body">

              <!-- Multi Columns Form -->
              <form class="row g-3" action="actualizarUsuario.php" method="POST">
                  <?php 
                    
                    if(isset($_GET["usuario"]))
                    {
                        require 'comunes/funciones.php';
                        $_SESSION['usuarioActualizar'] = $_GET["usuario"];
                        $conn = conn();
                        $sql = "SELECT * FROM users WHERE username = ?";
                        $sentence = $conn->prepare($sql);
                        $sentence->bind_param("s", $_GET["usuario"]);
                        $sentence->execute();
                        $result = $sentence->get_result();
                        $user = $result->fetch_assoc();
                            
                        
                  ?>
                        <div class="col-md-4">
                            <label for="inputName5" class="form-label">Nombre</label>
                            <?php echo '<input type="text" name="nombre" value="' . $user['nombre'] . '" class="form-control" id="inputName5" placeholder="Nombre" required>'; ?>
                        </div>
                        <div class="col-md-4">
                            <label for="inputApellido1" class="form-label">Apellido 1</label>
                            
                            <?php echo '<input type="text" name="apellido1" value="'. $user['apellido1'] .'" class="form-control" id="inputApellido1" placeholder="Apellido 1" required>'; ?>
                        </div>
                        <div class="col-md-4">
                            <label for="inputApellido2" class="form-label">Apellido 2</label>
                            <?php echo '<input type="text" name="apellido2" value="' . $user['apellido2'] . '" class="form-control" id="inputApellido2" placeholder="Apellido 2" required>'; ?>
                        </div>
                        <div class="col-12">
                            <label for="inputEmail" class="form-label">Email</label>
                            <?php echo '<input type="email" name="email" value="' . $user['email'] . '" class="form-control" id="inputEmail" placeholder="Email" required>'; ?>
                        </div>
                        <div class="col-6">
                            <label for="inputUsuario" class="form-label">Usuario</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <?php echo '<input type="text" name="username" value="' . $user['username'] . '" placeholder="Usuario" class="form-control" id="inputUsuario" required>'; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" id="inputPassword">
                        </div>
                        <div class="col-md-4">
                            <label for="inputRol" class="form-label">Rol</label>
                            <select id="inputRol" class="form-select">
                                <option>SuperAdmin</option>
                                <option selected>Admin</option>
                            </select>
                        </div>
                    
                        <div class="row mb-3">
                        
                            <button type="submit" name="actualizar" value="actualizar" class="btn btn-next">Actualizar Usuario</button>
                    
                        </div>
                <?php 
                    }
                ?>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
   

    

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
