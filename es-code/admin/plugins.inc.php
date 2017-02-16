<?PhP
function plugins(){
	global $bd;
	$plugins	= $bd->query("SELECT Pasta FROM ".BD_PREFIXO."Plugins WHERE Activo = '1'");
	while($plugin = $bd->dados($plugins)){
		if(is_file(SERVER_ROOT."/es-code/plugins/".$plugin[0]."/admin.php")){
			include_once(SERVER_ROOT."/es-code/plugins/".$plugin[0]."/admin.php");
		}
	}
}

function list_plugins(){
	global $bd;
	$plugins	= $bd->query("SELECT Descricao, Pasta FROM ".BD_PREFIXO."Plugins WHERE Activo=1");
	while($row = $bd->dados($plugins)){
		echo '<li><a href="?c='.$row[1].'">'.$row[0].'</a></li>';
	}
}

?>