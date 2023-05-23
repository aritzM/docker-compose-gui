<?php 
session_start();
if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}
require '../funciones.php';

if(!isset($_GET["cargar"])){
  if(isset($_GET["apache2"]) && isset($_GET["mysql"]) && isset($_GET["nginx"]) && isset($_GET["mongo"])) {
    $params["servicio1"]["name"] = "Apache";
    $params["servicio2"]["name"] = "Mysql";
    $params["servicio3"]["name"] = "Nginx";
    $params["servicio4"]["name"] = "Mongo";
    $params["servicio1"]["puertoPriv"] = "80";
    $params["servicio2"]["puertoPriv"] = "3306";
    $params["servicio3"]["puertoPriv"] = "8000";
    $params["servicio4"]["puertoPriv"] = "27017";
    mostrarPuertos(4, $params);
  } else {
    if(isset($_GET["apache2"]) && isset($_GET["mysql"]) && isset($_GET["nginx"])) {
      $params["servicio1"]["name"] = "Apache";
      $params["servicio2"]["name"] = "Mysql";
      $params["servicio3"]["name"] = "Nginx";
      $params["servicio1"]["puertoPriv"] = "80";
      $params["servicio2"]["puertoPriv"] = "3306";
      $params["servicio3"]["puertoPriv"] = "8000";
      mostrarPuertos(3, $params);
    } 
    elseif (isset($_GET["apache2"]) && isset($_GET["mysql"]) && isset($_GET["mongo"]))
    {
      $params["servicio1"]["name"] = "Apache";
      $params["servicio2"]["name"] = "Mysql";
      $params["servicio3"]["name"] = "Mongo";
      $params["servicio1"]["puertoPriv"] = "80";
      $params["servicio2"]["puertoPriv"] = "3306";
      $params["servicio3"]["puertoPriv"] = "27017";
      mostrarPuertos(3, $params);
    } 
    elseif (isset($_GET["apache2"]) && isset($_GET["mongo"]) && isset($_GET["nginx"]))
    {
      $params["servicio1"]["name"] = "Apache";
      $params["servicio2"]["name"] = "Mongo";
      $params["servicio3"]["name"] = "Nginx";
      $params["servicio1"]["puertoPriv"] = "80";
      $params["servicio2"]["puertoPriv"] = "27017";
      $params["servicio3"]["puertoPriv"] = "8000";
      
      mostrarPuertos(3, $params);
    }
    elseif (isset($_GET["nginx"]) && isset($_GET["mongo"]) && isset($_GET["mysql"]))
    {
      $params["servicio1"]["name"] = "Nginx";
      $params["servicio2"]["name"] = "Mongo";
      $params["servicio3"]["name"] = "Mysql";
      $params["servicio1"]["puertoPriv"] = "8000";
      $params["servicio2"]["puertoPriv"] = "27017";
      $params["servicio3"]["puertoPriv"] = "3306";
      mostrarPuertos(3, $params);
    } else {
      if (isset($_GET["apache2"]) && isset($_GET["mysql"])) {
        $params["servicio1"]["name"] = "Apache";
        $params["servicio2"]["name"] = "Mysql";
        $params["servicio1"]["puertoPriv"] = "80";
        $params["servicio2"]["puertoPriv"] = "3306";
        mostrarPuertos(2, $params);
      } 
      elseif (isset($_GET["apache2"]) && isset($_GET["nginx"])) 
      {
        $params["servicio1"]["name"] = "Apache";
        $params["servicio2"]["name"] = "Nginx";
        $params["servicio1"]["puertoPriv"] = "80";
        $params["servicio2"]["puertoPriv"] = "8000";
        mostrarPuertos(2, $params);
      }
      elseif (isset($_GET["apache2"]) && isset($_GET["mongo"]))
      {
        $params["servicio1"]["name"] = "Apache";
        $params["servicio2"]["name"] = "Mongo";
        $params["servicio1"]["puertoPriv"] = "80";
        $params["servicio2"]["puertoPriv"] = "27017";
        mostrarPuertos(2, $params);
      } 
      elseif (isset($_GET["mysql"]) && isset($_GET["nginx"])) 
      {
        $params["servicio1"]["name"] = "Mysql";
        $params["servicio2"]["name"] = "Nginx";
        $params["servicio1"]["puertoPriv"] = "3306";
        $params["servicio2"]["puertoPriv"] = "8000";
        mostrarPuertos(2, $params);
      } 
      elseif (isset($_GET["mysql"]) && isset($_GET["mongo"])) 
      {
        $params["servicio1"]["name"] = "Mysql";
        $params["servicio2"]["name"] = "Mongo";
        $params["servicio1"]["puertoPriv"] = "3306";
        $params["servicio2"]["puertoPriv"] = "27017";
        mostrarPuertos(2, $params);
      } 
      elseif (isset($_GET["mongo"]) && isset($_GET["nginx"])) 
      {
        $params["servicio1"]["name"] = "Mongo";
        $params["servicio2"]["name"] = "Nginx";
        $params["servicio1"]["puertoPriv"] = "27017";
        $params["servicio2"]["puertoPriv"] = "8000";
        mostrarPuertos(2, $params);
      } else {
        if(isset($_GET["apache2"])) {
          $params["servicio1"]["name"] = "Apache";
          $params["servicio1"]["puertoPriv"] = "80";
          mostrarPuertos(1, $params);
        }
        if(isset($_GET["mysql"])) {
          $params["servicio1"]["name"] = "Mysql";
          $params["servicio1"]["puertoPriv"] = "3306";
          mostrarPuertos(1, $params);
        }
        if(isset($_GET["nginx"])) {
          $params["servicio1"]["name"] = "Nginx";
          $params["servicio1"]["puertoPriv"] = "8000";
          mostrarPuertos(1, $params);
        }
        if(isset($_GET["mongo"])) {
          $params["servicio1"]["name"] = "Mongo";
          $params["servicio1"]["puertoPriv"] = "27017";
          mostrarPuertos(1, $params);
        }
      }
    }
  }
} else {
  if(isset($_GET["usuario"]) && isset($_GET["numeroContenedor"])){
    $container = json_decode(file_get_contents("/home/" . $_GET['usuario'] . "/docker-". $_GET["numeroContenedor"] . ".json"), true);
    if(isset($_GET["volumenes"])){
      //cargar volumenes
      cargarFilasVolumenes($container);
    }
    if(isset($_GET["puertos"])){
      //cargar puertos
      cargarPuertos($container);
    }
  }
}
?>