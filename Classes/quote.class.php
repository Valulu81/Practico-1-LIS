<?php
// clase de cuotas
class Quote {
    public $code;
    public $client;
    public $items;
    public $subtotal;
    public $discount;
    public $total;
    public $iva;

    public function agregarItem($id, $name, $description, $price, $category) {
        $this->items[] = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $category
        ];
        
    }

    public function CalcularSubtotal(){
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $this->subtotal += $item['price'];
        }
    }

    public function CalcularDescuento($subtotal) {
        
    }

}