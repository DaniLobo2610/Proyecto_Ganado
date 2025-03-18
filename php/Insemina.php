<?php
session_start(); // Asegura que la sesión está iniciada

// Conexión a la base de datos
include("conexion.php");

// Verificar si el usuario está autenticado y obtener su ID
if (!isset($_SESSION['ID'])) {
    die("<script>alert('Error: No hay un usuario autenticado.'); window.location.href = 'index.php';</script>");
}

$id_usuario = $_SESSION['ID']; // Ahora sí está definido correctamente

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experimentos de Inseminacion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: url('../images/Fondito.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            width: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease; /* Transición suave al cambiar el tamaño */
            overflow-x: hidden; /* Evita el desbordamiento horizontal */
        }
    
        header {
            width: 100%;
            background: url('../images/banner1.png') no-repeat center center;
            background-size: cover;
            color: white;
            font-size: 3em;
            font-weight: bold;
            text-align: center;
            padding: 25px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            position: relative;
            z-index: 1;
            background-attachment: fixed;
            overflow: hidden;
        }
    
        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }
    
        .menu-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #333;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 24px;
            border-radius: 5px;
            transition: left 0.3s;
            z-index: 1001;
            margin-bottom: 10px;
        }
        
        .menu {
            position: fixed;
            left: -250px;
            top: 0;
            width: 250px;
            height: 100%;
            background: #222;
            padding-top: 60px;
            transition: left 0.3s;
            color: white;
            z-index: 1000;
        }

        .menu a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: white;
            font-size: 18px;
            border-bottom: 1px solid #bd1212;
            transition: 0.3s;
        }

        .menu a:hover {
            background: #bd1212;
        }

        .menu.active {
            left: 0;
        }

        /* Clase que ajusta el contenido cuando el menú está abierto */
        body.menu-open .content {
            margin-left: 250px; 
            
        }

        * {
    box-sizing: border-box;
}

        .content {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s ease; /* Suaviza el desplazamiento */
        }

        .footer {
            background: #222;
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

        .user-info {
    padding: 12px;
    display: flex;
    align-items: center;
    border-top: 1px solid #bd1212;
    background-color: #222;
    color: white;
    font-size: 13px;
    gap: 5px;
}

.user-info i {
    margin-right: 10px;
    font-size: 18px;
}

.logout-icon {
        color: white;
        font-size: 14px;
        cursor: pointer;
    }

    .logout-icon:hover {
        color:rgb(255, 255, 255); 
    }




    .login-container {
        box-sizing: content-box;
            width: 300px;
            margin: -30px auto;
            padding: 30px;
            background-color: #333;
            border-radius: 10px;
            text-align: center;
        }
        .login-container h2 {
            color: red;
            margin-bottom: 20px;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #444;
            color: white;
            border: 1px solid #888;
            border-radius: 5px;
        }
        .input-field::placeholder {
            color: #bbb;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #cc0000;
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


.submenu {
    position: relative;
}

.submenu-content {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    background: #333;
    width: 200px;
    padding-top: 10px;
}

.submenu-content a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    border-bottom: 1px solid #bd1212;
}

.submenu-content a:hover {
    background: #bd1212;
}


.submenu:hover .submenu-content {
    display: block;
}

    </style>
</head>
<body>
    <header>Ganadería & Agricultura</header>

    <div class="menu-btn" id="menuBtn">
        <i class="fas fa-bars"></i>
    </div>
    <br>
    

    <nav class="menu" id="menu">
    <div class="user-info">
        <a> 
            <i class="fas fa-user-circle"></i> 
            <?php
                if (isset($_SESSION['nombre']) && isset($_SESSION['apellido'])) {
                    echo $_SESSION['nombre'] . " " . $_SESSION['apellido'];
                } else {
                    echo "Usuario no logueado";
                }
            ?>
             
        <?php if (isset($_SESSION['nombre'])): ?>
            <a href="logout.php" class="logout-icon" title="Cerrar sesión">
                <i class="fas fa-door-open"></i> 
            </a>
        <?php endif; ?>
        </a>

       
    </div>

        <a href="../Inicio.php">Inicio</a>
        <a href="AddAnimal.php">Agregar Ganado</a>

        <div class="submenu">
        <a href="#" class="submenu-toggle">Tratamientos y vacunas</a>
        <div class="submenu-content">
            <a href="vacunacion.php">Vacunación</a>
            <a href="#">Registro de Vacunas</a>
            <a href="#">Registro de Tratamientos</a>
        </div>
    </div>
    
        

        
    </nav>


    <div class="content">
    <div class="login-container">
 
 <img src="../images/Toro.png" alt="Logo de Proyecto">

     <h2>¡¡Vamos a experimentar!!</h2>
     
     <form action="Insemina.php" method="POST">

     <select name="Hembra" class="input-field" required><br>
        <option selected disabled>--Seleccionar a la Hembra--</option>
        <?php
include("conexion.php");
// Consulta para obtener las pólizas
$sql = $conexion->query("SELECT * FROM animales Where  sexo = 'Hembra'");
while ($resultado = $sql->fetch_assoc()) {
    echo "<option value='" . $resultado['ID'] . "'>" . $resultado['Nombre']  . " ---- Raza: " . $resultado['Raza'] .  "</option>";
}
?>
</select>
     <input type="text" class="input-field" name="Fecha" placeholder="Fecha realizada (año-mes-dia)" required><br>

     <select name="Donador" class="input-field" required><br>
        <option selected disabled>--Seleccionar Donador--</option>
        <?php
include("conexion.php");
// Consulta para obtener las pólizas
$sql = $conexion->query("SELECT * FROM animales Where  sexo = 'Macho'");
while ($resultado = $sql->fetch_assoc()) {
    echo "<option value='" . $resultado['ID'] . "'>" . $resultado['Nombre']  . " ---- Raza: " . $resultado['Raza'] . "</option>";
}
?>
</select>

<input type="text" class="input-field" name="Muestra" placeholder="¿Qué muestra usó?" required><br>

<div class="input-field">
              
              <label>
                <input type="radio" name="resultado" value="Exitoso" />
               Exitoso
              </label>
              <label>
                <input type="radio" name="resultado" value="Fallido" />
                Fallido
              </label>
              <label>
                <input type="radio" name="resultado" value="En espera" />
                En espera
              </label>
            
            </div>
        
        
         <button type="submit" class="btn">Agregar</button>
     </form>
     
 </div>
    </div>

    <footer class="footer">
        <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="danilobo2018@gmail.com"><i class="fas fa-envelope"></i> Correo</a>
        <a href="tel:+123456789"><i class="fas fa-phone"></i> +504 9945-4789</a>
    </footer>

    <script>
        let menuBtn = document.getElementById('menuBtn');
        let menu = document.getElementById('menu');
        let isOpen = false;

        menuBtn.addEventListener('click', function() {
            isOpen = !isOpen;
            menu.classList.toggle('active');
            menuBtn.style.left = isOpen ? '10px' : '20px';
            // Cambiar clase al body para ajustar el contenido
            if (isOpen) {
                document.body.classList.add('menu-open');
            } else {
                document.body.classList.remove('menu-open');
            }
        });
    </script>
</body>
</html>
<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_animal = !empty($_POST['Hembra']) ? trim($_POST['Hembra']) : "NULL";
    $id_animal2 = !empty($_POST['Donador']) ? trim($_POST['Donador']) : "NULL";
    $fecha = trim($_POST['Fecha']);
    $resultado = trim($_POST['resultado']);
    $muestra = trim($_POST['Muestra']);



    if (empty($id_animal) || empty($id_animal2) || empty($fecha) || empty($resultado) || empty($muestra)) {
        echo "<script>alert('Error: Los campos Animal, Fecha, resultado y Muestra son obligatorios.'); window.history.back();</script>";
        exit();
    }


    $sql = "INSERT INTO Inseminaartificial (IdAnimal, FechaRealizada, DonadorID, Resultado, Muestra)
            VALUES ('$id_animal', '$fecha', '$id_animal2', '$resultado', '$muestra')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('Registro exitoso.'); window.location.href = 'Insemina.php';</script>";
    } else {
        echo "<script>alert('Error al registrar: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}
?>

    