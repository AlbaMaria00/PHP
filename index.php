<?php
session_start();
include("template/cabecera.php");
$nombreUsuario=$_SESSION['nombreUsuario'];
?>
<div class="col-12">
                <div class="jumbotron">
                    <h1 class="display-3">Bienvenido a mi pagina <?php echo $nombreUsuario;?></h1>
                    <p class="lead">Estas en la parte de administración de la WEB</p>
                    <hr class="my-2">
                    <img src="imagenes/imagenLogo.png" alt="" srcset="">
                </div>
              </div>
<?php
include("template/pie.php");
?>