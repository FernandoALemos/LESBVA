<?php
require_once "../../database/conectar_db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asignatura_id = $_POST['asignatura_id'];
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
    $query = "UPDATE materia_carrera SET carrera_id='$carrera_id',turno_id='$turno_id',curso_id='$curso_id',materia_id='$materia_id',profesor_id='$profesor_id', modulos='$modulos',situacion_revista='$situacion_revista',inscriptos='$inscriptos',regulares='$regulares',atraso_academico='$atraso_academico',recursantes='$recursantes',primer_periodo='$primer_periodo',segundo_periodo='$segundo_periodo' WHERE materia_carrera_id='$asignatura_id'";

    $result = mysqli_query($con, $query);

    if ($result) {
        $_SESSION['mensaje_exito'] = "La asignatura se ha modificado con éxito.";
        header("Location: ../../asignaturas.php");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
else {
    echo "Error: " . mysqli_error($con);
}
?>
