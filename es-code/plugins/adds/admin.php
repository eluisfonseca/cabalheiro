<?PhP
//require_once("fetch_data.php");


/*********** função de listar as noticias *******************/
if(!function_exists('adds')){
	function adds(){
		global $bd;

		echo '<div class="container-fluid">';
		

			echo '<div class="col-xs-12">';
				echo '<h1>Banners</h1>';
			echo '</div>';

			echo '<div class="col-xs-12">';
				echo '<table align="center" border="0" cellpadding="2" cellspacing="0" style="width:80%">';
					echo '<tr>',
						'<th>Posição</th>',
						'<th>'.I_PUBLISHED.'</th>',
						'<th>'.I_ACTIONS.'</th>',
					'</tr>';
		    		$noticias =  $bd->query("SELECT ID, Posicao, Estado FROM Adds");
		    		while($row = $bd->dados($noticias)){
						echo '<tr align="left">';
							echo '<td>'.$row[1].'</td>';
							if($row[2] == 1){
								echo '<td><a href="?h=changeAddState&add_id='.$row[0].'" >'.I_REMOVEPUB.'</a></td>';
							}else{
								echo '<td><a href="?h=changeAddState&add_id='.$row[0].'" >'.I_PUBLICA.'</a></td>';
							}
							echo '<td><a href="?c=criador_adds&add_id='.$row[0].'">'.I_EDIT.'</a> | <a href="?h=addDelete&add_id='.$row[0].'">'.I_DELETE.'</a></td>';
						echo '</tr>';
					}
				echo '</table>';
			echo '</div>';	
    	echo '</div>';		
	}
}

/**** função para criar e editar desconto ****/
if(!function_exists('criador_adds')){
	function criador_adds(){
		global $bd;
		
		//para editar
		if(reqvlr("add_id") > 0){
			$dados 		= $bd->query("SELECT Posicao, Imagem, Estado, ID, Link FROM Adds WHERE ID = ".reqvlr("add_id")."");
			$da 		= $bd->dados($dados);
			$posicao  	= $da[0];
			$estado 		= $da[2];
			$banner 	= $da[1];
            $link       = $da[4];
		}else{
			//para criar
			$posicao  	= "";
			$estado	    = "";
			$banner 	= "";
		
		}
		
		echo '<h1 style="margin-bottom: 50px;"> Editor de Publicidade </h1>';
		echo '<h4>Posição do Banner</h4><h5>'.$posicao.'</h5>';
        if($estado==1) {
            echo '<h6>Estado: Activo</h6>';
        }
        else {
            echo '<h6>Estado: Desactivado</h6>';
        }
		echo '<form method="post" action="">';
            /************ Imagem **************/
            echo '<h3>Link</h3>';
            echo '<p><input type="text" id="add-link" name="add-link" size="100" value="'.$link.'"></p><small>NOTA: Não esquecer de incluir "http://"</small>';
	 		/************ Imagem **************/
			echo '<h3>Imagem</h3>';
			//caso ainda não tenha imagem
			if(strlen($banner) == 0){
				echo '<img src= "" style="margin:10px auto; max-height:300px; width:auto; max-width: 300px;" id="sliderimg"><br>';
			}else{
				echo '<img src= "'.SITE_ROOT.DATA_DIR.'/adds/'.$banner.'" style="margin:10px auto; max-height:300px; width:auto; max-width: 300px;" id="sliderimg"><br>';
			}
			echo I_PATH.': <input type="text" id="image" name="image" size="50" value="'.$banner.'">
			<button type="button" id="imgNot" class="search">'.I_SEARCH.'</button> <br><br>';

			echo '<script type="text/javascript"> 
				document.getElementById("imgNot").addEventListener("click", 
					function() {
    					ExpAbrir2("adds", "sliderimg", "image");
					}, false);
			</script>
			';
			/************ botoes **************/	
			echo '<div align="center">';
				echo '<input type="button" value="Gravar" name="gravar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=addsSave&pub=0&add_id='.reqvlr("add_id").'\', \'index.php?c=criador_adds&add_id=\');" />';
				
				echo '<input type="button" name="saveandpub" value="Gravar e Publicar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=addsSave&pub=1&add_id='.reqvlr("add_id").'\', \'index.php?c=adds\');"/>';
				echo '<button type="button" id="cancelar">Cancelar</button> ';
			echo '</div>';
		echo '</form>';


		echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
						if(checkChanges("image")){
							var a = confirm("Perderá alterações se sair sem gravar. Deseja continuar?");
							if (a) {
								window.location.replace("?c=adds");
							}
							else {
    						// Do nothing!
							}
						}
						else { window.location.replace("?c=adds");}
					}, false);
			</script>';
	}
}


/********* apagar o desconto ***********/
if(!function_exists('addDelete')){
	function addDelete(){
		global $bd;
		if(reqvlr('add_id')) {
			
			$slDados = $bd->query("DELETE FROM Adds WHERE ID =".urldecode(trim(reqvlr("add_id"), "\x00..\x1F")));
			if($slDados){
				$_SESSION["ERR_A"]	= 1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
				header("location: ?c=adds");
			}else {
				$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: ?c=adds");
			}
		}
	}
}

/************* função que altera o estado do desconto ******************/
/************ publicado e não publicado *************/
if(!function_exists('changeAddState')){
	function changeAddState(){
		global $bd;
		if(reqvlr('add_id')) {
			$slDados	= $bd->query("SELECT Estado FROM Adds WHERE ID =".urldecode(trim(reqvlr("add_id"), "\x00..\x1F")));
			if($bd->tem_linhas($slDados)){
				$row = $bd->dados($slDados);
				if($row[0]==0){
					$chState = $bd->query("UPDATE Adds SET Estado = 1 WHERE ID =".urldecode(trim(reqvlr("add_id"), "\x00..\x1F")));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=adds");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=adds");
					}
				}
				else {
					$chState = $bd->query("UPDATE Adds SET Estado = 0 WHERE ID =".urldecode(trim(reqvlr("add_id"), "\x00..\x1F")));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=adds");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=adds");
					}
				}
			}
			
		}
	}
}

/***************** gravar o desconto **********************/
if(!function_exists('addsSave')){
	function addsSave() {
		global $bd;
		$banner 	= 	reqvlr('image');
		$pub 	 	= 	reqvlr('pub');
        $add_link = reqvlr('add-link');
		

		$saveQ;
		if(reqvlr('add_id') > 0) {
            if(trim(reqvlr('add-link'))!='') {
                $saveQ = $bd->query("UPDATE Adds SET Imagem ='".$banner."', Link = '".$add_link."' WHERE ID =".urldecode(trim(reqvlr("add_id"), "\x00..\x1F")));
            }
            else {
                $saveQ = $bd->query("UPDATE Adds SET Imagem ='".$banner."', Link = NULL WHERE ID =".urldecode(trim(reqvlr("add_id"), "\x00..\x1F")));
            }

			
			if($saveQ) {
				if($pub == 1){
					echo 'a';
				}else{
					echo urldecode(trim(reqvlr("add_id"), "\x00..\x1F"));
				}
			}else {
				echo '0';
			}
		}
	}
}
?>
