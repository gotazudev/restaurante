<?php 

 //Base de datos
 require '../../includes/config/database.php'; 
 $db = conectarDB();

 //Consultar para obtener comidas
 $consulta = "SELECT * FROM galeria";
 $resultado = mysqli_query($db,$consulta);

 //Arreglo con mensajes de errores
 $errores=[];

 $creado = date('Y/m/d'); 

  //Ejecutar el codigo despues de que el usuario envie el formulario
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Asignar files hacia la variable
        $imagen = $_FILES['imagen'];
        
        if(!$imagen['name'] || $imagen['error']){
            $errores[]= "La imagen es obligatoria";
        }

        // Validar por tamaño (100 kb maximo)
        // $medida = 1000 * 100;
        // if($imagen['size'] > $medida){
        //     $errores[] = "La imagen es muy pesada";
        // }

         // Revisar que el arreglo de errores este vacío
         if( empty($errores) ) {
            
            // Crear carpeta 
            $carpetaImagenes = '../../img-galeria2/';
 
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = md5(uniqid(rand(),true)).".jpg";

            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);


        //Insertar en BD
        $query = "INSERT INTO galeria (imagen, creado ) VALUES ('$nombreImagen', '$creado')";
        // echo $query;
        $resultado = mysqli_query($db,$query);

            if($resultado){
                // Redirecciona al usuario
                header('Location: /admin/galeria-restaurante.php?mensaje=1');
            }
        }
  }

?>

<main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin/galeria-restaurante.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/galeria/crear-galeria.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion general</legend>

                <label for="">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
            </fieldset>
            <input type="submit" value="Crear imagen" class="boton boton-verde">
        </form>

    </main>