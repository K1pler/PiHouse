<?php
include_once 'database.php';
include 'check/CheckSesion.php';
ob_start();

$db_delete = new Database();
//Se recibe el id a traves del metod get proveniente del historial.php.
if(isset($_GET['id'])) {
  $id = $_GET['id'];
  //Se borra aquel registro que tenga como id el obtenido anteriormente.
  $query = $db_delete->connect()->prepare("DELETE FROM registro WHERE id = $id");
  $resultado = $query->execute();

  if(!$resultado) {
    die("Query Failed.");
  }

  $_SESSION['message'] = 'Registro correctamente eliminado';
  $_SESSION['message_type'] = 'success';
  header('Location: historial.php');
}
$db_delete = new Database();
?>