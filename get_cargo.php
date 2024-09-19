<?php
require_once "database/conectar_db.php";
$con = conectar_db();

$id = intval($_POST['id']);
// $id = $con->real_escape_string($_POST['id']);

echo $id;

$sql = "SELECT ca.cargo_id, ca.carrera_id, ca.turno_id, ca.cargo_nombre, c.carrera_nombre, t.turno
FROM cargos ca
JOIN carreras c ON ca.carrera_id = c.carrera_id
JOIN turnos t ON ca.turno_id = t.turno_id
WHERE ca.cargo_id = $id LIMIT 1";


$resultado = $con->query($sql);
$rows = $resultado->num_rows;

$asignatura = [];

if ($rows > 0) {
    $asignatura = $resultado->fetch_array();
}

echo json_encode($asignatura, JSON_UNESCAPED_UNICODE);


?>
