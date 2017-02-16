<?PhP
require_once("config.inc.php");
//Codigo
require_once(SERVER_ROOT."/es-code/sessao.inc.php");
//Classes
require_once(SERVER_ROOT."/es-code/classes/acbd.inc.php");
require_once(SERVER_ROOT."/es-code/classes/fpdf/fpdf.php");
//Bibliotecas
require_once(SERVER_ROOT."/es-code/config.inc.php");
require_once(SERVER_ROOT."/es-code/reqvlr.inc.php");
require_once(SERVER_ROOT."/es-code/charset.inc.php");
require_once(SERVER_ROOT."/es-code/add_hook.inc.php");
require_once(SERVER_ROOT."/es-code/run_hooks.inc.php");
require_once(SERVER_ROOT."/es-code/addJSinit.inc.php");
require_once(SERVER_ROOT."/es-code/addJSresize.inc.php");
//Bibliotecas Administração
require_once(SERVER_ROOT."/es-code/admin/login.inc.php");
require_once(SERVER_ROOT."/es-code/admin/get_header.inc.php");
require_once(SERVER_ROOT."/es-code/admin/get_footer.inc.php");
require_once(SERVER_ROOT."/es-code/admin/plugins.inc.php");
require_once(SERVER_ROOT."/es-code/admin/title.inc.php");
require_once(SERVER_ROOT."/es-code/admin/head.inc.php");
require_once(SERVER_ROOT."/es-code/admin/content.inc.php");
require_once(SERVER_ROOT."/es-code/admin/explorador.php");
//Bibliotecas de Gestão
require_once(SERVER_ROOT."/es-code/admin/menus.inc.php");
require_once(SERVER_ROOT."/es-code/admin/paginas.inc.php");
//Preparar ambiente Administração
require_once(SERVER_ROOT."/es-code/admin/ambiente.inc.php");
require_once(SERVER_ROOT."/es-admin/temas/admin/functions.php");
//Definição do Idioma
require_once(SERVER_ROOT."/es-code/idiomas/". IDIOMA .".inc.php");
//Execução de Código

if((isset($_SESSION["S01"]))&&(reqvlr('c'))){
	add_hook('admin_content', reqvlr('c'));
}else{
	add_hook('admin_content', 'main');
}

if(reqvlr("out")){
	session_destroy();
	header("location: index.php");
}elseif(reqvlr('h')){
	$hookRun	= reqvlr('h');
	$hookRun();
}else{
	include(SERVER_ROOT."/es-admin/temas/" . config(7) . "/" . $esPage . ".php");
}
?>