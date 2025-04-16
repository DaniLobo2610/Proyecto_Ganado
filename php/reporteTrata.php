<?php
session_start(); // Asegura que la sesión está iniciada

// Conexión a la base de datos
include("conexion.php");

// Verificar si el usuario está autenticado y obtener su ID
if (!isset($_SESSION['ID'])) {
    die("<script>alert('Error: No hay un usuario autenticado.'); window.location.href = 'php/index.php';</script>");
}

$id_usuario = $_SESSION['ID']; // Ahora sí está definido correctamente

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Tratamientos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/4.2.8/css/tooltipster.bundle.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/4.2.8/js/tooltipster.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link rel="stylesheet" as="style" onload="this.rel='stylesheet'" 
          href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter:wght@400;500;700;900&amp;family=Noto+Sans:wght@400;500;700;900" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        body {
            background: url('../images/Fondito.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease; /* Transición suave al cambiar el tamaño */
        }
    
        header {
            background: url('../images/banner.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            font-size: 3em;
            font-weight: bold;
            text-align: center;
            padding: 150px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            position: relative;
            z-index: 1;
            background-attachment: fixed;
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
            background:rgb(216, 216, 214);
            color: black;
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
            background: #636b3f;
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
            border-bottom: 1px solid rgb(0, 0, 0);
            transition: 0.3s;
        }

        .menu a:hover {
            background:#b17036;
        }

        .menu.active {
            left: 0;
        }

        /* Clase que ajusta el contenido cuando el menú está abierto */
        body.menu-open .content {
            margin-left: 250px; /* Deja espacio para el menú */
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

        .user-info {
    padding: 10px;
    display: flex;
    align-items: center;
    border-top: 1px solid rgb(0, 0, 0);
    background-color: #636b3f;
    color: white;
    font-size: 12px;
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
    border-bottom: 1px solid #b17036;
}

.submenu-content a:hover {
    background: #b17036;
}


.submenu:hover .submenu-content {
    display: block;
}  

#calendar {

    width: 90%;
    margin: 20px auto;
    max-width: 1200px;
    background: white; /* Fondo blanco para el calendario */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

 /* Estilos generales para la tabla */
 #animalTable {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Estilo de las celdas y bordes */
#animalTable th, #animalTable td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

/* Estilo de las cabeceras de las columnas */
#animalTable th {
    background-color: #2b361c;
    color: white;
    font-size: 16px;
}

/* Asegurar que todas las filas tengan fondo blanco */
#animalTable tr {
    background-color: rgb(255, 255, 255);
}

/* Efecto hover sobre las filas */
#animalTable tr:hover {
    background-color:rgb(93, 114, 63);
    color : white;
    cursor: pointer;
}

/* Estilo para las celdas del cuerpo de la tabla */
#animalTable td {
    font-size: 14px;
    font-weight: bold;
}

/* Estilo para la tabla cuando no hay datos */
#animalTable tbody tr.no-data td {
    text-align: center;
    color: #777;
}


/* Opcional: agregar paginación si lo necesitas */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    margin: 0 5px;
    padding: 8px 12px;
    background-color: black;  /* Fondo negro */
    color: white;  /* Número blanco */
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;  /* Opcional: para que el número resalte más */
}

.pagination a:hover {
    background-color: #333;  /* Fondo negro más claro al pasar el mouse */
    color: #fff;  /* Asegura que el texto sea blanco al pasar el mouse */
}

       
    </style>
</head>
<body>
<header>FINCA MACHADO LAMBURG</header>

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
            <a href="reporteVacunas.php">Registro de Vacunas</a>
            <a href="Tratamiento.php">Tratamientos</a>
            <a href="reporteTrata.php">Registro de Tratamientos</a>
        </div>
    </div>
    <div class="submenu">
        <a href="Insemina.php" class="submenu-toggle">Inseminación Artificial</a>
        <div class="submenu-content">
        <a href="reporteinsemina.php">Registro de Inseminaciones</a>

        </div>
    </div>
    <a href="AddEvento.php">Agregar Eventos</a> 
    <div class="submenu">
        <a href="reportestablo.php" class="submenu-toggle">Reporte de lugares de ganado</a>
        <div class="submenu-content">
        <a href="Addlugar.php">Agregar Nuevo Lugar</a>
            <a href="cambiarestablo.php">Cambiar a ganado de Lugar</a>
        </div>
      </div>
        <a href="UpDeAnimal.php">Vender o eliminar Ganado</a>  
        
    </nav>


    <div class="content">
    <?php
require 'conexion.php'; // Conexión a la base de datos

$busqueda = $conexion->real_escape_string($_GET['search'] ?? '');
$rows_per_page = intval($_GET['rows_per_page'] ?? 5);
$page = max(intval($_GET['page'] ?? 1), 1);
$offset = ($page - 1) * $rows_per_page;

// Condiciones de búsqueda
if (preg_match('/^[0-9]+$/', $busqueda)) {
    $condicion = "a.Peso = '$busqueda'";
} else {
    $condicion = "
        a.Nombre LIKE '%$busqueda%' OR
        a.Raza LIKE '%$busqueda%' OR
        a.Sexo LIKE '%$busqueda%' OR
        tr.Medicamento LIKE '%$busqueda%' OR
        tr.Detalles LIKE '%$busqueda%'
    ";
}

$where_clause = "WHERE a.IdUser = $id_usuario";
if (!empty($busqueda)) {
    $where_clause .= " AND ($condicion)";
}

