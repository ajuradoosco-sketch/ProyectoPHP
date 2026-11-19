<?php

class Producto
{
    private $codigo;
    private $nombre;
    private $stock;
    private $stock_min;
    private $precio;

    public function __get($atributo)
    {
        if (property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }

    public function __set($atributo, $valor)
    {
        if (property_exists($this, $atributo)) {
            $this->$atributo = $valor;
        }
    }
}

?>