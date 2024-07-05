<?php
session_start();
require_once "database/conectar_db.php";

// Verificar si los datos de la sesión existen
if (!isset($_SESSION['materia_data']) || !isset($_SESSION['ciclo']) || !isset($_SESSION['carrera_nombre'])) {
    die("No hay datos disponibles para descargar.");
}

$data = $_SESSION['materia_data'];
$ciclo = $_SESSION['ciclo'];
$carrera_nombre = $_SESSION['carrera_nombre'];

// Preparar el nombre del archivo
$filename = "{$ciclo}-{$carrera_nombre}.xls";

// Enviar encabezados para la descarga del archivo
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");

// Iniciar la tabla
// Usamos utf8_decode para que reconosca los caracteres especiales al meterlos en el .xls
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
