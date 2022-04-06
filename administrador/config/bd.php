<?php
$host="localhost";
$bd="sitio";
$usuario="root";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
    if($conexion){
        // echo "Conectando...a sistema";
    }

} catch (Exception $ex) {
    //En caso de que haya algun error imprimimos el mensaje
    echo $ex->getMessage();
}
?>