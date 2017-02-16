<?PhP
require_once("../../../es-admin/config.inc.php"); /*SITE_ROOT . '/es-code/*/
require_once(SERVER_ROOT. "/es-code/idiomas/" . IDIOMA . ".inc.php");

echo "<script type=\"text/javascript\" src=\"../../js/tinymce/tiny_mce_popup.js\"></script>";
echo "<script type=\"text/javascript\" src=\"explorer.js\"></script>";
echo "<link href=\"explorer.css\" rel=\"stylesheet\" type=\"text/css\" />";
echo "<body>";

echo "<form action=\"change.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"rnform\" target=\"_self\">";
echo "<input name=\"File\" type=\"hidden\" size=\"40\">";
echo "</form>";

echo "<form action=\"ask.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"delform\" target=\"_self\">";
echo "<input name=\"File\" type=\"hidden\" size=\"40\">";
echo "</form>";


echo "<div id=\"explorer\">";
	if(!file_exists(SERVER_ROOT . DATA_DIR)){
		mkdir(SERVER_ROOT . DATA_DIR, 0777);
	}
	if(isset($_REQUEST["c"])){
		$caminho	= str_replace("../", "", $_REQUEST["c"]);
	}else{
		$caminho	= DATA_DIR;
	}
	echo "<div id=\"caminho\">" . $caminho . "</div>";
	
	echo "<div id=\"ops\">";
		echo "<a href=\"choose.php\" target=\"_self\"><div class=\"botao\">" . L_UPLOAD . "</div></a>";
		echo "<a href=\"javascript:rename();\" target=\"_self\"><div class=\"botao\">" . L_RENAME . "</div></a>";
		echo "<a href=\"javascript:remove();\" target=\"_self\"><div class=\"botao\">" . L_DELETE . "</div></a>";
	echo "</div>";
	
	echo "<div id=\"pasta\"><div id=\"pasta1\">";
	$conteudo	= scandir(SERVER_ROOT . DATA_DIR, SCANDIR_SORT_ASCENDING);

	foreach($conteudo as $item){
		if(is_file(SERVER_ROOT . DATA_DIR . "/" . $item)){
			echo "<label class=\"ficheiro\" onclick=\"javascript:CaixaExplorador.Set('" .SITE_ROOT. DATA_DIR . "/" . $item . "', '" . $item . "');\">";
			echo "<input type=\"radio\" name=\"Ficheiros\" value=\"" . DATA_DIR . "/" . $item . "\" />";
			echo " " . $item;
			echo "</label><br />";
		}
	}
	
	echo "</div></div>";
	
	echo "<div onClick=\"javascript:CaixaExplorador.Select();\" id=\"botao1\">" . L_SELECT . "</div>";
	echo "<div onClick=\"javascript:CaixaExplorador.Close();\" id=\"botao2\">" . L_CLOSE . "</div>";
	
echo "</div>";
echo "</body>";

?>
