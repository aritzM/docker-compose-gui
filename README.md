# Docker Compose GUI

## Notas Para desarrolladores 

### Estructura y explicacion de la misma
- Carpeta DB ahi reside el script.sql que se ejecutara en MySql con el diseño de la BBDD y un usuario de pruebas que luego se borra.

- OLDIntegration es donde reside los antiguos archivos que eran ejemplos de como crear actualizar y eliminar una sola maquina esos archivo no se usan en ningun momento

- Python-Tool ahi es donde reside la herramienta que usamos para ejecutar comandos en el sistema, en este caso para crear contenedores y manejar los datos relacionados a el tanto como el usuario que lo ha creado donde reside el contenedor, que carpetas tenemos enlazadas y donde, el puerto, servicios etc. Eso lo manejara en parte python y parte PHP que lo que hara sera interpretar ese JSON ubicado en la carpeta del usuario ademas de existir uno por cada contenedor. Por otra parte tiene un test.py que prueba la herramienta antes de desplegarla por si existen fallos de compilacion etc. casque la maquina de desarrollo o produccion y no se pueda continuar el desarrollo.

- WEB contendra toda la aplicacion en este caso la interfaz grafica que maneja los datos y realizar acciones como crear contenedores.
### IMPORTANTE
La estructura puede llegar a cambiar ya que falta el desarrollo JAVA que sera la herramienta final. Por lo tanto estar atentos a que esta estructura no vaya cambiando con el tiempo.

## Continuo Desarrollo

### IMPORTANTE

Este proyecto esta sin finalizar puede que existan errores que no hemos contemplado los desarrolladores, por favor si encuentra algun error comuniquelo en el apartado de issues de este repositorio. Ademas se necesita tener configurado la herramienta python y la maquina de cierta forma.

## Lista de cosas por hacer

### GitLab Despliegue
- [ ] Falta añadir HTTPS a la maquina de GitLab
- [ ] Mejorar despliegue GitLab
    - [ ] Los archivos de configuracion que haya que tocar en la maquina se deberia de hacer en el despliegue
    - [ ] Importante todos los archivos que se suelen pasar en el depliegue se cargan en variables de GitLab por lo tanto en este repo no estan los scripts de despliegue habra que redesarrollarlos
    - [ ] Instalacion de dependencias desde GitLab a maquina, habra que determinar si las tiene instaladas, urls de ayuda:
        - https://phoenixnap.com/kb/install-docker-on-ubuntu-20-04
        - https://phoenixnap.com/kb/install-docker-compose-on-ubuntu-20-04
    - [ ] Importante retirar la carpeta .git de la ruta de despliegue. Dos formas de hacerlo los archivos que se copian en la ruta del servicio web cambiar el destino a otra carpeta eliminar la carpeta .git y despues copiar a la ruta a desplegar o eliminar la carpeta git directamente.
- [ ] Desplegar el Proyecto Java
- [ ] Crear test para Java (Si se puede)
- [ ] Crear test para PHP (Si se puede)
### PHP
- [ ] Dar la capacidad de eleguir el tipo de imagen
- [ ] Mejorar los servicios que se pueden configurar en el contenedor
- [ ] Crear correctamente los volumenes
- [ ] Dar acceso a la terminal del contenedor desde la pagina web
- [ ] Para el anterior punto tendra que estar desarrollado un sistema de roles
- [ ] El usuario podra elegir los recursos que se destinan al contenedor.

### JAVA
- [x] Crear el proyecto dentro de otra carpeta del repo y separarlo del proyecto PHP
- [ ] Conexion a BBDD para login
- [ ] Comprobar uso de la herramienta Python
- [x] Crear commonsDockerGui, dockerGui, dockerGuiWS. En coommonsDockerGui ira la mayoria de las logicas, llamadas a python, llamadas a BBDD etc. En dockerGuiWS se realizaran las llamadas a BBDD y todos los datos se enviaran mediante JSON. En dockerGui tendremos la pagina responiva con la structura que tenia asta ahora pero lleno de jsp o jspf hay que tener en cuanta que habra que hacer comprobaciones para ello <c:if>. Habra que investigar bastante.
- [ ] Importante Crear Dtos tanto para llamadas a WS como para respuesta WS
- [ ] Crear los archivos .properties necesarios.
- [ ] Una vez llegado a este punto, intentar desplegar con GitLab.
- [ ] Despues implementar asta el punto de PHP

### Documentacion

- https://www.howtoforge.com/how-to-install-and-configure-gitlab-on-ubuntu-20-04/
- https://www.fosstechnix.com/how-to-install-gitlab-runner-on-ubuntu/
