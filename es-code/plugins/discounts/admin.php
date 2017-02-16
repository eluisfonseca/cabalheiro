<?PhP
//require_once("fetch_data.php");


/*********** função de listar as noticias *******************/
if(!function_exists('discounts')){
	function discounts(){
		global $bd;

		echo '<div class="container-fluid">';

			echo '<div class="col-xs-12">';
				echo '<h1>Descontos</h1>';
			echo '</div>';


            echo '<div class="col-xs-12" style="margin:30px 0px;">';
                echo '<div class="col-xs-3">';
                    echo '<button class="btn btn-primary" type="button" onclick=window.location="?c=criador_descontos&discount_id=0">Novo Desconto</button>';
                echo '</div>';
            echo '</div>';

			echo '<div class="col-xs-12">';
				echo '<table align="center" border="0" cellpadding="2" cellspacing="0" style="width:80%">';
					echo '<tr>',
						'<th>Marca</th>',
						'<th>'.I_PUBLISHED.'</th>',
						'<th>'.I_ACTIONS.'</th>',
					'</tr>';
		    		$noticias =  $bd->query("SELECT Id, Marca, Estado FROM Descontos");
		    		while($row = $bd->dados($noticias)){
						echo '<tr align="left">';
							echo '<td>'.$row[1].'</td>';
							if($row[2] == 1){
								echo '<td><a href="?h=changeDiscountState&discount_id='.$row[0].'" >'.I_REMOVEPUB.'</a></td>';
							}else{
								echo '<td><a href="?h=changeDiscountState&discount_id='.$row[0].'" >'.I_PUBLICA.'</a></td>';
							}
							echo '<td><a href="?c=criador_descontos&discount_id='.$row[0].'">'.I_EDIT.'</a> | <a href="?h=discountDelete&discount_id='.$row[0].'">'.I_DELETE.'</a></td>';
						echo '</tr>';
					}
				echo '</table>';
			echo '</div>';	
    	echo '</div>';		
	}
}

/**** função para criar e editar desconto ****/
if(!function_exists('criador_descontos')){
	function criador_descontos(){
		global $bd;
		
		//para editar
		if(reqvlr("discount_id") > 0){
			$dados 		= $bd->query("SELECT Marca, Descricao, Link, Banner FROM Descontos WHERE Id = ".reqvlr("discount_id")."");
			$da 		= $bd->dados($dados);
			$marca  	= $da[0];
			$descricao 	= $da[1];
			$link 		= $da[2];
			$banner 	= $da[3];
		}else{
			//para criar
			$marca  	= "";
			$descricao 	= "";
			$link 		= "";
			$banner 	= "";
		
		}
		
		echo '<h1> Desconto </h1>';
		
		echo '<form method="post" action="">';
			/************ Marca **************/
			echo '<h3>Marca: </h3>';
			echo '<input type="text" id="marca" name="marca" size="100" value="'.$marca.'"">';	
			/************ url  **************/
			echo '<h3> Link </h3>';
	 		echo '<input type="text" id="link" name="link" size="100" value="'.$link.'">';
	 		/************ Imagem **************/
			echo '<h3>Banner</h3>';
			//caso ainda não tenha imagem
			if(strlen($banner) == 0){
				echo '<img src= "" style="margin:10px auto; width=50%; max-width=300px;" id="sliderimg"><br>';
			}else{
				echo '<img src= "'.SITE_ROOT.DATA_DIR.'/banner/'.$banner.'" style="margin:10px auto; width=50%; max-width=300px;" id="sliderimg"><br>';
			}
			echo I_PATH.': <input type="text" id="image" name="image" size="50" value="'.$banner.'">
			<button type="button" id="imgNot" class="search">'.I_SEARCH.'</button> <br><br>';

			echo '<script type="text/javascript"> 
				document.getElementById("imgNot").addEventListener("click", 
					function() {
    					ExpAbrir2("banner", "sliderimg", "image");
					}, false);
			</script>
			';
	 		/************ Descricao **************/
			echo '<h3> Descrição </h3>';
			echo '<div style="width:60%; margin:10px auto;">
				<textarea id="descricao" name="descricao" rows="4" cols="100" class="mceEditor" >'.$descricao.'</textarea> </div>';
			/************ botoes **************/	
			echo '<div align="center">';
				echo '<input type="button" value="Gravar" name="gravar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=discountSave&pub=0&discount_id='.reqvlr("discount_id").'\', \'index.php?c=criador_descontos&discount_id=\');" />';
				
				echo '<input type="button" name="saveandpub" value="Gravar e Publicar" class="botao" onclick="javascript:gravarNoticias(this.form, \'index.php?h=discountSave&pub=1&discount_id='.reqvlr("discount_id").'\', \'index.php?c=discounts\');"/>';
				echo '<button type="button" id="cancelar">Cancelar</button> ';
			echo '</div>';
		echo '</form>';


		echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
						if(checkChanges("marca")||checkChanges("link")||checkChanges("image")||checkChanges("descricao")){
							var a = confirm("Perderá alterações se sair sem gravar. Deseja continuar?");
							if (a) {
								window.location.replace("?c=discounts");
							}
							else {
    						// Do nothing!
							}
						}
						else { window.location.replace("?c=discounts");}
					}, false);
			</script>';
	}
}


