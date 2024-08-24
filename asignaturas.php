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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <div class="divMaterias-cabecera">
        <button class="btn btn-primary" onclick="location.href='index.php'">Inicio</button>
        <button class="btn btn-primary" onclick="location.href='buscador.php'">Volver</button>
        <div class="btns-space"></div>
    </div> <br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Asignaturas</h1>
    </div>
    <?php if (!empty($data_ids)) { ?>
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
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody class="table-active">
            <?php
            $asignaturas = MateriaCarrera::obtenerAsignaturasPorIds($data_ids);

            foreach ($asignaturas as $asignatura) { ?>
                <tr>
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
                    <td>
                    <button class='btn btn-info btn-sm btnEditar' data-id= "$asignatura['materia_carrera_id']"><i class="fa-solid fa-pen-to-square"> </i>Editar</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hay datos para mostrar.</p>
    <?php } ?>

    <!-- Modales -->
    <!-- Modal para Editar Asignatura -->
    <div class="modal fade" id="editaModal" tabindex="-1" aria-labelledby="editaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Contenido del modal -->
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title" id="editaModalLabel">Editar Asignatura</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">
                            <!-- Campos del formulario -->
                            <input type="hidden" id="edit_asignatura_id" name="asignatura_id">
                            <!-- Ciclo no funcion-->
                            
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
                        <!-- Otros campos de formulario -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>


<script>
    $(document).ready(function() {
        $('.btnEditar').on('click', function() {
            var id = $(this).data('id');
            $('#edit_asignatura_id').val(id);
            $('#editaModal').modal('show');
        });
    });
</script>

<!-- <script>
    $(document).ready(function() {
        $('.btnEditar').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: 'get_asignatura.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    // Parsear la respuesta JSON
                    var asignatura = JSON.parse(response);

                    $('#edit_asignatura_id').val(asignatura.materia_carrera_id);

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

                    $('#editaModal').modal('show');
                },
                error: function(error) {
                    console.error("Error en la solicitud AJAX", error);
                }
            });
        });
    });
</script> -->


<script src="js/bootstrap.bundle.min.js"></script>


</body>

<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"></i><a href="index.php">Ir a inicio</a></p><br> <!-- Lo agrego acá, queda mejor que arriba de todo creo. -->
</footer>



</html>
