<?PhP
require_once("fetch_data.php");


/*********** função de listar as noticias *******************/
if(!function_exists('news')){
	function news(){
		global $bd;

		echo '<div class="container-fluid">';

            echo '<div class="col-xs-12">';
                echo '<h1>Gestão de Publicações</h1>';
            echo '</div>';

			echo '<div class="col-xs-12" style="margin:30px 0px;">';
            	echo '<div class="col-xs-3">';
					echo '<button class="btn btn-primary" type="button" onclick=window.location="?c=criador&news_id=0">Nova Publicação</button>';
				echo '</div>';
			echo '</div>';


			echo '<div class="col-xs-12">';
				echo '<table align="center" border="0" cellpadding="2" cellspacing="0" style="width:80%">';
					echo '<tr>',
						'<th>'.I_DESCRIPTION.'</th>',
                        '<th> Secção </th>',
						'<th> Categoria </th>',
						'<th>'.I_PUBLISHED.'</th>',
						'<th>'.I_ACTIONS.'</th>',
					'</tr>';
		    		$noticias =  $bd->query("SELECT N.Id, N.Titulo, N.Publicada, S.Descricao, C.Descricao FROM Noticias AS N LEFT JOIN Seccao AS S ON N.Seccao=S.Id LEFT JOIN Categorias AS C ON N.Categoria =C.Id ORDER BY N.Data DESC");
		    		while($row = $bd->dados($noticias)){
						echo '<tr align="left">';
							echo '<td>'.$row[1].'</td>';
							echo '<td>'.$row[3].'</td>';
                            if (empty($row[4]) || is_null($row[4])) {
                                echo '<td> - </td>';
                            }
                            else {
                                echo '<td>'.$row[4].'</td>';
                            }
							if($row[2] == 1){
								echo '<td><a href="?h=changePubstate&news_id='.$row[0].'" >'.I_REMOVEPUB.'</a></td>';
							}else{
								echo '<td><a href="?h=changePubstate&news_id='.$row[0].'" >'.I_PUBLICA.'</a></td>';
							}
							echo '<td><a href="?c=criador&news_id='.$row[0].'">'.I_EDIT.'</a> | <a href="?h=newsDelete&news_id='.$row[0].'">'.I_DELETE.'</a></td>';
						echo '</tr>';
					}
				echo '</table>';
			echo '</div>';	
    	echo '</div>';		
	}
}

