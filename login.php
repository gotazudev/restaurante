<?php 
    
    // Incluye el header
    require 'includes/config/database.php';
    $db = conectarDB();

    // Autenticar usuario

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){

        $email = mysqli_real_escape_string($db , filter_var($_POST['nombre'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db , $_POST['contrasena']);

        if(!$email){
            $errores[] = "El nombre es obligatorio";
        }
        if(!$password){
            $errores[] = "El pass es obligatorio";
        }

        if(empty($errores)){
            // Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE nombre = '$email';";
            $resultado = mysqli_query($db , $query);

            if($resultado->num_rows){
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // Verificar si el password es correcto o no
                $auth = password_verify($password, $usuario['contrasena']);
                // var_dump($auth);

                if($auth){
                    // El usuario esta autenticado
                    session_start();

                    // Llenar el arrelo de la sesion
                    $_SESSION['usuario'] = $usuario['nombre'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');
                    // var_dump($_SESSION);

                }else{
                    $errores[] = 'El password es incorrecto';
                }

            }else{
                $errores[] = 'El usuario no existe';

            }
        }

    }

 ?>
    <main class="contenedor seccion">
        <h1>Iniciar sesion</h1>

<?php foreach ($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
<?php endforeach; ?>

        <form method="POST" novalidate>
            <fieldset>
                <legend>Email y pass</legend>

                <label for="email">E-mail</label>
                <input type="nombre" name="nombre" placeholder="Tu nombre" id="nombre" required>

                <label for="password">Contraseña</label>
                <input type="password" name="contrasena" placeholder="contrasena" id="contrasena" required>
                
            </fieldset>

            <input type="submit" value="Iniciar sesion" class="boton boton-verde">
        </form>
    </main>
