<?php
require_once "../classes/services.class.php";

// aca para jalar los recursos deñ jason
$servicios = Service::cargarDatos("../assets/json/cursos.json");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Primer practico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/services-catalog.css">
</head>

<body>

<div class="container-fluid min-vh-100 d-flex flex-column">

    <!-- cabezas jajajjaj lol -->
    <header class="text-center p-3">
        <h1>UDB Academy sv</h1>
    </header>
    <div class="flex-grow-1">
        <div class="row h-100">
            <!-- menu -->
             <nav class="col-md-4 col-lg-3 bg-light p-3 d-flex flex-column">
                <h5 class="mb-3 text-center">
                    Mi carrito sv  
                </h5>
                <!-- bote del carrito -->
                 <div id="cart-body" class="flex-grow-1 border rounded p-2 mb-3 bg-white overflow-auto">
                    <p class="text-muted text-center">Carrito vacío</p>
                </div>
                <!-- total -->
                 <div class="mb-2 text-end">
                    <strong>Total de items:<span id="contador">0</span></strong>
                    <div id="info" class="text-end"></div>
                    <strong>Total: $<span id="total">0.00</span></strong>
                </div>
                <button id="btn-comprar" class="btn btn-success w-100 mt-auto">Procesar compra</button>
                <button class="btn btn-danger w-100 mt-2" onclick="vaciarCarrito()">Vciar el carro</button>       
            </nav>

            <!--El main-->
            <main class="col-md-8 col-lg-9 p-4">
                <div id="alerta" class="alert alert-primary d-none" role="alert">
                    Curso agregado al carrito
                </div>
                <!--El catalogo -->
                <h3 class="mb-3">Catálogo</h3>
                <div class="row g-4">
                    <?php foreach ($servicios as $s): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card" style="width: 18rem;">

                                <img 
                                    src="<?= $s->getImagen() ?>" 
                                    class="card-img-top" 
                                    alt="Curso">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= $s->getNombre() ?>
                                    </h5>
                                    <p class="card-text">
                                        <?= $s->getDescripcion() ?>
                                    </p>
                                    <p><strong>$<?= $s->getPrecio() ?></strong></p>
                                    <button
                                        class="btn btn-primary btn-add w-100"
                                        data-id="<?= $s->getId() ?>"
                                    >
                                        Agregar al carrito
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>
    <footer class="text-center p-3">
        <p class="mb-0">
            Aca nuestros nombres 
        </p>
    </footer>

</div>
<script src="../assets/js/services-catalog.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>