<?php
session_start();

// Incluir las dependencias necesarias
include_once("views/View.php");
include_once("controllers/ProductsController.php");
include_once("controllers/UsersController.php");

// Obtener el controlador y la acción desde la URL
$controller = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : 'ProductController';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'getAllProducts';

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Si el usuario está logueado, proceder con la acción solicitada
    if ($controller == 'ProductController' && $action == 'getAllProducts') {
        // Mostrar los productos
        $productController = new ProductController();
        $productController->getAllProducts();
    } else {
        // Instanciar el controlador y ejecutar la acción correspondiente
        $controllerInstance = new $controller();
        $controllerInstance->$action();
    }
} else {
    // Si el usuario no está logueado, verificar la acción solicitada
    if (isset($_REQUEST['action']) && isset($_REQUEST['controller'])) {
        // Si el usuario no está logueado y la acción requiere autenticación
        if ($_REQUEST['controller'] == 'CartController' || $_REQUEST['controller'] == 'OrderController') {
            // Redirigir a la página de login si intenta acceder a estas acciones sin estar logueado
            header("Location: login.php");
            exit();
        } else {
            // Si no es una acción que requiera login, procesar la solicitud
            $act = $_REQUEST['action'];
            $cont = $_REQUEST['controller'];

            // Instanciar el controlador e invocar el método
            $controller = new $cont();
            $controller->$act();
        }
    } else {
        // Si no hay acción en la URL, mostrar los productos
        $productController = new ProductController();
        $productController->getAllProducts();
    }
}
?>
