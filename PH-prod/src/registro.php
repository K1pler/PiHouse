<?php
include_once 'database.php';//Conexion base de datos.
include 'check/CheckSesion.php';//Chequeo de sesion.
include 'structure/header.php';//Cabezera con el menu.
ob_start();//Funcion primitiva de php para evitar error de cabezeras
$db_email = new Database();
//Declaracion variables de notificacion de error.
$_SESSION["nameErr"] = "";
$_SESSION["emailErr"] = "";
$_SESSION["passErr"] = "";
//Declaracion de variables para asignar valores.
$name = $email = $pass = "";


//VALIDACION DE FORMULARIO , ASIGNACION DE VARIABLES DE ERROR E INSERCION DE USUARIOS.

if ($_POST) {// Si se envian datos por el formulario
  
  //Primero se chequea de que los campos no esten vacíos. Después, el formato.
  
  if (empty($_POST["nombre"])) {//Si no se ha enviado nada por el campo nombre
    $_SESSION["nameErr"] = "Nombre requerido";//Asignacion de la variavle de error.
  } else {
      $name = test_input($_POST["nombre"]);//Asignamos a $nombre el valor introducido por nombre.
      // Nos aseguramos que el nombre tenga letras,numeros y espacios blancos.
      if (!preg_match("/^[a-zA-Z0-9' ]*$/",$name)) {//Si el nombre tiene caracteres no permitidos...
        $_SESSION["nameErr"] = "Caracteres no permitidos.";//Error caracteres no validos.
        unset($_POST["nombre"]);//Borramos el valor nombre que se ha enviado por el campo nombre.
      }
  }

  if (empty($_POST["email"])) {//Si el campo email está vacio...
    $_SESSION["emailErr"] = "Email requerido";//Asginacion de la variable error email
  } else {
    $email = test_input($_POST["email"]);//Asignamos a $email el valor que introducimos
    // Nos aseguramos que el email se ha escrito en el formato correcto.
    //Para este proceso se utiliza variables predefinidas de php.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {//Si el formato es incorrecto...
      $_SESSION["emailErr"] = "Formato de email invalido";//Mensaje de error email
      unset($_POST["email"]);//Borramos el valor enviado por el campo email.
    }
  }

  if (empty($_POST["pass"])) {//Si el campo contraseña esta vacío.
    $_SESSION["passErr"] = "Contraseña requerida";//Asignacion de la variavle error contraseña
  } else {
      if (strlen($_POST["pass"]) < 4 ) {//Comprobamos la longitud de la contraseña tiene que ser
        //mayor de cuatro caracteres.
        $_SESSION["passErr"] = "La contraseña debe contener mas de 4 caracteres.Se recomienda
        el uso de mayusculas minusculas y caracteres especiales";//Asignacion de mensaje de error
        //de contraseña
        unset($_POST["pass"]);//Borrar el valor enviado por el campo contraseña.
      } 
  }

  //Vuelvo a comporobar que los campos del formulario no estan vacios.
  if ( !empty($_POST["nombre"]) && !empty($_POST["email"]) && !empty($_POST["pass"]) 
      && !empty($_POST["tipo"]) )
  {
    //Query para comporbar si el email esta en uso
    $query_check = $db_email->connect()->prepare("SELECT count(*) FROM us3rs 
    WHERE ema1l = :email");
    $query_check->bindParam(':email', $_POST["email"]);
    $query_check->execute();
    $nrows = $query_check->fetchColumn();
    $db_email = null;
    
    //Querry para comprobar si el nombre de usuario esta en uso.
    $db_nombre_usuario = new Database();
    $query_check2 = $db_nombre_usuario->connect()->prepare("SELECT count(*) FROM us3rs 
    WHERE nombre = :nombre");
    $query_check2->bindParam(':nombre', $_POST["nombre"]);
    $query_check2->execute();
    $nrows2 = $query_check2->fetchColumn();
    $db_nombre_usuario = null;

    if ($nrows > 0) {//Si el correo esta en uso, mensaje de error.
      $_SESSION['message'] = 'Correo en uso.';
      $_SESSION['message_type'] = 'danger';
    }elseif($nrows2 > 0) {//Si el nombre esta en uso, mensaje de error
      $_SESSION['message'] = 'Nombre en uso.';
      $_SESSION['message_type'] = 'danger';
    }else{
      //Despues de haber pasado la validacion y ver si el nombre de usuario y correo no estan en uso.
      //Se procede a crear un usuario en la base de datos.
      $db_guardar_usuario = new Database();
      $query = $db_guardar_usuario->connect()->prepare("INSERT INTO us3rs (nombre,ema1l,passw0rd,tipo) 
      VALUES (:nombre, :email, :password, :tipo)");
      $query->bindParam(':nombre', $_POST["nombre"]);
      $query->bindParam(':email', $_POST["email"]);
      //A destacar que las contraseñas se insertan encriptadas.
      $password_hash = password_hash($_POST["pass"], PASSWORD_BCRYPT);
      $query->bindParam(':password', $password_hash );
      $query->bindParam(':tipo', $_POST["tipo"]);
      $resultado = $query->execute();
      $db_guardar_usuario = null;
      unset($_POST["nombre"]);
      unset($_POST["email"]);
      unset($_POST["tipo"]);

      if(!$resultado) {//Mensajes error creacion
        
        $_SESSION['message'] = 'Error al crear el usuario';
        $_SESSION['message_type'] = 'success';
        die();
      }else{//Mensaje de exito en la creacion de usuario
        unset($_POST["nombre"]);
        unset($_POST["email"]);
        unset($_POST["tipo"]);
        $_SESSION['message'] = 'Usuario correctamente creado';
        $_SESSION['message_type'] = 'success';
        $name="";
        $email="";
      }
    }
  }  
}
function test_input($data) {//Funcion para validar formato de nombre, correo.
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//FIN DE VALIDACION DE FORMULARIO , ASIGNACION DE VARIABLES DE ERROR E INSERCION DE USUARIOS.

//Esta cosulta es para poder mostrar los tipos de usuarios en un combobox.
    $db_tipo_usuario = new Database();
    $queryUsu = $db_tipo_usuario->connect()->prepare("SELECT * FROM tipoUsu");
    $queryUsu->setFetchMode(PDO::FETCH_ASSOC);
    $queryUsu->execute();
    $db_tipo_usuario = null;
?>
<br>
<br>
<br>
<div class="w3-row">
   
   <!-- Mensajes -->
   <?php if (isset($_SESSION['message'])) { ?>
          <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
    <?php unset($_SESSION['message']); } ?>
    <!-- Mensajes -->

  <!-- Formulario -->
  <div class="w3-container w3-quarter">
      <form action="registro.php" method="POST">
          <!-- Los campos se rellenan con un echo de una variable que ha sido validada en las 
          3 primeras validadciones del principio. -->
          
          Nombre: <input autocomplete="off" class="w3-input w3-border" type="text" name="nombre" value="<?php echo $name;?>">
          <!-- En caso de que haya un error en la validación, la vaiable de error de ese campo
          deja de ser nula y se muestra el error de que el campo esta vacio-->
          <span>* <?php echo $_SESSION["nameErr"];?></span>
          <br><br>
          
          Email: <input autocomplete="off" class="w3-input w3-border" type="text" name="email" value="<?php echo $email;?>">
          <!-- En caso de que haya un error en la validación, la vaiable de error de ese campo
          deja de ser nula y se muestra el error de que el campo esta vacio-->
          <span>* <?php echo $_SESSION["emailErr"];?></span>
          <br><br>
     
          Contraseña: <input class="w3-input w3-border" type="password" name="pass" value="<?php echo $pass;?>">
          <!-- En caso de que haya un error en la validación, la vaiable de error de ese campo
          deja de ser nula y se muestra el error de que el campo esta vacio-->
          <span>* <?php echo $_SESSION["passErr"];?></span>
          <br>
          <!-- Combobox que nos muestra los tipos de usario, necesario para la creacion de un nuevo usuario -->
          Tipo de usuario: <select name="tipo">
          <!-- Por defecto se establece como invitado -->
          <option selected value="N">Tipo de usuario</option>
                  <!--Gracias a la consulta realizada al final de la validacion y utilizando el mismo metodo
                  para mostrar elementos del menu en el footer, se crear un combobox con
                  los tipos de usuario que estan en la tabla tipoUsu-->
                  <?php
              while ($rowtipo = $queryUsu->fetch()){
                  echo  "<option  value=".$rowtipo["tipo"].">".$rowtipo["nombre"]."</option>";
              }
              $selectOption = $_POST["tipo"];
                  ?>
          </option>
        </select>
        <br><br>
        <input type="submit" name="guardar_usu" class="w3-button w3-black" value="Guadar usuario">
  </div>
  <!-- Formulario -->

  <!-- CRUD -->
  <div class="w3-container w3-threequarter">
    <div class="w3-container">
      <h2>Usuarios</h2>
        <table class="w3-table-all">
          <thead>
              <tr class="w3-red">
                <th>NOMBRE</th>
                <th>CORREO</th>
                <th>TIPO</th>
                <th>OPCIONES</th>
              </tr>
            </thead>
            <tbody>
            <!-- Se consulta la tabla de us3rs y se usa el metodo de crear un array indexado
            con los nombres de las tablas de us3rs -->
            <?php
            $db_usuarios = new Database();
            $query = $db_usuarios->connect()->prepare("SELECT id,nombre,ema1l,tipo 
            FROM us3rs");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            //Se utiliza el mismo metodo del menu para mostar los registros de la tabla us3rs.
            while ($row_h = $query->fetch()){ ?>
              <tr>
              <td><?php echo $row_h["nombre"]; ?></td>
              <td><?php echo $row_h["ema1l"]; ?></td>
              <td><?php echo $row_h["tipo"]; $db_historial = null; ?></td>
              <td>
              <!-- Botones para editar y eliminar cuentas. Cada uno de los botones tiene 
              un enlace que redireciona a otra pagina con el añadido del id_unico de cada
              usuario.-->
              <!-- Se le envia a edit_user.php por metodo get el id unico de usuario que se va a editar -->
                <a href="edit_user.php?id=<?php echo $row_h['id']?>" class="btn btn-secondary">
                  <i class="fas fa-marker"></i>
                </a>
              <!-- Se le envia a delete user por metodo get el id unico del usuario. -->
                <a href="delete_user.php?id=<?php echo $row_h['id']?>" class="btn btn-danger">
                  <i class="far fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            <?php $db_usuarios = null;} ?>
          </body>
        </table>
    </div>
  </div>
  <!-- CRUD -->  
</div>
<?php include 'structure/footer.php'; ?>