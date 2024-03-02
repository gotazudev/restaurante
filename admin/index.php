<?php 
    echo "CABECERA DE ADMIN XD";
    // include "cabeceradeADMINXD";
    include "../includes/cabecera.php";

    require '../includes/funciones.php';

    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /');
    }
    
?>



        <div class="row">
                <div class="row justify-content-center">
                    <div class="col-sm-8 py-5 my-5">
                        <h2 class="mb-4">Vista admin</h2>
                        <div class="row">
                            <div class="row">
                                <a href="/comidasPeruanas" class="btn btn-lg btn-primary my-2">Editar Comidas</a>
                            </div>
                            <div class="row">
                                <a href="/galeriaPeruana" class="btn btn-lg btn-primary my-2">Editar Galeria</a>
                            </div>
                            <div class="row">
                                <a href="informacion-restaurante.php" class="btn btn-lg btn-primary my-2">Editar Informacion</a href="galeria.php">
                            </div>
                            <div class="row">
                                <a href="redes-sociales.php" class="btn btn-lg btn-primary my-2">Editar Redes Sociales</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include "../includes/footer.php" ?>
