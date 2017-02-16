<?PhP
require_once("../../../es-admin/config.inc.php");
require_once(SERVER_ROOT. "/es-code/idiomas/" . IDIOMA . ".inc.php");

echo "<script type=\"text/javascript\" src=\"../../js/tinymce/tiny_mce_popup.js\"></script>";
echo "<script type=\"text/javascript\" src=\"explorer.js\"></script>";
echo "<link href=\"explorer.css\" rel=\"stylesheet\" type=\"text/css\" />";
echo "<body>";
echo "<div id=\"explorer\">";
	if(isset($_REQUEST["c"])){
		$caminho	= str_replace("../", "", $_REQUEST["c"]);
	}else{
		$caminho	= DATA_DIR;
	}
	echo "<div id=\"caminho\">" . $caminho . "</div>";
	echo "<div id=\"upload\">" . L_ASKREMFILE . " ";
		echo "<form action=\"remove.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"upform\" target=\"_self\">";
		echo "<input name=\"oFile\" type=\"hidden\" size=\"40\" value=\"".$_REQUEST['File']."\">";
		echo "</form>";
		echo $_REQUEST['File'];
	echo "</div>";
	
	echo "<a href=\"javascript:enviar();\" target=\"_self\"><div id=\"botao1\">" . L_YES . "</div></a>";
	echo "<a href=\"explorer.php\" target=\"_self\"><div id=\"botao2\">" . L_NO . "</div></a>";
	
echo "</div>";
echo "</body>";

?>
