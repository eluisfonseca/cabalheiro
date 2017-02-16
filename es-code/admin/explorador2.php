<?PhP

if(!function_exists('explorador')){
	function explorador(){ 
	echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
		echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
		echo "<body>";
	echo "<form action=\"?c=change\" method=\"post\" enctype=\"multipart/form-data\" name=\"rnform\" target=\"_self\">";
	echo "<input name=\"File\" type=\"hidden\" size=\"40\">";
	echo "</form>";

	echo "<form action=\"?h=ask\" method=\"post\" enctype=\"multipart/form-data\" name=\"delform\" target=\"_self\">";
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
		echo "<a href=\"?h=choose\" target=\"_self\"><div class=\"botao\">" . L_UPLOAD . "</div></a>";
		echo "<a href=\"javascript:ExpRename();\" target=\"_self\"><div class=\"botao\">" . L_RENAME . "</div></a>";
		echo "<a href=\"javascript:ExpRemove();\" target=\"_self\"><div class=\"botao\">" . L_DELETE . "</div></a>";
	echo "</div>";
	
	echo "<div id=\"pasta\"><div id=\"pasta1\">";
	$conteudo	= scandir(SERVER_ROOT . DATA_DIR);
	sort($conteudo, SORT_STRING);
	foreach($conteudo as $item){
		if(is_file(SERVER_ROOT . DATA_DIR . "/" . $item)){
			echo "<label class=\"ficheiro\" onclick=\"javascript:ExpChoose('" .SITE_ROOT. DATA_DIR . "/" . $item . "', '" . $item . "');\">";
			echo "<input type=\"radio\" name=\"Ficheiros\" value=\"" . DATA_DIR . "/" . $item . "\" />";
			echo " " . $item;
			echo "</label><br />";
		}
	}
	
	echo "</div></div>";
	
	echo "<div onClick=\"javascript:ExpSet();\" id=\"botao1\">" . L_SELECT . "</div>";
	echo "<div onClick=\"javascript:window.close();\" id=\"botao2\">" . L_CLOSE . "</div>";
	
	echo "</div>";
	echo "</body>";
	}
}

if(!function_exists('change')){
	function change(){ 
	echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
	echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
	echo "<body>";
	echo "<div id=\"explorer\">";
	
		if(isset($_REQUEST["c"])){
			$caminho	= str_replace("../", "", $_REQUEST["c"]);
		}else{
			$caminho	= DATA_DIR;
		}
		echo "<div id=\"caminho\">" . $caminho . "</div>";
		echo "<div id=\"upload\">" . L_RENAMEFILE . " ";
			echo "<form action=\"?h=rename\" method=\"post\" enctype=\"multipart/form-data\" name=\"upform\" target=\"_self\">";
			echo "<input name=\"oFile\" type=\"hidden\" size=\"40\" value=\"".$_REQUEST['File']."\">";
			echo "<input name=\"File\" type=\"text\" size=\"40\" value=\"".$_REQUEST['File']."\">";
			echo "</form>";
		echo "</div>";
	
		echo "<a href=\"javascript:ExpEnviar();\" target=\"_self\"><div id=\"botao1\">" . L_RENAME . "</div></a>";
		echo "<a href=\"index.php?h=explorador\" target=\"_self\"><div id=\"botao2\">" . L_BACK . "</div></a>";
	
	echo "</div>";
	echo "</body>";
	}
}

if(!function_exists('ask')){
	function ask(){ 
		echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
		echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
		echo "<body>";
		echo "<div id=\"explorer\">";
		if(isset($_REQUEST["c"])){
			$caminho	= str_replace("../", "", $_REQUEST["c"]);
		}else{
			$caminho	= DATA_DIR;
		}
		echo "<div id=\"caminho\">" . $caminho . "</div>";
		echo "<div id=\"upload\">" . L_ASKREMFILE . " ";
		echo "<form action=\"?h=remove\" method=\"post\" enctype=\"multipart/form-data\" name=\"upform\" target=\"_self\">";
		echo "<input name=\"oFile\" type=\"hidden\" size=\"40\" value=\"".$_REQUEST['File']."\">";
		echo "</form>";
		echo $_REQUEST['File'];
		echo "</div>";
		echo "<a href=\"javascript:ExpEnviar();\" target=\"_self\"><div id=\"botao1\">" . L_YES . "</div></a>";
		echo "<a href=\"index.php?h=explorador\" target=\"_self\"><div id=\"botao2\">" . L_NO . "</div></a>";
	
	echo "</div>";
	echo "</body>";
	}
}

