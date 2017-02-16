
<?PhP
require_once("es-admin/config.inc.php");
//Codigo
require_once(SERVER_ROOT."/es-code/sessao.inc.php");
//Classes
require_once(SERVER_ROOT."/es-code/classes/acbd.inc.php");
//Bibliotecas
require_once(SERVER_ROOT."/es-code/config.inc.php");
require_once(SERVER_ROOT."/es-code/reqvlr.inc.php");
require_once(SERVER_ROOT."/es-code/charset.inc.php");
require_once(SERVER_ROOT."/es-code/get_header.inc.php");
require_once(SERVER_ROOT."/es-code/get_footer.inc.php");
require_once(SERVER_ROOT."/es-code/get_menu.inc.php");
require_once(SERVER_ROOT."/es-code/plugins.inc.php");
require_once(SERVER_ROOT."/es-code/head.inc.php");
require_once(SERVER_ROOT."/es-code/title.inc.php");
require_once(SERVER_ROOT."/es-code/menu.inc.php");
require_once(SERVER_ROOT."/es-code/item.inc.php");
require_once(SERVER_ROOT."/es-code/paginas.inc.php");
require_once(SERVER_ROOT."/es-code/pagina.inc.php");
require_once(SERVER_ROOT."/es-code/get_template.inc.php");
require_once(SERVER_ROOT."/es-code/get_plugin_template.inc.php");
require_once(SERVER_ROOT."/es-code/valores.inc.php");
require_once(SERVER_ROOT."/es-code/link_format.inc.php");
require_once(SERVER_ROOT."/es-code/add_hook.inc.php");
require_once(SERVER_ROOT."/es-code/run_hooks.inc.php");
require_once(SERVER_ROOT."/es-code/addJSinit.inc.php");
require_once(SERVER_ROOT."/es-code/addJSresize.inc.php");
//Preparar ambiente
require_once(SERVER_ROOT."/es-code/ambiente.inc.php");
//Execução de Código
if(reqvlr('h')){
	$hookRun	= reqvlr('h');
	$hookRun();
}else{
	include(SERVER_ROOT."/es-temas/" . config(1) . "/" . $esPage . ".php");
}
?>