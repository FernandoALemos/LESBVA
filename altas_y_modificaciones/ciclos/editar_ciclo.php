<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_ciclo.php"; 

if (isset($_POST['ciclo_id']) && isset($_POST['ciclo'])) {
    $ciclo = new CicloLectivo($_POST['ciclo']);
    $ciclo->modificarCiclo($_POST['ciclo_id']);
    header('Location:  ../../ciclos_carreras_cursos.php');
}
?>
