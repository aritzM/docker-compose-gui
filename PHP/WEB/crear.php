<?php

// Falta recojer los volumenes

session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
require 'comunes/funciones.php';
if(isset($_POST["crear"]))
{
  $exec = false;
  $docker = array("execUser" => null,
                  "container" => 
                       array("containerName" => null, 
                             "descripcion" => null,
                             "services" => null, 
                             "volumes" => null, 
                             "publicPorts" => null, 
                             "privatePorts" => null
                            )
               );
  if(isset($_POST["nombreServicio"]) && isset($_POST["descripcion"])) {
    if(isset($_POST["apache2"]) && isset($_POST["mysql"]) && isset($_POST["nginx"]) && isset($_POST["mongo"])) {
      $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
      $params["servicio2"]["name"] = MYSQL_SERVICE_NAME;
      $params["servicio3"]["name"] = NGINX_SERVICE_NAME;
      $params["servicio4"]["name"] = MONGO_SERVICE_NAME;
      $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
      $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMysql"];
      $params["servicio3"]["puertoPublic"] = $_POST["puertoPublicNginx"];
      $params["servicio4"]["puertoPublic"] = $_POST["puertoPublicMongo"];
      $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
      $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
      $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivNginx"];
      $params["servicio4"]["puertoPriv"] = $_POST["puertoPrivMongo"];
      $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 4, $params);
    } else {
      if(isset($_POST["apache2"]) && isset($_POST["mysql"]) && isset($_POST["nginx"])) {
        $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
        $params["servicio2"]["name"] = MYSQL_SERVICE_NAME;
        $params["servicio3"]["name"] = NGINX_SERVICE_NAME;
        $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
        $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMysql"];
        $params["servicio3"]["puertoPublic"] = $_POST["puertoPublicNginx"];
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
        $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
        $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivNginx"];
        $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 3, $params);
      } 
      elseif (isset($_POST["apache2"]) && isset($_POST["mysql"]) && isset($_POST["mongo"]))
      {
        $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
        $params["servicio2"]["name"] = MYSQL_SERVICE_NAME;
        $params["servicio3"]["name"] = MONGO_SERVICE_NAME;
        $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
        $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMysql"];
        $params["servicio3"]["puertoPublic"] = $_POST["puertoPublicMongo"];
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
        $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
        $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivMongo"];
        $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 3, $params);
      } 
      elseif (isset($_POST["apache2"]) && isset($_POST["mongo"]) && isset($_POST["nginx"]))
      {
        $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
        $params["servicio2"]["name"] = MONGO_SERVICE_NAME;
        $params["servicio3"]["name"] = NGINX_SERVICE_NAME;
        $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
        $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMongo"];
        $params["servicio3"]["puertoPublic"] = $_POST["puertoPublicNginx"];
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
        $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
        $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivNginx"];
        $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 3, $params);
      }
      elseif (isset($_POST["nginx"]) && isset($_POST["mongo"]) && isset($_POST["mysql"]))
      {
        $params["servicio1"]["name"] = NGINX_SERVICE_NAME;
        $params["servicio2"]["name"] = MONGO_SERVICE_NAME;
        $params["servicio3"]["name"] = MYSQL_SERVICE_NAME;
        $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicNginx"];
        $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMongo"];
        $params["servicio3"]["puertoPublic"] = $_POST["puertoPublicMysql"];
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivNginx"];
        $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
        $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivMysql"];
        $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 3, $params);
      } else {
        if (isset($_POST["apache2"]) && isset($_POST["mysql"])) {
          $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
          $params["servicio2"]["name"] = MYSQL_SERVICE_NAME;
          $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
          $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMysql"];
          $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
          $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
          $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 2, $params);
        } 
        elseif (isset($_POST["apache2"]) && isset($_POST["nginx"])) 
        {
          $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
          $params["servicio2"]["name"] = NGINX_SERVICE_NAME;
          $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
          $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicNginx"];
          $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
          $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivNginx"];
          $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 2, $params);
        }
        elseif (isset($_POST["apache2"]) && isset($_POST["mongo"]))
        {
          $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
          $params["servicio2"]["name"] = MONGO_SERVICE_NAME;
          $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
          $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMongo"];
          $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
          $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
          $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 2, $params);
        } 
        elseif (isset($_POST["mysql"]) && isset($_POST["nginx"])) 
        {
          $params["servicio1"]["name"] = MYSQL_SERVICE_NAME;
          $params["servicio2"]["name"] = NGINX_SERVICE_NAME;
          $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicMysql"];
          $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicNginx"];
          $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMysql"];
          $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivNginx"];
          $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 2, $params);
        } 
        elseif (isset($_POST["mysql"]) && isset($_POST["mongo"])) 
        {
          $params["servicio1"]["name"] = MYSQL_SERVICE_NAME;
          $params["servicio2"]["name"] = MONGO_SERVICE_NAME;
          $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicMysql"];
          $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicMongo"];
          $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMysql"];
          $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
          $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 2, $params);
        } 
        elseif (isset($_POST["mongo"]) && isset($_POST["nginx"])) 
        {
          $params["servicio1"]["name"] = MONGO_SERVICE_NAME;
          $params["servicio2"]["name"] = NGINX_SERVICE_NAME;
          $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicMongo"];
          $params["servicio2"]["puertoPublic"] = $_POST["puertoPublicNginx"];
          $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMongo"];
          $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivNginx"];
          $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 2, $params);
        } else {
          if(isset($_POST["apache2"])) {
            $params["servicio1"]["name"] = APACHE2_SERVICE_NAME;
            $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicApache"];
            $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
            $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 1, $params);
          }
          if(isset($_POST["mysql"])) {
            $params["servicio1"]["name"] = MYSQL_SERVICE_NAME;
            $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicMysql"];
            $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMysql"];
            $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 1, $params);
          }
          if(isset($_POST["nginx"])) {
            $params["servicio1"]["name"] = NGINX_SERVICE_NAME;
            $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicNginx"];
            $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivNginx"];
            $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 1, $params);
          }
          if(isset($_POST["mongo"])) {
            $params["servicio1"]["name"] = MONGO_SERVICE_NAME;
            $params["servicio1"]["puertoPublic"] = $_POST["puertoPublicMongo"];
            $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMongo"];
            $docker = componerDockerJSON($_SESSION["user"], $_POST["nombreServicio"], $_POST["descripcion"], 1, $params);
          }
        }
      }
    }
    echo "<pre>" . print_r(json_encode($docker)) . "</pre>";
    $fp = fopen('/var/www/html/docker-compose-gui/JSONs/docker-'. $_SESSION['user'] .'.json', 'w');
    fwrite($fp, json_encode($docker));
    fclose($fp);
    exec("echo L3h3nd@k@r1 | sudo docker-managment-backend -i /var/www/html/docker-compose-gui/JSONs/docker-". $_SESSION['user'] .".json -c");
    $contContainers = countServices($_SESSION['user']);
    $contContainers++;
    exec("echo L3h3nd@k@r1 | sudo mv /var/www/html/docker-compose-gui/JSONs/docker-". $_SESSION['user'] .".json /home/". $_SESSION['user'] ."/docker-" . $contContainers . ".json");
    header("Location: dashboard.php");  
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Crear Docker Webmin Docker Compose</title>
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
  <script type="text/javascript">
    var actualizar=false;
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="js/script.js"></script>

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
    /*$result = checkOpenedPorts();
    for($i = 0; $i < count($result); $i++){ 
      $result[$i];
    }*/
  ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Crear</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Docker</a></li>
          <li class="breadcrumb-item active">Crear</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="card">
      <div class="card-body">

        <!-- Vertical Pills Tabs -->
        <div class="d-flex align-items-start" id="myFormu">
          <div class="nav flex-column nav-pills me-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-home-tab"   type="button" role="tab"  aria-selected="true">Nombre</button>
            <button class="nav-link" id="v-pills-profile-tab"   type="button" role="tab"  aria-selected="false">Servicios</button>
            <button class="nav-link" id="v-pills-messages-tab"   type="button" role="tab"  aria-selected="false">Volumenes</button>
            <button class="nav-link" id="v-pills-port-tab"     type="button" role="tab"  aria-selected="false">Puertos</button>
          </div>

          <form action="crear.php" method="POST">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                
                  <div class="row mb-10">
                    <label for="inputText" class="col-sm-4 col-form-label">Nombre:</label>
                    <div class="col-sm-10">
                      <input type="text" name="nombreServicio" placeholder="Nombre del Servicio Ej: Wordpress" class="form-control">
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
                      <button  class="btn btn-next" id="1">Next</button>
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
                      <tr class="checkbox" id="checkbox">
                        <th scope="row"></th>
                        <td><input type="checkbox" name="apache2"></td>
                        <td><input type="checkbox" name="mysql"></td>
                        <td><input type="checkbox" name="mongo"></td>
                        <td><input type="checkbox" name="nginx"></td>
                      </tr>
                    </tbody>
                  </table>
                  


                  <div class="row mb-3">
                    <div class="col-sm-10">
                      <button type="button" class="btn btn-primary" aria-controls="v-pills-profile" id="volver-1" >Back</button>
                      <button  type="button" class="btn btn-next" aria-controls="v-pills-profile" id="2">Next</button>
                    </div>
                  </div>

                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                  <!-- Esto se deberia de generar dependiendo de que checkbox se haya clickado -->
                  <table class="table" id="tabla">
                    <thead >
                      <tr>
                        <th scope="col">Nº Volumen</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <div class="row mb-3">
                    <div class="col-sm-10">
                      <button type="button" class="btn btn-primary" id="volver-2" >Back</button>
                      <button type="button" class="btn btn-primary" id="anadirVolumen" >Añadir Volumenes</button>
                      <button type="button" class="btn btn-next" id="3">Next</button>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="v-pills-port" role="tabpanel" aria-labelledby="v-pills-port-tab">
                  <!--Este apartado se deberia de generar dependiendo de los servicios añadidos en el checkbox de servicios-->
                  <table class="table" id="tablaPuertos">
                    <thead>
                      <tr>
                        <th scope="col">Puertos</th>
                        <th scope="col">Privado</th>
                        <th scope="col">Publico</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>

                  <div class="row mb-3">
                    <div class="col-sm-10">
                      <button type="button" class="btn btn-primary" id="volver-3">Back</button>
                      <button type="submit" value="crear" name="crear" class="btn">Finish</button>
                    </div>
                  </div>
                </div>

            </div>
          </form>
        </div>
        <!-- End Vertical Pills Tabs -->

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
  <sc src="assets/vendor/apexcharts/apexcharts.min.js"></sc>
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
