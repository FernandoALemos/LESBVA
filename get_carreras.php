<?php
require_once "database/conectar_db.php";

if (isset($_POST['ciclo'])) {
    $ciclo = $_POST['ciclo'];
    $con = conectar_db();

    $sql_carrera = "SELECT DISTINCT carreras.carrera_id, carreras.carrera_nombre 
                    FROM carreras 
                    INNER JOIN materia_carrera ON carreras.carrera_id = materia_carrera.carrera_id
                    INNER JOIN ciclo_lectivo ON materia_carrera.ciclo_id = ciclo_lectivo.ciclo_id
                    WHERE ciclo_lectivo.ciclo = ?";
    
    $stmt = $con->prepare($sql_carrera);
    $stmt->bind_param("s", $ciclo);
    $stmt->execute();
    $resultado_carrera = $stmt->get_result();

    echo "<option value=''>Seleccione una carrera</option>";
    while ($fila = $resultado_carrera->fetch_assoc()) {
        echo "<option value='{$fila['carrera_id']}'>{$fila['carrera_nombre']}</option>";
    }
    $stmt->close();
    $con->close();
}
?>
