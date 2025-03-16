<?php
include_once("views/View.php");
include_once("models/productos.php");  
include_once("models/pedidos.php"); 

// Verificar si la clase ya existe antes de declararla
if (!class_exists('ProductController')) {
    class ProductController {

        // Mostrar todos los productos
        public function getAllProducts() {
            // Iniciar sesión si no está iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $pDAO = new ProductoDAO();
            $products = $pDAO->getAllProducts();
            $pDAO = null;

            // Mostrar vista con todos los productos (sin modificar las imágenes)
            View::show("showProducts", $products);
        }

        // Método para ver detalles de un producto específico
        public function verDetallesProducto() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_REQUEST['idProducto'])) {
                $idProducto = $_REQUEST['idProducto'];
                $pDAO = new ProductoDAO();
                $producto = $pDAO->getProductById($idProducto);
                
                if ($producto) {
                    // Mostrar la vista de detalles del producto
                    View::show("productDetails", ['producto' => $producto]);
                } else {
                    // Si el producto no existe, mostrar un mensaje de error
                    $_SESSION['mensaje'] = "El producto solicitado no existe.";
                    header("Location: index.php?controller=ProductController&action=getAllProducts");
                    exit();
                }
            } else {
                // Si no se proporcionó un ID de producto, volver a la lista de productos
                $this->getAllProducts();
            }
        }

        // Obtener todos los productos para un uso posterior
        public function getProductsData() {
            $pDAO = new ProductoDAO();
            $products = $pDAO->getAllProducts();
            $pDAO = null;
            
            return $products;
        }

        // Eliminar un producto
        public function eliminarProducto() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Verificar si el usuario es administrador
            if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
                $_SESSION['mensaje'] = "No tienes permisos para eliminar productos.";
                header("Location: index.php?controller=ProductController&action=getAllProducts");
                exit();
            }

            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                $pDAO = new ProductoDAO();
                $pDAO->borrarprod($id);
                $_SESSION['mensaje'] = "El producto ha sido eliminado correctamente.";
                header("Location: index.php?controller=ProductController&action=getAllProducts");
                exit();
            } else {
                header("Location: index.php?controller=ProductController&action=getAllProducts");
                exit();
            }
        }

        // Ver el carrito de compras
        public function verCarrito() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }

            $ProductoDAO = new ProductoDAO();
            $productosCarrito = array();
            $total = 0;

            foreach ($_SESSION['carrito'] as $id => $cantidad) {
                $producto = $ProductoDAO->getProductById($id);
                if ($producto) {
                    $producto['cantidad'] = $cantidad;
                    $producto['subtotal'] = $producto['Precio'] * $cantidad;
                    $total += $producto['subtotal'];
                    $productosCarrito[] = $producto;
                }
            }

            View::show("cart", $productosCarrito);
        }

        // Eliminar producto del carrito
        public function eliminarDelCarrito() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['carrito']) && isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                if (isset($_SESSION['carrito'][$id])) {
                    unset($_SESSION['carrito'][$id]);
                    $_SESSION['mensaje'] = "El producto ha sido eliminado del carrito.";
                }
            }

            $this->verCarrito();
        }

        // Insertar un nuevo producto
        public function insertProduct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
                header("Location: index.php?controller=UsuController&action=showiniciosesion");
                exit();
            }

            $errores = array();

            if (isset($_POST['insertar'])) {
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);
                $precio = trim($_POST['precio']);
                
                // Validaciones más robustas
                if (empty($nombre)) {
                    $errores['nombre'] = "El nombre del producto no puede estar vacío.";
                } elseif (strlen($nombre) < 3) {
                    $errores['nombre'] = "El nombre debe tener al menos 3 caracteres.";
                }

                if (empty($precio) || !is_numeric($precio) || $precio <= 0) {
                    $errores['precio'] = "El precio debe ser un número válido mayor que cero.";
                }

                if (empty($descripcion) || strlen($descripcion) < 10) {
                    $errores['descripcion'] = "La descripción debe tener al menos 10 caracteres.";
                }

                if (!empty($_POST['imagen_url'])) {
                    $imagen_path = trim($_POST['imagen_url']);
                }

                if (empty($errores)) {
                    $pDAO = new ProductoDAO();

                    if ($pDAO->insertProduct($nombre, $precio, $descripcion, $imagen_path)) {
                        $_SESSION['mensaje'] = "El producto \"" . htmlspecialchars($nombre) . "\" se ha creado correctamente.";
                        header("Location: index.php?controller=ProductController&action=getAllProducts");
                        exit();
                    } else {
                        $errores['general'] = "Hubo un problema al insertar el producto. Inténtalo de nuevo.";
                        View::show("addProduct", $errores);
                    }
                } else {
                    View::show("addProduct", $errores);
                }
            } else {
                View::show("addProduct", null);
            }
        }

        // Agregar un producto al carrito
        public function addCarrito() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }

            $idproducto = $_REQUEST['id'];
            $cantidad = max(1, intval($_REQUEST['cantidad'])); 

            if (!isset($_SESSION['carrito'][$idproducto])) {
                $_SESSION['carrito'][$idproducto] = $cantidad;
            } else {
                $_SESSION['carrito'][$idproducto] += $cantidad;
            }

            $_SESSION['mensaje'] = "El producto ha sido añadido al carrito exitosamente.";
            header("Location: index.php?controller=ProductController&action=getAllProducts");
            exit();
        }

        // Confirmar un pedido
        public function confirmarPedido() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['usuario'])) {
                $_SESSION['mensaje'] = "Debes iniciar sesión para confirmar el pedido.";
                header("Location: index.php?controller=UsuController&action=showiniciosesion");
                exit();
            }

            if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
                $_SESSION['mensaje'] = "No hay productos en tu carrito.";
                header("Location: index.php?controller=ProductController&action=getAllProducts");
                exit();
            }

            include_once 'models/productos.php';
            include_once 'models/usuarios.php';
            include_once 'models/pedidos.php';

            $pDAO = new ProductoDAO();
            $uDAO = new UsuarioDAO();
            $pedidoDAO = new PedidoDAO();

            $user = $uDAO->getUserByUsername($_SESSION['usuario']);
            if (!$user) {
                $_SESSION['mensaje'] = "Usuario no encontrado.";
                header("Location: index.php?controller=UsuController&action=showiniciosesion");
                exit();
            }

            $total = 0;
            $productosCarrito = array();

            foreach ($_SESSION['carrito'] as $id => $cantidad) {
                $producto = $pDAO->getProductById($id);
                if ($producto) {
                    $subtotal = $producto['Precio'] * $cantidad;
                    $total += $subtotal;
                    $productosCarrito[] = array(
                        'id' => $id,
                        'cantidad' => $cantidad,
                        'precio' => $producto['Precio']
                    );
                }
            }

            $pedido_id = $pedidoDAO->createPedido($user['id'], $total);

            if ($pedido_id) {
                foreach ($productosCarrito as $producto) {
                    $pedidoDAO->addProductToPedido(
                        $pedido_id, 
                        $producto['id'], 
                        $producto['cantidad'], 
                        $producto['precio']
                    );
                }

                $_SESSION['carrito'] = array();
        
                header("Location: index.php?controller=ProductController&action=getAllProducts");
                exit();
            } else {
                header("Location: index.php?controller=ProductController&action=verCarrito");
                exit();
            }
        }
    }
}
?>