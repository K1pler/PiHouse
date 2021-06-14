<?php 
  include_once 'database.php'; //Introducimos la base de datos
  include 'check/CheckSesion.php';//Chequeo de sesión.
  include 'structure/header.php';//Menu superior
?>
<!--Mostramos el nombre que hemos obtenido de CheckSesion.php $nombre 
"$_SESSION["nombre"]" para dar la bienvenida al usuario logueado.-->
<div class="w3-container w3-red w3-center" style="padding:100px 10px">
      <h1 class="w3-margin w3-jumbo"><?php echo "Bienvenido ".$nombre."."; ?></h1>

    
    <div class="w3-margin w3-jumbo">
      <div id="c_f124c6136ed2b770188a816ee9f1d01e" class="normal">
        <script type="text/javascript" src="https://www.eltiempo.es/widget/widget_loader/f124c6136ed2b770188a816ee9f1d01e"></script>
      </div>
    </div>
  
</div>
<?php include 'structure/footer.php'; // Footer que contiene el cierre de sesion?>








  
