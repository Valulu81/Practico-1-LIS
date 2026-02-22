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
    // Si está vacío
    if (carrito.length === 0) {
        contenedor.innerHTML = `
            <p class="text-muted text-center">
                Carrito vacío
            </p>
        `;
        totalSpan.textContent = "0.000";
        document.getElementById("info").innerHTML="";
        document.getElementById("contador").textContent="0";
        return;
    }
    let html = "";
    let total = 0;
    carrito.forEach(item => {
        let desactivarMenos= item.cantidad <= 1 ? "disabled" : "";
        let desactivarMas  = item.cantidad >= 10 ? "disabled" : "";
        let subtotal = item.precio * item.cantidad;
        total += subtotal;
        html += `
        <div class="border p-2 mb-2 mt-4 fs-5">
            <strong class="fs-4">${item.nombre}</strong><br>
            $${item.precio} x ${item.cantidad} = 
            <strong>$${subtotal}</strong>
            <div class="mt-2 d-flex gap-2">
                <button 
                    class="btn btn-sm btn-secondary mt-2 px-3"
                    ${desactivarMenos}
                    onclick="cambiarCantidad(${item.product_id}, -1)">
                    -
                </button>

                <button 
                    class="btn btn-sm btn-secondary mt-2 px-3"
                    ${desactivarMas}
                    onclick="cambiarCantidad(${item.product_id}, 1)">
                    +
                </button>
                <button 
                    class="btn btn-sm btn-danger mt-2 px-3"
                    onclick="eliminarProducto(${item.product_id})">
                    X
                </button>
            </div>
        </div>
        `;
    });
    contenedor.innerHTML = html;
    //totalSpan.textContent = total.toFixed(3);

    //La logica del cuento
    let descuento = 0;
    if(total>=500 && total<1000){
        descuento = total *0.05;
    } else if(total>=1000 && total<2500){
        descuento = total *0.1;
    } else if(total>=2500){
        descuento = total * 0.15;
    }
    let iva = (total-descuento)*0.13;
    let final = total -descuento+iva;
    totalSpan.textContent=final.toFixed(3);
    //aca mando a imprimir la informacion 
    document.getElementById("info").innerHTML=`
    Subtotal:$ ${total.toFixed(3)} <br>
    Descuento: $ ${descuento.toFixed(3)}<br>
    IVA: $ ${iva.toFixed(3)}<br>`;
    let totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
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
            carritoActual= data.cart;
            renderCarrito(data.cart);

            data.cart.forEach(item=>{
                if(item.cantidad==10){
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

function vaciarCarrito(){
    fetch("../api/clear-cart.php",{
        method:"POST"
    })
    .then(res=>res.json())
    .then(()=>{
        carritoActual = [];
        // Solo esto
        renderCarrito([]);
        mostrarAlerta("Carrito vaciado");
    });
}