<?php
session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
require 'comunes/funciones.php';
$conn = conn();
if(isset($_POST["eliminar"]))
{
  
  $sql = "DELETE FROM users WHERE username = ?";
  $sentence = $conn->prepare($sql);
  $sentence->bind_param("s", $_POST["usuario"]);
  $sentence->execute();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ver Usuarios Webmin Docker Compose</title>
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
      <h1>Ver Usuarios</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="verUsuario.php">Usuarios</a></li>
          <li class="breadcrumb-item active">Ver Usuarios</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Rol</th>
                  <?php 
                    if($_SESSION['role'] == 1)
                    {
                  ?>
                      <th scope="col">Password</th>
                      <th scope="col">Update</th>
                      <th scope="col">Delete</th>
                  <?php
                    }
                  ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $sql = " ";
                    if($_SESSION['role'] != 1)
                    {
                      $sql = "SELECT * FROM users WHERE username != ? AND role != 1";
                      $sentence = $conn->prepare($sql);
                    }
                    else
                    {
                      $sql = "SELECT * FROM users WHERE username != ? AND role != 2 OR role != 1";
                      $sentence = $conn->prepare($sql);
                    }
                    $sentence->bind_param("s", $_SESSION['user']);
                    $sentence->execute();
                    $result = $sentence->get_result();
                    $count = 1;
                    while ($user = $result->fetch_assoc()) 
                    {
                      echo '<tr>';
                      echo '<th scope="row">'. $count .'</th>';
                      echo '<td>'. $user["username"] .'</td>';
                      if($user["role"] == 1)
                      {
                        echo '<td>Super Administrador</td>';
                      }
                      if($user["role"] == 2)
                      {
                        echo '<td>Administrador</td>';
                      }
                      if($_SESSION['role'] == 1)
                      {
                        echo '<td>'. $user['password'] .'</td>';
                        echo '<td><form action="actualizarUsuario.php" method="GET"><button type="submit" name="usuario" value="'. $user["username"] .'"class="btn usuario"><i class="bi bi-arrow-repeat"></i></button></form></td>';
                        //Mostrar modal
                        $varDeAyuda = 'document.getElementById("modalEliminar").style.display="block"';
                        ?><td><button type="submit" class="btn usuario" data-toggle="modal" data-target=".bd-example-modal-lg" onclick='<?php echo  $varDeAyuda;?>'><i class="bi bi-trash"></i></button></td>
                        <?php
                        
                      }
                      echo '</tr>';
                      $count++;
                    }
                  ?>
                </tbody>
              </table>

              <div class="row mb-3">
                <a href="crearUsuario.php">
                  <button type="submit" class="btn btn-next">Crear Usuario</button>
                </a>
              </div>
      <div id="modalEliminar" class="modal fade show" style="background-color: rgba(0,0,0,0.4);">
        <div class="modal-dialog modal-lg">  
          <div class="modal-content" >
            <div class="modal-header">
              <label for="inputName5" class="form-label">Seguro que quieres eliminarlo, escribe el nombre del usuario para confirmarlo</label>
            </div>
            <form action="verUsuario.php" method="POST">
            <input type="text" name="usuario" class="form-control" id="validacionDocker" placeholder="Escriba el nombre del usuario" required>
              <div class="row mb-3">
                <div class="col-sm-12">
                  <button onclick='document.getElementById("modalEliminar").style.display="none"' data-toogle="#"  type="submit" class="btn btn-primary">Cancelar</button>
                  <button type="submit" value="eliminar" name="eliminar" class="btn btn-primary">Aceptar</button>
                </div>
              </div>
            </form>
          </div>
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
