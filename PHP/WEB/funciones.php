<?php
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

  if($cantidadServicios == 1){
    $docker = componerDockerJSONUnServicio($docker, $params);
  }
  if($cantidadServicios == 2){
    $docker = componerDockerJSONDosServicios($docker, $params);
  }
  if($cantidadServicios == 3){
    $docker = componerDockerJSONTresServicios($docker, $params);
  }
  if($cantidadServicios == 4){
    $docker = componerDockerJSONCuatroServicios($docker, $params);
  }
  return $docker;
}

function componerDockerJSONUnServicio($docker, $params){
  $docker["container"]["services"] = array($params["servicio1"]["name"]);  
  $docker["container"]["volumes"] = array($params["servicio1"]["name"] => array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql"));
  $docker["container"]["publicPorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPublic"]);
  $docker["container"]["privatePorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPriv"]);
  return $docker;
}

function componerDockerJSONDosServicios($docker, $params){
  $docker["container"]["services"] = array($params["servicio1"]["name"],$params["servicio2"]["name"]);  
  $docker["container"]["volumes"] = array(
                                          $params["servicio1"]["name"] => array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql"), 
                                          $params["servicio2"]["name"] => array("wordpress:/var/www/html/wordpress", ".htaccess:/var/www/html/.htaccess")
                                        );
  $docker["container"]["publicPorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPublic"], 
                                              $params["servicio2"]["name"] => $params["servicio2"]["puertoPublic"]
                                            );
  $docker["container"]["privatePorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPriv"],
                                               $params["servicio2"]["name"] => $params["servicio2"]["puertoPriv"]
                                            );
  return $docker;
}

function componerDockerJSONTresServicios($docker, $params){
  $docker["container"]["services"] = array($params["servicio1"]["name"],$params["servicio2"]["name"],$params["servicio3"]["name"]);  
  $docker["container"]["volumes"] = array(
                                          $params["servicio1"]["name"] => array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql"), 
                                          $params["servicio2"]["name"] => array("wordpress:/var/www/html/wordpress", ".htaccess:/var/www/html/.htaccess"),
                                          $params["servicio3"]["name"] => array("dbdata:/var/lib/nginx", "script.sql:/dbScript/script.sql")
                                        );
  $docker["container"]["publicPorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPublic"], 
                                              $params["servicio2"]["name"] => $params["servicio2"]["puertoPublic"], 
                                              $params["servicio3"]["name"] => $params["servicio3"]["puertoPublic"] 
                                            );
  $docker["container"]["privatePorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPriv"],
                                               $params["servicio2"]["name"] => $params["servicio2"]["puertoPriv"],
                                               $params["servicio3"]["name"] => $params["servicio3"]["puertoPriv"]
                                            );
  return $docker;
}

function componerDockerJSONCuatroServicios($docker, $params){
  $docker["container"]["services"] = array($params["servicio1"]["name"],$params["servicio2"]["name"],$params["servicio3"]["name"],$params["servicio4"]["name"]);  
  $docker["container"]["volumes"] = array(
                                          $params["servicio1"]["name"] => array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql"), 
                                          $params["servicio2"]["name"] => array("wordpress:/var/www/html/wordpress", ".htaccess:/var/www/html/.htaccess"),
                                          $params["servicio3"]["name"] => array("dbdata:/var/lib/nginx", "script.sql:/dbScript/script.sql"), 
                                          $params["servicio4"]["name"] => array("wordpress:/var/www/html/wordpress", ".htaccess:/var/www/html/.htaccess")
                                        );
  $docker["container"]["publicPorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPublic"], 
                                              $params["servicio2"]["name"] => $params["servicio2"]["puertoPublic"], 
                                              $params["servicio3"]["name"] => $params["servicio3"]["puertoPublic"], 
                                              $params["servicio4"]["name"] => $params["servicio4"]["puertoPublic"]
                                            );
  $docker["container"]["privatePorts"] = array($params["servicio1"]["name"] => $params["servicio1"]["puertoPriv"],
                                               $params["servicio2"]["name"] => $params["servicio2"]["puertoPriv"],
                                               $params["servicio3"]["name"] => $params["servicio3"]["puertoPriv"],
                                               $params["servicio4"]["name"] => $params["servicio4"]["puertoPriv"]
                                            );
  return $docker;
}
?>