#!/usr/bin/python3
import sys, getopt, json, os

# Version 0.0.1

# 1.- Comprobar antes de crear el usuario si ya existe para no crearlo dos veces (Haciendo)
# 2.- Crear todos los volumenes necesarios para ejecutar el contenedor, habra que plantear como si solo permitiremos carpetas o tambien archivos (Haciendo)



# Funcion que se ejecuta cada vez que lanzamos el script
def main(argv):
   # Archivo json que nos entra por parametro
   data = ''
   # Variable que nos permitira obligar al usuario pasar un archivo .json como argumento
   isInput = False
   # Esto es importante para editar el docker-compose.yml
   jsonFileName = ''
   # Esto es importante para saber si se han ejecutado todos los comandos o no y poder devolver la variable que haya que el test devuelva OK/KO
   executeCorrect = False
   try:
      # argumentos1:argumentos2 = comando argumento1.1 argumento2.1
      #                           comando argumento1.2 argumento2.1
      #                           comando argumento1.1 argumento2.2
      #                           comando argumento1.2 argumento2.2 
      #                           ....
      # Intentamos cojer los parametros
      opts, args = getopt.getopt(argv,"hisp:cdu",["ifile="])
      print(args)
   # Controlamos la excepcion de que no esperabamos el argumento
   except getopt.GetoptError:
      # Llamamos a la funcion que muestra el manual
      manual()
      # Exit del script
      sys.exit(2)
   # Recorremos todos los argumentos que nos han pasado es una dupla [('argumento1', 'paremetro1'), ('argumento2', 'parametro2')]
   for opt, arg in opts:
      # -h o --help para mostrar la ayuda del script y nos diga el uso del script
      if opt == '-h':
         # Llamamos a la funcion que muestra el manual
         manual()
         sys.exit()
      # Si nos pasan el argumento -i (Abrimos el archivo que nos han pasado por parametro)
      if opt in ("-i", "--ifile"):
         # Cambiamos el estado de la variable a true para marcar que si nos han pasado el archivo .json
         isInput = True
         # En caso de que nos hayan pasado un archivo json abrimos el archivo
         jsonfile = open(args[0])
         # Cargamos los datos del archivo
         data = json.load(jsonfile)
         # Cerramos el archivo json
         jsonfile.close()
         # Esto es importante para editar el docker-compose.yml, ademas de devolver el Test OK/KO
         jsonFileName = args[0]
         # Esto hara que el test devuelva OK
         executeCorrect = True
         if len(args) > 1:
            # Si nos pasan el argumento -c (Creamos el docker-compose.yml y lo ejecutamos)
            if args[1] == "-c":
               # Llamamos a la funcion que comprueba si hemos pasado por parametro el archivo .json
               isJSON(isInput)
               # Llamamos a la funcion que creara el usuario
               createUser(data)
               # Llamamos a la funcion que crea el docker
               createDockerComposeFile(data)
               # Ejecutar docker habra que buscar la forma de ejecutar con el usuario
               os.system("runuser -l " + data["execUser"] + " -c 'cd /home/" + data["execUser"]+ "/" + data["container"]["containerName"] + " && docker-compose up -d'")
               # Esto hara que el test devuelva OK
               executeCorrect = True
               # Si nos pasan el argumento -u (Paramos el docker-compose.yml en especifico, agregamos las nuevas modificaciones y volvemos a ejecutar)
            if args[1] == "-u":
               # Llamamos a la funcion que comprueba si hemos pasado por parametro el archivo .json
               isJSON(isInput)
               updateDockerComposeFile(data, jsonFileName)
               # Esto hara que el test devuelva OK
               executeCorrect = True   
               # Si nos pasan el argumento -d (Paramos y eliminamos el docker-compose.yml en especifico)
            if args[1] == "-d":
               # Llamamos a la funcion que comprueba si hemos pasado por parametro el archivo .json
               isJSON(isInput)
               deleteDockerComposeFile(data)
               # Esto hara que el test devuelva OK
               executeCorrect = True         
      if opt in ('-s', '--ifile'):
         data = args[0].split("/")
         os.system("runuser -l " + data[0] + " -c 'cd /home/" + data[0] + "/" + data[1] + " && docker-compose down'")
      if opt in ('-p', '--ifile'):
         data = arg.split("/")
         os.system("runuser -l " + data[0] + " -c 'cd /home/" + data[0] + "/" + data[1] + " && docker-compose up -d'")
      # Si nos pasan el argumento -u (Paramos el docker-compose.yml en especifico, agregamos las nuevas modificaciones y volvemos a ejecutar)
      # Si nos pasan el argumento -u (Paramos el docker-compose.yml en especifico, agregamos las nuevas modificaciones y volvemos a ejecutar)
      
   # Esto es importante para devolver el Test OK/KO
   if(executeCorrect == True):
      return jsonFileName
