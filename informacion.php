<?php
require_once "database/conectar_db.php";
require_once "clase_materia.php";
require_once "clase_usuario.php";
require_once "clase_carrera.php";
require_once "clase_curso.php";
require_once "clase_materia_carrera.php";

session_start();
if ($_SESSION['usuario_suspendido'] == 1){
    echo "<h1>Este usuario esta suspendido</h1>";
    echo "<br><a href='login.php'>Ir a inicio</a>";
    exit();
}
if (!isset($_SESSION['rol_id'])) {
    echo "<h1>Usted no posee permisos para utilizar esta página</h1>";
    echo "<br><a href='login.php'>Ir a inicio</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Bienvenido</title>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>
<main>

    <body>
        <section id="Materias" class="divMaterias">
            <div class="divMaterias-cabecera">
                <button class="btn-descargar" onclick="location.href='buscador.php'"><i class="fa-solid fa-arrow-left"> </i> Volver</button>
                <div class="btns-space"></div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn-descargar me-md-2" onclick="location.href='asignaturas.php'"><i class="fa-solid fa-pen-to-square"> </i> Editar</button>
                    <button class="btn-descargar" onclick="location.href='excel.php'"><i class="fa-solid fa-file-excel"> </i> Descargar</button>
                </div>
            </div>
            <table class="table table-sm table-striped table-hover mt-4">
                <thead class="table-primary">
                    <tr>
                        <th>CICLO</th>
                        <th>CARRERA</th>
                        <th>CURSO</th>
                        <th>MATERIA</th>
                        <th>MODULOS</th>
                        <th>PROFESOR</th>
                        <th>SITUACIÓN DE REVISTA</th>
                        <th>INSCRIPTOS</th>
                        <th>REGULARES</th>
                        <th>ATRASO ACADEMICO</th>
                        <th>RECURSANTES</th>
                        <th>1° PERIODO</th>
                        <th>2° PERIODO</th>
                    </tr>
                </thead>
                <tbody class="table-active">
                <?php
                    $con = conectar_db();

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $_SESSION['filtros'] = array_map(function ($value) {
                            return is_numeric($value) ? intval($value) : $value;
                        }, $_POST);
                        $filtros = $_SESSION['filtros'];

                        $ciclo_id = isset($filtros['ciclo']) ? $filtros['ciclo'] : null;
                        $turno_id = isset($filtros['turno']) ? $filtros['turno'] : null;
                        $carrera_id = isset($filtros['carrera']) ? $filtros['carrera'] : null;
                        $curso_id = isset($filtros['curso']) ? $filtros['curso'] : null;
                        $profesor_id = isset($filtros['profesor']) ? $filtros['profesor'] : null;
                    }

                    $where_clauses = [];
                    
                    if ($ciclo_id !== null && $ciclo_id !== "") {
                        $where_clauses[] = "cl.ciclo_id = $ciclo_id";
                        $sql_ciclo = "SELECT ciclo FROM ciclo_lectivo WHERE ciclo_id = ?";
                                        $stmt_ciclo = $con->prepare($sql_ciclo);
                                        $stmt_ciclo->bind_param("i", $ciclo_id);
                                        $stmt_ciclo->execute();
                                        $stmt_ciclo->bind_result($ciclo);
                                        $stmt_ciclo->fetch();
                                        $stmt_ciclo->close();

                        $_SESSION['ciclo'] = $ciclo;
                    }
                    else {
                        unset($_SESSION['ciclo']);
                    }

                    if ($carrera_id !== null && $carrera_id !== "") {
                        $where_clauses[] = "mc.carrera_id = $carrera_id";
                        $sql_carrera = "SELECT carrera_nombre FROM carreras WHERE carrera_id = ?";
                                        $stmt_carrera = $con->prepare($sql_carrera);
                                        $stmt_carrera->bind_param("i", $carrera_id);
                                        $stmt_carrera->execute();
                                        $stmt_carrera->bind_result($carrera_nombre);
                                        $stmt_carrera->fetch();
                                        $stmt_carrera->close();

                        $_SESSION['carrera_nombre'] = $carrera_nombre;
                    }
                    else {
                        unset($_SESSION['carrera_nombre']);
                    }

                    if ($turno_id !== null && $turno_id !== "") {
                        $where_clauses[] = "mc.turno_id = $turno_id";
                        $sql_turno = "SELECT turno FROM turnos WHERE turno_id = ?";
                                        $stmt_turno = $con->prepare($sql_turno);
                                        $stmt_turno->bind_param("i", $turno_id);
                                        $stmt_turno->execute();
                                        $stmt_turno->bind_result($turno);
                                        $stmt_turno->fetch();
                                        $stmt_turno->close();

                        $_SESSION['turno'] = $turno;
                    }
                    else {
                        unset($_SESSION['turno']);
                    }

                    if ($curso_id !== null && $curso_id !== "") {
                        $where_clauses[] = "mc.curso_id = $curso_id";
                        $sql_curso = "SELECT curso FROM cursos WHERE curso_id = ?";
                                        $stmt_curso = $con->prepare($sql_curso);
                                        $stmt_curso->bind_param("i", $curso_id);
                                        $stmt_curso->execute();
                                        $stmt_curso->bind_result($curso);
                                        $stmt_curso->fetch();
                                        $stmt_curso->close();

                        $_SESSION['curso'] = $curso;
                    }
                    else {
                        unset($_SESSION['curso']);
                    }

                    if ($profesor_id !== null && $profesor_id !== "") {
                        $where_clauses[] = "mc.profesor_id = $profesor_id";
                        $sql_profesor = "SELECT CONCAT(profesor_apellido, ' ', profesor_nombre) AS profesor FROM profesores WHERE profesor_id = ?";
                                        $stmt_profesor = $con->prepare($sql_profesor);
                                        $stmt_profesor->bind_param("i", $profesor_id);
                                        $stmt_profesor->execute();
                                        $stmt_profesor->bind_result($profesor);
                                        $stmt_profesor->fetch();
                                        $stmt_profesor->close();

                        $_SESSION['profesor'] = $profesor;
                    }
                    else {
                        unset($_SESSION['profesor']);
                    }

                    $where_sql = '';
                    if (!empty($where_clauses)) {
                        $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
                    }

                    $sql_filtros = "SELECT DISTINCT 
                                mc.materia_carrera_id,
                                m.materia_nombre,
                                c.carrera_nombre,
                                cl.ciclo,
                                cr.curso,
                                t.turno,
                                p.profesor_apellido, 
                                p.profesor_nombre,
                                mc.situacion_revista,
                                mc.inscriptos,
                                mc.regulares,
                                mc.atraso_academico,
                                mc.recursantes,
                                mc.modulos,
                                mc.primer_periodo,
                                mc.segundo_periodo
                            FROM 
                                materia_carrera mc
                            INNER JOIN materias m ON mc.materia_id = m.materia_id
                            INNER JOIN carreras c ON mc.carrera_id = c.carrera_id
                            INNER JOIN ciclo_lectivo cl ON mc.ciclo_id = cl.ciclo_id
                            INNER JOIN cursos cr ON mc.curso_id = cr.curso_id
                            INNER JOIN turnos t ON mc.turno_id = t.turno_id
                            INNER JOIN profesores p ON mc.profesor_id = p.profesor_id
                            $where_sql
                            ORDER BY 
                                cl.ciclo,
                                c.carrera_nombre, 
                                cr.curso, 
                                m.materia_nombre, 
                                p.profesor_apellido";

                    $result = $con->query($sql_filtros);

                    $data = [];
                    $data_ids = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                        $data_ids[] = $row['materia_carrera_id'];
                    }

                    $_SESSION['materia_data'] = $data;
                    $_SESSION['materia_carrera_ids'] = $data_ids;
                    if (empty($data)) {
                        echo "<tr><td colspan='13'><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
                    } else {
                        foreach ($data as $info) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($info['ciclo']); ?></td>
                                <td><?php echo htmlspecialchars($info['carrera_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($info['curso']); ?></td>
                                <td><?php echo htmlspecialchars($info['materia_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($info['modulos']); ?></td>
                                <td><?php echo htmlspecialchars($info['profesor_apellido'] . " " . $info['profesor_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($info['situacion_revista']); ?></td>
                                <td><?php echo htmlspecialchars($info['inscriptos']); ?></td>
                                <td><?php echo htmlspecialchars($info['regulares']); ?></td>
                                <td><?php echo htmlspecialchars($info['atraso_academico']); ?></td>
                                <td><?php echo htmlspecialchars($info['recursantes']); ?></td>
                                <td><?php echo htmlspecialchars($info['primer_periodo']); ?></td>
                                <td><?php echo htmlspecialchars($info['segundo_periodo']); ?></td>
                            </tr>
                    <?php }
                    }

                    $con->close()
                    ?>
                </tbody>
            </table>
        </section>
    </body>
</main>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php"> Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"> </i><a href="index.php"> Ir a inicio</a></p><br> <!-- Lo agrego acá, queda mejor que arriba de todo creo. -->
</footer>

</html>