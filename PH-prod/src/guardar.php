<?php 
 include_once 'database.php';
 include 'check/CheckSesion.php';
 ob_start();
  $dbguardar = new Database();
  if (isset($_POST['guardar'])) {//Si se envian datos por post['guardar']
    if ( !empty($_POST["usuario"]) && !empty($_POST["fechaE"]) && !empty($_POST["hini"]) && !empty($_POST["fechaS"]) 
      && !empty($_POST["hfin"]) )// Si todos los campos estan llenos.
    {
      //Aignacion de los datos del formulario a variables.
      $id_usu=$_POST["usuario"];
      $fechaE=$_POST['fechaE'];
      $hini=$_POST['hini'];
      $fechaS=$_POST['fechaS'];
      $hfin=$_POST['hfin'];
      //Insertamos el registro.
      $query = $dbguardar->connect()->prepare("INSERT INTO registro(id_usuario,fechaE,hini,fechaS,hfin) 
      VALUES ('$id_usu', '$fechaE', '$hini','$fechaS','$hfin')");
      $resultado = $query->execute();

      if(!$resultado) {//Si la consulta no se ha realizado..
        die("Query Failed.");
      }else {//Si la consulta si se ha realizado...
      $_SESSION['message'] = 'Registro correctamente incluido';
      $_SESSION['message_type'] = 'success';
      header('Location: historial.php');
      }
    }else{//Si alguno de los datos no se ha rellenado.
      $_SESSION['message'] = 'Debe rellenar todos los campos';
      $_SESSION['message_type'] = 'danger';
      header('Location: historial.php');
    }  
  }
 
?>