# Funcion que nos permite crear el usuario
def createUser(data):
   # Comprobamos que el no exista antes de crearlo si existe no hacemos nada
   if os.system("id -u " + data["execUser"]) != 0:   
      # Creamos el usuario que se nos pide en el archivo .json que se nos pasa en el argumento por linea de comando
      os.system('useradd ' + data["execUser"])
      # Lo creamos sin contraseña ya que este usuario no tendra acceso a la terminal pero si que tiene que existir como tal en el sistema por si queremos darle permisos en concreto
      os.system('passwd -d ' + data["execUser"])
      # Creamos el home del usuario
      os.system('mkdir /home/' + data["execUser"])
      # Le damos permisos al usuario sobre su home
      os.system('chown ' + data["execUser"] + ":" + data["execUser"] + " -R /home/" + data["execUser"])
      os.system('chmod 755 -R /home/' + data["execUser"])
      # Especificamos el directorio del usuario
      os.system('usermod -d /home/'+ data["execUser"] + " " + data["execUser"])
      # Le decimos que puede acceder a la terminal
      os.system('usermod -s /bin/bash ' + data["execUser"])
      #Importante: para ejecutar docker con este usuario se debera de ejectuar la siguiente linea: 
      os.system('usermod -aG docker ' + data["execUser"])

