<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pedidos</title>
    <style>
        .table-container {
            max-height: 400px; 
            overflow-y: auto;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }
        thead {
            position: sticky;
            top: 0;
            background-color: black;
            z-index: 10;
        }
         
    </style>
</head>
<body>
    <h2>Listado de Pedidos</h2>
    
    <?php if (!empty($data)): ?>
        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     // Invertir el orden de mis pedidos
                    $data = array_reverse($data);
                    foreach ($data as $pedido):
                     ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['ID_Pedido']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['usuario_nombre']); ?></td>
                            <td><?php echo number_format($pedido['total'], 2); ?> €</td>
                            <td><?php 
                                $fecha = new DateTime($pedido['fecha']); 
                                $fecha->setTimezone(new DateTimeZone('Europe/Madrid')); // Ajusta a mi zona horaria
                                echo $fecha->format('Y-m-d H:i:s'); 
                            ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No hay pedidos disponibles.</p>
    <?php endif; ?>
</body>
</html>