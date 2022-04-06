<?php
session_start();
//Si hay un envio de metodo post
//Es decir, si clickamos el boton enviar del form de abajo
//se va a hacer una redireccion a inicio.php
if($_POST){
  //Si el usuario que hemos puesto es develoteca y la contraseña sistema
  //se redirecciona a inicio.php
  //Esta linea la cambiarimos si tuvieramos los usuarios y las contraseñas
  //de la bdd
  if(($_POST['usuario']=="alba")&&($_POST['contraseña']=="sistema")){
    //pero antes ponemos la clave de sesion usuario a ok 
    $_SESSION['usuario']="ok";
    $_SESSION['nombreUsuario']="Alba";
    header("Location:inicio.php");
  }else{
    //para que se imprima tenemos que llamarlo en el html de abajo
    $mensaje="Error: El usuario o la contraseña son incorrectos";
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador web</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              Login
            </div>
            <div class="card-body">
              <!-- esto es lo del codigo de error -->
              <?php if(isset($mensaje)){?>
              <div class="alert alert-danger" role="alert">
                <?php echo $mensaje; ?>
              </div>
              <?php }?>
              <form method="POST" action="">
                <div class="form-group">
                  <label for="exampleInputEmail1">Usuario</label>
                  <input type="text" class="form-control" name="usuario" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña:</label>
                  <input type="password" class="form-control" name="contraseña" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Entrar administrador</button>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </body>
</html>