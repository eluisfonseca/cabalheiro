<?PhP
function get_template($template){
	global $bd;
	include(SERVER_ROOT."/es-temas/" . config(1) . "/" . $template . ".php");
}
?>
