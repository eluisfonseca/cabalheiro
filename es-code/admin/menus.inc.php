<?PhP
if(!function_exists('menus')){
	function menus(){
		global $bd;
		
		echo '<h1>'.I_MENU.'</h1>';
		
		echo '<table align="center" border="0" cellpadding="2" cellspacing="0">';
		echo '<tr>',
			'<th>'.I_DESCRIPTION.'</th>',
			'<th>'.I_LINK.'</th>',
			'<th>'.I_TARGET.'</th>',
			'<th>'.I_MENU.'</th>',
			'<th>'.I_POSITION.'</th>',
			'<th>'.I_PUBLISHED.'</th>',
			'<th>'.I_ACTIONS.'</th>',
		'</tr>';
		
		$menus	= $bd->query("SELECT ID, Descricao, Link, Target, Activo, Menu, Pos FROM ".BD_PREFIXO."Menu ORDER BY Menu, Pos ASC");
		while($row = $bd->dados($menus)){
			echo '<tr>',
				'<td>'.$row[1].'</td>',
				'<td>'.$row[2].'</td>';
				if($row[3] == 1){
					echo '<td><a href="?h=swtmenuTarget&menu_id='.$row[0].'">'.I_SELF.'</a></td>';
				}else{
					echo '<td><a href="?h=swtmenuTarget&menu_id='.$row[0].'">'.I_NEW.'</a></td>';
				}
				echo '<td>'.$row[5].'</td>';
				echo '<td>'.$row[6].'</td>';
				if($row[4]){
					echo '<td><a href="?h=swtmenuState&menu_id='.$row[0].'">'.I_REMOVEPUB.'</a></td>';
				}else{
					echo '<td><a href="?h=swtmenuState&menu_id='.$row[0].'">'.I_PUBLICA.'</a></td>';
				}
				echo '<td><a href="?c=menueditor&menu_id='.$row[0].'">'.I_EDIT.'</a> | <a href="?h=menuDelete&menu_id='.$row[0].'">'.I_DELETE.'</a></td>';
			echo '</tr>';
		}
		echo '<tr><td colspan="7" style="text-align: right;"><a href="?c=criarmenu">'.I_ADD.'</a></td></tr>';
		echo '</table>';
	}
}

if(!function_exists('menuDelete')){
	function menuDelete(){
		global $bd;
		if(reqvlr('menu_id')) {
			
			$slDados = $bd->query("DELETE FROM ".BD_PREFIXO."Menu WHERE ID =".reqvlr('menu_id'));
			if($slDados){
				$_SESSION["ERR_A"]	= 1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
				header("location: ?c=menus");
			}else {
				$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: ?c=menus");
			}
		}
	}
}

