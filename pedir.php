<?php
    require('basededatos.php');
    
    session_start();
    
    $cliente = $_SESSION['cliente'];
    $producto = $_GET['producto'];
    
    $resultado = mysqli_query($conexion, "INSERT INTO carrito (cliente, producto) VALUES ('$cliente', '$producto')");
    
    header("Location: index.php");
?>