<?php
/********************************Version 0.0.1**********************************************************************************************/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
/*
* IMPORTANTE: en caso de querer configurar las contraseñas de mysql abria que añadir mas cosas al json. 
* de la misma forma pasa en caso de querer hacer configuraciones mas complejas de momento esto es la fase de pruebas y no hay muchas opciones.
* ADVERTENCIA: este script se usa de la siguiente forma: 
*     1.- Abrir una terminal (IMPORTANTE: tener instalado php)
*     2.- Ejecutar el siguiente comando: php createDocker.php
* Al ser un metodo de pruebas los datos estan hardcodeados pero habra que recojer por el metodo Post los datos necesarios.
*/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
$docker = array("execUser" => "aritz", 
                "container" => 
                       array("containerName" => "wordpress", 
                              "services" => array("apache2", "mysql", "php"), 
                              "volumes" => 
                                  array("mysql" => array("dbdata:/var/lib/mysql", "script.sql:/dbScript/script.sql"), 
                                        "apache2" => array("wordpress:/var/www/html/wordpress", ".htaccess:/var/www/html/.htaccess")
                                       ), 
                              "publicPorts" => 
                                    array("apache2" => "8080", 
                                          "mysql" => "33306"
                                         ), 
                              "privatePorts" => 
                                    array("apache2" => "8080", 
                                           "mysql" => "3306"
                                         )
                            )
               );
//exec("mkdir /home/aritz");
$fp = fopen('/docker-aritz.json', 'w');
fwrite($fp, json_encode($docker));
fclose($fp);
exec("docker-managment-backend -i /docker-aritz.json -c");
// Composicion de docker final, para crear mas de un docker y poder modificarlos.
// "/home/" . $_POST["execUser"] . "-" . $_POST["containerName"] . ".json"
exec("mv /docker-aritz.json /home/aritz/docker.json");

?>