// Consulta principal con paginación
$consulta = $conexion->query("
    SELECT 
        a.Nombre,
        a.Raza,
        a.Sexo,
        a.Peso,
        tr.FechaInicio,
        tr.FechaFin,
        tr.Detalles,
        tr.Medicamento
    FROM tratamiento tr
    INNER JOIN animales a ON tr.IdAnimal = a.ID
    $where_clause
    ORDER BY tr.FechaInicio DESC
    LIMIT $rows_per_page OFFSET $offset
");

if (!$consulta) {
    die("Error en la consulta SQL: " . $conexion->error);
}

// Consulta total de registros
$total_consulta = $conexion->query("
    SELECT COUNT(*) AS total
    FROM tratamiento tr
    INNER JOIN animales a ON tr.IdAnimal = a.ID
    $where_clause
");

if (!$total_consulta) {
    die("Error en la consulta COUNT: " . $conexion->error);
}

$total_rows = $total_consulta->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $rows_per_page);

?>


<form id="search-form">
    <input 
        type="text" 
        name="search" 
        placeholder="Buscar..." 
        value="<?= htmlspecialchars($busqueda) ?>" 
        oninput="debouncedSubmit()"
    >
    <select name="rows_per_page" onchange="document.getElementById('search-form').submit();">
        <option value="5" <?= ($rows_per_page == 5) ? 'selected' : '' ?>>5</option>
        <option value="10" <?= ($rows_per_page == 10) ? 'selected' : '' ?>>10</option>
        <option value="15" <?= ($rows_per_page == 15) ? 'selected' : '' ?>>15</option>
    </select>
</form>

<script>
    let typingTimer;
    const doneTypingInterval = 50000000; // milisegundos de espera

    function debouncedSubmit() {
        clearTimeout(typingTimer); // limpia el temporizador previo
        typingTimer = setTimeout(() => {
            document.getElementById('search-form').submit();
        }, doneTypingInterval);
    }
</script>


<div id="printable-table">
<div id="print-header" style="display: none; text-align: center; margin-bottom: 20px;">
    <h2>Reporte de Tratamientos </h2>
    <p id="fecha-impresion"></p>
</div>




    <table id="animalTable">
        <tr>
            <th>Nombre del Paciente</th>
            <th>Raza</th>
            <th>Sexo</th>
            <th>Peso</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Detalles</th>
            <th>Medicamento</th>
        
        </tr>
        <?php while ($row = $consulta->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['Nombre'] ?></td>
                <td><?= $row['Raza'] ?></td>
                <td><?= $row['Sexo'] ?></td>
                <td><?= $row['Peso'] ?></td>
                <td><?= $row['FechaInicio'] ?></td>
                <td><?= $row['FechaFin'] ?></td>
                <td><?= $row['Detalles'] ?></td>
                <td><?= $row['Medicamento'] ?></td>

                
            </tr>
        <?php } ?>
    </table>
</div>


    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="?search=<?= htmlspecialchars($busqueda) ?>&rows_per_page=<?= $rows_per_page ?>&page=<?= $i ?>">
                <?= $i ?>
            </a>
        <?php } 
        ?>
    </div>

    <div style="text-align: center; margin: 20px 0;">
    <button onclick="printTable()" style="
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: background-color 0.3s ease;
    "
    onmouseover="this.style.backgroundColor='#0056b3'"
    onmouseout="this.style.backgroundColor='#007BFF'"
    >
        Imprimir Tabla
    </button>
    </div>

    <script>
function printTable() {
    // Mostrar el encabezado personalizado
    const header = document.getElementById('print-header');
    const fecha = new Date();
    const opciones = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('fecha-impresion').textContent = 'Fecha de impresión: ' + fecha.toLocaleString('es-ES', opciones);
    header.style.display = 'block';

    // Ocultar elementos que no se deben imprimir (como botones)
    const originalContent = document.body.innerHTML;
    const tabla = document.getElementById('animalTable').outerHTML;
    const encabezado = header.outerHTML;

    document.body.innerHTML = encabezado + tabla;

    window.print();

    // Restaurar la página
    document.body.innerHTML = originalContent;
    location.reload(); // recarga para restaurar eventos
}
</script>
    
</div>

    <footer class="footer">
        <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="mailto:correo@example.com"><i class="fas fa-envelope"></i> Correo</a>
        <a href="tel:+123456789"><i class="fas fa-phone"></i> +504 9945-4789</a>
    </footer>

    <script>
    let menuBtn = document.getElementById('menuBtn');
    let menu = document.getElementById('menu');
    
    // Recupera el estado guardado del menú (si está abierto o cerrado)
    let isOpen = localStorage.getItem('menuOpen') === 'true';

    // Si el menú está abierto en el almacenamiento local, aplicamos los cambios correspondientes
    if (isOpen) {
        menu.classList.add('active');
        document.body.classList.add('menu-open');
        menuBtn.style.left = '10px'; // Ajusta la posición si el menú está abierto
    } else {
        menu.classList.remove('active');
        document.body.classList.remove('menu-open');
        menuBtn.style.left = '20px'; // Ajusta la posición si el menú está cerrado
    }

    // Maneja el clic en el botón del menú
    menuBtn.addEventListener('click', function() {
        isOpen = !isOpen; // Cambia el estado del menú
        menu.classList.toggle('active');
        menuBtn.style.left = isOpen ? '10px' : '20px'; // Cambia la posición del botón

        // Cambia el estado del body para ajustar el contenido
        if (isOpen) {
            document.body.classList.add('menu-open');
        } else {
            document.body.classList.remove('menu-open');
        }

        // Guarda el estado del menú en localStorage
        localStorage.setItem('menuOpen', isOpen);
    });
</script>

</body>




</html>
