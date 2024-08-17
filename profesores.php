<?php
require_once "database\conectar_db.php";
require_once "clase_usuario.php";
require_once "clase_profesores.php";


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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Gestión de Profesores</title>
</head>

<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>

<body>

    <button class="btn-descargar" onclick="location.href='index.php'">Inicio</button>
    <div class="btns-space"></div><br>

    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Profesores</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearProfesor">Nuevo profesor</button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $profesores = Profesor::listarProfesores();
                foreach ($profesores as $profesor) {
                    echo "<tr>";
                    echo "<td>{$profesor['profesor_apellido']}</td>";
                    echo "<td>{$profesor['profesor_nombre']}</td>";
                    // VER si data-nombre funciona
                    echo "<td>
                            <button class='btn btn-info btn-sm btnEditar' data-id='{$profesor['profesor_id']}' data-nombre='{$profesor['profesor_nombre']}' data-apellido='{$profesor['profesor_apellido']}'>Editar</button>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>


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
                        <div class="form-group">
                            <label for="profesor_nombre">Nombre </label>
                            <input type="text" class="form-control" id="profesor_nombre" name="profesor_nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="profesor_apellido">Apellido </label>
                            <input type="text" class="form-control" id="profesor_apellido" name="profesor_apellido" required>
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
                        <input type="hidden" id="editar_profesor_id" name="profesor_id">
                        <div class="form-group">
                            <label for="editar_profesor_nombre">Nombre </label>
                            <input type="text" class="form-control" id="editar_profesor_nombre" name="profesor_nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="editar_profesor_apellido">Apellido </label>
                            <input type="text" class="form-control" id="editar_profesor_apellido" name="profesor_apellido" required>
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
            var nombre = $(this).data('nombre');
            var apellido = $(this).data('apellido');
            $('#editar_profesor_id').val(id);
            $('#editar_profesor_nombre').val(nombre);
            $('#editar_profesor_apellido').val(apellido);
            $('#modalEditarProfesor').modal('show');
        });
    });
    </script>
</body>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Cerrar sesión</a></p><br>
</footer>

</html>