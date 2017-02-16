<?PhP
function link_format(){
	global $bd;
	global $esID;
	$string	= str_replace("{%ID}", $esID, config(6));
	return $string;
}
?>
