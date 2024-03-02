<?php 
    
    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);


    //Base de datos
    include '../includes/config/database.php'; 
    $db = conectarDB();

    // Obtener los datos de la propiedad
    $consulta = "SELECT * FROM redessociales WHERE id = ".$id;
    $resultado = mysqli_query($db,$consulta);
    $red = mysqli_fetch_assoc($resultado);

    
    //Arreglo con mensajes de errores
    $errores=[];
    $facebook = $red['facebookURL'];
    $whatsapp = $red['whatsappURL'];
    $instagram = $red['instagramURL'];
    $tiktok = $red['tiktokURL'];

    //Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
    $facebook = mysqli_real_escape_string($db, $_POST["facebook"]);
    $whatsapp = mysqli_real_escape_string($db, $_POST['whatsapp']);
    $instagram = mysqli_real_escape_string($db, $_POST['instagram']);
    $tiktok = mysqli_real_escape_string($db, $_POST['tiktok']);
           
        if( empty($errores) ) {
               
        //Actualizar en BD
        $query = "UPDATE redessociales SET 
        facebookURL = '{$facebook}', 
        whatsappURL = '{$whatsapp}',
        instagramURL = '{$instagram}',
        tiktokURL = '{$tiktok}'
        WHERE id = {$id} ";


        $resultado = mysqli_query($db,$query);

            if($resultado){
                // Redirecciona al usuario
                header('Location: /admin/redes-sociales.php?mensaje=2');
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

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion general</legend>

                <label for="">Facebook:</label>
                <input type="text" id="facebook" name="facebook" placeholder="Face" value="<?php echo $facebook; ?>">
                
                <label for="">Whatsapp:</label>
                <input type="text" id="whatsapp" name="whatsapp" placeholder="Menu Texto 1" value="<?php echo $whatsapp; ?>">
                
                <label for="">Instagram:</label>
                <input type="text" id="instagram" name="instagram" placeholder="Menu Texto 2" value="<?php echo $instagram; ?>">
                
                <label for="">Tiktok:</label>
                <input type="text" id="tiktok" name="tiktok" placeholder="Menu Texto 3" value="<?php echo $tiktok; ?>">

            </fieldset>
           
            <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
        </form>

    </main>
