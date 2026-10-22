<?php
// El usuario debe tener 8 caracteres o más.
// La contraseña debe ser el nombre del usuario al revés.
function usuarioOK($usuario, $contrasena) {
    return strlen($usuario) >= 8 && $contrasena == strrev($usuario);
}

// Evita que el texto introduzca código HTML en la página.
function limpiar($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Cuenta cuántas veces aparece cada palabra y devuelve la más repetida.
function palabraRepetida($texto) {
    $texto = strtolower($texto);
    $palabras = preg_split('/\s+/', trim($texto));
    $mejor = "Ninguna";
    $maximo = 0;

    foreach ($palabras as $palabra) {
        $palabra = preg_replace('/[^a-z0-9áéíóúüñ]/u', '', $palabra);
        if ($palabra == "") {
            continue;
        }

        $veces = 0;
        foreach ($palabras as $otra) {
            $otra = strtolower(preg_replace('/[^a-z0-9áéíóúüñ]/u', '', $otra));
            if ($palabra == $otra) {
                $veces++;
            }
        }

        if ($veces > $maximo) {
            $maximo = $veces;
            $mejor = $palabra . " (" . $veces . " veces)";
        }
    }

    return $mejor;
}

// Cuenta las letras y devuelve la que aparece más veces.
function letraRepetida($texto) {
    $texto = strtolower(str_replace(" ", "", $texto));
    $mejor = "Ninguna";
    $maximo = 0;

    for ($i = 0; $i < strlen($texto); $i++) {
        $letra = $texto[$i];
        if (!ctype_alpha($letra)) {
            continue;
        }

        $veces = substr_count($texto, $letra);
        if ($veces > $maximo) {
            $maximo = $veces;
            $mejor = $letra;
        }
    }

    return $mejor;
}
?>
