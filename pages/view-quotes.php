<?php
session_start();
$quotes = $_SESSION['quotes'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Cotizaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/services-catalog.css">
</head>


<body>

    <!-- cabezas jajajjaj lol -->
    <header class="text-center p-3 width-100">
        <h1>UDB Academy sv</h1>
    </header>

    <main class="container py-3">
        <h3 class="mb-3">Cotizaciones Generadas</h3>

        <!-- Tabla en desktop -->
        <div class="d-none d-md-block">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Servicios</th>
                        <th>Ver mas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quotes as $q): ?>
                        <tr>
                            <td><?= $q['codigo'] ?></td>
                            <td><?= $q['cliente']['nombre'] ?> (<?= $q['cliente']['empresa'] ?>)</td>
                            <td><?= $q['fecha'] ?></td>
                            <td>$<?= number_format($q['total'], 2) ?></td>
                            <td><?= $q['cantidadServicios'] ?></td>
                            <td><button class="btn btn-info btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detalleModal"
                                    data-quote='<?= htmlspecialchars(json_encode($q), ENT_QUOTES, 'UTF-8') ?>'>
                                    Ver detalle
                                </button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Cards en mobile -->
        <div class="d-md-none">
            <?php foreach ($quotes as $q): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $q['codigo'] ?></h5>
                        <p><strong>Cliente:</strong> <?= $q['cliente']['nombre'] ?> (<?= $q['cliente']['empresa'] ?>)</p>
                        <p><strong>Fecha:</strong> <?= $q['fecha'] ?></p>
                        <p><strong>Total:</strong> $<?= number_format($q['total'], 2) ?></p>
                        <p><strong>Servicios:</strong> <?= $q['cantidadServicios'] ?></p>
                        <button class="btn btn-info btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#detalleModal"
                            data-quote='<?= htmlspecialchars(json_encode($q), ENT_QUOTES, 'UTF-8') ?>'>
                            Ver detalle
                        </button>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <!-- Modal para ver mas -->
        <div class="modal fade" id="detalleModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalle de Cotización</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Código:</strong> <span id="detalleCodigo"></span></p>
                        <p><strong>Cliente:</strong> <span id="detalleCliente"></span></p>
                        <p><strong>Email:</strong> <span id="detalleEmail"></span></p>
                        <p><strong>Teléfono:</strong> <span id="detalleTelefono"></span></p>
                        <p><strong>Fecha:</strong> <span id="detalleFecha"></span></p>
                        <p><strong>Validez:</strong> <span id="detalleValidez"></span></p>

                        <h6>Servicios:</h6>
                        <ul id="detalleServicios" class="list-group mb-3"></ul>

                        <div class="text-end">
                            <strong>Total: $<span id="detalleTotal"></span></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="services-catalog.php" class="btn btn-primary mt-3">Volver al catálogo</a>
    </main>
    <footer class="text-center p-3 fixed-bottom">
        <p class="mb-0">
            Valeria Liseth Paredes Lara
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('detalleModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const quote = JSON.parse(button.getAttribute('data-quote'));

            document.getElementById('detalleCodigo').textContent = quote.codigo;
            document.getElementById('detalleCliente').textContent = quote.cliente.nombre + " (" + quote.cliente.empresa + ")";
            document.getElementById('detalleEmail').textContent = quote.cliente.email;
            document.getElementById('detalleTelefono').textContent = quote.cliente.telefono;
            document.getElementById('detalleFecha').textContent = quote.fecha;
            document.getElementById('detalleValidez').textContent = quote.validez;
            document.getElementById('detalleTotal').textContent = quote.total.toFixed(2);

            const serviciosList = document.getElementById('detalleServicios');
            serviciosList.innerHTML = quote.items.map(p => {
                const cantidad = p.cantidad ?? 1;
                const subtotal = (p.precio * cantidad).toFixed(2);
                return `
                    <li class="list-group-item">
                        <strong>${p.nombre}</strong><br>
                        Cantidad: ${cantidad}<br>
                        Precio unitario: $${p.precio}<br>
                        Subtotal: $${subtotal}
                    </li>
                `;
            }).join('');
        });
    </script>
</body>

</html>