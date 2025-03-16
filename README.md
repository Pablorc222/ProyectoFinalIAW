# ProyectoFinalIAW
# FootStore ⚽

## Introducción
FootStore es una aplicación web de comercio electrónico especializada en la venta de botas de fútbol, desarrollada como proyecto final del módulo de Desarrollo de Aplicaciones Web (DAW). La plataforma ofrece una experiencia de compra completa e intuitiva para entusiastas del fútbol.

---

## Objetivos del Proyecto
### Objetivos Funcionales
- Implementar un sistema de gestión de productos con funcionalidades CRUD
- Crear un carrito de compras completamente funcional
- Desarrollar un sistema de autenticación y autorización de usuarios
- Gestionar pedidos con seguimiento detallado
- Proporcionar una interfaz de administración para gestión de productos y pedidos

### Objetivos Técnicos
- Utilizar arquitectura MVC (Modelo-Vista-Controlador)
- Implementar seguridad en las transacciones y autenticación
- Crear una aplicación responsive y accesible
- Optimizar el rendimiento de la aplicación
- Usar contenedores Docker para despliegue y desarrollo

---

## Características Principales
### Sistema de Autenticación
- Registro e inicio de sesión de usuarios
- Roles de usuario (admin y cliente)
- Gestión de sesiones segura

### Catálogo de Productos
- Visualización de botas de fútbol
- Detalles completos de productos
- Filtrado y búsqueda de productos

### Carrito de Compras
- Añadir y eliminar productos
- Cálculo de totales
- Gestión de cantidades

### Panel de Administración
- Crear, editar y eliminar productos
- Visualización de pedidos
- Gestión de usuarios

---

## 🛠️ Arquitectura Técnica
### Estructura de Directorios
```
FootStore/
│
├── controllers/
│   ├── ProductsController.php
│   └── UsersController.php
│
├── models/
│   ├── productos.php
│   ├── usuarios.php
│   └── pedidos.php
│
├── views/
│   ├── showProducts.php
│   ├── productDetails.php
│   └── cart.php
│
├── db/
│   └── database.php
│
└── docker-compose.yml
```

### Ejemplo de Controlador de Productos
```php
class ProductController {
    public function getAllProducts() {
        $pDAO = new ProductoDAO();
        $products = $pDAO->getAllProducts();
        View::show("showProducts", $products);
    }

    public function addCarrito() {
        session_start();
        
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

        $_SESSION['mensaje'] = "Producto añadido al carrito";
        header("Location: index.php?controller=ProductController&action=getAllProducts");
        exit();
    }
}
```

### Ejemplo de Modelo de Productos
```php
class ProductoDAO {
    public function getAllProducts() {
        try {
            $stmt = $this->db_con->prepare("SELECT * FROM Productos");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return [];
        }
    }

    public function insertProduct($nombre, $precio, $descripcion, $imagen) {
        try {
            $stmt = $this->db_con->prepare(
                "INSERT INTO Productos 
                (Nombre_Producto, precio, Descripcion, Imagen) 
                VALUES (:nombre, :precio, :descripcion, :imagen)"
            );
            
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':imagen', $imagen);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al insertar producto: " . $e->getMessage());
            return false;
        }
    }
}
```

---

## Configuración Docker Detallada
```yaml
version: '3.8'
services:
  nginx:
    image: nginx:1.23.3-alpine
    ports:
      - "80:80"
    volumes:
      - ./:/var/www/html
      - ./nginx.conf:/etc/nginx/nginx.conf
    depends_on:
      - php-fpm

  php-fpm:
    build: 
      context: .
      dockerfile: Dockerfile-php
    volumes:
      - ./:/var/www/html
    environment:
      - PHP_MEMORY_LIMIT=256M

  mariadb:
    image: mariadb:10.10.2
    environment:
      MYSQL_ROOT_PASSWORD: changepassword
      MYSQL_DATABASE: Tiendadezapatillas
    volumes:
      - mariadb_data:/var/lib/mysql

  redis:
    image: redis:7.0.7-alpine
    ports:
      - "6379:6379"

volumes:
  mariadb_data:
```

---

## Despliegue y Configuración
### Requisitos Previos
- Docker
- Docker Compose
- Git

### Pasos de Instalación
1. Clonar el repositorio
```bash
git clone https://github.com/Pablorc222/ProyectoFinalIAW
cd FootStore
```
2. Configurar variables de entorno
```bash
cp .env.example .env
# Editar configuraciones según sea necesario
```
3. Levantar contenedores
```bash
docker-compose up -d --build
```
4. Configurar base de datos
```bash
docker-compose exec mariadb mysql -u root -p
# Ejecutar scripts de migración
```

---

## Tecnologías y Herramientas
### Backend
- PDO para acceso a base de datos
- Arquitectura MVC
- Gestión de sesiones

### Infraestructura
- Docker
- Docker Compose
- Nginx
- MariaDB
- Redis

### Herramientas de Desarrollo
- Git & GitHub
- Visual Studio Code

---
