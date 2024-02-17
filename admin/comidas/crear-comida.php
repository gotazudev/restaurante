<?php 

 //Base de datos
 require '../../includes/config/database.php'; 
 $db = conectarDB();

 //Consultar para obtener comidas
 $consulta = "SELECT * FROM comidas";
 $resultado = mysqli_query($db,$consulta);

 //Arreglo con mensajes de errores
 $errores=[];

 $titulo = '';
 $precio = '';
 $descripcion = '';
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
            $carpetaImagenes = '../../img-galeria/';
 
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = md5(uniqid(rand(),true)).".jpg";

            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);


        //Insertar en BD
        $query = "INSERT INTO comidas (titulo, precio, imagen, descripcion, creado ) VALUES ('$titulo', '$precio', '$nombreImagen','$descripcion', '$creado')";
        // echo $query;
        $resultado = mysqli_query($db,$query);

            if($resultado){
                // Redirecciona al usuario
                header('Location: /admin/comidas-restaurante.php?mensaje=1');
            }
        }
  }

?>

<main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/comidas/crear-comida.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion general</legend>

                <label for="">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo comida" value="<?php echo $titulo ?>">
                <label for="">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio comida" value="<?php echo $precio ?>">
                <label for="">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion" cols="30" rows="10" ><?php echo $descripcion ?></textarea>
            </fieldset>
            <input type="submit" value="Crear comida" class="boton boton-verde">
        </form>

    </main>