<?php
$tema = $_POST['tema'] ?? '';
$comentario = $_POST['comentario'] ?? '';
?>
<div>
<form name="mensaje" method="POST" action="index.php">
Tema<br>
<input type="text" name="tema" size="30" maxlength="100" required value="<?= limpiar($tema) ?>"><br>
Comentario: <br>
<textarea name="comentario" rows="4" cols="50" maxlength="300" required><?= limpiar($comentario) ?></textarea>
<br><br>
<input type="submit" name="orden" value="Detalles">
<input type="submit" name="orden" value="Nueva opinión">
<input type="submit" name="orden" value="Terminar">
</form>
</div>
