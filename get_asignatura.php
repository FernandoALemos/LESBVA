<?php
require_once 'database/conectar_db.php';

if (isset($_GET['id'])) {
    $asignatura_id = $_GET['id'];
    echo $asignatura_id;

    $mysqli = conectar_db();
    // $sql = "SELECT situacion_revista, inscriptos, regulares, atraso_academico, recursantes, modulos, primer_periodo, segundo_periodo
    //         FROM materia_carrera
    //         WHERE materia_carrera_id = ?";
    $sql = "SELECT mc.*, c.ciclo, t.turno_nombre, cr.carrera_nombre, cu.curso, m.materia_nombre, p.profesor_apellido, p.profesor_nombre
            FROM materia_carrera mc
            JOIN ciclo c ON mc.ciclo_id = c.ciclo_id
            JOIN turno t ON mc.turno_id = t.turno_id
            JOIN carrera cr ON mc.carrera_id = cr.carrera_id
            JOIN curso cu ON mc.curso_id = cu.curso_id
            JOIN materia m ON mc.materia_id = m.materia_id
            JOIN profesor p ON mc.profesor_id = p.profesor_id
            WHERE mc.materia_carrera_id = ?";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $asignatura_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $asignatura = $result->fetch_assoc();
        echo json_encode($asignatura);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo $asignatura_id;
    echo json_encode(["error" => "No se proporcionó un ID válido"]);
}
?>
