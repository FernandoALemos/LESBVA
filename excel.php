<?php
session_start();
require_once "database/conectar_db.php";


if (!isset($_SESSION['materia_data'])) {
    die("No hay datos disponibles para descargar.");
}
$data = $_SESSION['materia_data'];


$ciclo = $_SESSION['ciclo'] ?? "";
$carrera_nombre = $_SESSION['carrera_nombre'] ?? "";
$turno = $_SESSION['turno'] ?? "";
$curso = $_SESSION['curso'] ?? "";
$profesor = $_SESSION['profesor'] ?? "";


$filename_parts = array_filter([$ciclo, $carrera_nombre, $turno, $curso, $profesor]);
$filename = implode("-", $filename_parts) . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");

echo "<table border='1'>
        <thead>
            <tr>
                <th>CICLO</th>
                <th>CARRERA</th>
                <th>CURSO</th>
                <th>MATERIA</th>
                <th>MODULOS</th>
                <th>PROFESOR</th>
                <th>" . utf8_decode("SITUACIÓN DE REVISTA") . "</th>
                <th>INSCRIPTOS</th>
                <th>REGULARES</th>
                <th>ATRASO ACADEMICO</th>
                <th>RECURSANTES</th>
                <th>" . utf8_decode("1° PERIODO") . "</th>
                <th>" . utf8_decode("2° PERIODO") . "</th>
            </tr>
        </thead>
        <tbody>";

foreach ($data as $info) {
    echo "<tr>
            <td>" . utf8_decode(htmlspecialchars($info['ciclo'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['carrera_nombre'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['curso'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['materia_nombre'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['modulos'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['profesor_nombre'] . " " . $info['profesor_apellido'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['situacion_revista'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['inscriptos'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['regulares'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['atraso_academico'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['recursantes'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['primer_periodo'])) . "</td>
            <td>" . utf8_decode(htmlspecialchars($info['segundo_periodo'])) . "</td>
            </tr>";
}

echo "</tbody></table>";
?>