/********* apagar o desconto ***********/
if(!function_exists('discountDelete')){
	function discountDelete(){
		global $bd;
		if(reqvlr('discount_id')) {
			
			$slDados = $bd->query("DELETE FROM Descontos WHERE Id =".reqvlr('discount_id'));
			if($slDados){
				$_SESSION["ERR_A"]	= 1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
				header("location: ?c=discounts");
			}else {
				$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: ?c=discounts");
			}
		}
	}
}

/************* função que altera o estado do desconto ******************/
/************ publicado e não publicado *************/
if(!function_exists('changeDiscountState')){
	function changeDiscountState(){
		global $bd;
		if(reqvlr('discount_id')) {
			$slDados	= $bd->query("SELECT Estado FROM Descontos WHERE Id =".reqvlr('discount_id'));
			if($bd->tem_linhas($slDados)){
				$row = $bd->dados($slDados);
				if($row[0]==0){
					$chState = $bd->query("UPDATE Descontos SET Estado = 1 WHERE Id =".reqvlr('discount_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=discounts");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=discounts");
					}
				}
				else {
					$chState = $bd->query("UPDATE Descontos SET Estado = 0 WHERE Id =".reqvlr('discount_id'));
					if($chState) {
						$_SESSION["ERR_A"]	= 1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
						header("location: ?c=discounts");
					}else {
						$_SESSION["ERR_A"]	= -1;
						$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
						header("location: ?c=discounts");
					}
				}
			}
			
		}
	}
}

/***************** gravar o desconto **********************/
if(!function_exists('discountSave')){
	function discountSave() {
		global $bd;
		$marca 		=	reqvlr('marca');
		$link 		= 	reqvlr('link');
		$descricao 	= 	reqvlr('descricao');
		$banner 	= 	reqvlr('image');
		$pub 	 	= 	reqvlr('pub');
		

		$saveQ;
		if(reqvlr('discount_id') > 0) {

			$saveQ = $bd->query("UPDATE Descontos SET Marca = '".$marca."', Descricao ='".$descricao."', Link ='".$link."', Banner ='".$banner."', Estado = 1 WHERE Id =".reqvlr('discount_id'));
			
			if($saveQ) {
				if($pub == 1){
					echo 'a';
				}else{
					echo reqvlr("discount_id");
				}
			}else {
				echo '0';
			}
		}
		else {
			//criar a noticia
			$saveQ = $bd->query("INSERT INTO Descontos (Marca, Link, Banner, Descricao, Estado) VALUES('".$marca."', '".$link."', '".$banner."', '".$descricao."', '".$pub."')" );
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