if(!function_exists('swtmenuState')){
	function swtmenuState(){
		global $bd;
		if(reqvlr('menu_id')) {
			$slDados	= $bd->query("SELECT Activo FROM ".BD_PREFIXO."Menu WHERE ID =".reqvlr('menu_id'));
			if($bd->tem_linhas($slDados)){
				$row = $bd->dados($slDados);
				if($row[0]==0){
					$chState = $bd->query("UPDATE ".BD_PREFIXO."Menu SET Activo = 1 WHERE ID =".reqvlr('menu_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=menus");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=menus");
					}
				}
				else {
					/*echo '<script type="text/javascript">alert("noticia já publicada.");</script>';*/
					$chState = $bd->query("UPDATE ".BD_PREFIXO."Menu SET Activo = 0 WHERE ID =".reqvlr('menu_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=menus");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=menus");
					}
				}
			}
			
		}
	}
}

if(!function_exists('swtmenuTarget')){
	function swtmenuTarget(){
		global $bd;
		if(reqvlr('menu_id')) {
			$slDados	= $bd->query("SELECT Target FROM ".BD_PREFIXO."Menu WHERE ID =".reqvlr('menu_id'));
			if($bd->tem_linhas($slDados)){
				$row = $bd->dados($slDados);
				if($row[0]==0){
					$chState = $bd->query("UPDATE ".BD_PREFIXO."Menu SET Target = 1 WHERE ID =".reqvlr('menu_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=menus");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=menus");
					}
				}
				else {
					/*echo '<script type="text/javascript">alert("noticia já publicada.");</script>';*/
					$chState = $bd->query("UPDATE ".BD_PREFIXO."Menu SET Target = 0 WHERE ID =".reqvlr('menu_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=menus");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=menus");
					}
				}
			}
			
		}
	}
}


if(!function_exists('criarMenu')){
	function criarMenu(){
		global $bd;
		echo '<h1>'.I_NEWMENU.'</h1>';
		
		// echo '<form method="post" action="index.php?h=saves"> gravar(form)
		echo '<form method="post" action="">
				Nome: <input type="text" id="nome" name="nome" size="54"><br><br>
				';
		echo'Endereço: <input type="text" id="link" name="link" size="50"><br>
			Destino: <input type="radio" name="target" value="1" checked="checked">'.I_SELF.'
					 <input type="radio" name="target" value="0">'.I_NEW.'<br>';
		echo 'Menu Principal: <input type="text" id="menu" name="menu" size="5">
			 Posição: <input type="text" id="position" name="position" size="5">
			 Activo: <input type="radio" name="activo" value="1">Sim
			 		 <input type="radio" name="activo" value="0" checked="checked">Não<br>';
		echo '<input type="button" value="'.I_SAVE.'" name="gravar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=menuSave\', \'index.php?c=menueditor&menu_id=\');" />';
		echo '<button type="button" id="cancelar">'.I_RETURN.'</button> 
			</div>
			</form>';
		echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
						if (checkChanges("nome")||checkChanges("link")||checkChanges("menu")||checkChanges("position")||$(\'input[name=activo]:checked\').val()!=0||$(\'input[name=target]:checked\').val()!=1){
							var a = confirm("Tem a certeza que deseja voltar?\nQualquer modificação não guardada será perdida.");
							if (a) {
								window.location.replace("?c=menus");
							}
							else {
    						// Do nothing!
							}
						}
						else { window.location.replace("?c=menus");}
					}, false);
			</script>';
	}
}

if(!function_exists('menueditor')){
	function menueditor(){
		global $bd;
		
		global $bd;
		
		if (isset($_GET['menu_id'])) {
			$mnID = $_GET['menu_id'];
			$slDados	= $bd->query("SELECT ID, Descricao, Link, Target, Menu, Pos, Activo FROM ".BD_PREFIXO."Menu WHERE ID =".$mnID);
			if($bd->tem_linhas($slDados)){
				echo '<h1>'.I_MENUITEM.'</h1>';
				$row = $bd->dados($slDados);
				echo '<form method="post" action="">
				Nome: <input type="text" id="nome" name="nome" size="54" value="'.$row[1].'"><br><br>';
				echo'Endereço: <input type="text" id="link" name="link" size="50" value="'.$row[2].'"><br>';
				if($row[3]) {
					echo 'Destino: <input type="radio" name="target" value="1" checked="checked">'.I_SELF.'
					 	 <input type="radio" name="target" value="0">'.I_NEW.'<br>';
				}
				else {
					echo 'Destino: <input type="radio" name="target" value="1">'.I_SELF.'
					 	 <input type="radio" name="target" value="0" checked="checked">'.I_NEW.'<br>';
				}
				echo 'Menu Principal: <input type="text" id="menu" name="menu" size="5" value="'.$row[4].'">
			 		 Posição: <input type="text" id="position" name="position" size="5" value="'.$row[5].'">';
				if($row[6]) {
					echo 'Activo: <input type="radio" name="activo" value="1" checked="checked">Sim
			 		 <input type="radio" name="activo" value="0" >Não<br>';
				}
				else {
					echo 'Activo: <input type="radio" name="activo" value="1">Sim
			 		 <input type="radio" name="activo" value="0" checked="checked">Não<br>';
				}
				echo '<input type="button" value="'.I_SAVE.'" name="gravar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=menuSave&menu_id='.$row[0].'\', null);" />';
				echo '<button type="button" id="cancelar">'.I_RETURN.'</button>
				</form>';
				//alert($(\'input[name=activo]:checked\').val()+ " - "+'.$row[6].');
				/*
				
								document.getElementById(\'link\').value + " - " + "'.$row[2].'" + "\n"+
								$(\'input[name=target]:checked\').val() + " - " + "'.$row[3].'" + "\n"+
								document.getElementById(\'menu\').value + " - " + "'.$row[4].'" + "\n"+
								document.getElementById(\'position\').value + " - " + "'.$row[5].'" + "\n"+
								$(\'input[name=activo]:checked\').val() + " - " + "'.$row[6].'" + "\n"*/
				echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
						if (checkChanges("nome")||checkChanges("link")||checkChanges("menu")||checkChanges("position")|| $(\'input[name=activo]:checked\').val()!='.$row[6].'||$(\'input[name=target]:checked\').val()!='.$row[3].'){
							var a = confirm("Tem a certeza que deseja voltar?\nQualquer modificação não guardada será perdida.");
							if (a) {
								window.location.replace("?c=menus");
							}
							else {
    						// Do nothing!
							}
						}
						else { window.location.replace("?c=menus");}
					}, false);
				</script>';
			}
		}
	}
}



if(!function_exists('menuSave')){
	function menuSave() {
		global $bd;
		$desc=reqvlr('nome');
		$link=reqvlr('link');
		$target=reqvlr('target');
		$menu=reqvlr('menu');
		$pos=reqvlr('position');
		$activo=reqvlr('activo');
		$saveQ;
		if(reqvlr('menu_id')) {
			$saveQ = $bd->query("UPDATE ".BD_PREFIXO."Menu SET Descricao='".$desc."', Link ='".$link."', Target =".$target.", Menu =".$menu.", Pos =".$pos.", Activo =".$activo." WHERE ID =".reqvlr('menu_id'));
			if($saveQ) {
				echo 'a';
			}else {
				echo '0';
			}
				//header("location: ?c=editor&news_id=".reqvlr('news_id'));
		}
		else {
			$saveQ = $bd->query("INSERT INTO ".BD_PREFIXO."Menu (Descricao, Link, Target, Menu, Pos, Activo) VALUES( '".$desc."', '".$link."', ".$target.", ".$menu.", ".$pos.", ".$activo.")");
			if($saveQ) {
				echo $bd->ultimo_id();
			}else {
				echo '0';
			}
			
		}
	}
}
?>
