<?php
include_once 'database.php'; //Introducimos la base de datos
include 'check/CheckSesion.php';//Chequeo de sesión.

//VALIDACION CAMBIO DE CONTRASEñA
    if (isset($_POST['oldpass']) && isset($_POST['newpass'])) {//SE ENVIAN LOS DOS PRIMEROS INPUTS
        
        $op = validate($_POST['oldpass']);
        $np = validate($_POST['newpass']);
        $c_np = validate($_POST['newpass2']);
        //Vemos que no estan vacios y si la confirmacion de contraseña es correcta.
        if (empty($op)) {
            header("Location: changepass.php?error=La constraseña actual es obligatoria");
            exit();
        }else if(empty($np)){
            header("Location: changepass.php?error=La nueva contraseña es obligatoria");
            exit();
        }else if($np !== $c_np){
            header("Location: changepass.php?error=Las contraseñas nuevas no coinciden");
            exit();
        }else{
            $db_cambiar_contraseña = new Database();
            $id = $_SESSION['id'];
            //Busco la contraseña correspondiente con la persona que actualmente ha iniciado sesion
            $query = $db_cambiar_contraseña->connect()->prepare("SELECT * FROM us3rs WHERE id='$id' 
            ");
            $query->execute();
            $results = $query->fetch(PDO::FETCH_ASSOC);
            

            if ($results) {//Verifico que la contraseña antigua introducida y la contraseña de la base de datos coincide.
                if (password_verify($op, $results['passw0rd'])) {
                    $password_hash_np = password_hash($np, PASSWORD_BCRYPT);
                    //Si es asi, cambia la contrseña
                    $sql_2 = "UPDATE us3rs
        	          SET passw0rd='$password_hash_np'
        	          WHERE id='$id'";
                      $query2 = $db_cambiar_contraseña->connect()->prepare($sql_2);
                      if ($query2->execute()) {
                        header("Location: changepass.php?error=Cambio de contraseña correcto.");
                        unset($op);
                        unset($np);
                        unset($c_np);
                        exit();
                      }
                }else{//Si no, muestra un mensaje de error.
                    header("Location: changepass.php?error=La contraseña antigua no coincide con la actual");
                    unset($op);
                    unset($np);
                    unset($c_np);
                    exit();
                    
               }
            }
        }
    }

function validate($data){//Funcion para validar los inputs del formulario.
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
?>
<!DOCTYPE html>
<html>
<title>Cambiar contraseña</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Enlaces para ccs w3 y sweetalert-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>

<div class="w3-container" style="margin-top:50px;">
  <div class="w3-card-4">
    <div class="w3-container w3-red">
      <h2>Cambiar contraseña</h2>
    </div>
        <!-- Formulario -->
        <form class="w3-container" method="POST">
        <br>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>

            </label>Contraseña antigua</label></p>
            <input type="password" 
                name="oldpass" placeholder="contraseña antigua" class="w3-input" 
                placeholder="Old Password">
                <br>

            <label>Contraseña nueva</label>
            <input type="password" 
                name="newpass" placeholder="Contraseña nueva" class="w3-input" 
                placeholder="New Password">
                <br>

            <label>Confirmar nueva Contraseña</label>
            <input type="password" 
                name="newpass2" placeholder="Confirmar contraseña nueva" class="w3-input" 
                placeholder="Confirm New Password">
                <br>
            <input type="submit" value="Cambiar" class="w3-button w3-red">
            <a href="/home.php" type="button" class="w3-button w3-black">Volver al home </a>
        </form>
        <br>
        <!-- Formulario -->
    </div>
</div>
<?php include 'structure/footer.php'; ?>
