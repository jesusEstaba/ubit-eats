<?php
    session_start();
    
    require('funciones.php');
    require('basededatos.php');
    require('mensaje.php');
    
    if (!isset($_SESSION['cliente'])) {
        $_SESSION['cliente'] = md5(time());
    }
 
    $cliente = $_SESSION['cliente'];
    
    $consulta_productos = mysqli_query($conexion, "SELECT * FROM productos");
    $productos = get_result($consulta_productos);
    
    $sql = "
        SELECT * 
        FROM carrito 
        JOIN productos 
        ON productos.id=carrito.producto
        WHERE carrito.cliente='$cliente'";
    
    $consulta_productos_carrito = mysqli_query($conexion, $sql);
    $productos_carrito = get_result($consulta_productos_carrito);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css" type="text/css" />
    
    <title>Tienda BIT</title>
</head>
<body>
	<div class="logo">
		<div class="titulo">
			UBIT <span class="color">EATS</span>
		</div>
	</div>
	<?php if($mensaje): ?>
	<div class="contenedor">
		<div class="fila">
			<div class="columna completa">
				<div class="mensaje">
					<b>¡Gracias por tu compra!</b> con tu dinero somos cada vez más ricos :D.
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
    <div class="contenedor">
        <div class="fila">
            <div class="mitad-de columna">
                <div class="productos">
                    <?php foreach($productos as $producto): ?>
                        <div class="producto">
                            <div class="foto">
                                <img class="imagen-adaptable" src="/fotos/<?= $producto->foto ?>" />
                                <?php if($producto->descuento): ?>
                                    <span class="descuento">-<?= $producto->descuento ?>%</span>
                                <?php endif; ?>
                            </div>
                            <div class="informacion">
                                <p>
                                    <b><?= $producto->nombre ?></b>
                                </p>
                                <p class="texto centrado">$<?= number_format($producto->precio, 2) ?></p>
                                
                            </div>
                            <a class="pedir" href="pedir.php?producto=<?= $producto->id ?>">Pedir</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mitad-de columna a-la-derecha">
                <div class="factura">
                	<h1 class="texto centrado">FACTURA</h1>
                	<hr>
                	<?php
                		$total = 0;
                	?>
                    <?php foreach($productos_carrito as $producto_carrito): ?>
                        <div class="producto">
                            <?= $producto_carrito->nombre ?> 
                            <span class="precio">
                            	<?php if($producto_carrito->descuento): ?>
                            		<span class="descuento">
                            			(- <?= $producto_carrito->descuento ?>%)
                            		</span> 
                            	<?php endif; ?>
                            	$<?= number_format($producto_carrito->precio, 2) ?>
                            </span>
                        </div>
                        <?php
                        	$total += $producto_carrito->precio * (1 - $producto_carrito->descuento / 100);
                        ?>
                    <?php endforeach; ?>
                    
                    <?php if(!count($productos_carrito)): ?>
                    	<p class="texto centrado"><em>Sin productos pedidos</em></p>
                    <?php endif; ?>
                    <hr>
                    <h2>
                    	Total: <span class="a-la-derecha" style="color:green">$<?= number_format($total, 2) ?></span>
                    </h2>
                    
                    <p>
                    	<small><span style="color: red;"><b>**</b></span>Cabe destacar que esto es una aplicación de prueba para el curso de PHP de <span class="bit">BIT</span>, por lo tanto nadie te va a vender nada. Mejor pide una empanadas por <span class="rappi">Rappi</span>.</small>
                    	<br>
                    	<small>
                    		Pd: Puedes brindarle al profe.
                    	</small>
                    </p>
                </div>
                <a href="comprar.php" class="comprar">Comprar</a>
            </div>
        </div>
    </div>
</body>
</html>