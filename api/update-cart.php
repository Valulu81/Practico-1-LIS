<?php
session_start();
header('Content-Type: application/json');

// actualiza el carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // saca el id del curso
    if (!isset($_POST['product_id']) || !isset($_POST['cantidad'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID y cantidad requeridos']);
        exit;
    }

    $productId = (int) $_POST['product_id'];
    $cantidad = (int) $_POST['cantidad'];
    $updated = false;

    foreach($_SESSION['cart'] as &$item){
        if($item['product_id']==$productId){
            $actual=$item['cantidad'];
            $nueva = $actual+$cantidad;
            //los limites
            if($nueva<1){
                $nueva=1;
            } 
            if($nueva>10){
                $nueva=10;
            }
            //actualizo
            $item['cantidad']=$nueva;
            $updated= true;
            break;
        }
    }

    // respuesta de estado + carrito
    echo json_encode([
        'status' => $updated ? 'success' : 'error',
        'message' => $updated ? "Curso con id $productId actualizado a cantidad $cantidad" : 'Curso no encontrado en el carrito',
        'cart' => $_SESSION['cart'] ?? []
    ], JSON_PRETTY_PRINT);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido'], JSON_PRETTY_PRINT);
}