/**** função para criar e editar noticias ****/
if(!function_exists('criador')){
	function criador(){
		global $bd;

		//para editar
		if(reqvlr("news_id") > 0){
			$dados 		= $bd->query("SELECT Titulo, Seccao, Resumo, Imagem, UrlVideo, Texto, Categoria FROM Noticias WHERE Id = ".reqvlr("news_id")."");
			$da 		= $bd->dados($dados);
			$titulo 	= $da[0];
			$seccao 	= $da[1];
			$resumo 	= $da[2];
			$imagem 	= $da[3];
			$url 		= $da[4];
			$texto 		= $da[5];
			$categoria	= $da[6];
		}else{
			//para criar
			$titulo 	= "";
			$seccao 	= 3;
			$resumo 	= "";
			$imagem 	= "";
			$url 		= "";
			$texto 		= "";
			$categoria 	= 0;
		
		}
		
		echo '<h1> Notícia </h1>';
		
		echo '<form method="post" action="">';
		
			echo '<h3>Titulo: </h3>';
			echo '<input type="text" id="titulo" name="titulo" size="100" value="'.$titulo.'"">';	
			
			/********** SECCAO ***********/
			echo '<h3>Secção</h3>';
			echo '<select name="seccao" id="seccao" onchange="fetch_select(this.value);">';

				$sec = $bd->query("SELECT Id, Descricao FROM Seccao");
				while($se = $bd->dados($sec)){
					if($se[0] == $seccao){
						echo '<option value="'.$se[0].'" selected>'.$se[1].'</option>';
					}else{
						echo '<option value="'.$se[0].'">'.$se[1].'</option>';
					}
			    }
			echo '</select>';

			/************ CATEGORIA **************/
			echo '<h3>Categorias</h3>';
			echo '<select name="categorias" id="categorias">';
				$resp = $bd->query("SELECT Id, Descricao FROM Categorias WHERE Seccao = ".$seccao."");
				while($row = $bd->dados($resp)){
					if($row[0] == $categoria){
           				echo '<option value="'.$row[0].'" selected>'.$row[1].'</option>';
           			}else{
           				echo '<option value="'.$row[0].'">'.$row[1].'</option>';
           			}	
         		}
				echo '<option value="0">-- select one -- </option>';
			echo '</select>';

			/************ Resumo **************/		
			echo '<h3> Resumo </h3>';
			echo '<div style="width:60%; margin:10px align="center"">';
			echo '<textarea name="resumo" rows="4" cols="97" id="resumo">'.$resumo.'</textarea></div>';
			echo '<script type="text/javascript"> $(document).ready(function(){
				setTextLimit("resumo", 200);
				});</script>';


			/************ Imagem **************/
			echo '<h3>'.I_IMAGE.'</h3>';
			//caso ainda não tenha imagem
			if(strlen($imagem) == 0){
				echo '<img src= "" style="margin:10px auto; max-height:300px; width:auto; max-width: 300px;" id="sliderimg"><br>';
			}else{
				echo '<img src= "'.SITE_ROOT.DATA_DIR.'/posts/'.$imagem.'" style="margin:10px auto; max-height:300px; width:auto; max-width: 300px;" id="sliderimg"><br>';
			}
			echo I_PATH.': <input type="text" id="image" name="image" size="50" value="'.$imagem.'">
			<button type="button" id="imgNot" class="search">'.I_SEARCH.'</button> <br><br>';

			echo '<script type="text/javascript"> 
				document.getElementById("imgNot").addEventListener("click", 
					function() {
    					ExpAbrir2("posts", "sliderimg","image");
					}, false);
			</script>
			';

			/************ url video **************/
			echo '<h3> Url Video </h3>';
	 		echo '<input type="text" id="url" name="url" size="100" value="'.$url.'">';	


			/************ corpo da noticia **************/
			echo '<h3> Conteúdo </h3>';
			echo '<div style="width:60%; margin:10px auto;">
				<textarea id="texto" name="texto" rows="4" cols="100" class="mceEditor" >'.$texto.'</textarea> </div>';


			/************ botoes **************/	
			echo '<div align="center">';
				echo '<input type="button" value="Gravar" name="gravar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=newsSave&pub=0&news_id='.reqvlr("news_id").'\', \'index.php?c=criador&news_id=\');" />';
				echo '<input type="button" name="saveandpub" value="Gravar e Publicar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=newsSave&pub=1&news_id='.reqvlr("news_id").'\', \'index.php?c=news\');"/>';
				echo '<button type="button" id="cancelar">Cancelar</button> ';
			echo '</div>';
		echo '</form>';

		echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
						if(checkChanges("titulo")||checkChanges("image")||checkChanges("url")||checkChanges("resumo")||checkEditorChanges("texto")){
							var a = confirm("Perderá alterações se sair sem gravar. Deseja continuar?");
							if (a) {
								window.location.replace("?c=news");
							}
							else {
    						// Do nothing!
							}
						}
						else { window.location.replace("?c=news");}
					}, false);
			</script>';
	}
}


/********* apagar as noticias ***********/
if(!function_exists('newsDelete')){
	function newsDelete(){
		global $bd;
		if(reqvlr('news_id')) {
			
			$slDados = $bd->query("DELETE FROM Noticias WHERE Id =".reqvlr('news_id'));
			if($slDados){
				$_SESSION["ERR_A"]	= 1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
				header("location: ?c=news");
			}else {
				$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: ?c=news");
			}
		}
	}
}

