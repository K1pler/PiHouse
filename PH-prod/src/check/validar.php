<?php
    require_once 'database.php';//Incluimos la conexion de la base de datos
	session_start();//Iniciamos sesion.
    
    // Comprobamos que los campos de index.php no estan vacios.
    if (!empty($_POST['email']) && !empty($_POST['pass']) ) { 
       $email=$_POST['email'];		//Asignamos los enviado por post a unas variables
       $pass=$_POST['pass'];

        $db = new Database();//Creamos la instancia para conectar con la base de datos.

        /*Creamos la query para buscar el mail en la base de datos. Utilizamos los metodos
        prepare() y bindParam() para evitar la injeccion sql*/
        $query = $db->connect()->prepare("SELECT * FROM us3rs WHERE ema1l = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        /*Usamos PDO::FETCH_ASSOC para que nos devuleva un array results indexado por 
        los nombres de las columnas del conjunto de resultados.
        */
        $results = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($results) {
            /* Utilizamos password_verify() pues la contraseña introducida en el formulario
            se debe comparar con el hash que esta almacenado en la tabla de usuarios. Todas
            las contraseñas estan cifradas y no en texto plano.A password_verify le pasamos
            la pass del formulario y el indice del array result correspondiente con el hash.
            */
            if (password_verify($pass, $results['passw0rd'])) {//Verificacion ok
                $_SESSION["nombre"] = $results["nombre"]; //Guardo el nombre del usuario
                $_SESSION["id"] = $results["id"];
                $_SESSION["tipo"] = $results["tipo"];//Guardamos esta key para ver sus permisoss
                header("Location: home.php");
            } else { //Verificacion no ok
                $_SESSION['messagei'] = 'Error nombre o correo invalidos';
                $_SESSION['message_typei'] = 'danger';
                header("Location. index.php");  
            }
        } else {//Caso en que la contraseña no sea correcta para ese usuario.
            $_SESSION['messagei'] = 'Error nombre o correo invalidos';
            $_SESSION['message_typei'] = 'danger';
            header("Location. index.php");
        }
        $db = null;//Cierra la conexion que consulta el mail
    }
?>