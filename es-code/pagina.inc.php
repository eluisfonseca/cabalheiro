<?PhP
function pagina(){
	global $bd;
	global $esPaginas;
	global $esID;
	global $esTitle;
	global $esContent;
	if($Row = $bd->dados($esPaginas)){
		$esID		= $Row[0];
		$esTitle	= $Row[1];
		$esContent	= $Row[2];
		return TRUE;
	}else{
		return FALSE;
	}
}
?>