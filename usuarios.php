<?php
require_once "database\conectar_db.php";
require_once "clase_usuario.php";
require_once "clase_cargo.php";
require_once "clase_carrera.php";
require_once "clase_materia_carrera.php";

session_start();
if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] <> 1) { //Acá solo lo limito para que solo el director entre hasta que definamos todas las pantallas.
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <title>Gestión de Profesores</title>
</head>

<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>

<body>
    <?php
    if (isset($_GET['mensaje'])) {
        $mensaje = '';
        if ($_GET['mensaje'] == 'cargo_creado') {
            $mensaje = 'Cargo creado con éxito.';
        } 
        elseif ($_GET['mensaje'] == 'cargo_editado') {
            $mensaje = 'Cargo editado con éxito.';
        }
        elseif ($_GET['mensaje'] == 'usuario_creado') {
            $mensaje = 'Usuario editado con éxito.';
        }
        elseif ($_GET['mensaje'] == 'usuario_editado') {
            $mensaje = 'Usuario editado con éxito.';
        }
        elseif ($_GET['mensaje'] == 'cargo_error') {
            $mensaje = 'Error: Ya éxiste el cargo.';
        }
        elseif ($_GET['mensaje'] == 'usuario_error') {
            $mensaje = 'Error: Ya éxiste el usuario.';
        }
        if ($mensaje) {
            echo '
            <div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="modalMensajeLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMensajeLabel">Éxito</h5>
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
            }, 3000); // se cierra después de 3 segundos
        });
    </script>
    <!-- Lista para cargos -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Cargos</h1>
        <button class="btn-descargar" data-toggle="modal" data-target="#modalCrearCargo"><i class="fa-solid fa-user-plus"> </i> Nuevo cargo</button>
    </div>
    <input type="text" id="searchCargos" class="form-control mb-3" placeholder="Buscar cargo...">
    <table class="table table-sm table-striped table-hover mt-4">
        <thead class="table-primary">
            <tr>
                <th>Carrera</th>
                <th>Turno</th>
                <th>Cargo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="table-active" id="tablaCargos">
            <?php
            $cargos = Cargo::listarCargos();
            foreach ($cargos as $cargo) {
                echo "<tr>";
                echo "<td>{$cargo['carrera_nombre']}</td>";
                echo "<td>{$cargo['turno']}</td>";
                echo "<td>{$cargo['cargo_nombre']}</td>";
                echo "<td>
                        <button class='btn btn-info btn-sm btnEditar' data-id='{$cargo['cargo_id']}'><i class='fa-solid fa-pen-to-square'> </i> Editar</button>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <script>

    // Función para filtro dinámico de Profesores
    document.getElementById('searchCargos').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tablaCargos tr');

        rows.forEach(function(row) {
            let carrera = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            let turno = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            let cargo = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            
            // Filtra por apellido o nombre
            if (carrera.includes(filter) || turno.includes(filter) || cargo.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>


    <!-- Modal Crear Profesor cambiar a cargos --> 
    <div class="modal fade" id="modalCrearCargo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCrearCargo" action="altas_y_modificaciones\cargos\crear_cargo.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Cargo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-row">
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
                        <label for="cargo">Cargo </label>
                        <input type="text" class="form-control" id="cargo_nombre" name="cargo_nombre" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Profesor  cambiar a cargos-->
    <div class="modal fade" id="modalEditarCargo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formEditarCargo" action="altas_y_modificaciones\cargos\editar_cargo.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Cargo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <input type="hidden" id="edit_cargo_id" name="cargo_id">

                            <div class="form-row">
                                <div class="form-group col-md-6">
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

                                <div class="form-group col-md-6">
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
                            </div>

                            <div class="form-group">
                                <label for="edit_cargo_nombre">Cargo </label>
                                <input type="text" class="form-control" id="edit_cargo_nombre" name="cargo_nombre" required>
                            </div>
                        </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        $('.btnEditar').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: 'get_cargo.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    console.log("Respuesta recibida: ", response);

                    var jsonResponse = response.substring(response.indexOf('{'));
                    console.log("JSON response: ", jsonResponse);

                    try {
                        var form_data = JSON.parse(jsonResponse);
                        console.log("Parsed data: ", form_data);
                    } 
                    catch (error) {
                        console.error("Error al parsear JSON: ", error);
                    }

                    form_data.cargo_id = parseInt(form_data.cargo_id, 10);
                    form_data.turno_id = parseInt(form_data.turno_id, 10);
                    form_data.carrera_id = parseInt(form_data.carrera_id, 10);

                    $('#edit_cargo_id').val(form_data.cargo_id);
                    $('#edit_turno_id').val(form_data.turno_id);
                    $('#edit_carrera_id').val(form_data.carrera_id);
                    $('#edit_cargo_nombre').val(form_data.cargo_nombre);
                    
                    $('#modalEditarCargo').modal('show');

                },
                
                error: function(error) {
                    console.error("Error en la solicitud AJAX", error);
                }
            });
        });
    });
</script>
</body>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php"> Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"> </i><a href="index.php"> Ir a inicio</a></p><br> <!-- Lo agrego acá, queda mejor que arriba de todo creo. -->
</footer>
</html>
