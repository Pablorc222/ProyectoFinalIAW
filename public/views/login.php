<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Estilo global para el body */
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f1f1f1; /* Fondo claro */
            overflow: hidden; /* Evita que la página haga scroll */
        }

        /* Contenedor principal del formulario */
        #formulario {
            background-color: #fff;
            border-radius: 10px;
            padding: 40px 60px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Máximo ancho de 400px */
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        /* Título del formulario */
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Estilo de los campos de texto */
        label {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
            text-align: left;
        }

        input {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #007BFF;
            outline: none;
        }

        /* Estilo del botón de inicio de sesión */
        button {
            background-color: #007BFF;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Estilo de los mensajes de error */
        .alert {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }

        .alert-danger {
            color: #e74c3c;
        }
        
        /* Estilo para mensajes de sesión */
        .alert-session {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }


    </style>
</head>
<body>

<div id="formulario">
    <?php
    // Mostrar mensaje de pedido exitoso si existe
    if (isset($_SESSION['pedido_exitoso'])) {
        echo "<div class='alert-success'>" . htmlspecialchars($_SESSION['pedido_exitoso']) . "</div>";
        
        // Limpiar el mensaje de pedido exitoso
        unset($_SESSION['pedido_exitoso']);
    }

    // Mostrar mensaje de sesión si existe
    if (isset($_SESSION['mensaje'])) {
        echo "<div class='alert-session'>" . htmlspecialchars($_SESSION['mensaje']) . "</div>";
        unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
    }
    ?>

    <form action="index.php?controller=UsuController&action=validacioniniciosesion" method="POST">
        <h2>Inicio de Sesión</h2>

        <label for="usuario">Nombre de usuario:</label>
        <input placeholder="Usuario" type="text" id="usuario" name="usuario" required>
        
        <?php
        if (isset($data) && isset($data['usuario'])) {
            echo "<div class='alert alert-danger'>" . htmlspecialchars($data['usuario']) . "</div>";
        }
        ?>

        <label for="contrasena">Contraseña:</label>
        <input placeholder="Contraseña" type="password" id="contrasena" name="contrasena" required>

        <button type="submit" name="iniciarsesion">Entrar</button>
    </form>

    <?php
    if (isset($data) && isset($data['contrasena'])) {
        echo "<div class='alert alert-danger'>" . htmlspecialchars($data['contrasena']) . "</div>";
    }
    if (isset($data) && isset($data['general'])) {
        echo "<div class='alert alert-danger'>" . htmlspecialchars($data['general']) . "</div>";
    }
    ?>
</div>

</body>
</html>