if(!function_exists('choose')){
	function choose(){ 
		echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
		echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
		echo "<body>";
		echo "<div id=\"explorer\">";
		if(isset($_REQUEST["c"])){
			$caminho	= str_replace("../", "", $_REQUEST["c"]);
		}else{
			$caminho	= DATA_DIR;
		}
		echo "<div id=\"caminho\">" . $caminho . "</div>";
		echo "<div id=\"upload\">" . L_SELECTFILE . " ";
		echo "<form action=\"?h=upload\" method=\"post\" enctype=\"multipart/form-data\" name=\"upform\" target=\"_self\">";
		echo "<input name=\"Upload\" type=\"file\" size=\"40\">";
		echo "</form>";
		echo "</div>";
	
		echo "<a href=\"javascript:ExpEnviar();\" target=\"_self\"><div id=\"botao1\">" . L_UPLOAD . "</div></a>";
		echo "<a href=\"index.php?h=explorador\" target=\"_self\"><div id=\"botao2\">" . L_BACK . "</div></a>";
	
		echo "</div>";
		echo "</body>";
	}
}

if(!function_exists('remove')){
	function remove(){ 
		echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
		echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
		echo "<body>";
		echo "<div id=\"explorer\">";
		if(isset($_REQUEST["c"])){
			$caminho	= str_replace("../", "", $_REQUEST["c"]);
		}else{
			$caminho	= DATA_DIR;
		}
		echo "<div id=\"caminho\">" . $caminho . "</div>";
		echo "<div id=\"upload\">";
		
		if(strlen($_REQUEST['oFile']) > 0){
			if(file_exists(SERVER_ROOT . DATA_DIR . "/" . $_REQUEST['oFile'])){
				$rm		= unlink(SERVER_ROOT . DATA_DIR . "/" . $_REQUEST['oFile']);
				if($rm){
					echo L_FILEREMOVED;
				}else{
					echo L_INVALIDNAME;
				}
			}else{
				echo L_INVALIDNAME;
			}
		}else{
			echo L_INVALIDNAME;
		}
		echo "</div>";
	
		echo "<a href=\"index.php?h=explorador\" target=\"_self\"><div id=\"botao2\">" . L_CLOSE . "</div></a>";
	
		echo "</div>";
		echo "</body>";
	}
}


if(!function_exists('rename')){
	function rename(){ 
		echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
		echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
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
	
		echo "<a href=\"index.php?h=explorador\" target=\"_self\"><div id=\"botao2\">" . L_CLOSE . "</div></a>";
	
		echo "</div>";
		echo "</body>";
	}
}

if(!function_exists('upload')){
	function upload(){ 
		echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
		echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
		echo "<body>";
		echo "<div id=\"explorer\">";
		if(isset($_REQUEST["c"])){
			$caminho	= str_replace("../", "", $_REQUEST["c"]);
		}else{
			$caminho	= DATA_DIR;
		}
		echo "<div id=\"caminho\">" . $caminho . "</div>";
		echo "<div id=\"upload\">";
		
		if($_FILES['Upload']['size'] > 0){
			if(file_exists(SERVER_ROOT . DATA_DIR . "/" . $_FILES['Upload']['name'])){
				echo L_FILEEXISTS;
			}else{
				$cp		= copy($_FILES['Upload']['tmp_name'], SERVER_ROOT . DATA_DIR . "/" . $_FILES['Upload']['name']);
				unlink($_FILES['Upload']['tmp_name']);
				if($cp){
					echo L_FILEUPLOADED;
				}else{
					echo L_FILENOTUPLOADED;
				}
			}
		}else{
			echo L_INVALIDFILE;
		}
		echo "</div>";
	
		echo "<a href=\"index.php?h=explorador\" target=\"_self\"><div id=\"botao2\">" . L_CLOSE . "</div></a>";
	
	echo "</div>";
		echo "</body>";
	}
}
?>
