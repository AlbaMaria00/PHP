<?php
 include("template/cabecera.php");
?>
<?php
//añadimos la conexion a la base de datos
include ('administrador/config/bd.php');

//Lista de coches
$sql=$conexion->prepare("SELECT * FROM coches");
$sql->execute();
$listaCoches=$sql->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
foreach($listaCoches as $coche){

?>
<div class="col-4">
    <div class="card">
            <img class="card-img-top" src="./imagenes/<?php echo $coche['imagen'];?>" width="20px" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $coche['nombre'];?></h4>
                <br>
                <a name="" id="" class="btn btn-primary mt mt-2" href="#" role="button">Ver más</a>
            </div>
        </div>
</div>
<?php
}
?>
<?php
 include("template/pie.php");
?>