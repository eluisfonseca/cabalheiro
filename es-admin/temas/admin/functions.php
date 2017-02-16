<?PhP
if(!function_exists('adminT_head')){
	function adminT_head(){
		echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-admin/temas/admin/code.js"></script>';
		echo '<link href="'.SITE_ROOT .'/es-admin/temas/admin/dropzone.css" type="text/css" rel="stylesheet" />';
				
	}
	add_hook('admin_head', 'adminT_head');
}
addJSinit("$('#err1').fadeOut(3000);");
addJSinit("$('#err2').fadeOut(3000);");

if(!function_exists('main')){
	function main(){
		global $bd;
		echo '<div class="container-fluid" id="user_area">';
            echo '<div class="row">';
                echo '<div class="col-lg-12">';
					echo '<h1 class="page-header">'.I_USERDATA.'</h1>';
				echo '</div>';
				echo '<form method="post" onsubmit="return false;" action="" style="margin-bottom:0px; position:relative;">';
				$utilizador	= $bd->query("SELECT ID, Utilizador, Palavra, Nome, Email, Activo, Administrador FROM ".BD_PREFIXO."Utilizadores WHERE ID=".$_SESSION["S01"]);
				if($row = $bd->dados($utilizador)) {
					echo I_USER.': <input type="text" id="user" name="user" size="30" value="'.$row[1].'"><br><br>';
				echo		I_NOME.': <input type="text" id="nome" name="nome" size="100" value="'.$row[3].'"><br><br>';
				if($row[6]==1){
					echo I_ADMIN.': '.I_YES;
				}
				else {echo I_ADMIN.': '.I_NO;}
				echo '<span style="margin-left:30px;"></span>';
				if($row[5]==1){
					echo I_STATE.': '.I_ACTIVE;
				}
				else {echo I_STATE.': '.I_NOT_ACTIVE;}

				echo '<input style="margin-left:30px;" type="submit" value="'.I_SAVE.'" onclick="javascript:gravarForm(this.form, \'index.php?h=editUser&user_id='.$row[0].'&\', null);" class="btn btn-primary">';
				echo '</form>';
				echo '<br><br>';
				
				echo '<form method="post" onsubmit="return false;" action="" style="margin-top:10px;">';
				echo '<a href="#" class="unobtrusive btn btn-success" onclick="displayForm(\'coiso\')" >'.I_REQPASSWORD.'</a><br>';
						
						echo '<div style="display:none; padding-top:20px;" id="coiso" class="col-xs-12">';
							echo '<div class="col-xs-10 col-xs-offset-1 col-sm-4 col-md-3 col-md-offset-1">'.
							 I_PASSWORD.'
						<br><input type="password" name="pass"></div>';
							echo '<div class="col-xs-10 col-xs-offset-1 col-sm-4 col-md-3 col-md-offset-1"> '.I_NEWPASSWORD.'
						<br><input type="password" name="newpass"></div>';
							echo '<div class="col-xs-10 col-xs-offset-1 col-sm-4 col-md-3 col-md-offset-1">
							'.I_CONFIRMPASSWORD.'<br><input type="password" name="passconfirm">
							</div>';
							echo '<div style="clear:both; text-align: center;padding: 20px;">';
							echo '<button style="float:none;" type="submit" class="btn btn-info btn-circle" onclick="javascript:gravarForm(this.form, \'index.php?h=savePass&user_id='.$row[0].'&\', null); hideForm(\'coiso\');"><i class="fa fa-check"></i>
                            </button>';
                            echo '<button style="float:none; margin-left:50px;" type="submit" class="btn btn-danger btn-circle" onclick="javascript:hideForm(\'coiso\');"><i class="fa fa-times"></i>
                            </button>';
							echo'</div>';
							
						echo '</form>';
						echo '</div>';
				}
				echo '<br>';
				echo "</div>";

				echo '<div class="col-xs-12">';
				if ($row[6]==1) {
					echo '<div class="col-xs-8">';
						listUsers();
					echo '</div>';
				}
				else {
					echo '<div class="col-xs-8">';
						echo '<h3 style="text-align:center;">Não possui permissões de Administrador.</h3>';
					echo '</div>';
					
				}
				echo '<div style="clear:both;"></div>';
			echo '</div>';
		echo '</div>';
	}
}
	

