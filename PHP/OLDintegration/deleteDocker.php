<?php
/********************************Version 0.0.1**********************************************************************************************/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
/*
* ADVERTENCIA: este script se usa de la siguiente forma: 
*     1.- Abrir una terminal (IMPORTANTE: tener instalado php)
*     2.- Ejecutar el siguiente comando: php updateDocker.php
* Al ser un metodo de pruebas los datos estan hardcodeados pero habra que recojer por el metodo Post los datos necesarios.
*/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/

//Del json general tendremos que recojer el json que hace referencia al docker que se quiere eliminar ademas de comprobar que sea ese


// Asi es es como reconoceremos que contenedor tenemos que eliminar
// "/home/" . $_POST["execUser"] . "-" . $_POST["containerName"] . ".json"
exec("docker-managment-backend -i /home/aritz/docker.json -d");
exec("rm /home/aritz/docker.json");

// Eliminar la ruta del archivo en el json general

?>
