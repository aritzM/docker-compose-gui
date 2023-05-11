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
?>