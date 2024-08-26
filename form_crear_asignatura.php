<?php
require_once "database/conectar_db.php";
require_once "clase_ciclo.php";
require_once "clase_materia.php";
require_once "clase_usuario.php";
require_once "clase_carrera.php";
require_once "clase_curso.php";
require_once "clase_profesores.php";
require_once "clase_materia_carrera.php";

session_start();
if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
    echo "<h1>Usted no posee permisos para utilizar esta página</h1>";
    echo "<br><a href='login.php'>Ir a inicio</a>";
    exit();
}


$data_ids = isset($_SESSION['materia_carrera_ids']) ? $_SESSION['materia_carrera_ids'] : [];
$data = isset($_SESSION['materia_data']) ? $_SESSION['materia_data'] : [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Gestión de Asignaturas</title>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>


<body>

    <div class="divMaterias-cabecera" >
        <button class="btn-descargar" onclick="location.href='buscador.php'">Volver</button>
    </div> <br>
        
    <form action="altas_y_modificaciones\asignaturas\crear_asignatura.php" method="post">
        <label>Nueva Asignatura</label>
        <div class="form-row">
            <!-- Campo Ciclo -->
            <div class="form-group col-md-6">
                <label for="ciclo_id">Ciclo</label>
                <select class="form-control select2" id="ciclo_id" name="ciclo_id" required>
                    <?php
                    $ciclos = CicloLectivo::listarCiclos();
                    foreach ($ciclos as $ciclo) {
                        echo "<option value='{$ciclo['ciclo_id']}'>{$ciclo['ciclo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Campo Turno -->
            <div class="form-group col-md-6">
                <label for="turno_id">Turno</label>
                <select class="form-control select2" id="turno_id" name="turno_id" required>
                    <?php
                    $turnos = Turno::listarTurnos();
                    foreach ($turnos as $turno) {
                        echo "<option value='{$turno['turno_id']}'>{$turno['turno']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <!-- Campo Carrera -->
            <label for="carrera_id">Carrera</label>
            <select class="form-control select2" id="carrera_id" name="carrera_id" required>
                <?php
                $carreras = Carrera::listarCarreras();
                foreach ($carreras as $carrera) {
                    echo "<option value='{$carrera['carrera_id']}'>{$carrera['carrera_nombre']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-row">
            <!-- Campo Materia -->
            <div class="form-group col-md-6">
                <label for="materia_id">Materia</label>
                <select class="form-control select2" id="materia_id" name="materia_id" required>
                    <?php
                    $materias = Materia::listarMaterias();
                    foreach ($materias as $materia) {
                        echo "<option value='{$materia['materia_id']}'>{$materia['materia_nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="profesor_id">Profesor</label>
                <select class="form-control select2" id="profesor_id" name="profesor_id" required>
                    <?php
                    $profesores = Profesor::listarProfesores();
                    foreach ($profesores as $profesor) {
                        echo "<option value='{$profesor['profesor_id']}'>{$profesor['profesor_apellido']} {$profesor['profesor_nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Campo Curso -->
            <div class="form-group col-md-2">
                <label for="curso_id">Curso</label>
                <select class="form-control select2" id="curso_id" name="curso_id" required>
                    <?php
                    $cursos = Curso::listar_Cursos();
                    foreach ($cursos as $curso) {
                        echo "<option value='{$curso['curso_id']}'>{$curso['curso']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <!-- Campo situacion revista -->
            <div class="form-group col-md-6">
                <label for="situacion_revista">Situación de Revista</label>
                <input type="text" class="form-control" id="situacion_revista" name="situacion_revista" required>
            </div>
            <!-- Campo modulos -->
            <div class="form-group col-md-6">
                <label for="modulos">Módulos</label>
                <input type="number" class="form-control" id="modulos" name="modulos" required>
            </div>
        </div>
        <div class="form-row">
            <!-- Campo inscriptos -->
            <div class="form-group col-md-6">
                <label for="inscriptos">Inscriptos</label>
                <input type="number" class="form-control" id="inscriptos" name="inscriptos" required>
            </div>
            <!-- Campo regulares -->
            <div class="form-group col-md-6">
                <label for="regulares">Regulares</label>
                <input type="number" class="form-control" id="regulares" name="regulares" required>
            </div>
        </div>
        <div class="form-row">
            <!-- Campo atraso academico -->
            <div class="form-group col-md-6">
                <label for="atraso_academico">Atraso Académico</label>
                <input type="number" class="form-control" id="atraso_academico" name="atraso_academico" required>
            </div>
            <!-- Campo recurusantes -->
            <div class="form-group col-md-6">
                <label for="recursantes">Recursantes</label>
                <input type="number" class="form-control" id="recursantes" name="recursantes" required>
            </div>
        </div>
        <div class="form-row">
            <!-- Campo 1° Periodo -->
            <div class="form-group col-md-6">
                <label for="primer_periodo">1° Período</label>
                <input type="number" class="form-control" id="primer_periodo" name="primer_periodo" required>
            </div>
            <!-- Campo 2° Periodo -->
            <div class="form-group col-md-6">
                <label for="segundo_periodo">2° Período</label>
                <input type="number" class="form-control" id="segundo_periodo" name="segundo_periodo" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck" required>
            <label class="form-check-label" for="gridCheck">
                Confirmar
            </label>
            </div>
        </div>
        <button type="submit" class="btn-descargar">Crear Asignatura</button>
    </form>



<script src="js/bootstrap.bundle.min.js"></script>


</body>

<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php">Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"> </i><a href="index.php">Ir a inicio</a></p><br> <!-- Lo agrego acá, queda mejor que arriba de todo creo. -->
</footer>



</html>
