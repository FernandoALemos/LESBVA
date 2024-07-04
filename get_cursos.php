<?php
require_once "database/conectar_db.php";

if (isset($_POST['carrera'])) {
    $carrera_id = $_POST['carrera'];
    $con = conectar_db();

    $sql_curso = "SELECT DISTINCT cursos.curso_id, cursos.curso 
                    FROM cursos 
                    INNER JOIN materia_carrera ON cursos.curso_id = materia_carrera.curso_id
                    WHERE materia_carrera.carrera_id = ?";
    
    $stmt = $con->prepare($sql_curso);
    $stmt->bind_param("i", $carrera_id);
    $stmt->execute();
    $resultado_curso = $stmt->get_result();

    echo "<option value=''>Seleccione un curso</option>";
    while ($fila = $resultado_curso->fetch_assoc()) {
        // echo <option value='{$fila['valor que tomo y muestro por post']>{$fila['nombre o dato que muestro en el combo']}
        echo "<option value='{$fila['curso_id']}'>{$fila['curso']}</option>";
    }
    $stmt->close();
    $con->close();
}
?>
