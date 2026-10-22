<?php
$tema = $_POST['tema'] ?? '';
$comentario = $_POST['comentario'] ?? '';

$caracteres = strlen($comentario);
$palabras = str_word_count($comentario, 0, 'áéíóúüñÁÉÍÓÚÜÑ');
?>
<div>
<b>Detalles:</b><br>
<p><b>Tema:</b> <?= limpiar($tema) ?></p>
<p><b>Comentario:</b> <?= nl2br(limpiar($comentario)) ?></p>

<table>
<tr><td>Longitud:</td><td><?= $caracteres ?></td></tr>
<tr><td>Nº de palabras:</td><td><?= $palabras ?></td></tr>
<tr><td>Letra + repetida:</td><td><?= limpiar(letraRepetida($comentario)) ?></td></tr>
<tr><td>Palabra + repetida:</td><td><?= limpiar(palabraRepetida($comentario)) ?></td></tr>
</table>
</div>
