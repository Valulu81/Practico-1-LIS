# Sistema de Cotización con Carrito en PHP
Estudiantes:
- Valeria Liseth Paredes Lara  
- Andre Emanuel Preza Deras  
---

## Descripción General del proyecto

Este proyecto es un sistema web que permite navegar sobre los diferentes "servivios" (especie de cursos), agregarlos a un carrito, modificar cantidades y posteriormente generar cotizaciones.

Funciona utilizando principalmente PHP, JavaScript, AJAX y sesiones.

---

## Tecnologías Utilizadas
- PHP  
- JavaScript  
- HTML  
- CSS  
- Bootstrap 5  
- JSON  
- AJAX  
  
---

## Funcionamiento del Sistema
                     INICIO
                       │
                       ↓
        ┌────────────────────────────┐
        │   Usuario abre el sistema  │
        │ (services-catalog.php)     │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │  Mostrar catálogo desde    │
        │  archivo JSON              │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │ Usuario selecciona curso   │
        │ (Agregar al carrito)       │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │ Enviar petición AJAX a     │
        │ add-to-cart.php            │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │ Guardar en sesión          │
        │ $_SESSION['cart']          │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │ Mostrar carrito            │
        │ actualizado                │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │ Usuario modifica           │
        │ cantidades o elimina       │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │ Recalcular total, IVA       │
        │ y descuento                │
        └────────────────────────────┘
                       │
                       ↓
        ┌────────────────────────────┐
        │ ¿Presiona "Procesar compra"?│
        └────────────────────────────┘
                       │
             ┌─────────┴─────────┐
             │                   │
            NO                  SÍ
             │                   │
             ↓                   ↓
 ┌────────────────────┐  ┌──────────────────────┐
 │ Seguir editando     │  │ Mostrar formulario   │
 │ el carrito          │  │ de datos del cliente │
 └────────────────────┘  └──────────────────────┘
             │                   │
             │                   ↓
             │       ┌──────────────────────┐
             │       │ Enviar datos a        │
             │       │ process-quote.php    │
             │       └──────────────────────┘
             │                   │
             │                   ↓
             │       ┌──────────────────────┐
             │       │ Generar cotización   │
             │       │ y guardar historial  │
             │       └──────────────────────┘
             │                   │
             │                   ↓
             │       ┌──────────────────────┐
             │       │ Vaciar carrito       │
             │       │ y mostrar resultado │
             │       └──────────────────────┘
             │                   │
             └───────────────►   ↓
                              FIN

El usuario selecciona cursos, los agrega al carrito y luego genera una cotización ingresando sus datos.

---

## Reglas del Sistema

### Descuentos

| Cantidad | Descuento |
|----------|-----------|
| 3 - 5 | 8% |
| 6 - 9 | 12% |
| 10+ | 18% |

### Impuesto

IVA: 13%

### Límites

- Mínimo: 1
- Máximo: 10

---

## Instalación

### Requisitos

- WAMPSERVER 
- PHP 8 o superior
- Navegador

### Pasos

1. Iniciar wamp.

2. Abrir en el navegador:
http://localhost/Practico-1-LIS/pages/services-catalog.php

---

## Uso del Sistema

### Paso 1: Acceder al sistema

1. Abrir el navegador.
2. Ingresar la URL del proyecto.
3. Se mostrará el catálogo principal.

---

### Paso 2: Seleccionar cursos

1. Revisar los servicios disponibles.
2. Utilizar el buscador si es necesario.
3. Presionar el botón "Agregar al carrito".

---

### Paso 3: Administrar el carrito

1. Visualizar los cursos agregados.
2. Aumentar o disminuir cantidades.
3. Eliminar cursos si es necesario.
4. Vaciar el carrito si desea reiniciar.

---

### Paso 4: Generar cotización

1. Presionar el botón "Procesar compra".
2. Completar el formulario con datos del cliente.
3. Confirmar la información.
4. Generar la cotización.

---

### Paso 5: Ver historial

1. Acceder a la opción "Ver cotizaciones".
2. Revisar cotizaciones anteriores.
3. Consultar los detalles de cada una.
---

## Conclusión

Este proyecto permitió aplicar los conocimientos vistos en clase, integrando frontend y backend en una sola aplicación funcional.

---

