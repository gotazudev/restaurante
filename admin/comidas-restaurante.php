<?php 

//* 1. Importar la conexión:
require '../includes/config/database.php'; /* Exportamos la conexión */
$db = conectarDB();  /* Llamamos la función base de datos */
 
//* 2. Escribir el Query:
$query = "SELECT * FROM comidas";

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
        $query = "SELECT imagen FROM comidas WHERE id = " . $id;
 
        $resultadoDelete = mysqli_query($db, $query);
        $propiedad = mysqli_fetch_assoc($resultadoDelete);
 
        unlink('../imagenes/' . $propiedad['imagen']);
 
        //? Delete propierti
        $query = "DELETE FROM comidas WHERE id = " . $id;
        
        $resultadoDelete = mysqli_query($db, $query);
 
        if($resultadoDelete){
            header('Location: /admin/galeria.php?mensaje=3'); 
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

    <a href="/admin/comidas/crear-comida.php" class="boton boton-verde">Nueva propiedad</a>


<table class="comidas">
    <thead> <!-- Con esta etiqueta. Podemos diferncia el encabezado de una tabla. -->
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Descripcion</th>
            <th>Acciones</th>
        </tr>
    </thead>
 
    <tbody> 
    <?php while( $comida = mysqli_fetch_assoc($resultadoDB)): ?>
        <tr>
            <td> <?php echo $comida['id']; ?> </td>
            <td> <?php echo $comida['titulo']; ?> </td>
            <td> <?php echo $comida['precio']; ?> </td>
            <td> <img width="80px" src="/img-galeria/<?php echo $comida['imagen']; ?>" alt=""> </td>
            <td> <?php echo $comida['descripcion']; ?> </td>
            <td> 
                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $comida['id']; ?>"> <!-- Estos input tipo hidden no se pueden ver, pero si inspeccionamos el código só los podemos ver. No usamos tipo TEXT porque los usarios pueden modificarlo. -->
                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form>
                    <a href="/admin/comidas/actualizar-comida.php?id=<?php echo $comida['id']; ?>" class="boton-amarillo-block">Actualizar</a> <!-- Con este QueryString podremos mostrar por url el id de la propiedad a actualizar y esto nos ayudará a traernos la info de cada propiedad. -->
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
 
