<?php
  session_start();

  session_unset();//Unset las variables session.

  session_destroy();//Destruir sesion

  header('Location: index.php');//Redireccion a la pagin inicio/login.
?>