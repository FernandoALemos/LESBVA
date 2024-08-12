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
// if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
//     echo "<h1>Usted no posee permisos para utilizar esta página</h1>";
//     echo "<br><a href='login.php'>Ir a inicio</a>";
//     exit();
// }


$data_ids = isset($_SESSION['materia_carrera_ids']) ? $_SESSION['materia_carrera_ids'] : [];
$data = isset($_SESSION['materia_data']) ? $_SESSION['materia_data'] : [];
// $ciclo = isset($_SESSION['ciclo']) ? $_SESSION['ciclo'] : '';
// $carrera_nombre = isset($_SESSION['carrera_nombre']) ? $_SESSION['carrera_nombre'] : '';
// $turno = isset($_SESSION['turno']) ? $_SESSION['turno'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!-- <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script> -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Gestión de Asignaturas</title>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>

<body>
    <div class="divMaterias-cabecera">
        <button class="btn btn-primary" onclick="location.href='index.php'">Inicio</button>
        <button class="btn btn-primary" onclick="location.href='buscador.php'">Volver</button>
        <div class="btns-space"></div>
    </div> <br>
    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Asignaturas</h1>
            <!-- <button type="button" class="btn btn-primary btnEditarAsignatura" data-id="36" data-toggle="modal" data-target="#modalEditarAsignatura">
                Editar Asignatura
            </button> -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearAsignatura">Nueva Asignatura</button>
        </div>
        <?php if (!empty($data_ids)) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
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
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $asignaturas = MateriaCarrera::obtenerAsignaturasPorIds($data_ids);

                foreach ($asignaturas as $asignatura) { ?>
                    <tr>
                        <td><?php echo $asignatura['materia_carrera_id']; ?></td>
                        <td><?php echo $asignatura['ciclo']; ?></td>
                        <td><?php echo $asignatura['carrera_nombre']; ?></td>
                        <td><?php echo $asignatura['curso']; ?></td>
                        <td><?php echo $asignatura['materia_nombre']; ?></td>
                        <td><?php echo $asignatura['modulos']; ?></td>
                        <td><?php echo $asignatura['profesor_nombre']. " ".$asignatura['profesor_apellido']; ?></td>
                        <td><?php echo $asignatura['situacion_revista']; ?></td>
                        <td><?php echo $asignatura['inscriptos']; ?></td>
                        <td><?php echo $asignatura['regulares']; ?></td>
                        <td><?php echo $asignatura['atraso_academico']; ?></td>
                        <td><?php echo $asignatura['recursantes']; ?></td>
                        <td><?php echo $asignatura['primer_periodo']; ?></td>
                        <td><?php echo $asignatura['segundo_periodo']; ?></td>
                        <?php
                        echo "<td>
                                <button class='btn btn-info btn-sm btnEditarAsignatura' data-id='{$asignatura['materia_carrera_id']}' >Editar</button>
                            </td>";
                        ?>
                        <!-- <td>
                            <button class="btn btn-info btn-sm btnEditarAsignatura" data-id="
                            <?php 
                            // echo $asignatura['materia_carrera_id']; 
                            ?>
                            ">Editar</button>
                        </td> -->
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No hay datos para mostrar.</p>
        <?php } ?>

    <!-- Modales -->
    <!-- Modal para Crear Asignatura -->
    <div class="modal fade" id="modalCrearAsignatura" tabindex="-1" role="dialog" aria-labelledby="modalCrearAsignaturaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="altas_y_modificaciones\asignaturas\crear_asignatura.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCrearAsignaturaLabel">Nueva Asignatura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Campo Ciclo -->
                        <div class="form-group">
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
                        <div class="form-group">
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
                        <!-- Campo Carrera -->
                        <div class="form-group">
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
                        <!-- Campo Curso -->
                        <div class="form-group">
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
                        <!-- Campo Materia -->
                        <div class="form-group">
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
                        <!-- Campo Profesor -->
                        <div class="form-group">
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
                        <!-- Campo Situación de Revista -->
                        <div class="form-group">
                            <label for="situacion_revista">Situación de Revista</label>
                            <input type="text" class="form-control" id="situacion_revista" name="situacion_revista" required>
                        </div>
                        <!-- Campo Inscriptos -->
                        <div class="form-group">
                            <label for="inscriptos">Inscriptos</label>
                            <input type="number" class="form-control" id="inscriptos" name="inscriptos" required>
                        </div>
                        <!-- Campo Regulares -->
                        <div class="form-group">
                            <label for="regulares">Regulares</label>
                            <input type="number" class="form-control" id="regulares" name="regulares" required>
                        </div>
                        <!-- Campo Atraso Académico -->
                        <div class="form-group">
                            <label for="atraso_academico">Atraso Académico</label>
                            <input type="number" class="form-control" id="atraso_academico" name="atraso_academico" required>
                        </div>
                        <!-- Campo Recursantes -->
                        <div class="form-group">
                            <label for="recursantes">Recursantes</label>
                            <input type="number" class="form-control" id="recursantes" name="recursantes" required>
                        </div>
                        <!-- Campo Módulos -->
                        <div class="form-group">
                            <label for="modulos">Módulos</label>
                            <input type="number" class="form-control" id="modulos" name="modulos" required>
                        </div>
                        <!-- Campo 1° Período -->
                        <div class="form-group">
                            <label for="primer_periodo">1° Período</label>
                            <input type="number" class="form-control" id="primer_periodo" name="primer_periodo" required>
                        </div>
                        <!-- Campo 2° Período -->
                        <div class="form-group">
                            <label for="segundo_periodo">2° Período</label>
                            <input type="number" class="form-control" id="segundo_periodo" name="segundo_periodo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- Modal para Editar Asignatura -->
    <div class="modal fade" id="modalEditarAsignatura" tabindex="-1" role="dialog" aria-labelledby="modalEditarAsignaturaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="formEditarAsignatura" action="editar_asignatura.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarAsignaturaLabel">Editar Asignatura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <!-- Campos del formulario -->
                        <input type="hidden" id="edit_asignatura_id" name="asignatura_id">
                        <!-- Ciclo -->
                        <div class="form-group">
                            <label for="edit_ciclo_id">Ciclo</label>
                            <select class="form-control select2" id="edit_ciclo_id" name="ciclo_id" required>
                                <?php
                                    $ciclos = CicloLectivo::listarrCiclos();
                                    foreach ($ciclos as $ciclo) {
                                        echo "<option value='{$ciclo['ciclo_id']}'>{$ciclo['ciclo']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Turno -->
                        <div class="form-group">
                            <label for="edit_turno_id">Turno</label>
                            <select class="form-control select2" id="edit_turno_id" name="turno_id" required>
                                <?php
                                    $turnos = Turno::listarTurnos();
                                    foreach ($turnos as $turno) {
                                        echo "<option value='{$turno['turno_id']}'>{$turno['turno']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Otros campos siguen el mismo formato -->
                        <!-- Carrera -->
                        <div class="form-group">
                            <label for="edit_carrera_id">Carrera</label>
                            <select class="form-control select2" id="edit_carrera_id" name="carrera_id" required>
                                <?php
                                    $carreras = Carrera::listarCarreras();
                                    foreach ($carreras as $carrera) {
                                        echo "<option value='{$carrera['carrera_id']}'>{$carrera['carrera_nombre']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Curso -->
                        <div class="form-group">
                            <label for="edit_curso_id">Curso</label>
                            <select class="form-control select2" id="edit_curso_id" name="curso_id" required>
                                <?php
                                    $cursos = Curso::listar_Cursos();
                                    foreach ($cursos as $curso) {
                                        echo "<option value='{$curso['curso_id']}'>{$curso['curso']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Materia -->
                        <div class="form-group">
                            <label for="edit_materia_id">Materia</label>
                            <select class="form-control select2" id="edit_materia_id" name="materia_id" required>
                                <?php
                                    $materias = Materia::listarMaterias();
                                    foreach ($materias as $materia) {
                                        echo "<option value='{$materia['materia_id']}'>{$materia['materia_nombre']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Profesor -->
                        <div class="form-group">
                            <label for="edit_profesor_id">Profesor</label>
                            <select class="form-control select2" id="edit_profesor_id" name="profesor_id" required>
                                <?php
                                    $profesores = Profesor::listarProfesores();
                                    foreach ($profesores as $profesor) {
                                        echo "<option value='{$profesor['profesor_id']}'>{$profesor['profesor_apellido']} {$profesor['profesor_nombre']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Situación de Revista -->
                        <div class="form-group">
                            <label for="edit_situacion_revista">Situación de Revista</label>
                            <input type="text" class="form-control" id="edit_situacion_revista" name="situacion_revista" required>
                        </div>
                        <!-- Inscriptos -->
                        <div class="form-group">
                            <label for="edit_inscriptos">Inscriptos</label>
                            <input type="number" class="form-control" id="edit_inscriptos" name="inscriptos" required>
                        </div>
                        <!-- Regulares -->
                        <div class="form-group">
                            <label for="edit_regulares">Regulares</label>
                            <input type="number" class="form-control" id="edit_regulares" name="regulares" required>
                        </div>
                        <!-- Atraso Académico -->
                        <div class="form-group">
                            <label for="edit_atraso_academico">Atraso Académico</label>
                            <input type="number" class="form-control" id="edit_atraso_academico" name="atraso_academico" required>
                        </div>
                        <!-- Recursantes -->
                        <div class="form-group">
                            <label for="edit_recursantes">Recursantes</label>
                            <input type="number" class="form-control" id="edit_recursantes" name="recursantes" required>
                        </div>
                        <!-- Módulos -->
                        <div class="form-group">
                            <label for="edit_modulos">Módulos</label>
                            <input type="number" class="form-control" id="edit_modulos" name="modulos" required>
                        </div>
                        <!-- 1° Período -->
                        <div class="form-group">
                            <label for="edit_primer_periodo">1° Período</label>
                            <input type="number" class="form-control" id="edit_primer_periodo" name="primer_periodo" required>
                        </div>
                        <!-- 2° Período -->
                        <div class="form-group">
                            <label for="edit_segundo_periodo">2° Período</label>
                            <input type="number" class="form-control" id="edit_segundo_periodo" name="segundo_periodo" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




</body>
<footer>
    <font-size="2">
        <h4>
            <p class="titulos"><a href="logout.php">Cerrar sesión</a></p><br>
            <p class="titulos"></p>
        </h4>
    </font-size>
</footer>

<script>
    $(document).ready(function() {
        $('.btnEditarAsignatura').on('click', function() {
            // Capturamos el ID almacenado en el data-id del botón
            var asignaturaId = $(this).data('id');

            // Loguea el ID en la consola para verificar si se está capturando correctamente
            console.log("ID capturado: ", asignaturaId);

            // Asignamos el ID al campo oculto en el formulario del modal
            $('#edit_asignatura_id').val(asignaturaId);

            // Si necesitas hacer algo más, como rellenar otros campos del modal, hazlo aquí
            // Por ejemplo, podrías hacer una solicitud AJAX para obtener los detalles de la asignatura y llenar el formulario

            // Finalmente, abre el modal
            $('#modalEditarAsignatura').modal('show');
        });
    });
</script>


<!-- <script>
    $(document).ready(function() {
        $('.btnEditarAsignatura').on('click', function() {
            var id = $(this).data('id');
            console.log("ID de asignatura: " + id);

            $.ajax({
                // url: 'get_asignatura.php?id='+asignatura_id,
                url: 'implementation.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    console.log("Respuesta del servidor: ", response);
                    // Parsear la respuesta JSON
                    var asignatura = JSON.parse(response);

                    $('#edit_asignatura_id').val(asignatura.materia_carrera_id);

                    // Cargar select con select2
                    $('#edit_ciclo_id').select2({
                        data: [{ id: asignatura.ciclo_id, text: asignatura.ciclo }]
                    }).trigger('change');

                    $('#edit_turno_id').select2({
                        data: [{ id: asignatura.turno_id, text: asignatura.turno_nombre }]
                    }).trigger('change');

                    $('#edit_carrera_id').select2({
                        data: [{ id: asignatura.carrera_id, text: asignatura.carrera_nombre }]
                    }).trigger('change');

                    $('#edit_curso_id').select2({
                        data: [{ id: asignatura.curso_id, text: asignatura.curso }]
                    }).trigger('change');

                    $('#edit_materia_id').select2({
                        data: [{ id: asignatura.materia_id, text: asignatura.materia_nombre }]
                    }).trigger('change');

                    $('#edit_profesor_id').select2({
                        data: [{ id: asignatura.profesor_id, text: asignatura.profesor_apellido + ' ' + asignatura.profesor_nombre }]
                    }).trigger('change');

                    $('#edit_situacion_revista').val(asignatura.situacion_revista);
                    $('#edit_inscriptos').val(asignatura.inscriptos);
                    $('#edit_regulares').val(asignatura.regulares);
                    $('#edit_atraso_academico').val(asignatura.atraso_academico);
                    $('#edit_recursantes').val(asignatura.recursantes);
                    $('#edit_modulos').val(asignatura.modulos);
                    $('#edit_primer_periodo').val(asignatura.primer_periodo);
                    $('#edit_segundo_periodo').val(asignatura.segundo_periodo);

                    $('#modalEditarAsignatura').modal('show');
                },
                error: function(error) {
                    console.error("Error en la solicitud AJAX", error);
                }
            });
        });
    });
</script> -->


</html>
