<?php
if(!function_exists('faq')){
	function faq(){	
		
		global $bd;

		echo '<div class="container-fluid">';

			
			echo '<div class="col-xs-12">';
				echo '<h1>FAQ</h1>';
			echo '</div>';

			echo '<div class="col-xs-12" style="margin:30px 0px;">';
            	echo '<div class="col-xs-3">';
					echo '<button class="btn btn-primary" type="button" onclick=window.location="?c=veFaq&id=0">Novo Faq</button>';
				echo '</div>';
			echo '</div>';

			$perguntas = $bd->query("SELECT Id, Pergunta FROM faq");

			echo '<div class="col-xs-12">';
				echo '<table align="center" border="0" cellpadding="2" cellspacing="0" style="width:80%">';
				while($per = $bd->dados($perguntas)){
					echo '<tr>';
						echo '<td  style="cursor:pointer">'.$per[1].'</td>';		
						echo '<td><a href="?c=veFaq&id='.$per[0].'">'.I_EDIT.'</a> | <a href="?h=deleteFaq&id='.$per[0].'">'.I_DELETE.'</a></td>';
					echo '</tr>';
				}
				echo '</table>';
			echo '</div>';
		echo '</div>';

	}
}

if(!function_exists('veFaq')){
	function veFaq(){	
		
		global $bd;
		if(reqvlr("id") == 0){
			$pergunta 	= "";
			$resposta 	= "";
		}else{
			$dado 		= $bd->query("SELECT Pergunta, Resposta FROM faq WHERE Id = ".reqvlr("id")."");
			$da 		= $bd->dados($dado);
			$pergunta 	= $da[0];
			$resposta 	= $da[1];
		}
		echo '<div class="container-fluid">';
			echo '<form method="post" action="">';

				echo '<h3> Pergunta </h3>';
				echo '<div style="width:60%; margin:10px align="center"">';
				echo '<textarea name="pergunta" rows="4" cols="97" id="pergunta">'.$pergunta.'</textarea></div>';
				
				echo '<h3> Resposta </h3>';
				echo '<div style="width:60%; margin:10px auto;">
				<textarea id="resposta" name="resposta" rows="4" cols="100" class="mceEditor" >'.$resposta.'</textarea> </div>';

				echo '<div align="center">';
					echo '<input type="button" name="saveandpub" value="Gravar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=saveFaq&id='.reqvlr("id").'\', \'index.php?c=faq\');"/>';
					echo '<button type="button" id="cancelar">Cancelar</button> ';
				echo '</div>';	
			echo '</form>';		

			echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
						if(checkChanges("pergunta")||checkEditorChanges("resposta")){
							var a = confirm("Perderá alterações se sair sem gravar. Deseja continuar?");
							if (a) {
								window.location.replace("?c=faq");
							}
							else {
    						// Do nothing!
							}
						}
						else { window.location.replace("?c=faq");}
					}, false);
			</script>';
		echo '</div>';

	}
}

if(!function_exists('saveFaq')){
	function saveFaq() {
		global $bd;
		$pergunta 	=reqvlr('pergunta');
		$resposta	=reqvlr('resposta');
		
		$saveQ;
		if(reqvlr('id') > 0) {

			//para editar faq
			$saveQ = $bd->query("UPDATE faq SET Pergunta = '".$pergunta."', Resposta ='".$resposta."' WHERE Id =".reqvlr('id'));
			
			if($saveQ) {
				echo "a";
			}else {
				echo '0';
			}
		}
		else {
			//criar a faq
			$saveQ = $bd->query("INSERT INTO faq (Pergunta, Resposta) VALUES('".$pergunta."', '".$resposta."')" );
			if($saveQ) {
				echo "a";
			}else {
				echo '0';
			}
			
		}
	}
}

if(!function_exists('deleteFaq')){
	function deleteFaq(){
		global $bd;
		if(reqvlr('id')) {
			
			$slDados = $bd->query("DELETE FROM faq WHERE Id =".reqvlr('id'));
			if($slDados){
				$_SESSION["ERR_A"]	= 1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
				header("location: ?c=faq");
			}else {
				$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: ?c=faq");
			}
		}
	}
}

?>