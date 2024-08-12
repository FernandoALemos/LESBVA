<?php
require_once 'database/conectar_db.php';
require_once "clase_materia_carrera.php"; // Asegúrate de ajustar la ruta según sea necesario
echo $_POST['id'];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $asignatura = MateriaCarrera::obtenerAsignaturaPorId($id);
    
    if ($asignatura) {
        echo json_encode($asignatura);
    } else {
        echo json_encode(['error' => 'Asignatura no encontrada']);
    }
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}
?>
