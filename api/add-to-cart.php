<!-- parte de la api para agregar productos al carrito -->
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = (int) $_POST['product_id'];

    // aqui crea el carrito 
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // aqui verifica si el curso ya ta en el carrito
    $found = false;
    foreach ($_SESSION['cart'] as $item) {
        if ($item['product_id'] == $productId) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        $productos = json_decode(file_get_contents("../data/productos.json"), true);

        // filtra cusos
        $producto = null;
        foreach ($productos as $p) {
            if ($p['id'] == $productId) {
                $producto = $p;
                break;
            }
        }

        // agrega al carrito
        if ($producto) {
            $_SESSION['cart'][] = [
                'product_id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'imagen' => $producto['imagen']
            ];
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
            exit;
        }
    }

    // por si quiere volver a meterlo
    echo json_encode([
        'status' => 'success',
        'message' => $found ? 'El curso ya estaba en el carrito' : 'Curso agregado al carrito',
        'cart' => $_SESSION['cart']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
