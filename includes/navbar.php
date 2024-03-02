<?php

include "cabecera.php";

// Importar la BD
require 'config/database.php';
$db = conectarDB();

// Consultar
$queryInformacion = "SELECT * FROM informacion";
// Obtener resultados
$informacionResultado = mysqli_query($db,$queryInformacion);
$info = mysqli_fetch_assoc($informacionResultado);


?>

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/#home"><?php echo $info['menuTexto1']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#about"><?php echo $info['menuTexto2']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#gallary"><?php echo $info['menuTexto3']; ?></a>
                </li>
            </ul>
            <a class="navbar-brand m-auto" href="#">
                <img src="img-logo/<?php echo $info['imagenLogo']; ?>" class="brand-img" alt="">
                <span class="brand-txt"><?php echo $info['nombreEmpresa']; ?></span>
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#blog"><?php echo $info['menuTexto4']; ?><span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact"><?php echo $info['menuTexto5']; ?></a>
                </li>
                <!-- <li class="nav-item">
                    <a href="components.html" class="btn btn-primary ml-xl-4">Components</a>
                </li> -->
            </ul>
        </div>
    </nav>