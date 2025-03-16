<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Contar elementos en el carrito
$itemsCarrito = 0;
if (isset($_SESSION['carrito'])) {
    $itemsCarrito = array_sum($_SESSION['carrito']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootStore ⚽</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=REM:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Estilos globales */
        body {
            margin: 0;
            font-family: "REM", sans-serif;
            background: url('utils/fondo2.jpg') no-repeat center center fixed;
            background-size: cover;
            padding-bottom: 1px;
        }

        header {
            background-color: rgba(5, 5, 23, 0.9);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 97%;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.6);
            z-index: 1000;
        }

        header h1 {
            margin: 0;
            color: #fff;
            font-size: 2em;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        header h1:hover {
            transform: scale(1.1);
        }

        header h1 i {
            color: #F5A623;
        }

        nav {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav a:hover {
            color: #F5A623;
            transform: scale(1.1);
        }

        .carrito-icono {
            position: relative;
        }

        .cantidad-carrito {
            background: #F5A623;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            padding: 5px;
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 0.9em;
        }

        span {
            color: #F5A623;
            font-weight: bold;
        }
    </style>
</head>
<body>
<header>
    <a href="index.php">
        <h1><i class="fas fa-futbol"></i> FootStore</h1>
    </a>
    <nav>
        <?php if (isset($_SESSION['usuario'])): ?>
            <span>
                <i class="fas fa-user"></i> Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </span>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                <a href="index.php?controller=UsuController&action=listarPedidos">
                    <i class="fas fa-box"></i> Listar Pedidos
                </a>
                <a href="index.php?controller=ProductController&action=insertProduct">
                    <i class="fas fa-plus-circle"></i> Crear
                </a>
            <?php endif; ?>

            <a href="index.php?controller=ProductController&action=verCarrito" class="carrito-icono">
                <i class="fas fa-shopping-cart"></i> Carrito
                <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>
                    <span class="cantidad-carrito">
                        <?php echo $itemsCarrito; ?>
                    </span>
                <?php endif; ?>
            </a>

            <a href="index.php?controller=UsuController&action=cerrarsesion">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>

        <?php else: ?>
            <!-- Añadir el enlace al carrito también para usuarios no autenticados -->
            <a href="index.php?controller=ProductController&action=verCarrito" class="carrito-icono">
                <i class="fas fa-shopping-cart"></i> Carrito
                <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>
                    <span class="cantidad-carrito">
                        <?php echo $itemsCarrito; ?>
                    </span>
                <?php endif; ?>
            </a>
            
            <a href="index.php?controller=UsuController&action=showiniciosesion">
                <i class="fas fa-key"></i> Login
            </a>
        <?php endif; ?>
    </nav>
</header>


</body>
</html>