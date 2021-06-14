<?php 
  include 'check/CheckSesion.php';
  include 'structure/header.php';
?>

<!-- Se carga la imagen generada por Wireguard proveniente de la carpeta VPN/config-->
  <div class="container">
    <div class="w3-display-middle w3-large">
        <img src="VPN/config/peer1/peer1.png" alt="VPN2">
    </div>
  </div>

  <footer class=" w3-display-bottommiddle w3-container w3-padding-64 w3-center w3-opacity" >
  <a href="logout.php">Cerrar Sesión</a> <!-- Enlace que lleva a el archivo php que nos destruye
  sesion -->
</footer>
<script>
// Script para mostar elementos del menu en pantallas pequeñas.
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>
  
<!-- BOOTSTRAP 4 SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>