<?php
session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
if(isset($_POST["eliminar"]))
{
  require 'comunes/funciones.php';
  $contContainers = countServices($_SESSION['user']);
  if($contContainers != 0)
  {
    for($i=1;$i<=$contContainers;$i++)
    {
      $container = json_decode(file_get_contents("/home/" . $_SESSION['user'] . "/docker-". $i . ".json"), true);
      if($_POST["contenedor"] == $container["container"]["containerName"] && $_SESSION["user"] == $container["execUser"])
      {
        exec("echo L3h3nd@k@r1 | sudo docker-managment-backend -i /home/" . $_SESSION['user'] . "/docker-" . $i . ".json -d");
        exec("echo L3h3nd@k@r1 | sudo chown www-data:www-data /home/" . $_SESSION['user'] . "/docker-" . $i . ".json");
        exec("echo L3h3nd@k@r1 | sudo rm -R /home/" . $_SESSION['user'] . "/docker-" . $i . ".json");
      }
    }
    $contContainers = countServices($_SESSION['user']);
    for($i=1;$i<=$contContainers;$i++)
    {
      $numRename = $i + 1;
      exec("echo L3h3nd@k@r1 | sudo mv /home/" . $_SESSION['user'] . "/docker-" . $numRename . ".json /home/" . $_SESSION['user'] . "/docker-" . $i . ".json");
    }
  }
  header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Elegir Docker Webmin Docker Compose</title>
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
    
      <nav>
        <ol class="breadcrumb">
         
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
          <?php
            if(isset($_GET['tipo']))
            {
              require 'funciones.php';
              $contContainers = countServices($_SESSION['user']);
              if($_GET['tipo'] == 1)
              {
                if($contContainers != 0)
                {
                  for($i=1;$i<=$contContainers;$i++)
                  {
                    $container = json_decode(file_get_contents("/home/" . $_SESSION['user'] . "/docker-". $i . ".json"), true);
                    
                  
              
          ?>
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                      <div class="card info-card revenue-card">
                        <?php echo '<a href="actualizarDocker.php?contenedor=' . $i . '">'; ?>
                          <div class="card-body">
                            <h1 class="titu"><?php echo $container["container"]["containerName"]; ?></h1>
                          </div>
                        </a>
                      </div>
                    </div><!-- End Sales Card -->
          <?php 
                  }
                }
              }
              if($_GET['tipo'] == 2)
              {
                if($contContainers != 0)
                {
                  for($i=1;$i<=$contContainers;$i++)
                  {
                    $container = json_decode(file_get_contents("/home/" . $_SESSION['user'] . "/docker-". $i . ".json"), true);
          ?>
            <!-- Revenue Card -->
           
                    <div class="col-xxl-4 col-md-6" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="document.getElementById('modalEliminar').style.display='block'">
                      <div class="card info-card revenue-card">
                        <a href="#"><div class="card-body">
                        <h1 class="titu"><?php echo $container["container"]["containerName"]; ?></h1>
                        </a></div>

                      </div>
                    </div>
          <?php
                  }
                } 
              }
            }
          ?>
            </div><!-- End Sales Card -->
          </div>
        </div><!-- End Left side columns -->
      </div>

      <div id="modalEliminar" class="modal fade show" style="background-color: rgba(0,0,0,0.4);">
        <div class="modal-dialog modal-lg">
                
          <div class="modal-content" >
              <div class="modal-header">
                <label for="inputName5" class="form-label">Seguro que quieres eliminarlo, escribe el nombre del contenedor para confirmarlo</label>
              </div>
              <form action="elegir.php" method="POST">
                <input type="text" name="contenedor" class="form-control" id="validacionDocker" placeholder="Escriba el nombre del contenedor" required>
                <div class="row mb-3">
                    <div class="col-sm-12">
                      <button onclick='document.getElementById("modalEliminar").style.display="none"' data-toogle="#"  type="submit" class="btn btn-primary">Cancelar</button>
                      <button type="submit" value="eliminar" name="eliminar" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
              </form>
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