<?php
echo '
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: "REM", Arial, sans-serif;
    }

    body {
        background-color: #FBF2EE;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 100vh;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        padding: 20px;
        padding-top: 50px;
        padding-bottom: 80px;
        flex: 1;
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        width: 100%;
    }

    .product-card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        text-align: center;
        min-height: 280px;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-card .img-container {
        width: 100%;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
        overflow: hidden;
    }

    .product-card img {
        width: 90%;
        height: 130px;
        object-fit: contain;
        object-position: center;
        transition: transform 0.3s;
    }
    
    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card h3 {
        font-size: 15px;
        color: #333;
        margin: 0 0 8px 0;
        font-weight: 600;
    }

    .product-card p {
        font-size: 17px;
        font-weight: bold;
        color: #437F97;
        margin: 0 0 12px 0;
    }

    .actions {
        display: flex;
        gap: 8px;
        width: 100%;
        justify-content: center;
        align-items: center;
        margin-top: 8px;
    }

    .actions a, .actions button {
        padding: 8px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: none;
        cursor: pointer;
    }

    .view {
        background-color: #98D9C2;
    }

    .cart {
        background-color: #98D9C2;
    }

    .delete {
        background-color: #F08080;
    }

    input[type="number"] {
        width: 35px;
        height: 35px;
        padding: 5px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }
    
    @media screen and (max-height: 800px) {
        .container {
            padding-top: 70px;
            padding-bottom: 100px;
        }
    }
</style>

<div class="container">
    <div class="grid-container">';

$contador = 0;
foreach ($data as $article) {
    if ($contador >= 24) break;

    // Modificar esta línea para manejar URLs vacías
    $imagen = (!empty($article["Imagen"])) ? htmlspecialchars($article["Imagen"]) : "../utils/placeholder.png";

    echo '
        <div class="product-card">
            <div class="img-container">
                <img src="' . $imagen . '" alt="' . htmlspecialchars($article["Nombre_Producto"]) . '">
            </div>
            <h3>' . htmlspecialchars($article["Nombre_Producto"]) . '</h3>
            <p>' . htmlspecialchars($article["Precio"]) . '€</p>
            <form action="index.php" method="GET" style="margin-top: auto; width: 100%;" id="form_' . htmlspecialchars($article["ID_Producto"]) . '">
                <div class="actions">
                    <a href="index.php?controller=ProductController&action=verDetallesProducto&idProducto=' . htmlspecialchars($article["ID_Producto"]) . '" class="view">
                        <img style="width: 20px;" src="../utils/eye.svg"/>
                    </a>
                    
                    <input type="hidden" name="controller" value="ProductController">
                    <input type="hidden" name="action" value="addCarrito">
                    <input type="hidden" name="id" value="' . htmlspecialchars($article["ID_Producto"]) . '">
                    <input type="number" name="cantidad" value="1" min="1">

                    <button type="button" class="cart" onclick="confirmAddToCart(' . htmlspecialchars($article["ID_Producto"]) . ')">
                        <img style="width: 22px;" src="../utils/cart.svg"/>
                    </button>';
    
    if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin") {
        echo '
                    <a href="index.php?controller=ProductController&action=eliminarProducto&id=' . htmlspecialchars($article["ID_Producto"]) . '" class="delete" onclick="return confirmDelete()">
                        <img style="width: 20px;" src="../utils/trash.svg"/>
                    </a>';
    }
    
    echo '
                </div>
            </form>
        </div>';
    
    $contador++;
}

echo '</div></div>';

?>

<script>
function confirmAddToCart(id) {
    let confirmacion = confirm("¿Deseas añadir este producto al carrito?");
    if (confirmacion) {
        var form = document.getElementById("form_" + id);
        form.submit();
    }
}

function confirmDelete() {
    return confirm("¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.");
}
</script>