if(!function_exists('create_user')){
	function create_user(){
		global $bd;
		
		echo '<h1>Novo Utilizador</h1>';
		
		echo '<form method="post" action="" name="criador">';
		echo '<h3>'.I_USER.':</h3> <input type="text" id="user" name="user" size="25"> ';
		echo '<h3>'.I_MAIL.':</h3> <input type="text" id="email" name="email" size="40">';
		echo '<h3>'.I_NOME.':</h3> <input type="text" id="nome" name="nome"  size="70"><br><br>';
		echo '<h3>'.I_PASSWORD.':</h3> <input type="password" id="pass" name="pass" size="25" >';
		echo '<h3>'.I_CONFIRMPASSWORD.':</h3> <input type="password" id="confirmpass" name="confirmpass" size="20" >';
		echo '<h3>'.I_ADMIN.':</h3> <input type="radio" name="role" value="1">'.I_YES.' ';
		echo ' <input type="radio" name="role" value="0">'.I_NO;
		echo ' <span style="margin-left:30px;""></span> ';
		echo '<h3>'.I_STATE.':</h3> <input type="radio" name="state" value="1">'.I_ACTIVE.' ';
		echo '<input type="radio" name="state" value="0">'.I_NOT_ACTIVE.' ';
		echo '<div class="col-xs-12 margin-botup20">';
		echo '<button class="btn btn-primary botao fleft" type="button" id="cancelar">Cancelar</button> ';	
		echo '<input class="btn btn-primary botao fright" type="button" id="gravar" value="Gravar" name="gravar" class="botao" />';
		echo '</div>';
		echo '</form>';

		echo '<script type="text/javascript"> 
				document.getElementById("gravar").addEventListener("click", 
					function() {
						var error_flag=false;
						var error = "";
						if($("#user").val() == "") {
							error = error + "Campo \"'.I_USER.'\" não pode ser vazio.\n";
							error_flag=true;
						}
						if($("#email").val() == "") {
							error = error + "Campo \"'.I_MAIL.'\" não pode ser vazio.\n";
							error_flag=true;
						}
						if($("#nome").val() == "") {
							error = error + "Campo \"'.I_NOME.'\" não pode ser vazio.\n";
							error_flag=true;
						}
						if(($("#pass").val() != $("#confirmpass").val()) || $("#pass").val()=="" || $("#confirmpass").val()=="") {
							error = error + "'.I_MISMATCH.'";
							error_flag=true;
						}
						if (error_flag==true) {
							alert(error);
						}
						else {
								gravarForm(this.form, \'index.php?h=saveUser\', \'index.php\');
							}
					}, false);
			</script>';

		echo '<script type="text/javascript"> 
				document.getElementById("cancelar").addEventListener("click", 
					function() {
							var a = confirm("Perderá alterações se sair sem gravar. Deseja continuar?");
							if (a) {
								window.location.replace("index.php");
							}
							else {
    						// Do nothing!
							}
					}, false);
			</script>';
	}
}


if(!function_exists('listUsers')){
	function listUsers(){
		global $bd;
		$utilizadores	= $bd->query("SELECT ID, Utilizador, Nome, Email, Activo, Administrador FROM ".BD_PREFIXO."Utilizadores WHERE ID!=".$_SESSION["S01"]);
		echo  '<form method="post" onsubmit="return false;" action="" style=" margin:0px;" id="lalala">';
		echo '<div class="table-responsive col-lg-12">';
		echo '<table class="table table-hover">';
		echo '<thead>';
		echo '<tr>',
			'<th>'.I_USER.'</th>',
			'<th>'.I_NOME.'</th>',
			'<th>'.I_ROLES.'</th>',
			'<th>'.I_STATE.'</th>',
			'<th style="text-align:right;">'.I_ACTIONS.'</th>',
		'</tr>';
		echo '</thead>';
		if($bd->tem_linhas($utilizadores)){
		echo '<script type="text/javascript">
            $(\'document\').ready(
                function(){
                    $(\'#lalala input[type=radio]\').change(function() {
                    	
                    	var operation = this.name.replace(/[\d+-]/g, \'\');
						var userid = this.name;
						userid = userid.replace(/\D/g, \'\');
    					
    					if (operation==\'state\') {
    						gravarForm(this.form, \'index.php?h=state_editor&user_id=\'+userid+\'&\', null);
    					}
    					else if (operation==\'role\') {
    						gravarForm(this.form, \'index.php?h=role_editor&user_id=\'+userid+\'&\', null);
    					}
			});  
                }
            );

        </script>';
			echo '<tbody>';
		while($row = $bd->dados($utilizadores)){
			echo '<tr>';
			echo '<td>'.$row[1].'</td>';
			echo '<td>'.$row[2].'</td>';
				echo '<td>';
				
				if ($row[5]==1) {
					echo  '<span>'.I_ADMIN.'<input type="radio" name="role-'.$row[0].'" value="1" checked></span>';
					echo  '<span>'.I_USER.'<input type="radio" name="role-'.$row[0].'" value="0"></span>';
				}
				else {
					echo  '<span>'.I_ADMIN.'<input type="radio" name="role-'.$row[0].'" value="1"></span>';
					echo '<span>'.I_USER.'<input type="radio" name="role-'.$row[0].'" value="0" checked></span>';
				}
				echo '</td>';
				echo '<td>';
				if ($row[4]==1) {
					echo  '<span>'.I_ACTIVE.'<input type="radio" name="state-'.$row[0].'" value="1" checked></span>';
				echo  '<span>'.I_NOT_ACTIVE.'<input type="radio" name="state-'.$row[0].'" value="0"></span>';
				}
				else {
					echo  '<span>'.I_ACTIVE.'<input type="radio" name="state-'.$row[0].'" value="1"></span>';
				echo  '<span>'.I_NOT_ACTIVE.'<input type="radio" name="state-'.$row[0].'" value="0" checked></span>';
				}
				
				echo '</td>';
				echo '<td style="text-align:right;">';
				echo '<a class="btn btn-xs btn-danger" href="?h=userDelete&user_id='.$row[0].'">'.I_DELETE.'</a>';
				echo '</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
			echo '<a class="btn margin-botup20 btn-primary" href="?c=create_user">'.I_ADD.'</a>';
			echo '</form>';
		}

		else {
				echo '<td colspan="1" style="text-align: center; font-size:100%;">';
			echo '<a href="?c=create_user">'.I_ADD.'</a>';
			echo '</td>';
			echo '<td colspan="4" style="text-align: right; font-size:100%;">';
			echo '</td></tr>';
			echo '</tbody>';
			echo '</table>';
			
			echo '</form>';
		}
		echo '</div>';
	}
}

if(!function_exists('savePass')){
	function savePass(){
		global $bd;
		

		if (reqvlr("newpass")&&reqvlr("passconfirm")&&reqvlr("pass")) {
			$utilizador	= $bd->query("SELECT ID, Palavra FROM ".BD_PREFIXO."Utilizadores WHERE ID=".$_SESSION["S01"]);
			if ($row = $bd->dados($utilizador)) {
				if ((reqvlr("pass")==$row[1])&&(reqvlr("passconfirm")==reqvlr("newpass"))) {
					$dados=$bd->query("UPDATE ".BD_PREFIXO."Utilizadores SET Palavra = '".reqvlr("newpass")."' WHERE ID=".$_SESSION["S01"]);
					if ($dados) {
						echo 'a';
					}
					else{
					echo '0';
				}
					
				}
				else{
					echo '0';
				}
			}
		}
		else {echo '0';}
	}
}

if(!function_exists('saveUser')){
	function saveUser(){
		global $bd;
		

		if (reqvlr("user")&&reqvlr("pass")&&reqvlr("nome")&&reqvlr("email")) {
			$newutilizador	= "INSERT INTO ".BD_PREFIXO."Utilizadores ( Utilizador, Palavra, Nome, Email";
			if (!(reqvlr("role")===false)) {
			 	$newutilizador	= $newutilizador.", Administrador";
			}
			if (!(reqvlr("state")===false)) {
			 	$newutilizador	= $newutilizador.", Activo";
			}
			$newutilizador	= $newutilizador.") VALUES ('".reqvlr('user')."', '".reqvlr('pass')."', '".reqvlr("nome")."', '".reqvlr("email")."'";

			if (!(reqvlr("role")===false)) {
			 	$newutilizador	= $newutilizador.", ".reqvlr("role");
			}
			if (!(reqvlr("state")===false)) {
			 	$newutilizador	= $newutilizador.", ".reqvlr("state");
			}

			$newutilizador	= $newutilizador.")";
			$insert = $bd->query($newutilizador);
			if ($insert) {
				echo 'a';
			}
			else{
				echo '0';
			}
		}
		else {echo '0';}
	}
}

if(!function_exists('editUser')){
	function editUser(){
		global $bd;
		if (reqvlr("user") && reqvlr("nome") && (reqvlr("user")!='') && (reqvlr("nome")!='')) {
			$utilizador	= $bd->query("SELECT ID FROM ".BD_PREFIXO."Utilizadores WHERE ID=".$_SESSION["S01"]);
			if ($row = $bd->dados($utilizador)) {
					$dados=$bd->query("UPDATE ".BD_PREFIXO."Utilizadores SET Utilizador = '".reqvlr("user")."', Nome = '".reqvlr("nome")."' WHERE ID=".$_SESSION["S01"]);
					if ($dados) {
						echo 'a';
					}
					else{
						echo '0';
					}
			}
		}
		else {
			echo '3';
		}
	}
}

if(!function_exists('state_editor')){
	function state_editor(){
		global $bd;
		if (reqvlr("user_id")) {
			$user=reqvlr("user_id");
			$dados=$bd->query("UPDATE ".BD_PREFIXO."Utilizadores SET Activo = '".reqvlr("state-".$user)."' WHERE ID=".$user);
			if ($dados){
				echo 'a';
			}
			else {echo '0';}
			}
		else {echo '0';}
	}
}

if(!function_exists('role_editor')){
	function role_editor(){
		global $bd;
		if (reqvlr("user_id")) {
			$user=reqvlr("user_id");
			$dados=$bd->query("UPDATE ".BD_PREFIXO."Utilizadores SET Administrador = '".reqvlr("role-".$user)."' WHERE ID=".$user);
			if ($dados){
				echo 'a';
			}
			else {echo '0';}
			}
		else {echo '0';}
	}
}

if(!function_exists('userDelete')){
	function userDelete(){
		global $bd;
		if (reqvlr("user_id")) {
			$user=reqvlr("user_id");
			$dados=$bd->query("DELETE FROM ".BD_PREFIXO."Utilizadores WHERE ID=".$user);
			if ($dados){
				$_SESSION["ERR_A"]	= 1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_S;
				header("location: index.php");
			}
			else {
				$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: index.php");
			}
		}
		else {
			$_SESSION["ERR_A"]	= -1;
				$_SESSION["ERR_B"]	= I_DATA_SAVE_F;
				header("location: index.php");
		}
	}
}
?>