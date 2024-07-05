<?php
require_once "database/conectar_db.php";

if (isset($_POST['carrera'])) {
    $carrera_id = $_POST['carrera'];
    $con = conectar_db();

    $sql_profesor = "SELECT DISTINCT profesores.profesor_id, profesores.profesor_apellido, profesores.profesor_nombre  
                    FROM profesores 
                    INNER JOIN materia_carrera ON profesores.profesor_id = materia_carrera.profesor_id
                    WHERE materia_carrera.carrera_id = ?";
    
    $stmt = $con->prepare($sql_profesor);
    $stmt->bind_param("i", $carrera_id);
    $stmt->execute();
    $resultado_profesor = $stmt->get_result();

    echo "<option value=''>Seleccione un profesor</option>";
    while ($fila = $resultado_profesor->fetch_assoc()) {
        $profesor = $fila['profesor_nombre'].' '. $fila['profesor_apellido'];
        echo "<option value='{$fila['profesor_id']}'>{$profesor}</option>";
    }
    $stmt->close();
    $con->close();
}
?>
