<?PhP
function get_template($template){
	global $bd;
	include(SERVER_ROOT."/es-admin/temas/" . config(7) . "/" . $template . ".php");
}

?>
