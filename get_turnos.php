<?php
require_once "database/conectar_db.php";

if (isset($_POST['ciclo'])) {
    $ciclo = $_POST['ciclo'];
    $con = conectar_db();

    $sql_turno= "SELECT DISTINCT turnos.turno_id, turnos.turno 
                    FROM turnos 
                    INNER JOIN materia_carrera ON turnos.turno_id = materia_carrera.turno_id
                    INNER JOIN ciclo_lectivo ON materia_carrera.ciclo_id = ciclo_lectivo.ciclo_id
                    WHERE ciclo_lectivo.ciclo = ?";
    
    $stmt = $con->prepare($sql_turno);
    $stmt->bind_param("s", $ciclo);
    $stmt->execute();
    $resultado_turno = $stmt->get_result();

    echo "<option value=''>Seleccione un turno</option>";
    while ($fila = $resultado_turno->fetch_assoc()) {
        echo "<option value='{$fila['turno_id']}'>{$fila['turno']}</option>";
    }
    $stmt->close();
    $con->close();
}
?>