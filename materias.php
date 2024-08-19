<?php
require_once "database\conectar_db.php";
require_once "clase_materia.php";
require_once "clase_usuario.php";


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
    <title>Gestión de Materias</title>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>

<body>
    <!-- <div class="divMaterias-cabecera">
        <button class="btn-descargar" onclick="location.href='index.php'">Inicio</button>
        <div class="btns-space"></div>
    </div> <br> -->
    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Materias</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearMateria">Nueva materia</button>
        </div>
        <table class="table table-bordered">
            <!-- <table class="lista"> -->
            <thead>
                <tr>
                    <th>Nombre de la materia</th> <!-- Cambio nombre de th, me parece más adecuado -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $materias = Materia::listarMaterias();
                foreach ($materias as $materia) {
                    echo "<tr>";
                    echo "<td>{$materia['materia_nombre']}</td>";
                    // class='btn btn-info btn-sm btnEditar'
                    echo "<td>
                            <button class='btn btn-info btn-sm btnEditar' data-id='{$materia['materia_id']}' data-nombre='{$materia['materia_nombre']}'>Editar</button>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>


    <!-- Modal Crear Materia -->
    <div class="modal fade" id="modalCrearMateria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCrearMateria" action="altas_y_modificaciones\materias\crear_materia.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nueva Materia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="materia_nombre">Nombre de la Materia</label>
                            <input type="text" class="form-control" id="materia_nombre" name="materia_nombre" required>
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

    <!-- Modal Editar Materia -->
    <div class="modal fade" id="modalEditarMateria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formEditarMateria" action="altas_y_modificaciones\materias\editar_materia.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Materia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editar_materia_id" name="materia_id">
                        <div class="form-group">
                            <label for="editar_materia_nombre">Nombre de la Materia</label>
                            <input type="text" class="form-control" id="editar_materia_nombre" name="materia_nombre" required>
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
                $('#editar_materia_id').val(id);
                $('#editar_materia_nombre').val(nombre);
                $('#modalEditarMateria').modal('show');
            });
        });
    </script>





</body>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"></i><a href="index.php">Ir a inicio</a></p><br> <!-- Lo agrego acá, queda mejor que arriba de todo creo. -->
</footer>

</html>