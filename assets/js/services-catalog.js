let carritoActual = [];
document.addEventListener("DOMContentLoaded", () => {
    //  botones Agregar de las cards 
    const botones = document.querySelectorAll(".btn-add");
    botones.forEach(btn => {
        btn.addEventListener("click", () => {
            // Obtenemos ID
            const id = btn.dataset.id;
            agregarAlCarrito(id);
        });
    });
});

//agrega al carrito
function agregarAlCarrito(id) {
    const datos = new FormData();
    datos.append("product_id", id);
    fetch("../api/add-to-cart.php", {
        method: "POST",
        body: datos
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                //renderCarrito(data.cart);
                carritoActual = data.cart;
                renderCarrito(data.cart);
                mostrarAlerta("Curso agregado");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });

}
// la estructura del carrito
function renderCarrito(carrito) {
    const contenedor = document.getElementById("cart-body");
    const totalSpan = document.getElementById("total");
    const contador = document.getElementById("contador");
    let totalItems = 0;
    // Si está vacío
    if (carrito.length === 0) {
        contenedor.innerHTML = `
            <p class="text-muted text-center">
                Carrito vacío
            </p>
        `;
        totalSpan.textContent = "0.000";
        document.getElementById("info").innerHTML = "";
        document.getElementById("contador").textContent = "0";
        return;
    }
    let html = "";
    let total = 0;
    carrito.forEach(item => {
        let desactivarMenos = item.cantidad <= 1 ? "disabled" : "";
        let desactivarMas = item.cantidad >= 10 ? "disabled" : "";
        let subtotal = item.precio * item.cantidad;
        totalItems += item.cantidad;
        contador.textContent = totalItems;
        total += subtotal;
        html += `
        <div class="border p-2 mb-2 mt-4 fs-5">
            <strong class="fs-4">${item.nombre}</strong><br>
            $${item.precio} x ${item.cantidad} = 
            <strong>$${subtotal}</strong>
            <div class="mt-2 d-flex gap-2">
                <button 
                    class="btn btn-sm btn-outline-secondary mt-2 px-3"
                    ${desactivarMenos}
                    onclick="cambiarCantidad(${item.product_id}, -1)">
                    -
                </button>

                <button 
                    class="btn btn-sm btn-outline-secondary mt-2 px-3"
                    ${desactivarMas}
                    onclick="cambiarCantidad(${item.product_id}, 1)">
                    +
                </button>
                <button 
                    class="btn btn-sm btn-danger mt-2 px-3"
                    onclick="eliminarProducto(${item.product_id})">
                    Eliminar
                </button>
            </div>
        </div>
        `;
    });
    contenedor.innerHTML = html;

    //La logica del descuento
    let productosUnicos = new Set(carrito.map(item => item.product_id)).size;
    let descuento = 0;
    if (productosUnicos >= 3 && productosUnicos < 6) {
        descuento = total * 0.08;

    } else if (productosUnicos >= 6 && productosUnicos <= 9) {
        descuento = total * 0.12;
    } else if (productosUnicos > 9) {
        descuento = total * 0.18;
    }

    let iva = (total - descuento) * 0.13;
    let final = total - descuento + iva;
    totalSpan.textContent = final.toFixed(2);
    document.getElementById("info").innerHTML =
        ` Subtotal: $ ${total.toFixed(2)} 
    <br> 
    Descuento: $ ${descuento.toFixed(2)}
    <br> 
    IVA: $ ${iva.toFixed(2)}<br>`;
}

function cambiarCantidad(id, cambio) {
    fetch("../api/update-cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `product_id=${id}&cantidad=${cambio}`
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                carritoActual = data.cart;
                renderCarrito(data.cart);

                data.cart.forEach(item => {
                    if (item.cantidad == 10) {
                        mostrarAlerta("Ya llegaste al maximoooo");
                    }
                })
            }

        });

}

//Eliminar productos
function eliminarProducto(id) {
    fetch("../api/remove-from-cart.php", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `product_id=${id}`
    })
        .then(res => res.json())
        .then(data => {
            carritoActual = data.cart;
            renderCarrito(data.cart);
        });
}

//Altertas 
function mostrarAlerta(texto) {
    const alerta = document.getElementById("alerta");
    alerta.textContent = texto;
    alerta.classList.remove("d-none");
    setTimeout(() => {
        alerta.classList.add("d-none");
    }, 2000);
}

function vaciarCarrito() {
    fetch("../api/clear-cart.php", {
        method: "POST"
    })
        .then(res => res.json())
        .then(() => {
            carritoActual = [];
            // Solo esto
            renderCarrito([]);
            mostrarAlerta("Carrito vaciado");
        });
}

// pa filtrar los cursos
const inputFiltro = document.getElementById("filtrar");

function filtrarCursos() {
    const valor = inputFiltro.value.toLowerCase();
    const cards = document.querySelectorAll(".card");

    let encontrados = 0;

    cards.forEach(card => {
        const nombre = card.querySelector(".card-title").textContent.toLowerCase();
        const categoria = card.querySelector(".text-muted").textContent.toLowerCase();

        if (nombre.includes(valor) || categoria.includes(valor)) {
            card.parentElement.style.display = "";
            encontrados++;
        } else {
            card.parentElement.style.display = "none";
        }
    });

    const alerta = document.getElementById("alerta");
    if (valor !== "" && encontrados === 0) {
        alerta.classList.remove("d-none");
        alerta.textContent = "No se encontraron cursos";
    } else {
        alerta.classList.add("d-none");
    }
}

inputFiltro.addEventListener("input", filtrarCursos);

// tablita de cotizaciones
function renderQuotes(quotes) {
    const tbody = document.getElementById("quotesTable");
    tbody.innerHTML = quotes.map(q => `
                    <tr>
                    <td>${q.id}</td>
                    <td>${q.codigo}</td>
                        <td>${q.fecha}</td>
                    <td>$${q.total}</td>
                    <td><button onclick="showQuote('${q.id}')">Ver detalle</button></td>
                    </tr>
                    `).join("");
}
document.getElementById("btn-comprar").addEventListener("click", () => {
    const modal = new bootstrap.Modal(document.getElementById("clienteModal"));
    modal.show();
});

document.getElementById("formCotizacion").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("../api/process-quote.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert("Cotización generada: " + data.quote.codigo +
                    "\nValidez: " + data.quote.validez);
            } else {
                alert(data.message);
            }
        });
});

