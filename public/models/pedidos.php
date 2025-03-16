<?php
require_once 'db/database.php';

if (!class_exists('PedidoDAO')) {
    class PedidoDAO {
        private $db_con;

        public function __construct() {
            $this->db_con = Database::connect();
        }

        // Método para obtener todos los pedidos
        public function getAllPedidos() {
            try {
                $stmt = $this->db_con->prepare("
                    SELECT 
                        p.id AS ID_Pedido, 
                        u.username AS usuario_nombre, 
                        p.total, 
                        p.fecha
                    FROM Pedidos p
                    LEFT JOIN Usuarios u ON p.usuario_id = u.id
                    ORDER BY p.fecha DESC
                ");
                $stmt->execute();
                $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                return $pedidos;
            } catch (PDOException $e) {
                error_log("Error al obtener todos los pedidos: " . $e->getMessage());
                return [];
            }
        }

        // Método para añadir productos a un pedido
        public function addProductToPedido($pedido_id, $producto_id, $cantidad, $precio_unitario) {
            try {
                // Preparar la consulta SQL para insertar el detalle del pedido
                $stmt = $this->db_con->prepare("INSERT INTO DetallePedidos (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
                
                // Ejecutar la consulta
                return $stmt->execute([$pedido_id, $producto_id, $cantidad, $precio_unitario]);
            } catch (PDOException $e) {
                // Manejar cualquier error de base de datos
                error_log("Error al añadir producto al pedido: " . $e->getMessage());
                return false;
            }
        }

        // Método para obtener todos los pedidos de un usuario
        public function getPedidosByUsuario($usuario_id) {
            try {
                $stmt = $this->db_con->prepare("SELECT * FROM Pedidos WHERE usuario_id = ?");
                $stmt->execute([$usuario_id]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error al obtener pedidos: " . $e->getMessage());
                return [];
            }
        }

        // Método para crear un nuevo pedido
        public function createPedido($usuario_id, $total) {
            try {
                // Insertar el pedido en la tabla Pedidos
                $stmt = $this->db_con->prepare("INSERT INTO Pedidos (usuario_id, total, fecha) VALUES (?, ?, NOW())");
                $stmt->execute([$usuario_id, $total]);
                
                // Obtener el ID del pedido recién insertado
                return $this->db_con->lastInsertId();
            } catch (PDOException $e) {
                error_log("Error al crear el pedido: " . $e->getMessage());
                return null;
            }
        }
    }
}
?>