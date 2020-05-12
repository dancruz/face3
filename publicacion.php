<?php
include("config.php");

//Funcion para enlistar los registros de publicacion
function listar()
{
	global $conn;
	echo '<p><a href="index.php?">Ir a Inicio</a></p><table border=1><tr><td>ID</td><td>Usuario</td><td>Publicacion</td></tr>';
	$sql = mysqli_query($conn, "SELECT ID, Usuario, Publicacion FROM publicacion") or die("Error tabla publicacion");
	while($datos = mysqli_fetch_array($sql))
	{
		$id=$datos['ID'];
		$usuario=$datos['Usuario'];
		$publi=$datos['Publicacion'];
		echo "<tr><td><a href='publicacion.php?editid={$id}'>{$id}</a><br /><a href='comentario.php?id={$id}' style='color:red;'>( + )</a><br /><a href='publicacion.php?id={$id}' style='color:blue;'>(<>)</a></td><td>{$usuario}</td><td>{$publi}</td></tr>";
	}
	echo '</table>';
	return;
}

function actualizar($id)
{
	global $conn;
	$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
	$publi = mysqli_real_escape_string($conn, $_POST['publi']);
	$sql = mysqli_query($conn, "UPDATE publicacion SET Usuario='{$usuario}', Publicacion='{$publi}' WHERE ID = {$id}") or die("<p> No se actualizo publicacion ${$id}</p>");
	echo "<p> Se actualizo la publicacion #{$id}</p>";
	editar($id);

}
function editar($id)
{
	global $conn;
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	$sql = mysqli_query($conn, "SELECT ID, Usuario, Publicacion FROM publicacion WHERE ID = {$id}") or die("No se puede traer datos");
	$datos = mysqli_fetch_array($sql);
	if($datos["ID"] != "")
	{
		$id=$datos['ID'];
		$usuario=$datos['Usuario'];
		$publi=$datos['Publicacion'];
		echo "<form action='publicacion.php' method='POST'>
		<label for='usuario'>Usuario</label>
		<input name='usuario' type='text' value='{$usuario}' />
		<label for='publi'>Publicacion</label>
		<textarea name='publi'>{$publi}</textarea>
		<input name='id' type='hidden' value='{$id}' />
		<input type='submit' name='envio' value='Enviar' />
		</form>
		";
	}
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	return;
}

function vista($id){
	global $conn;
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	$sql = mysqli_query($conn, "SELECT ID, Usuario, Publicacion FROM publicacion WHERE ID = {$id}") or die("No se puede traer la vista");
	$datos = mysqli_fetch_array($sql);
	if($datos["ID"] != "")
	{
		$id=$datos['ID'];
		$usuario=$datos['Usuario'];
		$publi=$datos['Publicacion'];
		$publin = str_word_count($publi, 0);
		echo "<form action='publicacion.php' method='POST'>
		<label for='usuario'>Usuario</label>
		<input name='usuario' type='text' value='{$usuario}' />
		<label for='publi'>Publicacion</label>
		<textarea name='publi'>{$publi}</textarea> Total de palabras: {$publin} <br /><br />
		
		";
		$sql2 = mysqli_query($conn, "SELECT ID, Usuario, Comentario FROM comentarios WHERE IDPublicacion = {$id}") or die("no se puede traer comentarios");
		while($datos2 = mysqli_fetch_array($sql2))
		{
			$id=$datos2[0];
			$usuario=$datos2[1];
			$coment=$datos2[2];
			$publin = str_word_count($coment, 0);
			echo "<label for='usuario'>Usuario</label>
			<input name='usuario' type='text' value='{$usuario}' />
			<label for='coment'>Comentario</label>
			<textarea name='coment'>{$coment}</textarea> Total de palabras: {$publin}<br/>";
		}
		echo "
			<input name=id type='hidden' value='{$id}' />
			<input type='submit' onclick='window.history(-1)' value='Regresar' />
			</form>
		";
	}
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	return;
}

if(isset($_POST['envio'])&& $_POST['envio']=='Enviar') {
	$idi = mysqli_real_escape_string($conn, $_POST['id']);
	actualizar($idi);
} elseif (isset($_GET['editid'])&& is_numeric($_GET['editid'])) {
	$idi = mysqli_real_escape_string($conn, $_GET['editid']);
	editar($idi);
} elseif(isset($_GET['id'])&& is_numeric($_GET['id'])) {
	$idi = mysqli_real_escape_string($conn, $_GET['id']);
	vista($idi);
} else {
	listar();
}
?>
