<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_curso.php"; 

if (isset($_POST['curso'])) {
    $curso = new Curso($_POST['curso']);
    $curso->crearCurso();
    header('Location: ../../ciclos_carreras_cursos.php?mensaje=curso_creado');
    exit();
}
?>
