<?php
// Clase Service: representa un curso o servicio

class Service {

    // Atributos
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;
    public function __construct($id, $nombre, $descripcion, $precio, $imagen) {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;

    }

    // getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getImagen() {
        return $this->imagen;
    }

    // se usa un metodo estatico 
//     dejo sintaxis: class Service {
//     public static function cargarDatos($ruta) {
//         $contenido = file_get_contents($ruta); // Lee el archivo
//         return json_decode($contenido, true);  // Lo convierte en array de PHP
//     }
// }
    public static function cargarDatos($ruta) {
        $contenido = file_get_contents($ruta);
        // convierto los datos que obtuve del jason en un array ya que 
        // jason_decode convierte la cadena de texto del jason en un objeto array
        $data = json_decode($contenido, true);
        //mi variable para el array
        $servicios = [];
        // Recorremos cada curso
        foreach ($data as $item) {
            // se crea un objeto o sea aca llame al constructor para que me pase los datos 
            $servicio = new Service(
                $item['product_id'],
                $item['nombre'],
                $item['descripcion'],
                $item['precio'],
                $item['imagen']
            );
            // y esos datso los lleno en el array
            $servicios[] = $servicio;
        }
        return $servicios;
    }
}