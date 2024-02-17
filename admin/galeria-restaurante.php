<?php 

//* 1. Importar la conexión:
require '../includes/config/database.php'; /* Exportamos la conexión */
$db = conectarDB();  /* Llamamos la función base de datos */
 
//* 2. Escribir el Query:
$query = "SELECT * FROM galeria";

// echo "<pre>";
// var_dump($query);
// echo "</pre>";

//* 3. Consultar la DB.
$resultadoDB = mysqli_query($db, $query);

$mensaje = $_GET['mensaje'] ?? null; //* Con esta variable global podemos enviar todo tipo de datos por medio de la URL. Con este placeholder de ?? lo que hace básciamente es buscar el valor y sino esta lo declara null (es una forma nueva, antes usamos el isset).
 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id']; 
    $id = filter_var($id, FILTER_VALIDATE_INT);
 
    if($id){
 
        //? Delete Files
        $query = "SELECT imagen FROM galeria WHERE id = " . $id;
 
        $resultadoDelete = mysqli_query($db, $query);
        $galeria = mysqli_fetch_assoc($resultadoDelete);
 
        unlink('../img-galeria2/' . $galeria['imagen']);
 
        //? Delete propierti
        $query = "DELETE FROM galeria WHERE id = " . $id;
        
        $resultadoDelete = mysqli_query($db, $query);
 
        if($resultadoDelete){
            header('Location: /admin/galeria-restaurante.php?mensaje=3'); 
        }
    }
    
}
 
?>

<h1>Administrador de bienes raices</h1> 
    <!-- Validamos si la creación fue correcta para dar un mensaje al usuario. -->
    <?php if( intval($mensaje) === 1) :?>     <!--  La función intval nos permite convertir de String a int -->
        <p class="alerta exito">¡Anuncio Creado Correctamente!</p>
    <?php elseif( intval($mensaje) === 2) :?>  
        <p class="alerta exito">¡Anuncio Actualizado Correctamente!</p>
    <?php elseif( intval($mensaje) === 3) :?>  
        <p class="alerta error">¡Anuncio Eliminado Correctamente!</p>
    <?php endif; ?>

    <a href="/admin/galeria/crear-galeria.php" class="boton boton-verde">Subir nueva imagen</a>


<table class="comidas">
    <thead> <!-- Con esta etiqueta. Podemos diferncia el encabezado de una tabla. -->
        <tr>
            <th>Imagen</th>
        </tr>
    </thead>
 
    <tbody> 
    <?php while( $galeria = mysqli_fetch_assoc($resultadoDB)): ?>
        <tr>
            <td> <img width="80px" src="/img-galeria2/<?php echo $galeria['imagen']; ?>" alt=""> </td>
            <td> 
                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $galeria['id']; ?>"> <!-- Estos input tipo hidden no se pueden ver, pero si inspeccionamos el código só los podemos ver. No usamos tipo TEXT porque los usarios pueden modificarlo. -->
                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form>
                    <a href="/admin/galeria/actualizar-galeria.php?id=<?php echo $galeria['id']; ?>" class="boton-amarillo-block">Actualizar</a> <!-- Con este QueryString podremos mostrar por url el id de la propiedad a actualizar y esto nos ayudará a traernos la info de cada propiedad. -->
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
 
