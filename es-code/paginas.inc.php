<?PhP
function paginas(){
	global $bd;
	global $esPaginas;
	if(reqvlr('page_id')){
		$filtro	= " AND ID = '" . reqvlr('page_id') . "'";
	}else{
		$filtro	= "";
	}
	$esPaginas	= $bd->query("SELECT ID, Descricao, Corpo FROM " . BD_PREFIXO . "Paginas WHERE Activo = '1'" . $filtro . " ORDER BY Pos ASC");
	if($bd->tem_linhas($esPaginas)){
		return true;
	}else{
		return false;
	}
}
?>