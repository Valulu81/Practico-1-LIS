<?php
// Iniciamos sesión
session_start();

// Solo aceptamos POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recibimos id del producto
    $productId = $_POST['product_id'];

    // Creamos carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Leemos productos del JSON
    $productos = json_decode(
        file_get_contents("../assets/json/cursos.json"),
        true
    );

    // Bandera para saber si existe
    $existe = false;

    // Buscamos en el carrito
    foreach ($_SESSION['cart'] as &$item) {

        if ($item['product_id'] == $productId) {

            // Aumentamos cantidad (máx 10)
            if ($item['cantidad'] < 10) {
                $item['cantidad']++;
            }

            $existe = true;
            break;
        }
    }

    // Si no existe, lo agregamos
    if (!$existe) {

        $producto = null;

        // Buscamos en JSON
        foreach ($productos as $p) {

            if ($p['product_id'] == $productId) {
                $producto = $p;
                break;
            }
        }

        // Lo agregamos
        if ($producto) {

            $_SESSION['cart'][] = [

                'product_id' => $producto['product_id'],
                'nombre'     => $producto['nombre'],
                'precio'     => $producto['precio'],
                'imagen'     => $producto['imagen'],
                'cantidad'   => 1
            ];
        }
    }

    // Respondemos en JSON
    echo json_encode([
        'status' => 'success',
        'cart'   => $_SESSION['cart']
    ]);

} else {

    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
}