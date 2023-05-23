<?php

define("APACHE2_SERVICE_NAME","apache2");
define("APACHE2_STRING_NAME","Apache");
define("MYSQL_SERVICE_NAME","mysql");
define("MYSQL_STRING_NAME","Mysql");
define("MONGO_SERVICE_NAME","mongo");
define("MONGO_STRING_NAME","Mongo");
define("NGINX_SERVICE_NAME","nginx");
define("NGINX_STRING_NAME","Nginx");

function conn()
{
    //Desarrollo (Local)
    //$conn = new mysqli('localhost','testuser','Almi123','DockerComposeGui');
    //PreProduccion (Maquina Desarrollo)
    $conn = new mysqli('localhost','akaenterprises','L3h3nd@k@r1','DockerComposeGui');
    //Produccion (Maquina Produccion)
    //$conn = new mysqli('192.168.1.54','user','L0z@rr@6','DockerComposeGui');
    if ($conn->connect_error) 
    {
    die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function login($conn,$username,$password)
{
    $login = array("login" => false, "role" => null, "nombre" => null);   
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $sentence = $conn->prepare($sql);
    $sentence->bind_param("ss", $username, $password);
    $sentence->execute();
    $result = $sentence->get_result();
    $user = $result->fetch_assoc();
    
    $numUser = count($user);
    if($numUser > 0)
    {
      $login["login"] = true;
      $login["role"] = $user["role"];
      $login["nombre"] = $user["nombre"] . " " . $user["apellido1"] . " " . $user["apellido2"];
    }
    return $login;
}
function countServices($user)
{
  $contContainers = (exec("ls /home/" . $user . "/ | wc -l") / 2);
  $contContainers = round($contContainers, 0, PHP_ROUND_HALF_DOWN);
  return $contContainers;
}
function insertUsu($conn,$nombre,$apellido1,$apellido2,$email,$username,$password)
{
  $result = "El usuario ya existe";
  $sql = "SELECT * FROM users WHERE username = ?";
  $sentence = $conn->prepare($sql);
  $sentence->bind_param("s", $username);
  $sentence->execute();
  $result = $sentence->get_result();
  $user = $result->fetch_assoc();  
  $numUser = count($user);
  if($numUser == 0)
  {
    $sql = "INSERT INTO users VALUES (null,?,?,?,?,?,?,2)";
    //Ejecutar esta insert para crear el usuario
    $sentence = $conn->prepare($sql);
    $sentence->bind_param("ssssss", $nombre, $apellido1, $apellido2, $email, $username, $password);
    if($sentence->execute())
    {
      $resutl = "Usuario Insertado correctamente";
    }
  }
  return $result;
}
function actualizarUsuario($conn,$nombre,$apellido1,$apellido2,$email,$username,$password,$oldUsu)
{
    $sql = "UPDATE users SET nombre = ?, apellido1 = ?, apellido2 = ?, email = ?, username = ?, password = ? WHERE username = ?";
    $sentence = $conn->prepare($sql);
    $sentence->bind_param('sssssss', $nombre,$apellido1,$apellido2,$email,$username,$password,$oldUsu);
    $sentence->execute();
}
function componerDockerJSON($usuario, $nombreContenedor, $descripcion, $cantidadServicios, $params){
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
  $docker["execUser"] = $usuario;

  $docker["container"]["containerName"] = $nombreContenedor;
  $docker["container"]["descripcion"] = $descripcion;

  $servicios = array();
  $volumes = array();
  $publicPorts = array();
  $privatePorts = array();
  
  for($i = 1; $i <= $cantidadServicios; $i++){
    $servicios[$i-1] = $params["servicio".$i.""]["name"];  
    $volumes[$params["servicio".$i.""]["name"]] = array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql");
    $publicPorts[$params["servicio".$i.""]["name"]] = $params["servicio".$i.""]["puertoPublic"];
    $privatePorts[$params["servicio".$i.""]["name"]] = $params["servicio".$i.""]["puertoPriv"];
  }
  
  $docker["container"]["services"] = $servicios;
  $docker["container"]["volumes"] = $volumes;
  $docker["container"]["privatePorts"] = $privatePorts;
  $docker["container"]["publicPorts"] = $publicPorts;

  return $docker;
}

function mostrarPuertos($countServicios, $params){
  $openedPorts = checkOpenedPorts();
  for($i = 1; $i <= $countServicios; $i++){
    mostrarUnPuertos($params["servicio".$i.""], $openedPorts);
  }
}

function mostrarUnPuertos($param, $openedPorts) {
  echo "<tr>";
  echo "<th scope=\"row\">". $param["name"] ."</th>";
  echo "<td><input type=\"text\" name=\"puertoPriv". $param["name"] ."\" class=\"form-control\" value=\"". $param["puertoPriv"] ."\" readonly></td>";
  echo "<td><select name=\"puertoPublic". $param["name"] ."\" class=\"form-control\" >";
  
  for($i = 0; $i < count($openedPorts); $i++){
    echo "<option value=\"".$openedPorts[$i]."\">".$openedPorts[$i]."</option>";
  }
  echo "</select></td></tr>";
}

function checkOpenedPorts(){
  $result = array();
  $count = 0;
  //Max ports in server: 65535
  for($i = 8000; $i < 20000; $i++){
    if(checkPortOpen($i) != true){
      $result[$count] = $i;
      $count++;
    }
  }
  return $result;
}

function checkPortOpen($port){
  $result = false;
  if(fsockopen("localhost",$port))
  {
    $result = true;
  }
  return $result;
}

function cargarPuertos($data){
  $openedPorts = checkOpenedPorts();
  for($i=0; $i<count($data["container"]["services"]); $i++){
    echo "<tr>";
    $nombre = "";
    if($data["container"]["services"][$i] == APACHE2_SERVICE_NAME){
      $nombre = APACHE2_STRING_NAME;
    }
    if($data["container"]["services"][$i] == MYSQL_SERVICE_NAME){
      $nombre = MYSQL_STRING_NAME;
    }
    if($data["container"]["services"][$i] == MONGO_SERVICE_NAME){
      $nombre = MONGO_STRING_NAME;
    }
    if($data["container"]["services"][$i] == NGINX_SERVICE_NAME){
      $nombre = NGINX_STRING_NAME;
    }
    echo "<th scope=\"row\">". $nombre ."</th>";
    echo "<td><input type=\"text\" name=\"puertoPriv". $nombre ."\" class=\"form-control\" value=\"". $data["container"]["privatePorts"][$data["container"]["services"][$i]] ."\" readonly></td>";
    echo "<td><select name=\"puertoPublic". $nombre ."\" class=\"form-control\" >";
    $puesto = false;
    for($y = 0; $y < count($openedPorts); $y++){
      if(!$puesto){
        echo "<option value=\"".$data["container"]["publicPorts"][$data["container"]["services"][$i]]." selected\">".$data["container"]["publicPorts"][$data["container"]["services"][$i]]."</option>";
        $puesto=true;
      }
      echo "<option value=\"".$openedPorts[$y]."\">".$openedPorts[$y]."</option>";
    }
    echo "</select></td></tr>";
  }
}

function crearFilaVolumen($data, $countFila){
  $htmlResult = "";
  for($i=0; $i < count($data["container"]["services"]); $i++){
    $htmlResult = $htmlResult . crearColumnaVolumenDServicio($data, $data["container"]["services"][$i], $countFila);
  }
  return $htmlResult;
}

function maxVolumenes($data){
  $maxResult = 0;
  for($i=0; $i < count($data["container"]["services"]); $i++){
    $nombreServicio = $data["container"]["services"][$i];
    if($maxResult < count($data["container"]["volumes"][$nombreServicio])){
      $maxResult = count($data["container"]["volumes"][$data["container"]["services"][$i]]);
    }
  }
  return $maxResult;
}

function cargarFilasVolumenes($data){
  $countFila = 0;
  while($countFila < maxVolumenes($data)){
    $htmlResult = crearFilaVolumen($data, $countFila); 
    echo "<tr>";
    echo "<th scope=\"row\">". ($countFila + 1) ."</th>";
    echo $htmlResult;
    echo "</tr>";
    $countFila++;
  }
}

function crearColumnaVolumenDServicio($data, $nombreServicio, $filaObtener){
  $data["container"]["volumes"][$nombreServicio][$filaObtener];
  $htmlResult = "<td><input type=\"text\" name=\"volumenApache1\" value=\"".$data["container"]["volumes"][$nombreServicio][$filaObtener]."\" class=\"form-control\" placeholder=\"volumen1:volumenDocker\"></td>";
  return $htmlResult;
}

?>