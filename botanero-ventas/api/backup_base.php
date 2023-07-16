<?php
include_once "funciones.php";
include_once "encabezado.php";

// Obtener los datos de las tablas en formato JSON
$insumos = obtenerInsumosR();
$categorias = obtenerCategoriaR();
$usuarios = obtenerUsuariosR();
$ventas = obtenerVentasR();

// Crear un array para almacenar los datos de todas las tablas
$respaldo = array(
    "insumos" => $insumos,
    "categorias" => $categorias,
    "usuarios" => $usuarios,
    "ventas" => $ventas
);

// Convertir el array en formato JSON
$jsonRespaldo = json_encode($respaldo);

// Generar un nombre único para el archivo de respaldo
$fechaHora = date("Ymd-His");
$nombreArchivo = "respaldo_" . $fechaHora . ".json";

// Establecer la cabecera para descargar el archivo
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Content-Type: application/json');

// Imprimir el contenido del respaldo
echo $jsonRespaldo;
?>
