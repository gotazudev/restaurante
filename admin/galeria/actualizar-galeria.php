<?php 
    
    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);


    //Base de datos
    include '../../includes/config/database.php'; 
    $db = conectarDB();

    // Obtener los datos de la propiedad
    $consulta = "SELECT * FROM galeria WHERE id = ".$id;
    $resultado = mysqli_query($db,$consulta);
    $galeria = mysqli_fetch_assoc($resultado);

    //Arreglo con mensajes de errores
    $errores=[];

    // Por seguridad la imagen no se debe de llenar en actualizar
    $imagenGaleria = $galeria['imagen'];  
    $creado = date('Y/m/d');   

    //Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        //Asignar files hacia la variable
        $imagen = $_FILES['imagen'];
        
        // $medida = 1000 * 100;
        // if($imagen['size'] > $medida){
        //     $errores[] = "La imagen es muy pesada";
        // }

        // Revisar que el arreglo de errores este vacío
        if( empty($errores) ) {

            // // Crear carpeta 
            $carpetaImagenes = '../../img-galeria2/';
 
            if(!is_dir($carpetaImagenes)){
               mkdir($carpetaImagenes);
             }

            $nombreImagen = '';


            /* SUBIDA DE ARCHIVOS */
            if($imagen['name']){
                // Eliminar la imagen previa
                unlink($carpetaImagenes . $galeria['imagen']);

                 // Generar imagen nombre unico
                $nombreImagen = md5(uniqid(rand(),true)).".jpg";

                // Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);
            } else{
                $nombreImagen = $galeria['imagen'];
            }           

           
        //Insertar en BD
        $query = "UPDATE galeria SET imagen='{$nombreImagen}' WHERE id = {$id} ";
        // echo $query;

        $resultado = mysqli_query($db,$query);

            if($resultado){
                // Redirecciona al usuario
                header('Location: /admin/galeria-restaurante.php?mensaje=2');
            }
        }
    }   


 ?>
    <main class="contenedor seccion">
        <h1>ACtualizar galeria</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion general</legend>

     <!-- Por seguridad la imagen no se debe de llenar en actualizar -->
                <label for="">Imagen:</label>
                <img width="80px" src="/img-galeria2/<?php echo $imagenGaleria; ?>" class="imagen-small" alt="">

                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
            </fieldset>
           
            <input type="submit" value="Actualizar galeria" class="boton boton-verde">
        </form>

    </main>