/************* função que altera o estado de noticia ******************/
/************ publicado e não publicado *************/
if(!function_exists('changePubstate')){
	function changePubstate(){
		global $bd;
		if(reqvlr('news_id')) {
			$slDados	= $bd->query("SELECT Publicada FROM Noticias WHERE Id =".reqvlr('news_id'));
			if($bd->tem_linhas($slDados)){
				$row = $bd->dados($slDados);
				if($row[0]==0){
					$chState = $bd->query("UPDATE Noticias SET Publicada = 1, Data = '".date("c")."' WHERE Id =".reqvlr('news_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=news");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=news");
					}
				}
				else {
					$chState = $bd->query("UPDATE Noticias SET Publicada = 0 WHERE Id =".reqvlr('news_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=news");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=news");
					}
				}
			}
			
		}
	}
}

/***************** gravar a noticia **********************/
if(!function_exists('newsSave')){
	function newsSave() {
		global $bd;
		$titulo 	=reqvlr('titulo');
		$resumo 	=reqvlr('resumo');
		$texto 		= reqvlr('texto');
		$imagem 	= reqvlr('image');
		$seccao 	= reqvlr('seccao');
		$pub 		= reqvlr('pub');
		$url 		= reqvlr('url');
		$categoria 	= reqvlr('categorias');
		$saveQ;
        $catText = "";
        $secText = "";
        $queryText = "";

		if(reqvlr('news_id') > 0) {
            if (reqvlr('categorias') && urldecode(trim(reqvlr("categorias"), "\x00..\x1F"))!="" && urldecode(trim(reqvlr("categorias"), "\x00..\x1F"))!=0) {
                $catText = ", Categoria = '". $categoria."'";
            }
            else {
                $catText = ", Categoria = NULL";
            }
            if(reqvlr('seccao') && urldecode(trim(reqvlr("seccao"), "\x00..\x1F"))!="" && urldecode(trim(reqvlr("seccao"), "\x00..\x1F"))!=0) {
                $secText = ", Seccao  = '".$seccao."'";
            }

			//caso seja para publicar vamos ter de alterar a data
			if($pub == 1){
                $slcheckOldDateQ	= $bd->query("SELECT Publicada, Data FROM Noticias WHERE Id =".reqvlr('news_id'));
                $row = $bd->dados($slcheckOldDateQ);
                if($row[0]==1) {
                    //se já estava publicada, mantem a data inicial
                    $queryText = "UPDATE Noticias SET Titulo = '".$titulo."', Utilizador ='".$_SESSION["S01"]."', Resumo ='".$resumo."', Texto ='".$texto."', Imagem ='".$imagem."', UrlVideo = '".$url."', Publicada = ".$pub."".$secText.$catText." WHERE Id =".reqvlr('news_id');
                    $saveQ = $bd->query($queryText);
                }
                else {
                    //se não estava publicada, altera a data
                    $queryText = "UPDATE Noticias SET Titulo = '".$titulo."', Utilizador ='".$_SESSION["S01"]."', Resumo ='".$resumo."', Texto ='".$texto."', Imagem ='".$imagem."', UrlVideo = '".$url."', Publicada = ".$pub.", Data = '".date('c')."', ".$secText.", ".$catText." WHERE Id =".reqvlr('news_id');
                    $saveQ = $bd->query($queryText);
                }
			}else{
                //não é para publicar
                $slcheckOldDateQ	= $bd->query("SELECT Publicada, Data FROM Noticias WHERE Id =".reqvlr('news_id'));
                $row = $bd->dados($slcheckOldDateQ);
                //verificar se já estava publicada anteriormente
                if($row[0]==1) {
                    //se sim, não altera a data e mantém estado a 1
                    $queryText = "UPDATE Noticias SET Titulo = '".$titulo."', Utilizador ='".$_SESSION["S01"]."', Resumo ='".$resumo."', Texto ='".$texto."', Imagem ='".$imagem."', UrlVideo = '".$url."'".$secText.$catText." WHERE Id =".reqvlr('news_id');
                    $saveQ = $bd->query($queryText);
                }
                else {
                    //se não mantem a data inicial e estado deve ser 0
                    $queryText = "UPDATE Noticias SET Titulo = '".$titulo."', Utilizador ='".$_SESSION["S01"]."', Resumo ='".$resumo."', Texto ='".$texto."', Imagem ='".$imagem."', UrlVideo = '".$url."', Publicada = ".$pub."".$secText.$catText." WHERE Id =".reqvlr('news_id');
                    $saveQ = $bd->query($queryText);
                }
			}
			if($saveQ) {
				if($pub == 1){
					echo 'a';
				}else{
					echo reqvlr("news_id");
				}
			}else {
				echo '0';
			}
		}
		else {
            $queryText = "";

            if (reqvlr('categorias') && urldecode(trim(reqvlr("categorias"), "\x00..\x1F"))!="" && urldecode(trim(reqvlr("categorias"), "\x00..\x1F"))!=0) {
                $queryText = "INSERT INTO Noticias (Titulo, Texto, UrlVideo, Resumo, Imagem, Data, Utilizador, Seccao, Publicada, Categoria) VALUES('".$titulo."', '".$texto."', '".$url."', '".$resumo."', '".$imagem."', '".date("c")."', '".$_SESSION["S01"]."' ,'".$seccao."', ".$pub.", '".$categoria."' )";
            }
            else {
                $queryText = "INSERT INTO Noticias (Titulo, Texto, UrlVideo, Resumo, Imagem, Data, Utilizador, Seccao, Publicada) VALUES('".$titulo."', '".$texto."', '".$url."', '".$resumo."', '".$imagem."', '".date("c")."', '".$_SESSION["S01"]."', '".$seccao."', ".$pub." )";
            }
			//criar a noticia
			$saveQ = $bd->query($queryText);
			if($saveQ) {
				if($pub == 1){
					echo 'a';
				}else{
					echo $bd->ultimo_id();
				}
			}else {
				echo '0';
			}
			
		}
	}
}
?>
