<?PhP
if(!function_exists('paginas')){
	function paginas(){
		global $bd;
		
		echo '<h1>'.I_PAGES.'</h1>';
		
		echo '<table align="center" border="0" cellpadding="2" cellspacing="0">';
		echo '<tr>',
			'<th>'.I_DESCRIPTION.'</th>',
			'<th>'.I_PUBLISHED.'</th>',
			'<th>'.I_POSITION.'</th>',
			'<th>'.I_ACTIONS.'</th>',
		'</tr>';
		
		$menus	= $bd->query("SELECT ID, Descricao, Activo, Pos FROM ".BD_PREFIXO."Paginas ORDER BY Pos ASC");
		while($row = $bd->dados($menus)){
			echo '<tr>',
				'<td>'.$row[1].'</td>';
				if($row[2] == 1){
					echo '<td><a href="?h=swtpageState&page_id='.$row[0].'">'.I_REMOVEPUB.'</a></td>';
				}else{
					echo '<td><a href="?h=swtpageState&page_id='.$row[0].'">'.I_PUBLICA.'</a></td>';
				}
				echo '<td>'.$row[3].'</td>';
				echo '<td><a href="?c=pageeditor&page_id='.$row[0].'">'.I_EDIT.'</a> | <a href="?h=pageDelete&page_id='.$row[0].'">'.I_DELETE.'</a></td>';
			echo '</tr>';
		}
		echo '<tr><td colspan="4" style="text-align: right;"><a href="?c=pagecriador">'.I_ADD.'</a></td></tr>';
		echo '</table>';
	}
}

if(!function_exists('pageeditor')){
	function pageeditor() {
		global $bd;
		
		if (isset($_GET['page_id'])) {
			$pgID = $_GET['page_id'];
			$slDados	= $bd->query("SELECT ID, Descricao, Corpo, Activo, Pos, PaginaPrincipal FROM ".BD_PREFIXO."Paginas WHERE ID =".$pgID);
			
			if($bd->tem_linhas($slDados)){
				echo '<h1>'.I_PAGES.' - '.$pgID.'</h1>';
				$row = $bd->dados($slDados);
				$processedTxt = str_replace(array("\n","\r"), "", $row[2]);
				$processedTxt = str_replace(array("<br>"), "<br />", $processedTxt);
				//$processedTxt = str_replace(array("\""), "\'", $processedTxt);
				$printTxt = str_replace(array("\""), "'", $processedTxt);
				$processedTxt = preg_replace("/(&lt;+)([a-zA-Z0-9]+)(&gt;+)/", "$1 $2$3", $processedTxt);
				echo '<h2>'.$row[1].'</h2>';
				echo '<form method="post">
				Titulo: <input type="text" id="titulo" name="titulo" size="100" value="'.$row[1].'"><br>
				Posição: <input type="text" id="position" name="position" size="5" value="'.$row[4].'"><br>';
				if($row[3]){
					echo'Activa: <input type="radio" name="activa" value="1" checked="checked" id="activa">Sim
					<input type="radio" name="activa" value="0" id="activa">Não<br>';
				}
				else {
					echo'Activa: <input type="radio" name="activa" value="1" id="activa">Sim
					<input type="radio" name="activa" value="0" checked="checked" id="activa">Não <br>';
				}
				if($row[5]){
					echo'Homepage: <input type="radio" name="home" value="1" checked="checked" id="home">Sim
					<input type="radio" name="home" value="0" id="home">Não';
				}
				else {
					echo'Homepage: <input type="radio" name="home" value="1">Sim
					<input type="radio" name="home" value="0" checked="checked">Não';
				}
				echo '<div style="width:60%; margin:10px auto;"><textarea id="conteudo" name="conteudo" rows="4" cols="100" class="mceEditor">'.$processedTxt.'</textarea>
				
				<input type="button" name="gravar" value="'.I_SAVE.'" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=pageSave&page_id='.$row[0].'\',null);"/>
				<button type="button" id="cancelar">'.I_RETURN.'</button> 
				
				</div>';
				echo '</form>';
				echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
    					if(checkEditorChanges("conteudo", "'.$printTxt.'")||checkChanges("titulo")||$(\'input[name=activa]:checked\').val()!='.$row[3].'||$(\'input[name=home]:checked\').val()!='.$row[5].'){
							var a = confirm("Tem a certeza que deseja voltar?\nQualquer modificação não guardada será perdida.");
							if (a) {
								window.location.replace("?c=paginas");
							}
							else {
    						// Do nothing!
							}
						}
						else { 
							window.location.replace("?c=paginas");
						}
					}, false);
			</script>';
			}
		}
	}
}


