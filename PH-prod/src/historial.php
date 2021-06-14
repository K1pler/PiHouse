<?php 
  include_once 'database.php';
  include 'check/CheckSesion.php';
  ob_start();
  include 'structure/header.php';
  $db_historial_usuario = new Database();
  $db_historial_usuario2 = new Database();
  /*A la hora de añadir un registro, tenemos que tener en cuenta si es el superadministrador o
  un administrador a secas, pues el superadministrador puede añadir y eliminar registros de 
  cualquier persona pero el administrador solo puede editar y eliminar sus propios registros. 
  Todo esto es posible gracias a la variavle de sesiion tipo.*/
  
  
  if ( $_SESSION["tipo"] == "S") {
    $query_usu_historial = $db_historial_usuario->connect()->prepare("SELECT * FROM us3rs");
    $query_usu_historial2 = $db_historial_usuario2->connect()->prepare("SELECT * FROM us3rs");
    $query_usu_historial->setFetchMode(PDO::FETCH_ASSOC);
    $query_usu_historial2->setFetchMode(PDO::FETCH_ASSOC);
    $query_usu_historial->execute();
    $query_usu_historial2->execute();
    $db_historial_usuario = null;
    $db_historial_usuario2 = null;
  }else{
    $prueba_id = intval($_SESSION['id']);
    $query_usu_historial = $db_historial_usuario->connect()->prepare(" SELECT * FROM us3rs
    WHERE id = $prueba_id ");
    $query_usu_historial2 = $db_historial_usuario2->connect()->prepare(" SELECT * FROM us3rs
    WHERE id = $prueba_id ");
    $query_usu_historial->setFetchMode(PDO::FETCH_ASSOC);
    $query_usu_historial2->setFetchMode(PDO::FETCH_ASSOC);
    $query_usu_historial->execute();
    $query_usu_historial2->execute();
    $db_historial_usuario = null;
    $db_historial_usuario2 = null ;
  }
?>
<br>
<br>
<br>
<div class="w3-row">
  <!-- MENSAJES -->
  <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
          <?= $_SESSION['message']?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  <?php unset($_SESSION['message']); } ?>
  <!-- MENSAJES -->
  <!-- FORMULARIO PARA AñADIR UN REGISTRO -->
  <div class="w3-container w3-quarter">
      <!-- Formulario enviado a guardar.php-->
      <form action="guardar.php" method="POST">
          Usuario: <select name="usuario">
          <!-- A la hora de seleccionar un usuario, se nos aparecera un comobox. Para consultar
          los usuarios disponibles, se ha utilizado el mismo metodo que para el despliegue del
          menu superior o el tipo de usuario.-->
          <option selected value="0">Usuarios disponibles</option>
                  <?php
              while ($rowtipo = $query_usu_historial->fetch()){
                  echo  "<option  value=".$rowtipo["id"].">".$rowtipo["nombre"]."</option>";
              }
              $selectOption = $_POST["usuario"];
                  ?>
          </option>
        </select>
        <br></br>
        <label>Fecha Entrada</label>
          <input class="w3-input w3-border" type="date" name="fechaE" >
        <label>Hora de entrada </label>
          <input class="w3-input w3-border" type="time" name="hini" step="1">
        <label>Fecha salida</label>
          <input class="w3-input w3-border" type="date" name="fechaS" >
        <label>Hora de salida </label>
          <input class="w3-input w3-border" type="time" name="hfin" step="1">
        <br>
        <input href="historial.php?sort=nombre" type="submit" name="guardar" class="w3-button w3-black" value="Guardar">
        <br></br>
      </form>
  </div>
  <!-- FORMULARIO PARA AñADIR UN REGISTRO -->
  <!-- GESTION PARA CRUD-->
  <div class="w3-container w3-threequarter">
    <div class="w3-container">
      <?php
        /* Para mostrar en orden ascendente o descendente el nombre o la fecha de Entrada,
        necesitamos enviar datos por el GET a la hora de hace clik en la columna en la que 
        estemos interesados en ordenar.*/
        $db_historial = new Database();
        $prueba_id = intval($_SESSION['id']);
        //Se comprueba si $_GET['order'] ha recibido datos.
        if (isset($_GET['order'])) {
            $order = $_GET['order'];//Si se han enviado datos, asignamos a order nombre o
            //fecha de entrada.
        }else{//Si no se han recibido datos, se establecera por defecto la columna nombre.
            $order = 'nombre';
        }
        //Realizamos el mismo proceso para ver en que orden,(si ascendente o descendente)
        //queremos mostrar los registros.
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else {
            $sort = 'ASC';
        }
        //Se crear otra consulta adicional, parecida a la primera consulta para mostrar los 
        //registros, con la diferecia de que a la consulta sql se le añade condiciones con las
        //variables $order y $sort anteriormente creadas.
        if (!empty($_POST['sorthini'])) {
          $DIA = $_POST['sorthini'] ;
        } else {
          $dia = date('Y-m-d');
          $DIA = $dia ;
        }

        if (isset($_POST['sortuser']) && $_POST['sortuser'] <> 0) {
          $user = "= ".$_POST['sortuser']." ";
        } else {
          $user = " REGEXP '^[0-9]*$' ";
        }

        if ($_SESSION["tipo"] == "S") {
          $sql = "SELECT registro.*,us3rs.nombre  
                  FROM registro LEFT JOIN us3rs ON us3rs.id = registro.id_usuario 
                  WHERE registro.fechaE = '".$DIA."'
                  AND id_usuario ".$user."
                  ORDER BY $order $sort ";
        } else {
          $sql = "SELECT registro.*,us3rs.nombre  
                  FROM registro LEFT JOIN us3rs ON us3rs.id = registro.id_usuario 
                  WHERE registro.fechaE = '".$DIA."' 
                  AND id_usuario = ".$_SESSION["id"]."
                  ORDER BY $order $sort";
        }
      $query = $db_historial->connect()->prepare($sql);
      $query->setFetchMode(PDO::FETCH_ASSOC);
      $query->execute();
      //Este operador ternario permitirá alternar entre ASC O DESC cada vez que pulsamos
      //en una columna.
      $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC' ;
  ?>
<table class="w3-table-all">
  <div class="w3-row">
    <form action="" method="post">
      <?php   if ( $_SESSION["tipo"] == "S") { ?>
          <div class="w3-third w3-container">
            Buscar por usuario: <select class="w3-input w3-border" name="sortuser">
              <option selected value="0" >Todos los usuarios</option>
                <?php
                while ($rowtipo = $query_usu_historial2->fetch()){
                    echo  "<option  value=".$rowtipo["id"].">".$rowtipo["nombre"]."</option>";
                }
                ?>
              </option>
            </select>
          </div>
          <div class="w3-third w3-container">
            Hora de entrada :<input class="w3-input w3-border" type="date" name="sorthini" >
          </div>
          <div class="w3-third w3-container w3-padding-16">
            <input class="w3-button w3-large w3-black " type="submit" class="w3-black" value="Buscar">
          </div>
      <?php } else { ?>
          <div class="w3-half w3-container">
            Hora de entrada :<input class="w3-input w3-border" type="date" name="sorthini" >
          </div>
          <div class="w3-half w3-container w3-padding-16">
          <input class="w3-button w3-large w3-black " type="submit" class="w3-black" value="Buscar">
        </div>
        </div>
          <?php } ?>
    </form>
  </div>

    <div class="w3-container w3-panel w3-center ">
      <?php 
      //Esta condicion php hace que se muestre un texto en la parte superior de la tabla
      //que nos dice por que columna se esta ordenando y en que orden.
        switch ($order) {
          case 'nombre':
            switch ($sort) {
              case 'ASC':
                echo "Mostrando por nombre ascendente";
                break;
              case 'DESC':
                echo "Mostrando por nombre descendente";
                break;
            }
          break;
          case 'fechaE':
            switch ($sort) {
              case 'ASC':
                echo "Mostrando por fecha de entrada descendente";
                break;
                
              case 'DESC':
                echo "Mostrando por fecha de entrada ascendente";
                break;
            }
          break;
        } 
      ?>
      <!-- GESTION PARA CRUD-->
      <!-- CRUD -->
      <thead>
          <tr class="w3-red">
              <!-- Los botones envian por el método get el nombre de la columna que se ha clikado
              y el orden predeterminado, es decir ASC -->
              <th><a style="text-decoration:none;" class="w3-text-white" href="historial.php?order=nombre&&sort=<?php echo $sort?>"><i class="fas fa-sort"></i>NOMBRE</a></th>
              <th><a style="text-decoration:none;" class="w3-text-white" href="historial.php?order=fechaE&&sort=<?php echo $sort?>"><i class="fas fa-sort"></i>FECHA ENTRADA</a></th>
              <th>HORA ENTRADA</th>
              <th>FECHA SALIDA</th>
              <th>HORA SALIDA</th>
              <th>OPCIONES</th>
          </tr>
      </thead>
        <tbody>
            <!-- Query para mostrar todos los registros de la query 106, la cual tiene las condificones,
            orden, columna y que mostrar en funcion del usuario -->
            <?php while ($row_h = $query->fetch()){ ?>
                <tr>
                    <td><?php echo $row_h["nombre"]; ?></td>
                    <td><?php echo $row_h["fechaE"]; ?></td>
                    <td><?php echo $row_h["hini"]; ?></td>
                    <td><?php echo $row_h["fechaS"]; ?></td>
                    <td><?php echo $row_h["hfin"]; $db_historial = null; ?></td>
                    <td>
                    <!--Botones para editar y eliminar registros. Mismo funcionamiento que para 
                    crear cuentas.Funcionan de las misma manera que con la creacion de las cuentas. -->
                      <a href="edit.php?id=<?php echo $row_h['id']?>" class="btn btn-secondary">
                          <i class="fas fa-marker"></i>
                      </a>
                      <a href="delete.php?id=<?php echo $row_h['id']?>" class="btn btn-danger">
                      <i class="far fa-trash-alt"></i>
                      </a>
                    </td>
                </tr>
            <?php } ?>
          </tbody>
          <!-- CRUD -->
        </table>
      </div>
    </div>
  </div>
</div>
<?php include 'structure/footer.php'; ?>