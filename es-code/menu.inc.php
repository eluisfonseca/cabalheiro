<?PhP
function menu($menu = 0){
	global $bd;
	global $esMenu;
	$esMenu	= $bd->query("SELECT ID, Descricao, Link, Target, isParent FROM " . BD_PREFIXO . "Menu WHERE Activo = '1' AND Menu = '".$menu."' AND Parent='0' ORDER BY Pos ASC");
	if($bd->tem_linhas($esMenu)){
		return true;
	}else{
		return false;
	}
}
?>