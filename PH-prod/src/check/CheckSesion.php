<?php
include_once 'database.php';//Incluye la base de datos.
session_start();//Sesion para mantener las variables de validar.php.
$dbb = new Database();//Se crea instancia para la conexion de base de datos.

/* Si no se ha obtenido nombre o permisos, redirecciona a index.php. Esto lo hago pues sino
se podria acceder a cualquiera de los archivos .php con su ruta completa. Este archivo estara
incluido en la gran mayoria de nuestros archivos.*/
if (empty($_SESSION["nombre"]) || empty($_SESSION["tipo"])) {
        //Si no hay sesión redirecciono al fromulario de inicio de sesion.
        header('Location: index.php');
}

//Si tenemos el nombre y el tipo(permiso del usuario)...
$tipo = $_SESSION["tipo"];//Asigno los permisos a una variable
$nombre = $_SESSION["nombre"];//Asigno nombre a una variable

/*Se comprueba los permisos del usuario para ver que elementos del menu tenemos que enseñar.
Primero enseñaremos los permisos que puede tener los elementos del menu
-En el menu se encuentran los siguiente permisos:
    - 3 :Solo tendra acceso el superusuario
    - 1 :Tendra acceso el superusuario y administrador.
    - 2 :Tendre acceso el superusuario y administrador y el invitado.
-Los usuarios tengan los siguiente permisos.
    -Superusuario(S): Tendra acceso a todos los los elemnetos del menu.
    -Administrador(A): Tendra acceso solo a los elemnetos con permiso menu 1 y 2
    -Invitado(N): Tendra acceso solo a los elementos del menu con permiso 2.
El header.php se encargara de mostrar los elementos del menu en funcion del los
permisos que tenga el usuario. Se han realizado 2 consultas a la base de datos para el menu, 
una para cuando estemos en pantalla web y otra para cuando estemos en movil*/
switch ($tipo) {
    case 'S': //Caso S,super usuario, se muestran todos los elementos
        $query = $dbb->connect()->prepare("SELECT * FROM menu");
        $query2 = $dbb->connect()->prepare("SELECT * FROM menu");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query2->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $query2->execute();
        break;
    case 'N'://Caso N, no admin o invitado , solo muestra los elementos menu que solo tenga permiso = 2
        $query = $dbb->connect()->prepare("SELECT * FROM menu 
        where permisos = 2 ");
        $query2= $dbb->connect()->prepare("SELECT * FROM menu 
        where permisos = 2 ");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query2->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $query2->execute();
        break;
    case 'A'://Caso A, administrador, muestra los elementos donde permisos = 1 y permisos = 2.
        $query = $dbb->connect()->prepare("SELECT * FROM menu 
        where permisos = 1 OR permisos = 2 ");
        $query2 = $dbb->connect()->prepare("SELECT * FROM menu 
        where permisos = 1 OR permisos = 2 ");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query2->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $query2->execute();
        break;
} 
$dbb = null;//Cerramos la base de datos que consulta que elementos del menu queremos mostrar.
    
?>