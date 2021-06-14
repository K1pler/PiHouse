<!DOCTYPE html>
<html lang="en">
<title>Pihouse</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Mismos links de index.php para usar w3CSS. -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<body>
<!-- Barra de navegacion. -->
<div class="w3-top">
  <div class="w3-bar w3-red w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <!-- Icono que redirecciona al inicio. -->
    <a style="text-decoration:none;" href="http://pih0sue.duckdns.org/home.php" class="w3-bar-item w3-button w3-padding-large w3-white">Inicio</a>
    <!-- Este bucle es el que nos permite mostrar el menú.Recibe la query 
    del switch de CheckSesion.Se crear $row con un array indexado con los
    nombres de las columnas de la tabla menu.Finalmente fetch recupera el
    valor del valor siguiente y el while continuara hasta que $query no
    tenga mas filas para mostrar. -->
    <?php
      while ($row = $query->fetch()){
          echo  "<a style=\"text-decoration:none;\" href=".$row["link"]." class=\"w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white\">".$row["nombre"]."</a>";
      }//Se muestra un elemento menu con un link que nos llevara a un 
      //servicio.Mostramos con row[nombre], el nombre que aparecera en la interfaz.
      ?>
  </div>
  <!-- Barra de navegacion para telefono movil -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
      <?php
        while ($row2 = $query2->fetch()){
            echo  "<a style=\"text-decoration:none;\" href=".$row2["link"]." class=\"w3-bar-item w3-button w3-padding-large\">".$row2["nombre"]."</a>";
        }//Se realiza el mismo proceso que para el menu superior.
      ?>
  </div>
</div>