<?php
session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ver Docker Webmin Docker Compose</title>
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
      <h1>Ver Docker</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Inicio</a></li>
          <li class="breadcrumb-item active">Ver Docker</li>
        </ol>
        <div class="card">
          <div class="card-body">
            <?php 
            if(isset($_GET["contenedor"]))
            {
              $container = json_decode(file_get_contents("/home/" . $_SESSION['user'] . "/docker-". $_GET["contenedor"] . ".json"), true);
              echo '<H2>Nombre contenedor: '. $container["container"]["containerName"] .'</H2>';
              $tam = count($container["container"]["services"]);
              for($i=0;$i<$tam;$i++)
              { 
                echo '<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Serv: ' . $container["container"]["services"][$i] . '</h3>';
                if($container["container"]["services"][$i] == "mysql")
                {
                  $tam1 = count($container["container"]["volumes"]["mysql"]);
                  for($y=0;$y<$tam1;$y++)
                  { 
                    echo '<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volumen: ' . $container["container"]["volumes"]["mysql"][$y] .'</h5>';
                    //echo '<h1>' . $container["container"]["volumes"]["mysql"][$i] .'</h1>';
                  }
                  echo '<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puerto: ' . $container["container"]["publicPorts"]["mysql"] . '</h5>';
                  //echo '<h1>' . $container["container"]["publicPorts"]["mysql"] .'</h1>';
                }
                if($container["container"]["services"][$i] == "apache2")
                {
                  $tam1 = count($container["container"]["volumes"]["apache2"]);
                  for($y=0;$y<$tam1;$y++)
                  { 
                    echo '<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volumen: ' . $container["container"]["volumes"]["apache2"][$y] .'</h5>';
                    //echo '<h1>' . $container["container"]["volumes"]["mysql"][$i] .'</h1>';
                  }
                  echo '<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puerto: ' . $container["container"]["publicPorts"]["apache2"] . '</h5>';
                  //echo '<h1>' . $container["container"]["publicPorts"]["mysql"] .'</h1>';
                }
              }
            
            ?>

          </div>
        
        <div>
        
        
      </nav>
    </div><!-- End Page Title -->
      
    

      
    <div class="row mb-1">
      <div class="col-sm-7">
          <form action="actualizarDocker.php" method="GET">
            <?php echo '<button type="submit" name="contenedor" value="'. $_GET["contenedor"] .'" class="btn btn-primary">Modificar</button>';?>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="document.getElementById('modalEliminar').style.display='block'">Borrar</a>
          </form>
      </div>
    </div>
      <div id="modalEliminar" class="modal fade show" style="background-color: rgba(0,0,0,0.4);">
        <div class="modal-dialog modal-lg">
                
          <div class="modal-content" >
              <div class="modal-header">
                <label for="inputName5" class="form-label">Seguro que quieres eliminarlo, escribe el nombre del contenedor para confirmarlo</label>
              </div>
                <input type="text" name="nombre" class="form-control" id="validacionDocker" placeholder="Escriba el nombre del contenedor" required>
                <div class="row mb-3">
                    <div class="col-sm-12">
                      <button onclick='document.getElementById("modalEliminar").style.display="none"' data-toogle="#"  type="submit" class="btn btn-primary">Cancelar</button>
                      <button type="submit" value="crear" name="crear" class="btn btn-primary">Aceptar</button>
                    </div>
              </div>
            
          </div>
        </div>


      <?php
        }
    
      ?>
      
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
