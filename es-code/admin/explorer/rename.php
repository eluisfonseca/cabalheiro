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
	echo "<div id=\"upload\">";
		
		if(strlen($_REQUEST['File']) > 0){
			if(file_exists(SERVER_ROOT . DATA_DIR . "/" . $_REQUEST['File'])){
				echo L_FILEEXISTS;
			}else{
				$rn		= copy(SERVER_ROOT . DATA_DIR . "/" . $_REQUEST['oFile'], SERVER_ROOT . DATA_DIR . "/" . $_REQUEST['File']);
				if($rn){
					unlink(SERVER_ROOT . DATA_DIR . "/" . $_REQUEST['oFile']);
					echo L_FILERENAMED;
				}else{
					echo L_INVALIDNAME;
				}
			}
			
			
		}else{
			echo L_INVALIDNAME;
		}
	echo "</div>";
	
	echo "<a href=\"explorer.php\" target=\"_self\"><div id=\"botao2\">" . L_CLOSE . "</div></a>";
	
echo "</div>";
echo "</body>";

?>
