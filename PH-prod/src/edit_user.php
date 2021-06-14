<?php 
  include_once 'database.php';
  include 'check/CheckSesion.php';
  ob_start();
  include 'structure/header.php';
  $db_edit = new Database();
  if  (isset($_GET['id'])) {//Si se recibe el id de registro.php.
    $id = $_GET['id'];
    $query = "SELECT * FROM us3rs WHERE id=$id"; 
    $query = $db_edit->connect()->prepare($query);
    $query->execute();
    //Se busca el usuario por su id unico y se crear un array indexado por las columnas de la tabla us3rs.
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    $db_edit = null;
    if ($resultado) {
        //Se crean variables a partir del array indexado.
        $nombre=$resultado['nombre'];
        $email=$resultado['ema1l'];
        $tipo=$resultado['tipo'];
    //Query para mostar el combobox de los tipoUsu.
    $db_tipo_usuario = new Database();
    $queryUsu = $db_tipo_usuario->connect()->prepare("SELECT * FROM tipoUsu");
    $queryUsu->setFetchMode(PDO::FETCH_ASSOC);
    $queryUsu->execute();
    $db_tipo_usuario = null;
    }
  }
  
  if (isset($_POST['update_usu'])) {//Datos recibidos del formulario de abajo
    $db_update = new Database();
    $id = $_GET['id'];
    //Se asignan a variables los nuevos datos a insertar.
    $nombreUpdate= $_POST['nombre'];
    $emailUpdate= $_POST['email'];
    $tipoUpdate= $_POST['tipo'];
  
    $query_update = "UPDATE us3rs set nombre = '$nombreUpdate', ema1l = '$emailUpdate', tipo = '$tipoUpdate' WHERE id=$id";
    $query = $db_update->connect()->prepare($query_update);
    $query->execute();
    $db_update = null;
    //Mensaje al haberse insertados los datos nuevos.
    $_SESSION['message'] = 'Registro correctamente modificado';
    $_SESSION['message_type'] = 'success';
    header('Location: registro.php');
  }
?>
<br>
<br>
<br>
<!-- FORMULARIO PARA EDITAR EL USUARIO -->
<div class="w3-row">
    <div class="w3-padding " style="width:60%">
        <!-- El formulario se envia a si mismo los datos con el id enviado desde resgistro.php 
        y recibido por edit_user.php a través del método GET -->
        <form action="edit_user.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <br></br>
            <label>Nombre</label>
            <input class="w3-input w3-border" type="text" name="nombre" value="<?php echo $nombre; ?>" placeholder="Actualizar nombre">
            <label>Email</label>
            <input class="w3-input w3-border" type="text" name="email" value="<?php echo $email; ?>" placeholder="Actualizar email">
            <label>Tipo</label>
            <br>
            <!-- Mismo Combobox mostrado en registro.php con la diferencia de que el valor predeterminado
            es el tipo obtenido en la consulta del principio.-->
            <select name="tipo">
                <option selected value="<?php echo $tipo; ?>">Actualizar tipo de usuario</option>
                    <?php
                while ($rowtipo = $queryUsu->fetch()){
                    echo  "<option  value=".$rowtipo["tipo"].">".$rowtipo["nombre"]."</option>";
                }
                $selectOption = $_POST["tipo"];
                    ?>
            </option>
        </select>
        <br></br>
        <input type="submit" name="update_usu" class="w3-button w3-black" value="Editar usuario">
            <br></br>
        </from>
    </div>
</div>
<!-- FORMULARIO PARA EDITAR EL USUARIO -->
<?php include 'structure/footer.php'; ?>
