

<?
// PRIMERA APROXIMACIÓN AL MODELO VISTA CONTROLADOR. 
// Funciones auxiliars Ej- usuarioOK
include_once 'app/funciones.php';

// Salida hacia buffer
ob_start();
$msg = "";


// Segun la orden 
if (!isset($_REQUEST['orden'])) {
    include_once 'app/plantillas/entrada.php';
} else {
    switch ($_REQUEST['orden']) {

        case "Entrar":
            $nombre = $_POST['nombre'] ?? '';
            $contrasena = $_POST['contraseña'] ?? '';

            if (usuarioOK($nombre, $contrasena)) {
                echo "Bienvenido <b>" . limpiar($nombre) . "</b><br>";
                include_once 'app/plantillas/comentario.html';
            } else {
                $msg = "Usuario o contraseña no válidos.";
                include_once 'app/plantillas/entrada.php';
            }
            break;

        case "Nueva opinión":
            echo "Escribe una nueva opinión.<br>";
            include_once 'app/plantillas/comentario.html';
            break;

        case "Detalles":
            include_once 'app/plantillas/comentariorelleno.php';
            include_once 'app/plantillas/detalles.php';
            break;

        case "Terminar":
            include_once 'app/plantillas/entrada.php';
            break;
    }
}

$contenido_php = ob_get_clean();
include_once 'app/plantillas/principal.php';
?>
