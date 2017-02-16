<?PhP
function get_plugin_template($plugin, $template){
	global $bd;
	include(SERVER_ROOT."/es-code/plugins/" . $plugin . "/" . $template . ".php");
}
?>
