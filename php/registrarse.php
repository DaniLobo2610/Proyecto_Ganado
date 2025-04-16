<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E3C8B1;
            color: white;
            font-family: Arial, sans-serif;
        }
        .login-container {
            box-sizing: content-box;
            width: 300px;
            margin: 20px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            text-align: center;
        }
        .login-container h2 {
            color: #E0523F;
            margin-bottom: 20px;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: rgb(226, 224, 222); ;
            color: black;
            border: 1px solid #888;
            border-radius: 5px;
        }
        .input-field::placeholder {
            color: black;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color:rgb(161, 101, 49);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn2 {
            width: 100%;
            padding: 10px;
            background-color:rgb(98, 98, 99);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: rgb(180, 111, 51);
            color: black;
        }
        .btn2:hover {
            background-color:rgb(122, 122, 124);
            color: black;
        }
        .signup-link {
            display: block;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }
        .signup-link:hover {
            color: red;
        }

     
.message {
    padding: 15px;
    margin: 20px 0;
    border-radius: 5px;
    font-size: 16px;
    text-align: center;
}

.message.success {
    background-color: #4CAF50; 
    color: white;
}

.message.error {
    background-color: #f44336;
    color: white;
}

.footer {
            background: rgb(161, 101, 49);
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .footer a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-size: 20px;
        }

        .footer a:hover {
            color: #ffcc00;
        }

        * {
    box-sizing: border-box;
}

    </style>
</head>
<body>

    <div class="login-container">
 
    <img src="../images/logolamburg.jpg" width="250" height="150">

        <h2>¡¡Vamos Registrate!!</h2>
        <form action="registrarse.php" method="POST">
            <input type="text" class="input-field" name="nombre" placeholder="Nombre" required><br>
            <input type="text"class="input-field" name="apellido" placeholder="Apellido" required><br>
            <input type="text" class="input-field" name="usuario" placeholder="Usuario" required><br>
            <input type="email" class="input-field" name="correo" placeholder="Correo" required><br>
            <input type="password" class="input-field" name="password" placeholder="Contraseña" required><br>
            <button type="submit" class="btn">Registrarse</button><br><br>
            <button type="submit" class="btn2" onclick="location.href='index.php'">Cancelar</button>
        </form>
        
    </div>
    <footer class="footer">
        <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="mailto:correo@example.com"><i class="fas fa-envelope"></i> Correo</a>
        <a href="tel:+123456789"><i class="fas fa-phone"></i> +504 9945-4789</a>
    </footer>
</body>
</html>

<?php
include('conexion.php');

$conn = new mysqli($server, $user, $pass, $DB) ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Encriptar la contraseña antes de guardarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO usuario (Nombre, Apellido, User, Correo, Password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $usuario, $correo, $hashed_password);
    header("Location: index.php");

    if ($stmt->execute()) {
        echo "<div class='message success'>Usuario registrado correctamente.</div>";
    } else {
        echo "<div class='message error'>Error al registrar usuario.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
