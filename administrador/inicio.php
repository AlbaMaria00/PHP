<?php
include("template/cabecera.php");
 $nombreUsuario=$_SESSION['nombreUsuario'];
?>
<div class="col-12">
                <div class="jumbotron">
                    <h1 class="display-3">Bienvenido a mi pagina <?php echo $nombreUsuario;?></h1>
                    <p class="lead">Estas en la parte de administración de la WEB</p>
                    <hr class="my-2">
                    <p>Accede a la Base de Datos</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="http://localhost/phpmyadmin/index.php?route=/database/structure&server=1&db=sitio" role="button">Acceder</a>
                    </p>
                </div>
              </div>
<?php
include("template/pie.php");
?>