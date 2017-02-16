<?PhP
function reqvlr($campo){
	global $bd;
	if(isset($_REQUEST[$campo])){
		return $bd->escape_string(rawurldecode($_REQUEST[$campo]));
	}else{
		return FALSE;
	}
}
?>
