<?php
include("../template/cabecera.php");
?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";


// echo $txtID."<br>";
// echo $txtNombre."<br>";
// echo $txtImagen."<br>";
// echo $accion."<br>";

include("../config/bd.php");

switch ($accion) {
    case 'Agregar':
        $sql=$conexion->prepare("INSERT INTO coches (nombre, imagen) VALUES (:nombre,:imagen);");
        $sql->bindParam(':nombre',$txtNombre);
        //Esto es para que el nombre de las imagenes no coincida
        $fecha=new DateTime();
        //Ponemos el nuevo nombre de la imagen
                        //Si la imagen existe el nuevo nombre sera la fecha+txt de la imagen         si no existe pues el nuevo nombre va a ser imagen.jpg
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES['txtImagen']['name']:'imagen.jpg';
        //almacenamos la imagen en un archivo temporal
        $tmpImagen=$_FILES['txtImagen']['tmp_name'];
        //si la imagen tiene algo,es distinto de null
        //movemos la imagen a la carpeta imagenes
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../imagenes/".$nombreArchivo);
        }


        $sql->bindParam(':imagen',$nombreArchivo);
        $sql->execute();
        header("Location:productos.php");
        break;
    case 'Modificar':
        $sql=$conexion->prepare("UPDATE coches SET nombre=:nombre WHERE id=:id");
        $sql->bindParam(':nombre',$txtNombre);
        $sql->bindParam(':id',$txtID);
        $sql->execute();
//La imagen se modifica si hay algo de informacion de ella, es decir, si existe
        if($txtImagen!=""){

            $fecha=new DateTime();
            //Ponemos el nuevo nombre de la imagen
            //Si la imagen existe el nuevo nombre sera la fecha+txt de la imagen         si no existe pues el nuevo nombre va a ser imagen.jpg
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES['txtImagen']['name']:'imagen.jpg';
            //almacenamos la imagen 
            $tmpImagen=$_FILES['txtImagen']['tmp_name'];
            move_uploaded_file($tmpImagen,"../../imagenes/".$nombreArchivo);

            //Buscamos la imagen por if
            $sql=$conexion->prepare("SELECT imagen FROM coches WHERE id=:id");
            $sql->bindParam(':id',$txtID);
            $sql->execute();
            
            $coche=$sql->fetch(PDO::FETCH_LAZY);
            //Si la imagen existe y el nombre es distinto de imagen.jpg
            if(isset($coche['imagen']) && ($coche['imagen'])!='imagen.jpg'){
                //Si la imagen existe en la carpeta imagenes
                if(file_exists('../../imagenes/'.$coche['imagen'])){
                    //hacemos un unlink que es como borrar
                    unlink('../../imagenes/'.$coche['imagen']);
                }
            }

            //Despues de modificar se actualiza con update
            $sql=$conexion->prepare("UPDATE coches SET imagen=:imagen WHERE id=:id");
            $sql->bindParam(':imagen',$nombreArchivo);
            $sql->bindParam(':id',$txtID);
            $sql->execute();
        }
        header("Location:productos.php");
        break;
    case 'Cancelar':
        //Aqui recargamos la pagina
        header("Location:productos.php");
    break;
    case 'Borrar':

        $sql=$conexion->prepare("SELECT imagen FROM coches WHERE id=:id");
        $sql->bindParam(':id',$txtID);
        $sql->execute();
        $coche=$sql->fetch(PDO::FETCH_LAZY);
        //Si la imagen existe y el nombre es distinto de imagen.jpg
        if(isset($coche['imagen']) && ($coche['imagen'])!='imagen.jpg'){
            //Si la imagen existe en la carpeta imagenes
            if(file_exists('../../imagenes/'.$coche['imagen'])){
                //hacemos un unlink que es como borrar
                unlink('../../imagenes/'.$coche['imagen']);
            }
        }
        //BORRAR REGISTROS
        $sql=$conexion->prepare("DELETE FROM coches where id=:id");
        $sql->bindParam(':id',$txtID);
        $sql->execute();

        header("Location:productos.php");
        break;
        //seleccionar lo que hace es coger la info
    case 'Seleccionar':
        $sql=$conexion->prepare("SELECT * FROM coches WHERE id=:id");
        $sql->bindParam(':id',$txtID);
        $sql->execute();
        //fetch lazy es para cargar los datos uno a uno
        $coche=$sql->fetch(PDO::FETCH_LAZY);
        //Aqui metemos en el form los datos
        $txtNombre=$coche['nombre'];
        $txtImagen=$coche['imagen'];
        //Ahora para meterlo en el input nos vamos al form y metemos el value
        /*value="<?php  echo $txtID; ?>"  y asi para todos los campos a rellenar automaticamente*/
        break;
    
    default:
        # code...
        break;
}
//Con esto nos vamos a abajo, donde la tabla para poder rellenarla
$sql=$conexion->prepare("SELECT * FROM coches");
$sql->execute();
$listaCoches=$sql->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="col-5">
        <div class="card">
            <div class="card-header">
                Datos de Coche
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="txtID">ID</label>
                        <input type="text" class="form-control" id="txtID" value="<?php  echo $txtID; ?>" name="txtID" placeholder="ID" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="txtNombre">Nombre</label>
                        <input type="text" class="form-control" id="txtNombre" value="<?php  echo $txtNombre; ?>" name="txtNombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="txtImagen">Imagen</label>
                        <?php
                            if($txtImagen!=""){
                        ?>
                            <img class="img-thumbnail rounded" src="../../imagenes/<?php echo $txtImagen;?>" width="50"/>
                        <?php 
                            }
                        ?>
                        <input type="file" class="form-control" id="txtImagen" value="<?php  echo $txtImagen; ?>" name="txtImagen" placeholder="Nombre">
                    </div>
                    <div class="btn-group" role="group" aria-label="">
                        <!-- el codigo php es:
                            si hemos clickeado seleccionar, no podemos dar click al boton agregar porque entonces agregariamos una y otra vez los mismos datos
                            entonces ponemos disabled
                        -->
                        <button type="submit" name="accion" value="Agregar" <?php echo ($accion=="Seleccionar")?"disabled":"";?> class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" value="Modificar" <?php echo ($accion!="Seleccionar")?"disabled":"";?> class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" value="Cancelar" <?php echo ($accion!="Seleccionar")?"disabled":"";?> class="btn btn-info">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</div>
<div class="col-7">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Con este bucle recorremos le listados de coches de la BDD
                foreach ($listaCoches as $coche){ 
            ?>
            <tr>
                <td><?php echo $coche['id'];?></td>
                <td><?php echo $coche['nombre'];?></td>
                <td>
                    <img src="../../imagenes/<?php echo $coche['imagen'];?>" width="50"/>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $coche['id']; ?>"/>
                        <input type="submit" name ="accion" value="Seleccionar" class="btn btn-primary">
                        <input type="submit" name ="accion" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            <?php
               }
            ?>
        </tbody>
    </table>
</div>

<?php
include("../template/pie.php");
?>