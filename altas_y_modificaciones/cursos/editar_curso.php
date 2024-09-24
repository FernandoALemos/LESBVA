<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_curso.php"; 

$nombre = isset($_POST['curso']) ? $_POST['curso'] : null;
$id = isset($_POST['curso_id']) ? $_POST['curso_id'] : null;

if ($nombre) {
    if (Curso::verificarCurso($nombre)) {
        header("Location: ../../ciclos_carreras_cursos.php?mensaje=cr_error");
    } 
    else {
        $curso = new Curso($nombre);
        $curso->modificarCurso($id);
        header('Location: ../../ciclos_carreras_cursos.php?mensaje=curso_editado');
    }
} 
else {
    echo "Error: faltan datos de la materia.";
}
?>
