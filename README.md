# Docker Compose GUI


## Importante

Este proyecto esta sin finalizar puede que existan errores que no hemos contemplado los desarrolladores, por favor si encuentra algun error comuniquelo en el apartado de issues de este repositorio. Ademas se necesita tener configurado la herramienta python y la maquina de cierta forma.

```
cd existing_repo
git remote add origin https://akagitlab.duckdns.org/akaenterprises/docker-compose-gui.git
git branch -M main
git push -uf origin main
```
## Lista de cosas por hacer

### GitLab Despliegue
- [ ] Mejorar despliegue GitLab
    - [ ] Los archivos de configuracion que haya que tocar en la maquina se deberia de hacer en el despliegue
    - [ ] Importante todos los archivos que se suelen pasar en el depliegue se cargan en variables de GitLab por lo tanto en este repo no estan los scripts de despliegue habra que redesarrollarlos
    - [ ] Instalacion de dependencias desde GitLab a maquina, habra que determinar si las tiene instaladas
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
- [ ] Crear el proyecto dentro de otra carpeta del repo y separarlo del proyecto PHP
- [ ] Conexion a BBDD para login
- [ ] Comprobar uso de la herramienta Python
- [ ] Crear commonsDockerGui, dockerGui, dockerGuiWS. En cocommonsDockerGui ira la mayoria de las logicas, llamadas a python, llamadas a BBDD etc. En dockerGuiWS se realizaran las llamadas a BBDD y todos los datos se enviaran mediante JSON. En dockerGui tendremos la pagina responiva con la structura que tenia asta ahora pero lleno de jsp o jspf hay que tener en cuanta que habra que hacer comprobaciones para ello <c:if>. Habra que investigar bastante.
- [ ] Importante Crear Dtos tanto para llamadas a WS como para respuesta WS
- [ ] Crear los archivos .properties necesarios.
- [ ] Una vez llegado a este punto, intentar desplegar con GitLab.
- [ ] Despues implementar asta el punto de PHP
