<?php 
session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
require '../funciones.php';
if(isset($_POST["apache2"]) && isset($_POST["mysql"]) && isset($_POST["nginx"]) && isset($_POST["mongo"])) {
  $params["servicio1"]["name"] = "apache2";
  $params["servicio2"]["name"] = "mysql";
  $params["servicio3"]["name"] = "nginx";
  $params["servicio4"]["name"] = "mongo";
  $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
  $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
  $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivNginx"];
  $params["servicio4"]["puertoPriv"] = $_POST["puertoPrivMongo"];
  mostrarPuertos(4, $params);
} else {
  if(isset($_POST["apache2"]) && isset($_POST["mysql"]) && isset($_POST["nginx"])) {
    $params["servicio1"]["name"] = "apache2";
    $params["servicio2"]["name"] = "mysql";
    $params["servicio3"]["name"] = "nginx";
    $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
    $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
    $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivNginx"];
    mostrarPuertos(3, $params);
  } 
  elseif (isset($_POST["apache2"]) && isset($_POST["mysql"]) && isset($_POST["mongo"]))
  {
    $params["servicio1"]["name"] = "apache2";
    $params["servicio2"]["name"] = "mysql";
    $params["servicio3"]["name"] = "mongo";
    $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
    $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
    $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivMongo"];
    mostrarPuertos(3, $params);
  } 
  elseif (isset($_POST["apache2"]) && isset($_POST["mongo"]) && isset($_POST["nginx"]))
  {
    $params["servicio1"]["name"] = "apache2";
    $params["servicio2"]["name"] = "mongo";
    $params["servicio3"]["name"] = "nginx";
    $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
    $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
    $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivNginx"];
    mostrarPuertos(3, $params);
  }
  elseif (isset($_POST["nginx"]) && isset($_POST["mongo"]) && isset($_POST["mysql"]))
  {
    $params["servicio1"]["name"] = "nginx";
    $params["servicio2"]["name"] = "mongo";
    $params["servicio3"]["name"] = "mysql";
    $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivNginx"];
    $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
    $params["servicio3"]["puertoPriv"] = $_POST["puertoPrivMysql"];
    mostrarPuertos(3, $params);
  } else {
    if (isset($_POST["apache2"]) && isset($_POST["mysql"])) {
      $params["servicio1"]["name"] = "apache2";
      $params["servicio2"]["name"] = "mysql";
      $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
      $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMysql"];
      mostrarPuertos(2, $params);
    } 
    elseif (isset($_POST["apache2"]) && isset($_POST["nginx"])) 
    {
      $params["servicio1"]["name"] = "apache2";
      $params["servicio2"]["name"] = "nginx";
      $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
      $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivNginx"];
      mostrarPuertos(2, $params);
    }
    elseif (isset($_POST["apache2"]) && isset($_POST["mongo"]))
    {
      $params["servicio1"]["name"] = "apache2";
      $params["servicio2"]["name"] = "mongo";
      $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
      $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
      mostrarPuertos(2, $params);
    } 
    elseif (isset($_POST["mysql"]) && isset($_POST["nginx"])) 
    {
      $params["servicio1"]["name"] = "mysql";
      $params["servicio2"]["name"] = "nginx";
      $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMysql"];
      $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivNginx"];
      mostrarPuertos(2, $params);
    } 
    elseif (isset($_POST["mysql"]) && isset($_POST["mongo"])) 
    {
      $params["servicio1"]["name"] = "mysql";
      $params["servicio2"]["name"] = "mongo";
      $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMysql"];
      $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivMongo"];
      mostrarPuertos(2, $params);
    } 
    elseif (isset($_POST["mongo"]) && isset($_POST["nginx"])) 
    {
      $params["servicio1"]["name"] = "mongo";
      $params["servicio2"]["name"] = "nginx";
      $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMongo"];
      $params["servicio2"]["puertoPriv"] = $_POST["puertoPrivNginx"];
      mostrarPuertos(2, $params);
    } else {
      if(isset($_POST["apache2"])) {
        $params["servicio1"]["name"] = "apache2";
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivApache"];
        mostrarPuertos(1, $params);
      }
      if(isset($_POST["mysql"])) {
        $params["servicio1"]["name"] = "mysql";
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMysql"];
        mostrarPuertos(1, $params);
      }
      if(isset($_POST["nginx"])) {
        $params["servicio1"]["name"] = "nginx";
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivNginx"];
        mostrarPuertos(1, $params);
      }
      if(isset($_POST["mongo"])) {
        $params["servicio1"]["name"] = "mongo";
        $params["servicio1"]["puertoPriv"] = $_POST["puertoPrivMongo"];
        mostrarPuertos(1, $params);
      }
    }
  }
}

?>