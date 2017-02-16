<?PhP

$bd	= new acbd();

if(reqvlr('p')){
	$esPage	= reqvlr('p');
}else{
	$esPage	= 'index';
}

$esMenu		= NULL;
$esPaginas	= NULL;
$esID		= NULL;
$esTitle	= NULL;
$esLink		= NULL;
$esTarget	= NULL;
$esContent	= NULL;
$isParent	= NULL;

//Hooks
$esHooks			= array();
$esHooks['head']	= array();
$esHooks['footer']	= array();

$esJSInit			= array();
$esJSResize			= array();


plugins();

if(file_exists(SERVER_ROOT."/es-temas/" . config(1) . "/functions.php")){
	include(SERVER_ROOT."/es-temas/" . config(1) . "/functions.php");
}

header("Content-Type: text/html; charset=" . config(4));
?>
