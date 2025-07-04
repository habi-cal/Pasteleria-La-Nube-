<?php

$conexion = new mysqli("localhost", "root", "", "pedidos pasteleria");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

// Recibir datos
$Nombre = $_POST["Nombre"] ?? null;
$Numerotelefonico = $_POST["Numerotelefonico"] ?? null;
$Tipopastel = $_POST["Tipopastel"] ?? null;
$cantidadpastel = $_POST["cantidadpastel"] ?? null;
$Fechadeentrega = $_POST["Fechadeentrega"] ?? null;
$Horadeentrega = $_POST["Horadeentrega"] ?? null;
$NoPedido = $_POST["NoPedido"] ?? null;
$accion = $_POST["accion"] ?? null;

if ($accion === "eliminar" && !empty($NoPedido)) {
    // Borrar registro usando NoPedido
    $stmt = $conexion->prepare("DELETE FROM datosdelpedido WHERE NoPedido = ?");
    $stmt->bind_param("s", $NoPedido);

    if ($stmt->execute()) {
        echo "Pedido eliminado correctamente.";
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }

    $stmt->close();

} elseif ($accion === "insertar") {
    $stmt = $conexion->prepare("INSERT INTO datosdelpedido (Nombre, Numerotelefonico, Tipopastel, cantidadpastel, Fechadeentrega, Horadeentrega, NoPedido) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $Nombre, $Numerotelefonico, $Tipopastel, $cantidadpastel, $Fechadeentrega, $Horadeentrega, $NoPedido);

    if ($stmt->execute()) {
        echo "Pedido guardado correctamente.";
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "Acción no válida o datos incompletos.";
}

$conexion->close();

?>
