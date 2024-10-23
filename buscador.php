<?php
require_once "database\conectar_db.php";
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Reportes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function cargarFiltros() {
            var filter_data = {
                    ciclo: $('#ciclo').val(),
                    carrera: $('#carrera').val(),
                    turno: $('#turno').val(),
                    curso: $('#curso').val(),
                    profesor: $('#profesor').val()
                };
            $.ajax({
                url: 'get_filtros.php',
                method: 'POST',
                data: filter_data,
                dataType: 'json',
                success: function(response) {
                    $('#ciclo').empty();
                    $('#turno').empty();
                    $('#carrera').empty();
                    $('#curso').empty();
                    $('#profesor').empty();

                    $('#ciclo').append('<option value="">Seleccione un ciclo</option>');
                    response.ciclos.forEach(function(ciclo) {
                        var selected = (filter_data && filter_data.ciclo === ciclo.id) ? 'selected' : '';
                        $('#ciclo').append('<option value="' + ciclo.id + '" ' + selected + '>' + ciclo.descripcion + '</option>');
                    });

                    $('#turno').append('<option value="">Seleccione un turno</option>');
                    response.turnos.forEach(function(turno) {
                        var selected = (filter_data && filter_data.turno === turno.id) ? 'selected' : '';
                        $('#turno').append('<option value="' + turno.id + '" ' + selected + '>' + turno.descripcion + '</option>');
                    });

                    $('#carrera').append('<option value="">Seleccione una carrera</option>');
                    response.carreras.forEach(function(carrera) {
                        var selected = (filter_data && filter_data.carrera === carrera.id) ? 'selected' : '';
                        $('#carrera').append('<option value="' + carrera.id + '" ' + selected + '>' + carrera.descripcion + '</option>');
                    });

                    $('#curso').append('<option value="">Seleccione un curso</option>');
                    response.cursos.forEach(function(curso) {
                        var selected = (filter_data && filter_data.curso === curso.id) ? 'selected' : '';
                        $('#curso').append('<option value="' + curso.id + '" ' + selected + '>' + curso.descripcion + '</option>');
                    });

                    $('#profesor').append('<option value="">Seleccione un profesor</option>');
                    response.profesores.forEach(function(profesor) {
                        var selected = (filter_data && filter_data.profesor === profesor.id) ? 'selected' : '';
                        $('#profesor').append('<option value="' + profesor.id + '" ' + selected + '>' + profesor.descripcion + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los filtros:', error);
                }
            });
        }

        $(document).ready(function() {
            cargarFiltros();
            $('form').submit(function(e) {
                if (!$('#ciclo').val() && !$('#turno').val() && !$('#carrera').val() && !$('#curso').val() && !$('#profesor').val()) {
                    e.preventDefault();
                    alert('Debe seleccionar al menos un filtro antes de continuar.');
                }
            });
        });

    </script>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>
<main>

    <body class=".bg-secondary.bg-gradient">
        <form action='informacion.php' class="presentacion" method="POST" style="display: flex; justify-content: center; flex-direction: row;">
            <div style="margin-right: 10px;">
                
                <label for='ciclo'><strong style='color: #135da7;'>Ciclo</strong></label><br>
                <select name='ciclo' id='ciclo'>
                <option value=''>Seleccione un ciclo</option>
                </select>
                <br>

                <label for='turno'><strong style='color: #135da7;'>Turno </strong></label><br>
                <select name='turno' id='turno'>
                <option value=''>Seleccione un turno</option>
                </select>
                <br>

                <label for='carrera'><strong style='color: #135da7;'>Carrera </strong></label><br>
                <select name='carrera' id='carrera'>
                <option value=''>Seleccione una carrera</option>
                </select>
                <br>

                <label for='curso' style='color: #135da7;'>Curso </label><br>
                <select name='curso' id='curso'>
                <option value=''>Seleccione un curso</option>
                </select>
                <br>

                <label for='profesor' style='color: #135da7;'>Profesor </label><br>
                <!-- <input type="text" id="buscarProfesor" placeholder="Buscar para seleccionar" onkeyup="filtrarOpciones('buscarProfesor', 'profesor')"><br> -->
                <select name='profesor' id='profesor'>
                <option value=''>Seleccione un profesor</option>
                </select>
                <br>

                <br><input type='submit' class='btn-descargar' value='Continuar'>
                
            </div>
        </form>
        <script>
        // Función para filtrar opciones de un select
        function filtrarOpciones(inputId, selectId) {
            var input = document.getElementById(inputId);
            var filtro = input.value.toLowerCase();
            var select = document.getElementById(selectId);
            var opciones = select.getElementsByTagName("option");

            // Busca sobre las opciones y oculta las que no coincidan
            for (var i = 0; i < opciones.length; i++) {
                var texto = opciones[i].textContent || opciones[i].innerText;
                if (texto.toLowerCase().indexOf(filtro) > -1 || opciones[i].value === '') {
                    opciones[i].style.display = "";
                } else {
                    opciones[i].style.display = "none";
                }
            }
        }
    </script>
    </body>
</main>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php"> Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"> </i><a href="index.php"> Ir a inicio</a></p><br> 
</footer>

</html>
