<?php
require_once("config.inc.php");
require_once(SERVER_ROOT."/es-code/sessao.inc.php");
if(isset($_SESSION["S01"])){
	$file=$_REQUEST['f'];
	header('Content-Type: application/zip');
	header('Content-Disposition: attachment; filename="'.$_REQUEST['n'].'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($file));
	header("Pragma: no-cache");
	header("Expires: 0");
	readfile($file);
	unlink($file);
}