<?php
    $mensaje = false;
    
    if (isset($_SESSION['mensaje'])) {
    	$mensaje = true;
    	unset($_SESSION['mensaje']);
    }
?>
