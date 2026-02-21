<!-- partede la api para eliminar productos del carrito -->
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    
    // aqui verifica si esta en el carrito pa eliminarlo
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $productId) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        // vuelve a hacer el carrito
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    // respuesta de estado + carrito
    echo json_encode([
        'status' => 'success',
        'message' => 'Producto eliminado del carrito',
        'cart' => $_SESSION['cart']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
