<!-- parte de la api para agregar productos al carrito -->
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ahora puede recibir varios product_id
    $productIds = $_POST['product_id'];

    if (!is_array($productIds)) {
        $productIds = [$productIds]; // si solo viene uno, lo convertimos en array
    }

    // aqui crea el carrito 
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $productos = json_decode(file_get_contents("../assets/json/cursos.json"), true);

    $mensajes = [];

    foreach ($productIds as $productId) {
        $found = false;

        // aqui verifica si el curso ya ta en el carrito
        foreach ($_SESSION['cart'] as $item) {
            if ($item['product_id'] == $productId) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            // filtra cusos
            $producto = null;
            foreach ($productos as $p) {
                if ($p['product_id'] == $productId) {
                    $producto = $p;
                    break;
                }
            }

            // agrega al carrito
            if ($producto) {
                $_SESSION['cart'][] = [
                    'product_id' => $producto['product_id'],
                    'nombre' => $producto['nombre'],
                    'descripcion' => $producto['descripcion'],
                    'precio' => $producto['precio'],
                    'imagen' => $producto['imagen']
                ];
                $mensajes[] = "Curso {$producto['nombre']} agregado al carrito";
            } else {
                $mensajes[] = "Producto con id $productId no encontrado";
            }
        } else {
            $mensajes[] = "El curso con id $productId ya estaba en el carrito";
        }
    }

    // por si quiere volver a meterlo
    echo json_encode([
        'status' => 'success',
        'message' => $mensajes,
        'cart' => $_SESSION['cart']
    ], JSON_PRETTY_PRINT);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido'], JSON_PRETTY_PRINT);
}
