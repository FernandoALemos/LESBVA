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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <title>Gestión de Materias</title>
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
            $mensaje = 'Materia creada con éxito.';
        } elseif ($_GET['mensaje'] == 'editado') {
            $mensaje = 'Materia editada con éxito.';
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
    <br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Unidades Curriculares</h1>
        <button class="btn-descargar" data-toggle="modal" data-target="#modalCrearMateria"><i class="fa-solid fa-plus"> </i> Nueva materia</button>
    </div>
    <input type="text" id="searchMaterias" class="form-control mb-3" placeholder="Buscar unidad curricular...">
    <table class="table table-sm table-striped table-hover mt-4">
        <thead class="table-primary">
            <tr>
                <th>Nombre de la unidad curricular</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="table-active" id="tablaMaterias">
            <?php
            $materias = Materia::listarMaterias();
            foreach ($materias as $materia) {
                echo "<tr>";
                echo "<td>{$materia['materia_nombre']}</td>";
                echo "<td>
                        <button class='btn btn-info btn-sm btnEditar' data-id='{$materia['materia_id']}' data-nombre='{$materia['materia_nombre']}'><i class='fa-solid fa-pen-to-square'> </i> Editar</button>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
    // Función para filtro dinamico en Unidades Curriculares
    document.getElementById('searchMaterias').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tablaMaterias tr');

        rows.forEach(function(row) {
            let nombreMateria = row.querySelector('td').textContent.toLowerCase();
            if (nombreMateria.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>



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
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php"> Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"> </i><a href="index.php"> Ir a inicio</a></p><br> <!-- Lo agrego acá, queda mejor que arriba de todo creo. -->
</footer>

</html>
