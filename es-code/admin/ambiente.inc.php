<?PhP

$bd	= new acbd();

if((isset($_SESSION["S01"]))&&(reqvlr('p'))){
	$esPage	= reqvlr('p');
}elseif(isset($_SESSION["S01"])){
	$esPage	= 'index';
}else{
	$esPage	= 'login';
}

$esMenu		= NULL;
$esPaginas	= NULL;
$esID		= NULL;
$esTitle	= NULL;
$esLink		= NULL;
$esTarget	= NULL;
$esContent	= NULL;

//Hooks
$esHooks					= array();
$esHooks['admin_head']		= array();
$esHooks['admin_content']	= array();

$esJSInit					= array();
$esJSResize					= array();

//Menus
$esMenu						= array();
$esMenu[0]					= array();

plugins();

if(file_exists(SERVER_ROOT."/es-admin/temas/" . config(7) . "/functions.php")){
	include(SERVER_ROOT."/es-admin/temas/" . config(7) . "/functions.php");
}

header("Content-Type: text/html; charset=" . config(4));

?>
