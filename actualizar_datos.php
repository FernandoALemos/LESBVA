<?php
require_once "database/conectar_db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $materia_carrera_id = $_POST['materia_carrera_id'];
    $situacion_revista = $_POST['situacion_revista'];
    $inscriptos = $_POST['inscriptos'];
    $regulares = $_POST['regulares'];
    $atraso_academico = $_POST['atraso_academico'];
    $primer_periodo = $_POST['primer_periodo'];
    $segundo_periodo = $_POST['segundo_periodo'];

    $con = conectar_db();

    $sql = "UPDATE materia_carrera SET 
                situacion_revista = ?, 
                inscriptos = ?, 
                regulares = ?, 
                atraso_academico = ?, 
                primer_periodo = ?, 
                segundo_periodo = ? 
            WHERE materia_carrera_id = ?";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("siiiiii", $situacion_revista, $inscriptos, $regulares, $atraso_academico, $primer_periodo, $segundo_periodo, $materia_carrera_id);

    if ($stmt->execute()) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar el registro: " . $stmt->error;
    }

    $stmt->close();
    $con->close();

    // Redirigir de vuelta a informacion.php (o la página que desees)
    header("Location: informacion.php");
    exit();
}
?>
