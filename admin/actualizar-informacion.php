<?php 
    
    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);


    //Base de datos
    include '../includes/config/database.php'; 
    $db = conectarDB();

    // Obtener los datos de la propiedad
    $consulta = "SELECT * FROM informacion WHERE id = ".$id;
    $resultado = mysqli_query($db,$consulta);
    $info = mysqli_fetch_assoc($resultado);

    
    //Arreglo con mensajes de errores
    $errores=[];
    $nombreEmpresa = $info['nombreEmpresa'];
    $menuTexto1 = $info['menuTexto1'];
    $menuTexto2 = $info['menuTexto2'];
    $menuTexto3 = $info['menuTexto3'];
    $menuTexto4 = $info['menuTexto4'];
    $menuTexto5 = $info['menuTexto5'];
    $tituloPrincipal1 = $info['tituloPrincipal1'];
    $tituloPrincipal2 = $info['tituloPrincipal2'];
    $descripcionMenu2 = $info['descripcionMenu2'];
    $mapaURL = $info['mapaURL'];
    $direccionContacto = $info['direccionContacto'];
    $telefonoContacto = $info['telefonoContacto'];
    $correoContacto = $info['correoContacto'];
    $imagenLogoRestaurante = $info['imagenLogo'];
    // $imagenMenu2Restaurante = $info['imagenMenu2'];

    // $creado = date('Y/m/d');   

  

    //Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
    $nombreEmpresa = mysqli_real_escape_string($db, $_POST["nombreEmpresa"]);
    $menuTexto1 = mysqli_real_escape_string($db, $_POST['menuTexto1']);
    $menuTexto2 = mysqli_real_escape_string($db, $_POST['menuTexto2']);
    $menuTexto3 = mysqli_real_escape_string($db, $_POST['menuTexto3']);
    $menuTexto4 = mysqli_real_escape_string($db, $_POST['menuTexto4']);
    $menuTexto5 = mysqli_real_escape_string($db, $_POST['menuTexto5']);
    $tituloPrincipal1 = mysqli_real_escape_string($db, $_POST['tituloPrincipal1']);
    $tituloPrincipal2 = mysqli_real_escape_string($db, $_POST['tituloPrincipal2']);
    $descripcionMenu2 = mysqli_real_escape_string($db, $_POST['descripcionMenu2']);
    $mapaURL = mysqli_real_escape_string($db, $_POST['mapaURL']);
    $direccionContacto = mysqli_real_escape_string($db, $_POST['direccionContacto']);
    $telefonoContacto = mysqli_real_escape_string($db, $_POST['telefonoContacto']);
    $correoContacto = mysqli_real_escape_string($db, $_POST['correoContacto']);

    $imagen1 = $_FILES['imagenLogo'];
    


     //Asignar files hacia la variable
    //  $imagenLogo = $_FILES['imagenLogo'];
    //  $imagenMenu2 = $_FILES['imagenMenu2'];

        //Asignar files hacia la variable
        // $imagenMenu2 = $_FILES['imagenMenu2'];
        

        if(!$nombreEmpresa){
            $errores[] = "Debes añadir un titulo";
        }
        if(!$menuTexto1){
            $errores[] = "Debes añadir un menu texto1";
        }
        if(!$menuTexto2){
            $errores[] = "Debes añadir un menu texto2";
        }
        if(!$menuTexto3){
            $errores[] = "Debes añadir un menu texto3";
        }
        if(!$menuTexto4){
            $errores[] = "Debes añadir un menu texto4";
        }
        if(!$menuTexto5){
            $errores[] = "Debes añadir un menu texto5";
        }
        if(!$tituloPrincipal1){
            $errores[] = "Debes añadir un tituloPrincipal1";
        }
        if(!$tituloPrincipal2){
            $errores[] = "Debes añadir un tituloPrincipal2";
        }
        if(!$descripcionMenu2){
            $errores[] = "Debes añadir un descripcionMenu2";
        }
        if(!$mapaURL){
            $errores[] = "Debes añadir un mapaURL";
        }
        if(!$direccionContacto){
            $errores[] = "Debes añadir un direccionContacto";
        }
        if(!$telefonoContacto){
            $errores[] = "Debes añadir un telefonoContacto";
        }
        if(!$correoContacto){
            $errores[] = "Debes añadir un correo";
        }
       

        // $imagenLogoRestaurante = $info['imagenLogo'];
        // $imagen1 = $_FILES['imagenLogo'];
        
        // Revisar que el arreglo de errores este vacío
        if( empty($errores) ) {

                $carpetaImagenes1 = '../img-logo/';
                $nombreImagen1 = '';
    
    
                // /* SUBIDA DE ARCHIVOS */
                if($imagen1['name']){
                    // Eliminar la imagen previa
                    unlink($carpetaImagenes1 . $info['imagenLogo']);
                     // Generar imagen nombre unico
                    $nombreImagen1 = md5(uniqid(rand(),true)).".jpg";
    
                    // Subir la imagen
                    move_uploaded_file($imagen1['tmp_name'], $carpetaImagenes1.$nombreImagen1);
                } else{
                    $nombreImagen1 = $info['imagenLogo'];
                }           
    


                
        //Actualizar en BD
        $query = "UPDATE informacion SET imagenLogo = '{$nombreImagen1}' WHERE id = {$id} ";


        $resultado = mysqli_query($db,$query);

            if($resultado){
                // Redirecciona al usuario
                header('Location: /admin/informacion-restaurante.php?mensaje=2');
                // echo "<pre>";
                // echo var_dump($_FILES);
                // echo "<pre>";

            }
        }
    }   


 ?>
    <main class="contenedor seccion">
        <h1>ACtualizar info</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion general</legend>

                <label for="">Nombre de empresa:</label>
                <input type="text" id="nombreEmpresa" name="nombreEmpresa" placeholder="Nombre de empresa" value="<?php echo $nombreEmpresa ?>">
                
                <label for="">Imagen Logo:</label>  
                <img width="80px" src="/img-logo/<?php echo $imagenLogoRestaurante; ?>" class="imagen-small" alt="">
                <input type="file" id="imagenLogo" name="imagenLogo" accept="image/jpeg, image/png">

                <label for="">Menu Texto 1:</label>
                <input type="text" id="menuTexto1" name="menuTexto1" placeholder="Menu Texto 1" value="<?php echo $menuTexto1; ?>">
                
                <label for="">Menu Texto 2:</label>
                <input type="text" id="menuTexto2" name="menuTexto2" placeholder="Menu Texto 2" value="<?php echo $menuTexto2; ?>">
                
                <label for="">Menu Texto 3:</label>
                <input type="text" id="menuTexto3" name="menuTexto3" placeholder="Menu Texto 3" value="<?php echo $menuTexto3; ?>">

                <label for="">Menu Texto 4:</label>
                <input type="text" id="menuTexto4" name="menuTexto4" placeholder="Menu Texto 4" value="<?php echo $menuTexto4; ?>">

                <label for="">Menu Texto 5:</label>
                <input type="text" id="menuTexto5" name="menuTexto5" placeholder="Menu Texto 5" value="<?php echo $menuTexto5; ?>">

                <label for="">Titulo Pincipal:</label>
                <input type="text" id="tituloPrincipal" name="tituloPrincipal1" placeholder="Titulo Principal" value="<?php echo $tituloPrincipal1; ?>">
                
                <label for="">Titulo Pincipal 2:</label>
                <input type="text" id="tituloPrincipal2" name="tituloPrincipal2" placeholder="Titulo Principal 2" value="<?php echo $tituloPrincipal2; ?>">
                
                <label for="">Titulo Pincipal:</label>
                <input type="text" id="tituloPrincipal" name="tituloPrincipal" placeholder="Titulo Principal" value="<?php echo $tituloPrincipal1; ?>">
                              
                <label for="">Descripcion Menu 2:</label>
                <input type="text" id="descripcionMenu2" name="descripcionMenu2" placeholder="Descripcion Menu2" value="<?php echo $descripcionMenu2; ?>">
                
                <label for="">mapaURL:</label>
                <input type="text" id="mapaURL" name="mapaURL" placeholder="mapaURL " value="<?php echo $mapaURL; ?>">
                
                <label for="">direccionContacto:</label>
                <input type="text" id="direccionContacto" name="direccionContacto" placeholder="direccionContacto propiedad" value="<?php echo $direccionContacto; ?>">
               
                <label for="">telefonoContacto:</label>
                <input type="text" id="telefonoContacto" name="telefonoContacto" placeholder="telefonoContacto propiedad" value="<?php echo $telefonoContacto; ?>">
                
                <label for="">correoContacto:</label>
                <input type="text" id="correoContacto" name="correoContacto" placeholder="correoContacto propiedad" value="<?php echo $correoContacto; ?>">
               
                <img width="80px" src="/img-menu2/<?php echo $imagenMenu2; ?>" class="imagen-small" alt="">
                <input type="file" id="imagenMenu2" name="imagenMenu2" accept="image/jpeg, image/png">

            </fieldset>
           
            <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
        </form>

    </main>
