<?php
include_once ('db/database.php');

/**
 * Clase de acceso a datos para la tabla productos. Implementa todos los métodos que necesiten atacar
 * la tabla productos de la base de datos.
 */
if (!class_exists('ProductoDAO'));
class ProductoDAO {

    // Atributo con la conexión a la BBDD.
    public $db_con;

    // Constructor que inicializa la conexión a la BBDD.
    public function __construct(){
        $this->db_con = Database::connect();
    }

    // Método que devuelve un array con todos los productos existentes en la base de datos.
    public function getAllProducts(){
        try {
            $stmt = $this->db_con->prepare("SELECT * FROM Productos");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $productos = array();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // Método que devuelve toda la información de un producto dado su id.
    public function getProductById($id){
        try {
            $stmt = $this->db_con->prepare("SELECT * FROM Productos WHERE ID_producto = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Insertar un producto en la base de datos.
    /**
     * Parámetros: 
     *  $nombre, nombre del producto.
     *  $precio, precio del producto.
     *  $descripcion, descripción del producto.
     *  $imagen, URL o ruta de la imagen del producto.
     * 
     *  Retorna true si la inserción fue exitosa y false en caso contrario.
     */
    public function insertProduct($nombre, $precio, $descripcion, $imagen = ''){
        try {
            $stmt = $this->db_con->prepare("INSERT INTO Productos (Nombre_Producto, precio, Descripcion, Imagen) VALUES (:nombre, :precio, :descripcion, :imagen)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':imagen', $imagen);
            return $stmt->execute();
        } catch (PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Eliminar un producto de la base de datos dado su id.
    public function borrarprod($id){
        try {
            $stmt = $this->db_con->prepare("DELETE FROM Productos WHERE ID_Producto = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>