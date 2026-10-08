<?php

// Si entramos mediante GET mostramos el formulario
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    include "captura.html";

    exit;
}


// ==========================
// DATOS DEL FORMULARIO
// ==========================

$nombre = $_POST["nombre"] ?? "";
$alias = $_POST["alias"] ?? "";
$edad = $_POST["edad"] ?? "";


// Evitar inyección de código
$nombre = htmlspecialchars($nombre, ENT_QUOTES, "UTF-8");
$alias = htmlspecialchars($alias, ENT_QUOTES, "UTF-8");


// ==========================
// ARMAS
// ==========================

$armas = $_POST["armas"] ?? [];


// ==========================
// MAGIA
// ==========================

$magia = $_POST["magia"] ?? "No";


// ==========================
// IMAGEN
// ==========================

// Por defecto mostramos la calavera
$imagen = "calavera.png";

$error = "";


// Comprobar si se ha enviado una imagen
if (
    isset($_FILES["imagen"]) &&
    $_FILES["imagen"]["error"] != UPLOAD_ERR_NO_FILE
) {

    // Comprobar errores
    if ($_FILES["imagen"]["error"] != UPLOAD_ERR_OK) {

        $error = "Error al subir la imagen.";

    }

    // Comprobar tamaño
    elseif ($_FILES["imagen"]["size"] > 10 * 1024) {

        $error = "Error al subir la imagen";

    }

    else {

        // Comprobar que sea PNG
        $tipo = mime_content_type(
            $_FILES["imagen"]["tmp_name"]
        );

        if ($tipo != "image/png") {

            $error = "Error al subir la imagen";

        }

        else {

            // Nombre único para evitar problemas
            $nombreImagen = uniqid() . ".png";

            // Carpeta uploads
            $ruta = "uploads/" . $nombreImagen;


            // Guardar imagen
            if (
                move_uploaded_file(
                    $_FILES["imagen"]["tmp_name"],
                    $ruta
                )
            ) {

                $imagen = $ruta;

            }

            else {

                $error = "Error al subir la imagen";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Datos del Jugador</title>

    <style>

        body {

            margin: 0;

            padding: 30px;

            background-color: white;

            font-family: Arial, sans-serif;
        }


        .contenedor {

            width: 650px;

            margin: 0 auto;

            background-color: yellow;

            padding: 25px;

            border-radius: 8px;

            box-shadow: 0 2px 5px #aaa;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }


        .datos {

            width: 55%;
        }


        .datos h1 {

            text-align: center;

            font-size: 22px;

            margin-bottom: 25px;
        }


        .datos p {

            font-size: 14px;

            margin: 14px 0;
        }


        .imagen {

            width: 40%;

            text-align: center;
        }


        .imagen h2 {

            font-size: 14px;

            margin-bottom: 15px;
        }


        .imagen img {

            width: 130px;

            height: 130px;

            object-fit: contain;

            border: 1px solid #555;

            background-color: white;
        }


        .error {

            color: black;

            font-size: 13px;

            margin-top: 10px;
        }

    </style>

</head>


<body>


<div class="contenedor">


    <div class="datos">

        <h1>Datos del Jugador</h1>


        <p>
            <strong>Nombre:</strong>
            <?php echo $nombre; ?>
        </p>


        <p>
            <strong>Alias:</strong>
            <?php echo $alias; ?>
        </p>


        <p>
            <strong>Edad:</strong>
            <?php echo $edad; ?>
        </p>


        <p>

            <strong>Armas seleccionadas:</strong>

            <?php

            if (!empty($armas)) {

                echo htmlspecialchars(
                    implode(", ", $armas),
                    ENT_QUOTES,
                    "UTF-8"
                );

            } else {

                echo "Ninguna";
            }

            ?>

        </p>


        <p>

            <strong>¿Practica artes mágicas?:</strong>

            <?php

            echo htmlspecialchars(
                $magia,
                ENT_QUOTES,
                "UTF-8"
            );

            ?>

        </p>

    </div>


    <div class="imagen">

        <?php

        // Si hay imagen subida
        if ($imagen != "calavera.png") {

            echo "<h2>Imagen subida:</h2>";

        }

        // Si no se ha subido imagen
        else {

            echo "<h2>No se subió ninguna imagen.</h2>";

        }

        ?>


        <img
            src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, "UTF-8"); ?>"
            alt="Imagen del jugador"
        >


        <?php

        // Mostrar error si lo hay
        if ($error != "") {

            echo "<p class='error'>";
            echo htmlspecialchars(
                $error,
                ENT_QUOTES,
                "UTF-8"
            );
            echo "</p>";

        }

        ?>

    </div>


</div>


</body>

</html> 