# Funcion en el que creamos y escribimos el docker-compose.yml con los datos que nos pasan en el archivo .json
def createDockerComposeFile(data):
   #Comprobamos que exista la ruta antes de crearla si existe no la creamos
   if not os.path.exists('/home/' + data["execUser"] + '/' + data["container"]["containerName"]):
      # Creamos la carpeta que contendra el docker-compose.yml (home del usuario + (Carpeta)nombreContenedor = /home/usuario/nombreContenedor/docker-compose.yml)
      os.system('mkdir /home/' + data["execUser"] + '/' + data["container"]["containerName"])
   # Abrimos el archivo docker-compose.yml
   dockerComposeFile = open("/home/" + data["execUser"] + "/" + data["container"]["containerName"] + "/docker-compose.yml", "w")
   # Escribimos en el archivo docker-compose.yml (IMPORTANTE: los espacios en blanco tambien se escribe en el archivo)
   # Primera parte del archivo que no se necesita comrpobar ni recorrer nada
   dockerComposeFile.write("version: '3'\n" +
   "services:\n")
   # Segunada parte del archivo donde es necesario comprobar si existe algun servicio relacionado con este apartado
   # en el archivo .json data["container"]["services"] => array("servicio1", "servicio2"), para este caso tendremos que buscar el que
   # indique "mysql", "apache2", etc.
   # Recorremos el array de servicios para saber que parte tenemos que escribir y cual no 
   for services in data["container"]["services"]:
      if services == "mysql":
         # (OPCIONAL) Eleccion de imagen para la bbdd 
         dockerComposeFile.write(
         "   db-" + data["container"]["containerName"] + ":\n" +
         "     image: mysql:8.0\n" +
         "     container_name: db-" + data["container"]["containerName"] + "\n"
         "     volumes:\n")
   
         # En esta parte recorremos el array de volumenes para el servicio mysql.
         for volumes in data["container"]["volumes"]["mysql"]:
            # os.system("mkdir /home/" + data["execUser"] + "/" + data["container"]["containerName"] + "/" + volumes)
            dockerComposeFile.write("       - ./" + volumes + "\n")
         
         # Esto no queremos que se repita tantas veces como volumenes existen en el array por lo tanto lo dejamos fuera del bucle para que
         # se ponga una unica vez.   
         dockerComposeFile.write(
         "     environment:\n" +
         "       - MYSQL_ROOT_PASSWORD=password\n" +
         "       - MYSQL_USER=user\n" +
         "       - MYSQL_PASSWORD=password\n"+
         "     ports:\n" +
         "       - '" + data["container"]["publicPorts"]["mysql"] + ":" + data["container"]["privatePorts"]["mysql"] + "'\n")
      if services == "apache2":
         dockerComposeFile.write(
         "   web-" + data["container"]["containerName"] + ":\n" +
         "     image: httpd:latest\n" +
         "     container_name: web-" + data["container"]["containerName"] + "\n" +
         "     volumes:\n")
         
         # Recorremos los volumenes necesarios para el servicio apache2
         for volumes in data["container"]["volumes"]["apache2"]:
            # os.system("mkdir")
            dockerComposeFile.write("       - ./" + volumes + "\n")
         
         # Esta parte no queremos que se repita tantas veces como volumenes existentes haya asique lo dejamos fuera del array
         dockerComposeFile.write(
         "     ports:\n" +
         "       - '" + data["container"]["publicPorts"]["apache2"] + ":" + data["container"]["privatePorts"]["apache2"] + "'\n")
   # Cerramos el archivo docker-compose.yml         
   dockerComposeFile.close()

# Funcion que nos permitira modificar el archivo docker-compose.yml 
def updateDockerComposeFile(data, jsonFileName):
   
   # Paramos los dockers que estan en ejecuccion
   os.system("runuser -l " + data["execUser"] + " -c 'cd /home/" + data["execUser"] + "/" + data["container"]["containerName"] + " && docker-compose down'")
   # Nos llamamos a nosotros mismos para recrear el docker-compose.yml y lanzar de nuevo los contenedores (No necesitamos mas datos ya que se han modificado 
   # en el json y por esta parte solo hay que interpretarlo y rehacer el archivo de configuracion, por eso nos llamamos porque tenemos todos los datos ya)
   os.system("docker-managment-backend -i " + jsonFileName + " -c")

# Funcion que nos permitira eliminar el archivo docker-compose.yml y todo lo que tenga que ver con los contenedores en concreto (En desarrollo)
def deleteDockerComposeFile(data):
   os.system("runuser -l " + data["execUser"] + " -c 'cd /home/" + data["execUser"] + "/" + data["container"]["containerName"] + " && docker-compose down'")
   os.system("rm -R /home/" + data["execUser"] + "/" + data["container"]["containerName"])
   
# Funcion que nos muestra el manual de uso
def manual():
   print("Create: docker-managment-backend -i <inputfile> -c\n" +
            "Update: docker-managment-backend -i <inputfile> -u\n" +
            "Delete: docker-managment-backend -i <inputfile> -d" +
            "Stop Container of an user: docker-managment-backend -s <user|containerName>\n" + 
            "Play Container of an user: docker-managment-backend -p <user|containerName>")

# Funcion que comprueba que nos hayan pasado por argumento el archivo .json, en caso de no haberselo pasado muestra un error y unos pasos a seguir.
def isJSON(isInput):
   if isInput == False:
      print("IlegalArgumentException: Is necesary .json file directory argument, please check de manual with -h argument")
      sys.exit()

# Ejecucion principal
if __name__ == "__main__":
   main(sys.argv[1:])
   
      

