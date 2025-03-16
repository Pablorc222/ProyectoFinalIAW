<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Comprobar rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<div style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; 
            width: 100%; height: 100vh; position: fixed; top: 0; left: 0;">

    <form class="form" action="index.php?controller=ProductController&action=insertProduct" method="post" enctype="multipart/form-data"
        style="background-color: #fff; border-radius: 15px; padding: 40px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); 
               width: 500px; display: flex; flex-direction: column; position: fixed; top: 50%; 
               transform: translateY(-50%); max-height: 80vh; overflow-y: auto;">

        <h2 style="text-align: center; margin-bottom: 30px; font-size: 28px;">Crear producto</h2>
        
        <input class="form-control" name="nombre" type="text" placeholder="Título" 
               style="padding: 15px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 10px; font-size: 18px;">
        <?php if (isset($data['nombre'])) echo "<div style='color: red; margin-bottom: 15px;'>{$data['nombre']}</div>"; ?>
        
        <input class="form-control" name="descripcion" type="text" placeholder="Descripción" 
               style="padding: 15px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 10px; font-size: 18px;">
        <?php if (isset($data['descripcion'])) echo "<div style='color: red; margin-bottom: 15px;'>{$data['descripcion']}</div>"; ?>
        
        <input class="form-control" name="precio" type="number" placeholder="Precio" 
               style="padding: 15px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 10px; font-size: 18px;">
        <?php if (isset($data['precio'])) echo "<div style='color: red; margin-bottom: 15px;'>{$data['precio']}</div>"; ?>
        
        <!-- Campos para la imagen -->
        <label for="imagen_url" style="margin-bottom: 8px;">URL de la imagen:</label>
        <input type="text" id="imagen_url" name="imagen_url" placeholder="Ej: https://ejemplo.com/imagen.jpg" 
               style="padding: 15px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 10px; font-size: 18px; width: 100%;">
        
        <?php if (isset($data['imagen'])) echo "<div style='color: red; margin-bottom: 15px;'>{$data['imagen']}</div>"; ?>
        <?php if (isset($data['general'])) echo "<div style='color: red; margin-bottom: 15px;'>{$data['general']}</div>"; ?>

        <button class="form-group" name="insertar" type="submit" 
                style="background-color: #437F97; color: white; padding: 15px; border: none; border-radius: 10px; 
                       cursor: pointer; font-size: 20px; width: 100%; margin-top: 10px;">
            Crear
        </button>
    </form>
</div>