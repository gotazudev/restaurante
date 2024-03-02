<?php 
    include "includes/cabecera.php"; 
    include "includes/navbar.php";

  
    // Consultar
    $queryGaleria = "SELECT * FROM galeria";
    // Obtener resultados
    $galeriaResultado = mysqli_query($db,$queryGaleria);

    // Consultar
    $queryComidas = "SELECT * FROM comidas";
    // Obtener resultados
    $comidasResultado = mysqli_query($db,$queryComidas);

    // Consultar
    $queryInformacion = "SELECT * FROM informacion";
    // Obtener resultados
    $informacionResultado = mysqli_query($db,$queryInformacion);
    $info = mysqli_fetch_assoc($informacionResultado);


?>

  
    <header id="home" class="header" style="background: url(img-banner/<?php echo $info['imagenBanner']; ?>) no-repeat center center fixed;">
        <div class="overlay text-white text-center">
            <h1 class="display-2 font-weight-bold my-3"><?php echo $info['nombreEmpresa']; ?></h1>
            <h2 class="display-4 mb-5"><?php echo $info['tituloPrincipal1']; ?></h2>
            <a class="btn btn-lg btn-primary" href="#gallary">Ver galería</a>
        </div>
    </header>

    <!--  About Section  -->
    <div id="about" class="container-fluid wow fadeIn" id="about"data-wow-duration="1.5s">
        <div class="row">
            <div class="col-lg-6 has-img-bg" style="background: url(img-menu2/<?php echo $info['imagenMenu2']; ?>) no-repeat center center fixed;"></div>
            <div class="col-lg-6">
                <div class="row justify-content-center">
                    <div class="col-sm-8 py-5 my-5">
                        <h2 class="mb-4"><?php echo $info['menuTexto2']; ?></h2>
                        <p><?php echo $info['descripcionMenu2']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  gallary Section  -->
    <div id="gallary" class="text-center bg-dark text-light has-height-md middle-items wow fadeIn">
        <h2 class="section-title"><?php echo $info['menuTexto3']; ?></h2>
    </div>
    <div class="gallary row">
        <?php while( $gale = mysqli_fetch_assoc($galeriaResultado)): ?>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="img-galeria2/<?php echo $gale['imagen']; ?>" alt="imagensita" class="gallary-img">
        </div>
        <?php endwhile; ?>
    </div>


    <!-- BLOG Section  -->
    <div id="blog" class="container-fluid bg-dark text-light py-5 text-center wow fadeIn">
        <h2 class="section-title py-5"><?php echo $info['menuTexto4']; ?></h2>
        
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="foods" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                <?php while( $comi = mysqli_fetch_assoc($comidasResultado)): ?>
                    <div class="col-md-4">
                        <div class="card bg-transparent border my-3 my-md-0">
                            <img src="img-galeria/<?php echo $comi['imagen']; ?>" alt="template by DevCRID http://www.devcrud.com/" class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">S/<?php echo $comi['precio']; ?></a></h1>
                                <h4 class="pt20 pb20"><?php echo $comi['titulo']; ?></h4>
                                <p class="text-white"><?php echo $comi['descripcion']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTACT Section  -->
    <div id="contact" class="container-fluid bg-dark text-light border-top wow fadeIn">
        <div class="row">
            <div class="col-md-6 px-0">
                <iframe src="<?php echo $info['mapaURL']; ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6 px-5 has-height-lg middle-items">
                <h3><?php echo $info['menuTexto5']; ?></h3>
                <div class="text-muted">
                    <p><span class="ti-location-pin pr-3"></span> <?php echo $info['direccionContacto']; ?></p>
                    <p><span class="ti-support pr-3"></span> <?php echo $info['telefonoContacto']; ?></p>
                    <p><span class="ti-email pr-3"></span><?php echo $info['correoContacto']; ?></p>
                </div>
            </div>
        </div>
    </div>

<?php include "includes/footer.php" ?>

 