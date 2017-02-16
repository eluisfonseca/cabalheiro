<?PhP
function plugins(){
	global $bd;
	$plugins	= $bd->query("SELECT Pasta FROM ".BD_PREFIXO."Plugins WHERE Activo = '1'");
	while($plugin = $bd->dados($plugins)){
		include_once(SERVER_ROOT."/es-code/plugins/".$plugin[0]."/".$plugin[0].".php");
	}
}
?>