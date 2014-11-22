<?php
include("config.php");
function listar()
{
	global $conn;
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p><table border=1><tr><td>ID</td><td>Usuario</td><td>Comentario</td><td>IDPublicacion</td></tr>';
	$sql = mysql_query("SELECT ID, Usuario, Comentario, IDPublicacion FROM comentarios",$conn);
	while($datos = mysql_fetch_array($sql))
	{
		$id=$datos[0];
		$usuario=$datos[1];
		$coment=$datos[2];
		$idpubli=$datos[3];
		echo "<tr><td><a href='comentario.php?editid=$id'>$id</a></td><td>$usuario</td><td>$coment</td><td>$idpubli</td></tr>";
	}
	echo '</table><p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	return;
}

function filtrar($id)
{
	global $conn;
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p><table border=1><tr><td>ID</td><td>Usuario</td><td>Comentario</td><td>IDPublicacion</td></tr>';
	$sql = mysql_query("SELECT ID, Usuario, Comentario, IDPublicacion FROM comentarios WHERE IDPublicacion = $id",$conn);
	while($datos = mysql_fetch_array($sql))
	{
		$id=$datos[0];
		$usuario=$datos[1];
		$coment=$datos[2];
		$idpubli=$datos[3];
		echo "<tr><td><a href='comentario.php?editid=$id'>$id</a></td><td>$usuario</td><td>$coment</td><td>$idpubli</td></tr>";
	}
	echo '</table><p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	return;
}

function actualizar($id)
{
	global $conn;
	$usuario=$_POST['usuario'];
	$publi=$_POST['coment'];
	$sql = mysql_query("UPDATE comentarios SET Usuario = '$usuario', Comentario = '$publi' WHERE ID = $id",$conn);
	echo "<p> Se actualizo la comentario #$id</p>";
	editar($id);
}

function editar($id)
{
	global $conn;
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	$sql = mysql_query("SELECT ID, Usuario, Comentario, IDPublicacion FROM comentarios WHERE ID = $id",$conn);
	if($datos = mysql_fetch_array($sql))
	{
		$id=$datos[0];
		$usuario=$datos[1];
		$coment=$datos[2];
		$idpubli=$datos[3];
		echo "<form action='comentario.php' method='POST'>
		<label for=usuario>Usuario</label>
		<input name=usuario type='text' value='$usuario' />
		<label for=coment>Comentario</label>
		<textarea name=coment>$coment</textarea>
		<input name=id type='hidden' value='$id' />
		<input name=idpubli type='hidden' value='$idpubli' />
		<input type='submit' name=envio value='Enviar' />
		</form>
		";
	}
	echo '<p><a href="publicacion.php?">Regresar</a> | <a href="index.php?">Ir a Inicio</a></p>';
	return;
}
if(isset($_POST['envio'])&& $_POST['envio']=='Enviar') actualizar($_POST['id']);
elseif(isset($_GET['id'])&& is_numeric($_GET['id'])) filtrar($_GET['id']);
elseif(isset($_GET['editid'])&& is_numeric($_GET['editid'])) editar($_GET['editid']);
else listar();
?>
