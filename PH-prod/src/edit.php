<?php 
  include_once 'database.php';
  include 'check/CheckSesion.php';
  ob_start();
  include 'structure/header.php';
  $db_edit = new Database();
  if  (isset($_GET['id'])) { //Si se recibe un id de historial.php al pulsar el boton
    //de editar.
    $id = $_GET['id'];
    $query = "SELECT * FROM registro WHERE id=$id";
    //Se carga el resultado con el id obtenido por el metodo get.
    $query = $db_edit->connect()->prepare($query);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    $db_edit = null;
    if ($resultado) {
        //Se asigna cada indice de resultado a una variable.
        $fechaE=$resultado['fechaE'];
        $horaE=$resultado['hini'];
        $fechaS=$resultado['fechaS'];
        $horaS=$resultado['hfin'];
    }
  }
  
  if (isset($_POST['update'])) {//Si se envian datos del formulario de la linea 49
    $db_update = new Database();
    //Se supone que los datos que hemos enviado por el nuevo formulario, son 
    //datos actualizados.
    //Se asignan los datos actualizados a nuevas variables para insertarlas 
    $id = $_GET['id'];
    $fechaEUpdate= $_POST['fechaE'];
    $horaEUpdate= $_POST['hini'];
    $fechaSEUpdate= $_POST['fechaS'];
    $horaSUpdate= $_POST['hfin'];
    
    $query_update = "UPDATE registro set fechaE = '$fechaEUpdate', hini = '$horaEUpdate', fechaS = '$fechaSEUpdate', hfin = '$horaSUpdate' WHERE id=$id";
    $query = $db_update->connect()->prepare($query_update);
    $query->execute();
    $db_update = null;
    $_SESSION['message'] = 'Registro correctamente modificado';
    $_SESSION['message_type'] = 'success';
    header('Location: historial.php');
  }
?>
<br>
<br>
<br>
<!-- Los datos guardados de la linea 17 se cargan en el nuevo formulario
Este formulario se envia a si mismo con el id obtenido del boton de historial.php -->
<div class="w3-row">
    <div class="w3-padding" style="width:60%">
        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <br></br>
            <label>Fecha Entrada</label>
            <input class="w3-input w3-border" type="date" name="fechaE" value="<?php echo $fechaE; ?>" placeholder="Actualizar fecha entrada ">
            <label>Hora de entrada </label>
            <input class="w3-input w3-border" type="time" name="hini" step="1" value="<?php echo $horaE; ?>" placeholder="Actualizar hora entrada ">
            <label>Fecha salida</label>
            <input class="w3-input w3-border" type="date" name="fechaS" value="<?php echo $fechaS; ?>" placeholder="Actualizar fecha salida ">
            <label>Hora de salida </label>
            <input class="w3-input w3-border" type="time" name="hfin" step="1" value="<?php echo $horaS; ?>" placeholder="Actualizar hora salida">
            <br>
            <input  class="w3-button w3-black" name="update" class="w3-button w3-black" type="submit" value="Actualizar">
            <br></br>
        </from>
    </div>
</div>

<?php include 'structure/footer.php'; ?>
