<?php

// Falta recojer los volumenes

session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
if(isset($_POST["actualizar"]))
{
  $array = json_decode(file_get_contents("/home/" . $_SESSION['user'] . "/docker-" . $_SESSION["numCont"] . ".json"), true);
  
  if(isset($_POST["nombreServicio"]) && isset($_POST["descripcion"]))
  {
    
    $array["execUser"] = $_SESSION["user"];
    
    $array["container"]["containerName"] = $_POST["nombreServicio"];
    $array["container"]["descripcion"] = $_POST["descripcion"];
    
    if(isset($_POST["apache2"]) && isset($_POST["mysql"]))
    {
      $array["container"]["services"] = array("apache2","mysql");  
      $array["container"]["volumes"] = array(
                                              "mysql" => array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql"), 
                                              "apache2" => array("wordpress:/var/www/html/wordpress", ".htaccess:/var/www/html/.htaccess")
                                            );
      $array["container"]["publicPorts"] = array("apache2" => $_POST["puertoPublicApache"], "mysql" => $_POST["puertoPublicMysql"]);
      $array["container"]["privatePorts"] = array("apache2" => $_POST["puertoPrivApache"], "mysql" => $_POST["puertoPrivMysql"]);
      
    }
    else
    {
      if(isset($_POST["apache2"]))
      {
        $array["container"]["services"] = array("apache2");
        $array["container"]["volumes"] = array("apache2" => array("wordpress:/var/www/html/wordpress", ".htaccess:/var/www/html/.htaccess"));
        $array["container"]["publicPorts"] = array("apache2" => $_POST["puertoPublicApache"]);
        $array["container"]["privatePorts"] = array("apache2" => $_POST["puertoPrivApache"]);
      }
      if(isset($_POST["mysql"]))
      {
        $array["container"]["services"] = array("mysql");
        $array["container"]["volumes"] = array("mysql" => array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql"));
        $array["container"]["publicPorts"] = array("mysql" => $_POST["puertoPublicMysql"]);
        $array["container"]["privatePorts"] = array("mysql" => $_POST["puertoPrivMysql"]);
      }
    }
    exec("echo L3h3nd@k@r1 | sudo chmod 777 /home/" . $_SESSION["user"] . "/docker-" . $_SESSION["numCont"] . ".json");
    file_put_contents("/home/" . $_SESSION["user"] . "/docker-" . $_SESSION["numCont"] . ".json", json_encode($array));
    exec("echo L3h3nd@k@r1 | sudo chown " . $_SESSION["user"] . ":" . $_SESSION["user"] . " /home/" . $_SESSION["user"] . "/docker-" . $_SESSION["numCont"] . ".json");
    exec("echo L3h3nd@k@r1 | sudo docker-managment-backend -i /home/" . $_SESSION['user'] . "/docker-" . $_SESSION["numCont"] . ".json -u");
    unset($_SESSION["numCont"]);
    header("Location: dashboard.php");  
  }
  //exec("echo L3h3nd@k@r1 | sudo docker-managment-backend -p ". $_SESSION['user'] . "/" . $array["container"]["containerName"]);
  

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Actualizar Docker Webmin Docker Compose</title>
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
      <h1>Actualizar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Docker</a></li>
          <li class="breadcrumb-item active">Actualizar</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="card">
      <div class="card-body">
      <?php 
        if(isset($_GET['contenedor']))
        {
          $_SESSION["numCont"] = $_GET["contenedor"];
          $container = json_decode(file_get_contents("/home/" . $_SESSION['user'] . "/docker-". $_GET["contenedor"] . ".json"), true);
        
      ?>
          <!-- Vertical Pills Tabs -->
          <div class="d-flex align-items-start" id="myFormu">
            <div class="nav flex-column nav-pills me-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Nombre</button>
              <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Servicios</button>
              <!--<button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Volumenes</button>-->
              <button class="nav-link" id="v-pills-port-tab " data-bs-toggle="pill" data-bs-target="#v-pills-port  " type="button" role="tab" aria-controls="v-pills-port  " aria-selected="false">Puertos</button>
            </div>

            <form action="actualizarDocker.php" method="POST">
              <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                  
                    <div class="row mb-3">
                      <label for="inputText" class="col-sm-3 col-form-label">Nombre:</label>
                      <div class="col-sm-6">
                        <?php echo '<input type="text" name="nombreServicio" value="' . $container["container"]["containerName"] . '" placeholder="Nombre del Servicio Ej: Wordpress" class="form-control"/>'; ?>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="inputPassword" class="col-sm-4 col-form-label">Descripcion:</label>
                      <div class="col-sm-12">
                        <textarea class="form-control" name="descripcion" placeholder="Descripcion del Servicio" style="height: 100px"></textarea>
                      </div>
                    </div>
                  
                    <div class="row mb-3">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Next</button>
                      </div>
                    </div>
                    
                </div>
                  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Servicios</th>
                          <th scope="col">Apache2</th>
                          <th scope="col">Mysql</th>
                          <th scope="col">Mongo</th>
                          <th scope="col">Nginx</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="checkbox">
                          <th scope="row"></th>
                          <?php 
                            $tam1 = count($container["container"]["services"]);
                            $apache2 = false;
                            $mysql = false;
                            for($i=0;$i<$tam1;$i++)
                            {
                              if($container["container"]["services"][$i] == "apache2")
                              {
                                $apache2 = true;
                              }
                              if($container["container"]["services"][$i] == "mysql")
                              {
                                $mysql = true;
                              }
                            }
                            if($apache2 && $mysql)
                            {
                              echo '<td><input type="checkbox" name="apache2" checked></td>';
                              echo '<td><input type="checkbox" name="mysql" checked></td>';
                            }
                            else
                            {
                              if($apache2)
                              {
                                echo '<td><input type="checkbox" name="apache2" checked></td>';
                              }
                              else
                              {
                                echo '<td><input type="checkbox" name="apache2"></td>';
                              }
                              if($mysql)
                              {
                                echo '<td><input type="checkbox" name="mysql" checked></td>';
                              }
                              else
                              {
                                echo '<td><input type="checkbox" name="mysql"></td>';
                              }
                            }
                          ?>
                          <td><input type="checkbox" name="mongo"></td>
                          <td><input type="checkbox" name="nginx"></td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="row mb-3">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Back</button>
                        <button type="submit" class="btn btn-next">Next</button>
                      </div>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <!-- Esto se deberia de generar dependiendo de que checkbox se haya clickado -->
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Volumen</th>
                          <th scope="col">Apache</th>
                          <th scope="col">Mysql</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td><input type="text" name="volumenApache1" class="form-control" placeholder="volumen1:volumenDocker"></td>
                          <td><input type="text" name="volumenMysql1" class="form-control" placeholder="volumen1:volumenDocker"></td>
                          
                        
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td><input type="text" name="volumenApache2" class="form-control" placeholder="volumen2:volumenDocker"></td>
                          <td><input type="text" name="volumenMysql2" class="form-control" placeholder="volumen2:volumenDocker"></td>
                          
                        
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td><input type="text" name="volumenApache3" class="form-control" placeholder="volumen3:volumenDocker"></td>
                          <td><input type="text" name="volumenMysql3" class="form-control" placeholder="volumen3:volumenDocker"></td>
                        
              
                        </tr>
                        
                        
                      </tbody>
                    </table>

                    <div class="row mb-3">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Back</button>
                        <button type="submit" class="btn btn-next">Next</button>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="v-pills-port" role="tabpanel" aria-labelledby="v-pills-port-tab">
                    <!--Este apartado se deberia de generar dependiendo de los servicios añadidos en el checkbox de servicios-->
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Puertos</th>
                          <th scope="col">Privado</th>
                          <th scope="col">Publico</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">Apache</th>
                          <?php
                            echo '<td><input type="text" name="puertoPrivApache" value="'. $container["container"]["privatePorts"]["apache2"] . '" class="form-control" placeholder="80"></td>';
                            echo '<td><input type="text" name="puertoPublicApache" value="'. $container["container"]["publicPorts"]["apache2"] . '" class="form-control" placeholder="8080"></td>';
                          ?>
                        </tr>
                        <tr>
                          <th scope="row">Mysql</th>
                          <?php
                            echo '<td><input type="text" name="puertoPrivMysql" value="'. $container["container"]["privatePorts"]["mysql"] . '" class="form-control" placeholder="80"></td>';
                            echo '<td><input type="text" name="puertoPublicMysql" value="'. $container["container"]["publicPorts"]["mysql"] . '" class="form-control" placeholder="8080"></td>';
                          ?>
                        </tr>
                      
                        
                      </tbody>
                    </table>

                    <div class="row mb-3">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Back</button>
                        <button type="submit" value="actualizar" name="actualizar" class="btn btn-next">Finish</button>
                      </div>
                    </div>
                  </div>

              </div>
            </form>
          </div>
        <!-- End Vertical Pills Tabs -->
      <?php 
        } 
      ?>
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
