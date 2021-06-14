<?php
//Validacion de usuario y contraseña
include 'check/validar.php';
?>

<!DOCTYPE html>
<html>
  <title>PiHome</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Fuentes de google y css de W3 -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
  <!-- Fuente AWESOEM -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <body>
        <header class="w3-container w3-red w3-center">
            <h1>Iniciar Sesion</h1>
        </header>
            <!-- Notificacion error login -->
            <?php if (isset($_SESSION['messagei'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_typei']?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['messagei']?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php unset($_SESSION['messagei']); } ?>
            <!-- Formulario que recoje los datos de inicio de sesion -->
            <form method="POST" class="w3-container w3-centre w3-card-4" >
                <p>
                <label>Correo</label></p>
                <input autocomplete="off" style="width:20%" class="w3-input" type="text" name="email" required>

                <p>
                <label>Contraseña</label></p>
                <input style="width:20%" class="w3-input" type="password"  name="pass" required>

                <p>
                <!-- Enlace al formulario para requerir una contraseña -->
                <a href="phpmailer/mail.php">¿No tienes cuenta? Comunicate con el administrador</a>
                <p>
                <input class="w3-button w3-section w3-red w3-ripple" type="submit" value="Ingresar">
                <!-- Los datos de este formulario se enviarán validar.php -->
            </form>
        
            <script>
            // Funcion js para mostrar el menu en pantallas de movil.
            function myFunction() {
              var x = document.getElementById("navDemo");
              if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
              } else { 
                x.className = x.className.replace(" w3-show", "");
              }
            }
            </script>
  
<!-- Scripts de BOOTSTRAP 4 -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    </body>
</html> 

