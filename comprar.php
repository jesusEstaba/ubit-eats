<?php
    session_start();
    
    $_SESSION['cliente'] = md5(time());
    $_SESSION['mensaje'] = true;
    
    header("Location: index.php");
?>

