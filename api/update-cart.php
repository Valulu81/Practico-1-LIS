<!-- partede la api para actualizar productos del carrito -->
<?php
session_start();
// actualiza el carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // saca el id del curso
    if (!isset($_POST['product_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID requerido']);
        exit;
    }

    $productId = (int) $_POST['product_id'];
    $updated = false;
    // verifica si esta en el carrito pa actualizarlo
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $productId) {
                $updated = true;
                break;
            }
        }
    }
    // respuesta de estado + carrito
    echo json_encode([
        'status' => $updated ? 'success' : 'error',
        'message' => $updated ? 'El curso ya está en el carrito' : 'Curso no encontrado en el carrito',
        'cart' => $_SESSION['cart'] ?? []
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
