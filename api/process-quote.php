<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // debe tener algo el carrito para este paso
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode([
            "status" => "error",
            "message" => "El carrito está vacío"
        ]);
        exit;
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $producto) {
        $total += $producto['precio'];
    }

    echo json_encode([
        "status" => "success",
        "message" => "Compra procesada",
        "total" => $total,
        "items" => $_SESSION['cart']
    ]);

    // limpiamos carrito
    $_SESSION['cart'] = [];
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido"
    ]);
}
