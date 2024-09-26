<?php
require_once "database/conectar_db.php";
$con = conectar_db();

$id = intval($_POST['profesor_id']);

$sql = "SELECT 
            p.profesor_nombre, 
            p.profesor_apellido, 
            p.profesor_dni, 
            p.profesor_email, 
            p.profesor_direccion, 
            p.profesor_telefono, 
            p.profesor_activo
            FROM profesores p
            WHERE profesor_id = ? LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$profesor = $result->fetch_assoc();

echo json_encode($profesor, JSON_UNESCAPED_UNICODE);
?>
