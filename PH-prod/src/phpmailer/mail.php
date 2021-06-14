<!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Enlaces para ccs w3 y sweetalert-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>

<div class="w3-container" style="margin-top:50px;">
  <div class="w3-card-4">
    <div class="w3-container w3-red">
        <!-- MESSAGES -->
        <?php if (isset($_SESSION['message'])) { ?>
              <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
        <?php unset($_SESSION['message']); } ?>
        <!-- MESSAGES -->
      <h2>Formulario de contacto</h2>
    </div>
    <!-- Formulario -->
    <form class="w3-container">
      <p>
      <label>Nombre</label></p>
        <input id="name" placeholder="Nombre" class="w3-input" type="text">
      <p>
      <label>Email para ponerme en contacto contigo</label></p>
        <input id="email" placeholder="Email" class="w3-input" type="text">
      <p>
      <label>Asunto</label></p>    
        <input id="subject" placeholder="Asunto" class="w3-input" type="text">
      <p>
      <label>Comentarios</label></p>
        <input id="body" placeholder="Comentarios" class="w3-input" type="text">
      <p>
      
      <input type="button" onclick="sendEmail()" value="Enviar" class="w3-button w3-red">
      <a href="/index.php" type="button" class="w3-button w3-black">Volver a login </a>
    </form>
    <!-- Formulario -->
  </div>
</div>

<!-- Para obtner los elementos de formulario para posteriormente enviarlo, usaremos la libreria
de javascrip, jquery.-->
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript">
    //Creamos una funcion que recoje los elementos del formulario.
    function sendEmail() {
        var name = $("#name");
        var email = $("#email");
        var subject = $("#subject");
        var body = $("#body");
        //Comprobacion de que los campos del formulario no estan vacios.
        if (isNotEmpty(name) && isNotEmpty(email) && isNotEmpty(subject) && isNotEmpty(body)) {
            //Añadiremos una funcionalidad ajax ya que jqery permite metodos para este.
            $.ajax({
                url: 'sendEmail.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    name: name.val(),
                    email: email.val(),
                    subject: subject.val(),
                    body: body.val()
                }, success: function (response) {
                    if (response.status == "success")
                    Swal.fire(
                      'Mensaje correctamente enviado',
                      'El administrador se pondrá en contacto contigo',
                      'success'
                    )
                    else {
                      Swal.fire({
                        icon: 'Error',
                        title: 'Algo fue mal',
                        text: 'Intentelo de nuevo'
                      })
                    }
                }
            });
        }
    }

    function isNotEmpty(caller) {
        if (caller.val() == "") {
            caller.css('border', '1px solid red');
            return false;
        } else
            caller.css('border', '');

        return true;
    }
</script>

</body>
</html>