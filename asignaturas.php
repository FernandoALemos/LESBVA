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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
<?php
    if (isset($_GET['mensaje'])) {
        $mensaje = '';
        if ($_GET['mensaje'] == 'editado') {
            $titulo = 'Éxito';
            $mensaje = 'Asignatura editada con éxito.';
        }
        if ($mensaje) {
            echo '
            <div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="modalMensajeLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMensajeLabel">'.$titulo.'</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            '.$mensaje.'
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    ?>
    <script>
        $(document).ready(function() {
            $('#modalMensaje').modal('show');
            setTimeout(function() {
                $('#modalMensaje').modal('hide');
            }, 3000);
        });
    </script>
    <div class="divMaterias-cabecera">
        <div class="btns-space"></div>
        <button class="btn-descargar" onclick="location.href='buscador.php'"><i class="fa-solid fa-arrow-left"> </i> Volver</button>
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
                        <button class='btn btn-info btn-sm btnEditar' data-id= "<?php echo $asignatura['materia_carrera_id']; ?>"><i class="fa-solid fa-pen-to-square"> </i>Editar</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hay datos para mostrar.</p>
    <?php } ?>

    <!-- Modal -->
    <?php include "editaModal.php";?>


<script>
    $(document).ready(function() {
        $('.btnEditar').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: 'get_asignatura.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    console.log("Raw response: ", response);

                    var jsonResponse = response.substring(response.indexOf('{'));
                    console.log("JSON response: ", jsonResponse);

                    try {
                        var form_data = JSON.parse(jsonResponse);
                        console.log("Parsed data: ", form_data);
                    } 
                    catch (error) {
                        console.error("Error al parsear JSON: ", error);
                    }

                    form_data.materia_carrera_id = parseInt(form_data.materia_carrera_id, 10);
                    form_data.turno_id = parseInt(form_data.turno_id, 10);
                    form_data.carrera_id = parseInt(form_data.carrera_id, 10);
                    form_data.curso_id = parseInt(form_data.curso_id, 10);
                    form_data.materia_id = parseInt(form_data.materia_id, 10);
                    form_data.modulos = parseInt(form_data.modulos, 10);
                    form_data.profesor_id = parseInt(form_data.profesor_id, 10);
                    form_data.inscriptos = parseInt(form_data.inscriptos, 10);
                    form_data.regulares = parseInt(form_data.regulares, 10);
                    form_data.atraso_academico = parseInt(form_data.atraso_academico, 10);
                    form_data.recursantes = parseInt(form_data.recursantes, 10);
                    form_data.primer_periodo = parseInt(form_data.primer_periodo, 10);
                    form_data.segundo_periodo = parseInt(form_data.segundo_periodo, 10);

                    $('#edit_asignatura_id').val(form_data.materia_carrera_id);
                    $('#edit_turno_id').val(form_data.turno_id);
                    $('#edit_carrera_id').val(form_data.carrera_id);
                    $('#edit_curso_id').val(form_data.curso_id);
                    $('#edit_materia_id').val(form_data.materia_id);
                    $('#edit_modulos').val(form_data.modulos);
                    $('#edit_profesor_id').val(form_data.profesor_id);
                    $('#edit_situacion_revista').val(form_data.situacion_revista);
                    $('#edit_inscriptos').val(form_data.inscriptos);
                    $('#edit_regulares').val(form_data.regulares);
                    $('#edit_atraso_academico').val(form_data.atraso_academico);
                    $('#edit_recursantes').val(form_data.recursantes);
                    $('#edit_primer_periodo').val(form_data.primer_periodo);
                    $('#edit_segundo_periodo').val(form_data.segundo_periodo);

                    $('#editaModal').modal('show');

                },
                
                error: function(error) {
                    console.error("Error en la solicitud AJAX", error);
                }
            });
        });
    });
</script>



<script src="js/bootstrap.bundle.min.js"></script>


</body>

<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php"> Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"> </i><a href="index.php"> Ir a inicio</a></p><br>
</footer>



</html>
