<?php
require_once "database\conectar_db.php";
require_once "clase_usuario.php";
require_once "clase_profesores.php";


session_start();
if (!isset($_SESSION['rol_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
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
        if ($_GET['mensaje'] == 'creado') {
            $titulo = 'Éxito';
            $mensaje = 'Profesor/ra creado/a con éxito.';
        } 
        elseif ($_GET['mensaje'] == 'editado') {
            $titulo = 'Éxito';
            $mensaje = 'Profesor/ra editado/a con éxito.';
        }
        elseif ($_GET['mensaje'] == 'prof_error') {
            $titulo = 'Error';
            $mensaje = 'Profesor/ra editado/a ya existe.';
        }
        if ($mensaje) {
            echo '
            <div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="modalMensajeLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMensajeLabel">
                                '.$titulo.'
                            </h5>
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Profesores</h1>
        <button class="btn-descargar" data-toggle="modal" data-target="#modalCrearProfesor"><i class="fa-solid fa-user-plus"> </i> Nuevo profesor</button>
    </div>
    <input type="text" id="searchProfesores" class="form-control mb-3" placeholder="Buscar profesor...">
    <table class="table table-sm table-striped table-hover mt-4">
        <thead class="table-primary">
            <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="table-active" id="tablaProfesores">
            <?php
            $profesores = Profesor::listarProfesores();
            foreach ($profesores as $profesor) {
            ?>
            <tr>
                <td><?= $profesor['profesor_apellido'] ?></td>
                <td><?= $profesor['profesor_nombre'] ?></td>
                <td><?= $profesor['profesor_dni'] ?></td>
                <td><?= $profesor['profesor_email'] ?></td>
                <td><?= $profesor['profesor_direccion'] ?></td>
                <td><?= $profesor['profesor_telefono'] ?></td>
                <td><?= $profesor['profesor_activo'] ? 'Sí' : 'No' ?></td>
                <td>
                        <button class='btn btn-info btn-sm btnEditar' data-id="<?= $profesor['profesor_id'] ?>"><i class='fa-solid fa-pen-to-square'> </i> Editar</button>
                </td>
                
                
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <script>
    // Función para filtro dinámico de Profesores
    document.getElementById('searchProfesores').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tablaProfesores tr');

        rows.forEach(function(row) {
            let apellido = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            let nombre = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            let dni = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            let email = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            let direccion = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
            let telefono = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
            let activo = row.querySelector('td:nth-child(7)').textContent.toLowerCase();
            
            // Filtra por apellido o nombre
            if (apellido.includes(filter) || nombre.includes(filter) || dni.includes(filter) || email.includes(filter) || direccion.includes(filter) || telefono.includes(filter) || activo.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    </script>


    <!-- Modal Crear Profesor -->
    <div class="modal fade" id="modalCrearProfesor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCrearProfesor" action="altas_y_modificaciones\profesores\crear_profesor.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Profesor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="profesor_nombre">Nombre </label>
                                <input type="text" class="form-control" id="profesor_nombre" name="profesor_nombre" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="profesor_apellido">Apellido </label>
                                <input type="text" class="form-control" id="profesor_apellido" name="profesor_apellido" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="profesor_dni">DNI</label>
                                <input type="number" maxlength="8" class="form-control" name="profesor_dni" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="profesor_telefono">Teléfono</label>
                                <input type="text" class="form-control" name="profesor_telefono" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="profesor_email">Email</label>
                            <input type="email" class="form-control" name="profesor_email" required>
                        </div>
                        <div class="form-group">
                            <label for="profesor_direccion">Dirección</label>
                            <input type="text" class="form-control" name="profesor_direccion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Profesor -->
    <div class="modal fade" id="modalEditarProfesor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formEditarProfesor" action="altas_y_modificaciones\profesores\editar_profesor.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Profesor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_profesor_id" name="profesor_id">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_profesor_apellido">Apellido </label>
                                <input type="text" class="form-control" id="edit_profesor_apellido" name="profesor_apellido" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_profesor_nombre">Nombre </label>
                                <input type="text" class="form-control" id="edit_profesor_nombre" name="profesor_nombre" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_profesor_dni">DNI</label>
                                <input type="number" maxlength="8" class="form-control" id="edit_profesor_dni" name="profesor_dni" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_profesor_telefono">Teléfono</label>
                                <input type="text" class="form-control" id="edit_profesor_telefono" name="profesor_telefono" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_profesor_email">Email</label>
                            <input type="email" class="form-control" id="edit_profesor_email" name="profesor_email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_profesor_direccion">Dirección</label>
                            <input type="text" class="form-control" id="edit_profesor_direccion" name="profesor_direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="profesor_activo">Activo</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="profesor_activo" id="edit_activo_no" value="0">
                                <label class="form-check-label" for="edit_activo_no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="profesor_activo" id="edit_activo_si" value="1">
                                <label class="form-check-label" for="edit_activo_si">Sí</label>
                            </div>
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
            var profesor_id = $(this).data('id');
            $.ajax({
                url: 'get_profesor.php',
                type: 'POST',
                data: {profesor_id: profesor_id},
                success: function(response) {
                    var JsonResponse = response.substring(response.indexOf('{'));
                    try {
                        var form_data = JSON.parse(JsonResponse);
                        console.log("Parsed data: ", form_data);
                    } 
                    catch (error) {
                        console.error("Error al parsear JSON: ", error);
                    }

                    form_data.profesor_id = parseInt(form_data.profesor_id, 10);
                    form_data.profesor_dni = parseInt(form_data.profesor_dni, 10);
                    
                    
                    $('#edit_profesor_id').val(form_data.profesor_id);
                    $('#edit_profesor_nombre').val(form_data.profesor_nombre);
                    $('#edit_profesor_apellido').val(form_data.profesor_apellido);
                    $('#edit_profesor_dni').val(form_data.profesor_dni);
                    $('#edit_profesor_email').val(form_data.profesor_email);
                    $('#edit_profesor_direccion').val(form_data.profesor_direccion);
                    $('#edit_profesor_telefono').val(form_data.profesor_telefono)
                

                    if (form_data.profesor_activo == 1) {
                        $('#edit_activo_si').prop('checked', true);
                    } 
                    else {
                        $('#edit_activo_no').prop('checked', true);
                    }
                    
                    $('#modalEditarProfesor').modal('show');
                },
                error: function(error) {
                    console.log('Error:', error);
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
