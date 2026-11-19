<?php
include_once "app/dat/Producto.php";
include_once "app/config.php";

/*
 * Acceso a datos con BD Usuarios y Patrón Singleton 
 * Un único objeto para la clase
 * VERSION 1:  las sentencias precompiladas ser crean en cada función
 */
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    
    
    public static function getModelo(){
        // Si no existe lo crea el acceso de a la BD
        if (self::$modelo == null){
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }
    
    

   // Constructor privado  Patron singleton, se accede por getModelo
   
    private function __construct(){
        
        try {
            $dsn = "mysql:host=".SERVER_DB.";dbname=".DATABASE.";charset=utf8";
            // Creo el objeto PDO estableciendo la conexión a la BD
            $this->dbh = new PDO($dsn,DB_USER,DB_PASSWD);
            // Si falla genera una excepción
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }   
    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo(){
        if (self::$modelo != null){
            $obj = self::$modelo;
            $obj->dbh = null;     // Cierro la conexión
            self::$modelo = null; // Borro el objeto.
        }
    }


    // Devuelvo un array de objeto de Usuarios
    public function getProductos ():array {
        $tproductos = [];
        // Sobre la conexión PDO prepara la consulta;
        $stmt_tproductos  = $this->dbh->prepare("select CODIGO as codigo, NOMBRE as nombre, STOCK as stock, STOCK_MIN as stock_min, PRECIO as precio from Productos");
        // Los resultados se devuelven como objetos de la clase Productos
        $stmt_tproductos->setFetchMode(PDO::FETCH_CLASS, 'Producto');
        
        // Ejecuto la sentencias 
        if ( $stmt_tproductos->execute() ){
            // Mientra $producto no sea false, sea un objeto
            while ( $producto = $stmt_tproductos->fetch()){
               // añado ese objeto a la tabla
               $tproductos[]= $producto;
            }
        }
        

        return $tproductos;
    }
    
    // Devuelvo un producto o false
    public function getProducto (int $codigo) {
        $producto = false;
        $stmt_producto   = $this->dbh->prepare("select * from Productos where CODIGO =:codigo");
        $stmt_producto->setFetchMode(PDO::FETCH_CLASS, 'Producto');
        $stmt_producto->bindValue(':codigo', $codigo);
        if ( $stmt_producto->execute() ){
             // Solo hay un objeto
             if ( $obj = $stmt_producto->fetch()){
                $producto= $obj;
            }
        }
        return $producto;
    }
    
    // UPDATE
    public function modProducto($producto):bool{
      
        $stmt_modproducto   = $this->dbh->prepare( "update Productos set NOMBRE = :nombre, STOCK = :stock, STOCK_MIN = :stock_min, PRECIO = :precio where CODIGO = :codigo");
        $stmt_modproducto->bindValue(':codigo', $producto->codigo);
        $stmt_modproducto->bindValue(':nombre', $producto->nombre);
        $stmt_modproducto->bindValue(':stock', $producto->stock);
        $stmt_modproducto->bindValue(':stock_min', $producto->stock_min);
        $stmt_modproducto->bindValue(':precio', $producto->precio);
        $stmt_modproducto->execute();
        // El número de filas modificadas debe ser 1
        $resu = ($stmt_modproducto->rowCount () == 1);
        return $resu;
    }

    //INSERT
    public function addProducto($producto):bool{
        $stmt_creaproducto = $this->dbh->prepare("insert into Productos (CODIGO, NOMBRE, STOCK, STOCK_MIN, PRECIO) Values (?, ?, ?, ?, ?)");
        $stmt_creaproducto->execute( [$producto->codigo, $producto->nombre, $producto->stock, $producto->stock_min, $producto->precio]);
        $resu = ($stmt_creaproducto->rowCount() == 1);

        return $resu;

    }

    //DELETE
    public function borrarProducto(String $codigo):bool {
        $stmt_borproducto = $this->dbh->prepare("delete from Productos where CODIGO = :codigo");
        $stmt_borproducto->bindValue(':codigo', $codigo);
        $stmt_borproducto->execute();
        $resu = ($stmt_borproducto->rowCount() == 1);
        return $resu;
    }   
    
     // Evito que se pueda clonar el objeto. (SINGLETON)
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }
}

