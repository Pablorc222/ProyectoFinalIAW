<?php
// Solo iniciar la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializar el array de carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Aquí iría el código para obtener los productos del carrito
// El $data debería estar ya definido por el controlador que llama a esta vista
// No necesitamos verificar si está logueado aquí, lo haremos al confirmar pedido

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootStore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=REM:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div style="font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; padding: 60px;">
        <h1 style="margin-bottom: 40px;">Carrito de Compra</h1>
        
        <!-- Listado de productos en el carrito -->
        <div style="width: 50%; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; margin-bottom: 20px;">
           <!-- Productos en el carrito -->
            <?php
            if (empty($data)) {
                echo '<div style="text-align: center; padding: 20px;">';
                echo '<p>No hay productos en el carrito</p>';
                echo '<a href="index.php?controller=ProductController&action=getAllProducts" style="display: inline-block; margin-top: 15px; padding: 8px 15px; background-color: #437F97; color: white; text-decoration: none; border-radius: 5px;">Seguir comprando</a>';
                echo '</div>';
            } else {
                $total = 0;
                foreach ($data as $producto) {
                    $subtotal = $producto['Precio'] * $producto['cantidad'];
                    $total += $subtotal;
                    
                    echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee;">';
                    echo '<div>';
                    echo '<h3 style="margin: 0;">' . $producto['Nombre_Producto'] . '</h3>';
                    echo '<p style="margin: 5px 0;">Precio: ' . $producto['Precio'] . '€ | Cantidad: ' . $producto['cantidad'] . '</p>';
                    echo '<p style="margin: 0; font-weight: bold;">Subtotal: ' . number_format($subtotal, 2) . '€</p>';
                    echo '</div>';
                    echo '<a href="index.php?controller=ProductController&action=eliminarDelCarrito&id=' . $producto['ID_Producto'] . '" style="text-decoration: none; color: inherit; padding: 10px; background-color: #98D9C2; border: none; border-radius: 5px; cursor: pointer; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">';
                    echo '<img style="width: 75%;" src="../utils/trash.svg" alt="Eliminar">';
                    echo '</a>';
                    echo '</div>';
                }
                
                // Mostrar el total
                echo '<div style="margin-top: 20px; padding-top: 15px; border-top: 2px solid #437F97; text-align: right;">';
                echo '<h3>Total: ' . number_format($total, 2) . '€</h3>';
                echo '</div>';
                
                // Botones de acción
                echo '<div style="display: flex; justify-content: space-between; margin-top: 20px;">';
                echo '<a href="index.php?controller=ProductController&action=getAllProducts" style="text-decoration: none;">';
                echo '<button type="button" style="padding: 10px 20px; background-color: #98D9C2; color: white; border: none; border-radius: 5px; cursor: pointer;">';
                echo '<span style="font-size: 16px;">Seguir comprando</span>';
                echo '</button>';
                echo '</a>';
                
                // Modificación aquí: Verificar si el usuario está autenticado
                if (isset($_SESSION['usuario'])) {
                    // Usuario autenticado: enlace directo a confirmar pedido
                    echo '<a href="index.php?controller=ProductController&action=confirmarPedido" style="text-decoration: none;">';
                    echo '<button type="button" style="padding: 10px 20px; background-color: #437F97; color: white; border: none; border-radius: 5px; cursor: pointer;">';
                    echo '<span style="font-size: 16px;">Confirmar Pedido</span>';
                    echo '</button>';
                    echo '</a>';
                } else {
                    // Usuario no autenticado: enlace directo a la página de login
                    // Guardamos la URL de redirección en la sesión
                    $_SESSION['redirect_after_login'] = "index.php?controller=ProductController&action=confirmarPedido";
                    $_SESSION['mensaje'] = "Debes iniciar sesión para confirmar el pedido.";
                    
                    echo '<a href="index.php?controller=UsuController&action=showiniciosesion" style="text-decoration: none;">';
                    echo '<button type="button" style="padding: 10px 20px; background-color: #437F97; color: white; border: none; border-radius: 5px; cursor: pointer;">';
                    echo '<span style="font-size: 16px;">Confirmar Pedido</span>';
                    echo '</button>';
                    echo '</a>';
                }
                
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Pie de página -->
    <footer style="margin-top: 20px; text-align: center; font-size: 14px; font-weight: bold;">
    <p><b>© 2024 FootStore. Todos los derechos reservados.</b></p>
</footer>


</body>
</html>