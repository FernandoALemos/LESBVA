<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_usuario.php";

$usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : null;
$usuario_nombre = isset($_POST['usuario_nombre']) ? $_POST['usuario_nombre'] : null;
$usuario_apellido = isset($_POST['usuario_apellido']) ? $_POST['usuario_apellido'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$contrasenia = isset($_POST['contrasenia']) ? $_POST['contrasenia'] : null;
$rol_id = isset($_POST['rol_id']) ? $_POST['rol_id'] : null;
$cargo_id = isset($_POST['cargo_id']) ? $_POST['cargo_id'] : null;
$usuario_suspendido = isset($_POST['usuario_suspendido']) ? $_POST['usuario_suspendido'] : null;

if ($usuario_id && $usuario_nombre && $usuario_apellido && $email && $contrasenia && $rol_id && $cargo_id) {
    if (Usuario::verificarExistenciaEmail($email, $usuario_id)) {
        header("Location: ../../usuarios.php?mensaje=usuario_error");
    } 
    else {
        $usuario = new Usuario($usuario_nombre, $usuario_apellido, $email, $contrasenia, $rol_id, $cargo_id, $usuario_suspendido);
        $usuario->modificarUsuario($usuario_id);

        header("Location: ../../usuarios.php?mensaje=usuario_editado");
    }
} 
else {
    echo "Error: faltan datos del usuario.";
}
?>
