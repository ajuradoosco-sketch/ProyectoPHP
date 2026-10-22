<p><?= limpiar($msg) ?></p>
<div>
<form name="entrada" method="POST" action="index.php">
<table>
<tr>
<td>Nombre:</td><td><input type="text" name="nombre" required minlength="8"></td>
</tr>
<tr>
<td>Contraseña:</td>
<td><input type="password" name="contraseña" required></td>
</tr>
</table>
<input type="submit" name="orden" value="Entrar">
</form>
</div>
