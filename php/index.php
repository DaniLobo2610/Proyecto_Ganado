<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            margin: 40px auto;
            padding: 30px;
            background-color: #FFF;
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
            color: White;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: rgb(180, 111, 51);
            color: black;
        }
        .signup-link {
            display: block;
            margin-top: 10px;
            color: black;
            text-decoration: none;
        }
        .signup-link:hover {
            color: brown;
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
            padding: 30px;
            width: 100%;
            position: relative;
            z-index: 30;
        }

        .footer a {
            color: white;
            margin: 0 20px;
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

        <h2>Iniciar Sesión</h2>
        <form action="index.php" method="POST">
            <input type="text" class="input-field" name="usuario" placeholder="Correo o nombre de usuario" required><br>
            <input type="password" class="input-field" name="password" placeholder="Contraseña" required><br>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        <a href="registrarse.php" class="signup-link">¿No tienes cuenta? Crea una aquí</a>
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
session_start(); // Iniciar la sesión

include('conexion.php'); 

$error_message = "";

$conn = new mysqli($server, $user, $pass, $DB);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE (User = ? OR Correo = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

      
        if (password_verify($password, $user_data['Password'])) {
           
            $_SESSION['ID'] = $user_data['ID']; // 🔹 Guardar el ID del usuario
            $_SESSION['nombre'] = $user_data['Nombre'];
            $_SESSION['apellido'] = $user_data['Apellido'];
            $_SESSION['user'] = $user_data['User']; // Opcional: almacenar también el usuario

           
            header("Location: ../Inicio.php");
            exit();
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location.href='index.php';</script>";
    }

    $stmt->close(); // Cerrar el statement
}

$conn->close(); 
?>







