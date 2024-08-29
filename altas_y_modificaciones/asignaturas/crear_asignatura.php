<?php
require_once "../../database/conectar_db.php";

$text = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ciclo_id = $_POST['ciclo_id'];
    $carrera_id = $_POST['carrera_id'];
    $turno_id = $_POST['turno_id'];
    $curso_id = $_POST['curso_id'];
    $materia_id = $_POST['materia_id'];
    $profesor_id = $_POST['profesor_id'];
    $modulos = $_POST['modulos'];
    $situacion_revista = $_POST['situacion_revista'];
    $inscriptos = $_POST['inscriptos'];
    $regulares = $_POST['regulares'];
    $atraso_academico = $_POST['atraso_academico'];
    $recursantes = $_POST['recursantes'];
    $primer_periodo = $_POST['primer_periodo'];
    $segundo_periodo = $_POST['segundo_periodo'];
    // Otros datos del formulario
    $con = conectar_db();
    $query = "INSERT INTO materia_carrera 
    (ciclo_id, turno_id, carrera_id, curso_id, materia_id, profesor_id, modulos, situacion_revista, inscriptos, regulares, atraso_academico, recursantes, primer_periodo, segundo_periodo) 
    VALUES ('$ciclo_id', '$turno_id','$carrera_id','$curso_id','$materia_id','$profesor_id','$modulos','$situacion_revista','$inscriptos','$regulares','$atraso_academico','$recursantes','$primer_periodo','$segundo_periodo')";
    $result = mysqli_query($con, $query);

    if ($result) {
            header("Location: ../../form_crear_asignatura.php");
            ?>
            <script>
                alert("Se creó con éxito la asignatura");
            </script>
            <?php
        }

        
    else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

