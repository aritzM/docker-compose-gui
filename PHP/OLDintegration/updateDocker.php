<?php
/********************************Version 0.0.1**********************************************************************************************/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
/*
* IMPORTANTE: en caso de querer configurar las contraseñas de mysql abria que añadir mas cosas al json. 
* de la misma forma pasa en caso de querer hacer configuraciones mas complejas de momento esto es la fase de pruebas y no hay muchas opciones.
*
* ADVERTENCIA: este script se usa de la siguiente forma: 
*     1.- Abrir una terminal (IMPORTANTE: tener instalado php)
*     2.- Ejecutar el siguiente comando: php updateDocker.php
* Al ser un metodo de pruebas los datos estan hardcodeados pero habra que recojer por el metodo Post los datos necesarios.
*/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/

//Todos los datos que hay que dar posibilidad a modificar, esto es hardcodeado

// Asi es es como reconoceremos a que contenedor tenemos que ejecutar los cambio
// "/home/" . $_SESSION["username"] . "-" . $_SESSION["selectedContainer"] . ".json"
$array = json_decode(file_get_contents("/home/aritz/docker.json"), true);

$array["container"]["volumes"]["mysql"][0] = "mysql/dbdata:/var/lib/mysql";
$array["container"]["volumes"]["apache2"][0] = "apache2/wordpress:/var/www/html";
$array["container"]["publicPorts"]["mysql"] = "3306";
$array["container"]["privatePorts"]["apache2"] = "80";

unset($array["container"]["services"][0]);
$array["container"]["services"] = array_values($array["container"]["services"]);

//Fin datos a los que hay que dar posibilidada a modificar

//Editar servicios
/*
if($updateServicios == true)
{
    $indexOfEditServ = array();
    $index = 0;

    if($eliminarServicios == true){
        // Editamos el servicio del json
        for($i = 0; $i < count($serviciosAEditar); $i++)
        {
            for($y = 0; $y < count($array["container"]["services"]); $y++)
            {
                if($array["container"]["services"][$y] == $serviciosAEditar[$i])
                {
                    $indexOfEditServ[$index] = $y;
                    $index++;
                }
            }
        }
        for($i = 0; $i < count($indexOfEditServ); $i++)
        {
            unset($array["container"]["services"][$indexOfEditServ[$i]]);
        }
        $array["container"]["services"] = array_values($array["container"]["services"]);
    }
    if($añadirServicios)
    {

    }
    
    
}*/

//Editar volumen
/*if($updateVolumen == true)
{
    if($deleteVolumen == true)
    {
        // Eliminamos el volumen del json
        $indexOfVolmToDel = array();
        if($mysql == true)
        {
            $index = 0;
            
            for($i = 0; $i < count($volumenesAEliminarMYSQL); $i++)
            {
                for($y = 0; $y < count($array["container"]["volumes"]["mysql"]); $y++)
                {
                    if($array["container"]["volumes"]["mysql"][$y] == $volumenesAEliminarMYSQL[$i])
                    {
                        $indexOfVolmToDel[$index] = $y;
                        $index++;
                    }
                }
            }
            for($i = 0; $i < count($indexOfVolmToDelMYSQL); $i++)
            {
                unset($array["container"]["volumes"]["mysql"][$indexOfVolmToDel[$i]]);
            }
        }
        if($apache2 == true)
        {
            $index = 0;

            for($i = 0; $i < count($volumenesAEliminarAPACHE2"); $i++)
            {
                for($y = 0; $y < count($array["container"]["volumes"]["apache2"]); $y++)
                {
                    if($array["container"]["volumes"]["mysql"][$y] == $volumenesAEliminarAPACHE2[$i])
                    {
                        $indexOfVolmToDel[$index] = $y;
                        $index++;
                    }
                }
            }
            for($i = 0; $i < count($indexOfVolmToDel); $i++)
            {
                unset($array["container"]["volumes"]["apache2"][$indexOfVolmToDelAPACHE2[$i]]);
            }
        }
    }
    else
    {
        // Editamos el volumen del json
        if($mysql == true)
        {
            for($i = 0; $i < count($volumenesAEditarMYSQL); $i++)
            {
                for($y = 0; $y < count($array["container"]["volumes"]["mysql"]); $y++)
                {
                    //$array["container"]["volumes"]["mysql"][$y] = "/mysql/dbdata:/var/lib/mysql";
                    if($array["container"]["volumes"]["mysql"][$y] == $volumenesAEditarMYSQL[$i]["viejo"])
                    {
                        $array["container"]["volumes"]["mysql"][$y] = $volumenesAEditarMYSQL[$i]["nuevo"];
                    }
                }
            }
        }
        if($apache2 == true)
        {
            for($i = 0; $i < count($volumenesAEditarAPACHE2); $i++)
            {
                for($y = 0; $y < count($array["container"]["volumes"]["apache2"]); $y++)
                {
                    //$array["container"]["volumes"]["apache2"][$y] = "/apache2/wordpress:/var/www/html";
                    if($array["container"]["volumes"]["apache2"][$y] == $volumenesAEditarAPACHE2[$i]["viejo"])
                    {
                        $array["container"]["volumes"]["apache2"][$y] = $volumenesAEditarAPACHE2[$i]["nuevo"];
                    }
                }
            }
        }
    }
}*/

//Editar Puertos
/*
if($updatePorts == true)
{
    if($pubic == true)
    {
        if($mysql == true)
        {
            $array["container"]["publicPorts"]["mysql"] = $puPuertosAEditarMYSQL;
        }
        if($apache2 == true)
        {
            $array["container"]["publicPorts"]["apache2"] = $puPuertosAEditarMYSQL;    
        }
    }
    if($private == true)
    {
        if($mysql == true)
        {
            $array["container"]["privatePorts"]["mysql"] = $ppPuertosAEditarMYSQL;
        }
        if($apache2 == true)
        {
            $array["container"]["privatePorts"]["apache2"] = $ppPuertosAEditarAPACHE2;
        }
    }
}
*/
// "/home/" . $_POST["execUser"] . "-" . $_POST["containerName"] . ".json"
file_put_contents("/home/aritz/docker.json", json_encode($array));

// Ejecutando este comando se rehace toda la configuracion el solo
exec("docker-managment-backend -i /home/aritz/docker.json -u");
?>
