<?php 

//* 1. Importar la conexión:
require '../includes/config/database.php'; /* Exportamos la conexión */
$db = conectarDB();  /* Llamamos la función base de datos */
 
//* 2. Escribir el Query:
$query = "SELECT * FROM informacion";

//* 3. Consultar la DB.
$resultadoDB = mysqli_query($db, $query);

$mensaje = $_GET['mensaje'] ?? null; //* Con esta variable global podemos enviar todo tipo de datos por medio de la URL. Con este placeholder de ?? lo que hace básciamente es buscar el valor y sino esta lo declara null (es una forma nueva, antes usamos el isset).

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


<table class="comidas">
    <thead> <!-- Con esta etiqueta. Podemos diferncia el encabezado de una tabla. -->
        <tr>
            <th>Nombre de la empresa</th>
            <th>Imagen del logo</th>
            <th>Texto Menu 1</th>
            <th>Texto Menu 2</th>
            <th>Texto Menu 3</th>
            <th>Texto Menu 4</th>
            <th>Texto Menu 5</th>
            <th>Texto Principal 1</th>
            <th>Texto Principal 2</th>
            <th>Imagen Menu 2</th>
            <th>Descripcion Menu 2</th>
            <th>Contacto URL Mapa</th>
            <th>Correo</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Banner</th>
        </tr>
    </thead>
 
    <tbody> 
    <?php while( $info = mysqli_fetch_assoc($resultadoDB)): ?>
        <tr>
            <td> <?php echo $info['nombreEmpresa']; ?> </td>
            <td> <img width="80px" src="/img-logo/<?php echo $info['imagenLogo']; ?>" alt="e"> </td>
            
            <td> <?php echo $info['menuTexto1']; ?> </td>
            <td> <?php echo $info['menuTexto2']; ?> </td>
            <td> <?php echo $info['menuTexto3']; ?> </td>
            <td> <?php echo $info['menuTexto4']; ?> </td>
            <td> <?php echo $info['menuTexto5']; ?> </td>
            <td> <?php echo $info['tituloPrincipal1']; ?> </td>
            <td> <?php echo $info['tituloPrincipal2']; ?> </td>
            
            <td> <img width="80px" src="/img-menu2/<?php echo $info['imagenMenu2']; ?>" alt=""> </td>
            
            <td> <?php echo $info['descripcionMenu2']; ?> </td>
            <td> <?php echo $info['mapaURL']; ?> </td>
            <td> <?php echo $info['correoContacto']; ?> </td>
            <td> <?php echo $info['direccionContacto']; ?> </td>
            <td> <?php echo $info['telefonoContacto']; ?> </td>
            <td> <img width="80px" src="/img-banner/<?php echo $info['imagenBanner']; ?>" alt=""> </td>

            <td> 
                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $info['id']; ?>"> <!-- Estos input tipo hidden no se pueden ver, pero si inspeccionamos el código só los podemos ver. No usamos tipo TEXT porque los usarios pueden modificarlo. -->
                    <!-- <input type="submit" class="boton-rojo-block" value="Eliminar"> -->
                </form>
                    <a href="/admin/actualizar-informacion.php?id=<?php echo $info['id']; ?>" class="boton-amarillo-block">Actualizar</a> <!-- Con este QueryString podremos mostrar por url el id de la propiedad a actualizar y esto nos ayudará a traernos la info de cada propiedad. -->
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
 
