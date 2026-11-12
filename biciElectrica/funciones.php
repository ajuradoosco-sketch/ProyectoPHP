<?php
require_once("BiciElectrica.php");

// Leer el fichero csv y devuelve una tabla de bicicletas
function cargarbicis(): array
{
    $fich = @fopen("Bicis.csv", "r");
    if ($fich == false) {
        die("Error al abrir el fichero");
    }
    $tabla = [];

    while ($valor = fgetcsv($fich)) {
        list($id, $cx, $cy, $bat, $op) = $valor;
        $bici = new BiciElectrica($id, $cx, $cy, $bat, $op);
        $tabla[] = $bici;
    }

    return $tabla;
}
// Devuelve una cadena con la tabla html de bicis operativas
function mostrartablabicis($tabla): string
{   
    $cadena = "<table>";
    $cadena .= "<tr><th>Id</th><th>Coord X</th><th>Coord Y</th><th>Bateria</th></tr>";
    
    foreach ($tabla as $bici) {
        if ($bici->__get('operativa')) {
            $cadena .= "<tr>";
            $cadena .= "<td>" . $bici->__get('id') . "</td>";
            $cadena .= "<td>" . $bici->__get('coordx') . "</td>";
            $cadena .= "<td>" . $bici->__get('coordy') . "</td>";
            $cadena .= "<td>" . $bici->__get('bateria') . "%</td>";
            $cadena .= "</tr>";
        }
    }
    
    $cadena .= "</table>";
    return $cadena;
}


/**
 * Devuelve la bici con menor distancia a las coordenadas de usuario. 
 * @param $tabla - tabla de bicicletas
 * @param $x - Coordenada x de usuario
 * @param $y - Coordenada x de usuario
 * @return bicicleta más cercana o null
 */
function bicimascercana($tabla, $x, $y)
{   
    $bicicerca = null;
    $menorDistancia = PHP_FLOAT_MAX;

    foreach ($tabla as $bici) {
        // Solo evaluamos las bicis disponibles/operativas
        if ($bici->__get('operativa')) {
            $distancia = $bici->distancia($x, $y);
            if ($distancia < $menorDistancia) {
                $menorDistancia = $distancia;
                $bicicerca = $bici;
            }
        }
    }
    return $bicicerca;
}
?>
