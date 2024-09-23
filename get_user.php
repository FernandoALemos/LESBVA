<?php
require_once "database/conectar_db.php";
$con = conectar_db();

$id = intval($_POST['usuario_id']);

$sql = "SELECT 
        u.usuario_id, 
        u.usuario_nombre, 
        u.usuario_apellido, 
        u.email, 
        u.contrasenia,
        u.rol_id,
        u.cargo_id,
        r.rol_nombre, 
        c.cargo_nombre,
        u.usuario_suspendido,
        u.primer_ingreso
        FROM usuarios u
        JOIN roles r ON u.rol_id = r.rol_id
        JOIN cargos c ON u.cargo_id = c.cargo_id
        WHERE u.usuario_id = ? LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$usuario = $result->fetch_assoc();

echo json_encode($usuario);
?>
