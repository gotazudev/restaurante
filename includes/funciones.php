<?php

function estaAutenticado() : bool{
    session_start();

    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
    return false;
}

function debuguear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

?>