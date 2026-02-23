<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode(["status" => "error", "message" => "El carrito está vacío"]);
        exit;
    }

    // aqui guarda la info del cliente
    $cliente = [
        "nombre" => $_POST['nombre'] ?? '',
        "empresa" => $_POST['empresa'] ?? '',
        "email" => $_POST['email'] ?? '',
        "telefono" => $_POST['telefono'] ?? ''
    ];

    // genera el codigo con el formato indicado
    $year = date("Y");
    $consecutivo = str_pad(count($_SESSION['quotes'] ?? []) + 1, 5, "0", STR_PAD_LEFT);
    $codigo = "COT-$year-$consecutivo";

    $fecha = date("Y-m-d");
    $validez = date("Y-m-d", strtotime("+7 days"));

    // $total = array_sum(array_column($_SESSION['cart'], 'precio'));
    // Calcular subtotal real
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
    }if ($subtotal < 100) {
    echo json_encode([
        "status" => "error",
        "message" => "La cotización debe tener un subtotal mínimo de $100"
    ]);
    exit;
    }
    $cantidadServicios = count($_SESSION['cart']);

    // aqui datos genrales con lo de cuross
    $quote = [
        "codigo" => $codigo,
        "cliente" => $cliente,
        "fecha" => $fecha,
        "validez" => $validez,
        "total" => $total,
        "cantidadServicios" => $cantidadServicios,
        "items" => $_SESSION['cart']
    ];

    if (!isset($_SESSION['quotes'])) {
        $_SESSION['quotes'] = [];
    }
    $_SESSION['quotes'][] = $quote;

    echo json_encode(["status" => "success", "quote" => $quote]);

    $_SESSION['cart'] = [];
}
