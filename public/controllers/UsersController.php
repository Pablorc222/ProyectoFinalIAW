<?php if (!class_exists('UsuController')) {
    class UsuController {
        
        public function showiniciosesion() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            View::show("views/login");
        }
        
        public function validacioniniciosesion() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $errores = array();
            
            if (isset($_POST['iniciarsesion'])) {
                $usuario = trim($_POST['usuario']);
                $contrasena = trim($_POST['contrasena']);
                
                if (empty($usuario)) {
                    $errores['usuario'] = "El nombre debe estar relleno";
                }
                
                if (empty($contrasena)) {
                    $errores['contrasena'] = "La contraseña no puede estar vacía";
                }
                
                if (empty($errores)) {
                    include_once('models/usuarios.php');
                    $uDAO = new UsuarioDAO();
                    $usuario_encontrado = $uDAO->getUser($usuario, $contrasena);
                    
                    if ($usuario_encontrado === null) {
                        $errores['general'] = "El usuario no está registrado o las credenciales son incorrectas.";
                        View::show("login", $errores);
                    } else {
                        $_SESSION['usuario'] = $usuario_encontrado['username'];
                        $_SESSION['usuario_id'] = $usuario_encontrado['id'];
                        $_SESSION['rol'] = $usuario_encontrado['rol'];
                        
                        // Comprobar si hay una redirección pendiente después del login
                        if (isset($_SESSION['redirect_after_login'])) {
                            $redirect = $_SESSION['redirect_after_login'];
                            unset($_SESSION['redirect_after_login']);
                            
                            
                            header("Location: " . $redirect);
                            exit();
                        } else {
                            header("Location: index.php");
                            exit();
                        }
                    }
                } else {
                    View::show("login", $errores);
                }
            }
        }
        
        // Método Cerrarsesion
        public function cerrarsesion() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            // Limpiar todas las variables de sesión
            $_SESSION = array();
            
            // Destruir la sesión
            session_destroy();
            
            // Redirigir a la página principal
            header("Location: index.php");
            exit();
        }
        
        // Listar pedidos solo para admins
        public function listarPedidos() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
                return;
            }
            
            include_once("models/pedidos.php");
            $pDAO = new PedidoDAO();
            $pedidos = $pDAO->getAllPedidos();
            
            View::show("listarPedidos", $pedidos);
        }
    }
} ?>