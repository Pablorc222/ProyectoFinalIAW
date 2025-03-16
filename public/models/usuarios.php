<?php
require_once 'db/database.php';

if (!class_exists('UsuarioDAO')) {
    class UsuarioDAO {
        public $db_con;
        
        public function __construct() {
            $this->db_con = Database::connect();
        }

        // Método para obtener un usuario por su nombre de usuario y contraseña
        public function getUser($usuario, $contrasena) {
            try {
                $stmt = $this->db_con->prepare("SELECT * FROM Usuarios WHERE username = ? AND password = ?");
                $stmt->execute([$usuario, $contrasena]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $result ? $result : null;
            } catch (PDOException $e) {
                error_log("Error en getUser: " . $e->getMessage());
                return null;
            }
        }

        // Método para obtener un usuario por su nombre de usuario
        public function getUserByUsername($username) {
            try {
                $stmt = $this->db_con->prepare("SELECT * FROM Usuarios WHERE username = ?");
                $stmt->execute([$username]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $result ? $result : null;
            } catch (PDOException $e) {
                error_log("Error en getUserByUsername: " . $e->getMessage());
                return null;
            }
        }

        // Método para obtener todos los usuarios
        public function getAllUsers() {
            try {
                $stmt = $this->db_con->prepare("SELECT * FROM Usuarios");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error al obtener todos los usuarios: " . $e->getMessage());
                return [];
            }
        }
    }
}
?>
