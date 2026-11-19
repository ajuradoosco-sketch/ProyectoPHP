<?php
require_once "app/dat/Producto.php";
require_once 'app/dat/AccesoDatos.php';

function accionBorrar ($codigo){    
    $db = AccesoDatos::getModelo();
    $db->borrarProducto($codigo);
}

function accionTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
    header("Refresh:0 url='./index.php'");
}
 
function accionAlta(){
    $producto = new Producto();
    $producto->codigo = "";
    $producto->nombre = "";
    $producto->stock = "";
    $producto->stock_min = "";
    $producto->precio = "";
    $orden = "Nuevo";
    include_once "layout/formulario.php";
}

function accionDetalles($codigo){
    $db = AccesoDatos::getModelo();
    $producto = $db->getProducto($codigo);
    $orden = "Detalles";
    include_once "layout/formulario.php";
}


function accionModificar($codigo){
    $db = AccesoDatos::getModelo();
    $producto = $db->getProducto($codigo);
    $orden="Modificar";
    include_once "layout/formulario.php";
}

function accionPostAlta(){
    $producto = new Producto();
    $producto->codigo = $_POST['codigo'];
    $producto->nombre = $_POST['nombre'];
    $producto->stock = $_POST['stock'];
    $producto->stock_min = $_POST['stock_min'];
    $producto->precio = $_POST['precio'];
    $db = AccesoDatos::getModelo();
    $db->addProducto($producto);
    
}

function accionPostModificar(){
    $producto = new Producto();
    $producto->codigo = $_POST['codigo'];
    $producto->nombre = $_POST['nombre'];
    $producto->stock = $_POST['stock'];
    $producto->stock_min = $_POST['stock_min'];
    $producto->precio = $_POST['precio'];
    $db = AccesoDatos::getModelo();
    $db->modProducto($producto);
    
}

