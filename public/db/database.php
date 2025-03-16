<?php
class Database {
    public static function connect() {
        $host = 'mariadb'; // Nombre del servicio en Docker Compose
        $dbname = 'Tienda';
        
        try {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=UTF8';
            $dbh = new PDO($dsn, 'root', 'changepassword', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            return $dbh;
        } catch (PDOException $e) {
            // Log del error
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            
            // Mostrar mensaje detallado para depuración. Validaciones hechas.
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>