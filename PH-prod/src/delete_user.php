<?php
include_once 'database.php';
include 'check/CheckSesion.php';
ob_start();

$db_delete_user = new Database();

if(isset($_GET['id'])) {//Si se a recibido por el metodo get el id unico.
  $id = $_GET['id'];
  //Se genera una cosulta para eliminar el usuario con el id obtenio del get.
  $query = $db_delete_user->connect()->prepare("DELETE FROM us3rs 
  WHERE id = $id");
  $resultado = $query->execute();

  if(!$resultado) {
    die("Query Failed.");
  }

  $_SESSION['message'] = 'Usuario correctamente eliminado';
  $_SESSION['message_type'] = 'success';
  header('Location: registro.php');
}
$db_delete = new Database();
?>