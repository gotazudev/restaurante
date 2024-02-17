<?php 
    
    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);


    //Base de datos
    include '../../includes/config/database.php'; 
    $db = conectarDB();

    // Obtener los datos de la propiedad
    $consulta = "SELECT * FROM comidas WHERE id = ".$id;
    $resultado = mysqli_query($db,$consulta);
    $comida = mysqli_fetch_assoc($resultado);

    //Arreglo con mensajes de errores
    $errores=[];

    $titulo = $comida['titulo'];
    $precio = $comida['precio'];
    $descripcion = $comida['descripcion'];
    // Por seguridad la imagen no se debe de llenar en actualizar
    $imagenComida = $comida['imagen'];  
    $creado = date('Y/m/d');   

    //Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $titulo = mysqli_real_escape_string($db, $_POST["titulo"]);
        $precio = mysqli_real_escape_string($db, $_POST["precio"]);
        $descripcion = mysqli_real_escape_string($db, $_POST["descripcion"]);

        //Asignar files hacia la variable
        $imagen = $_FILES['imagen'];
        

        if(!$titulo){
            $errores[] = "Debes añadir un titulo";
        }
        if(!$precio){
            $errores[] = "Debes añadir un precio";
        }
        if(strlen($descripcion) <10){
            $errores[] = "Debes añadir un descripcion y debes tener almenos 10 caracteres";
        }
       
        // $medida = 1000 * 100;
        // if($imagen['size'] > $medida){
        //     $errores[] = "La imagen es muy pesada";
        // }

        

        // Revisar que el arreglo de errores este vacío
        if( empty($errores) ) {

            // // Crear carpeta 
            $carpetaImagenes = '../../img-galeria/';
 
            if(!is_dir($carpetaImagenes)){
               mkdir($carpetaImagenes);
             }

            $nombreImagen = '';


            /* SUBIDA DE ARCHIVOS */
            if($imagen['name']){
                // Eliminar la imagen previa
                unlink($carpetaImagenes . $comida['imagen']);

                 // Generar imagen nombre unico
                $nombreImagen = md5(uniqid(rand(),true)).".jpg";

                // Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);
            } else{
                $nombreImagen = $comida['imagen'];
            }           

           
        //Insertar en BD
        $query = "UPDATE comidas SET titulo = '{$titulo}', precio = {$precio}, imagen='{$nombreImagen}', descripcion = '{$descripcion}' WHERE id = {$id} ";
        // echo $query;

        $resultado = mysqli_query($db,$query);

            if($resultado){
                // Redirecciona al usuario
                header('Location: /admin/comidas-restaurante.php?mensaje=2');
            }
        }
    }   


 ?>
    <main class="contenedor seccion">
        <h1>ACtualizar comida</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion general</legend>

                <label for="">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo $titulo ?>">
                <label for="">Precio:</label>

     <!-- Por seguridad la imagen no se debe de llenar en actualizar -->

                <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $precio ?>">
                <label for="">Imaagen:</label>

                <img width="80px" src="/img-galeria/<?php echo $imagenComida; ?>" class="imagen-small" alt="">

                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion" cols="30" rows="10" ><?php echo $descripcion ?></textarea>
            </fieldset>
           
            <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
        </form>

    </main>
