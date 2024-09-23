<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_usuario.php";

$usuario_nombre = isset($_POST['usuario_nombre']) ? $_POST['usuario_nombre'] : null;
$usuario_apellido = isset($_POST['usuario_apellido']) ? $_POST['usuario_apellido'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$contrasenia = isset($_POST['contrasenia']) ? $_POST['contrasenia'] : null;
$rol_id = isset($_POST['rol_id']) ? $_POST['rol_id'] : null;
$cargo_id = isset($_POST['cargo_id']) ? $_POST['cargo_id'] : null;

if ($usuario_nombre && $usuario_apellido && $email && $contrasenia && $rol_id && $cargo_id) {
    if (Usuario::verificarExistenciaEmail($email)) {
        header("Location: ../../usuarios.php?mensaje=usuario_error");
    } 
    else {
        $usuario_suspendido = 0;
        $primer_ingreso = 0;

        $usuario = new Usuario($usuario_nombre, $usuario_apellido, $email, $contrasenia, $rol_id, $cargo_id, $usuario_suspendido, $primer_ingreso);
        $usuario->crearUsuario();

        header("Location: ../../usuarios.php?mensaje=usuario_creado");
    }
} 
else {
    echo "Error: faltan datos del usuario.";
}
?>
