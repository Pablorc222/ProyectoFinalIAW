<?php

echo '
<div style="margin-top: 75px; margin-bottom: 150px;">
    <div style="font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; padding: 20px;">
        <h1 style="margin-bottom: 20px;">Detalles del Producto</h1>
    </div>';

echo '<div style="display: flex; flex-wrap: wrap; justify-content: center;">';

// Accedemos correctamente a los datos usando $data['producto']
echo '
    <div style="width: calc(75% - 20px); background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 20px;">
        <img src="' . htmlspecialchars($data['producto']['Imagen']) . '" alt="' . htmlspecialchars($data['producto']['Nombre_Producto']) . '" style="width: 425px; height: 250px; border-top-left-radius: 10px; border-top-right-radius: 10px; object-fit: contain;">
        <div style="flex-grow: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
            <div style="flex-grow: 1; display: flex; flex-direction: row; align-items: center; gap: 20px">
                <h3 style="margin-top: 30px; font-size: 30px;">' . htmlspecialchars($data['producto']['Nombre_Producto']) . '</h3>
                <form action="index.php" method="GET" style="display: flex; align-items: center;">
                    <input type="hidden" name="controller" value="ProductController">
                    <input type="hidden" name="action" value="addCarrito">
                    <input type="hidden" name="id" value="' . htmlspecialchars($data['producto']['ID_Producto']) . '">
                    <input type="number" name="cantidad" value="1" min="1" style="width: 40px; margin-right: 10px;">
                    <button type="submit" style="text-decoration: none; color: inherit; padding: 10px 20px; background-color: #98D9C2; border: none; border-radius: 5px; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 10px">
                        <p style="font-size: 16px; margin: 0;">' . htmlspecialchars($data['producto']['Precio']) . '€</p>
                        <img style="width: 20px;" src="../utils/cart.svg">
                    </button>
                </form>
            </div>  
            <p style="margin-top: 10px; font-size: 18px;">' . htmlspecialchars($data['producto']['Descripcion']) . '</p>
            <a href="index.php" style="margin-top: 20px; padding: 10px 20px; background-color: #eee; color: #333; text-decoration: none; border-radius: 5px;">Volver a productos</a>
        </div>
    </div>';

echo '</div>';
echo '</div>';
?>