if(!function_exists('pagecriador')){
	function pagecriador(){
		global $bd;
		echo '<h1>'.I_NEWPAGE.'</h1>';
		
		// echo '<form method="post" action="index.php?h=saves"> gravar(form)
		echo '<form method="post" action="">
				Titulo: <input type="text" id="titulo" name="titulo" size="100" "><br>
				Posição: <input type="text" id="position" name="position" size="5"><br>
				';
		echo'Activa: <input type="radio" name="activa" value="1" id="activa1" checked="checked">Sim
					<input type="radio" name="activa" value="0" id="activa0">Não<br>';
		echo'Homepage: <input type="radio" name="home" value="1" id="home1">Sim
					<input type="radio" name="home" value="0" checked="checked" id="home0">Não';
		echo '<h3> Conteúdo </h3>';
		echo '<div style="width:60%; margin:10px auto;">
			<textarea id="conteudo" name="conteudo" rows="4" cols="100" class="mceEditor"></textarea>';
			echo '<input type="button" value="'.I_SAVE.'" name="gravar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=pageSave\', \'index.php?c=pageeditor&page_id=\');" />';
		echo '<button type="button" id="cancelar">'.I_RETURN.'</button> 
			</div>
			</form>';
			//<input type="submit" name="gravar" value="Gravar" class="botao" onclick="javascript:gravar(this.form);"/>
		echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
						if (checkEditorChanges("conteudo")||checkChanges("titulo")||$(\'input[name=activa]:checked\').val()!=1||$(\'input[name=home]:checked\').val()!=0){
							var a = confirm("Tem a certeza que deseja voltar?\nQualquer modificação não guardada será perdida.");
							if (a) {
								window.location.replace("?c=paginas");
							}
							else {
    						// Do nothing!
							}
						}
						else { window.location.replace("?c=paginas");}
					}, false);
			</script>';
	}
}

if(!function_exists('pageDelete')){
	function pageDelete(){
		global $bd;
		if(reqvlr('page_id')) {
			
			$slDados = $bd->query("DELETE FROM ".BD_PREFIXO."Paginas WHERE ID =".reqvlr('page_id'));
			$link = str_replace("{%ID}",reqvlr('page_id'),config(6));
			$upMenu = $bd->query("DELETE FROM ".BD_PREFIXO."Menu WHERE Link = \"".$link."\"");
			if($slDados && $upMenu){
				$_SESSION["ERR_A"]	= 1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
				header("location: ?c=paginas");
			}else {
				$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: ?c=paginas");
			}
		}
	}
}

if(!function_exists('swtpageState')){
	function swtpageState(){
		global $bd;
		if(reqvlr('page_id')) {
			$slDados	= $bd->query("SELECT Activo FROM ".BD_PREFIXO."Paginas WHERE ID =".reqvlr('page_id'));
			if($bd->tem_linhas($slDados)){
				$row = $bd->dados($slDados);
				if($row[0]==0){
					$chState = $bd->query("UPDATE ".BD_PREFIXO."Paginas SET Activo = 1 WHERE ID =".reqvlr('page_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=paginas");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=paginas");
					}
				}
				else {
					/*echo '<script type="text/javascript">alert("noticia já publicada.");</script>';*/
					$chState = $bd->query("UPDATE ".BD_PREFIXO."Paginas SET Activo = 0 WHERE ID =".reqvlr('page_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=paginas");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=paginas");
					}
				}
			}
			
		}
	}
}


if(!function_exists('pageSave')){
	function pageSave() {
		global $bd;
		$titulo=reqvlr('titulo');
		$active=reqvlr('activa');
		$home=reqvlr('home');
		$conteudo=reqvlr('conteudo');
		$position=reqvlr('position');
		$saveQ;
		if(reqvlr('page_id')) {
			$saveQ = $bd->query("UPDATE ".BD_PREFIXO."Paginas SET Descricao='".$titulo."', Corpo ='".$conteudo."', PaginaPrincipal =".$home.", Activo =".$active.", Pos =".$position." WHERE ID =".reqvlr('page_id'));
			
			if($saveQ) {
				echo 'a';
			}else {
				echo '0';
			}
				//header("location: ?c=editor&news_id=".reqvlr('news_id'));
		}
		else {
			$saveQ = $bd->query("INSERT INTO ".BD_PREFIXO."Paginas (Descricao, Corpo, PaginaPrincipal, Activo, Pos) VALUES( '".$titulo."', '".$conteudo."', ".$home.", ".$active.", ".$position.")");
			
			if($saveQ) {
				$last = $bd->ultimo_id();
				$link = str_replace("{%ID}",$bd->ultimo_id(),config(6));
				$act;
				if ($active=reqvlr('activa')) {
					$act=1;
				}
				else {
					$act=0;
				}
				
				$addMenu = $bd->query("INSERT INTO ".BD_PREFIXO."Menu (Descricao, Link, Activo) VALUES ( \"".$titulo."\", \"".$link."\", ".$act.")");
				if($addMenu) {
					echo $last;
				}
				else {
					echo '0';
				}
			}else {
				echo '0';
			}
			
		}
	}
}
?>
