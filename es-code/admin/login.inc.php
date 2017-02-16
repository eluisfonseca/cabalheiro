<?PhP
function login(){
	global $bd;
	$log	= $bd->query("SELECT ID, Nome FROM ".BD_PREFIXO."Utilizadores WHERE Utilizador = '".reqvlr('Utilizador')."' AND Palavra = '".reqvlr('Palavra')."'");
	if($bd->num_linhas($log) == 1){
		$row				= $bd->dados($log);
		$_SESSION["S01"]	= $row[0];
		$_SESSION["S02"]	= $row[1];
		
		$_SESSION["ERR_A"]	= 1;
		$_SESSION["ERR_B"]	= I_USER_AUTH_S;
		header("location: ?p=index");
	}else{
		$_SESSION["ERR_A"]	= -1;
		$_SESSION["ERR_B"]	= I_USER_AUTH_F;
		header("location: ?p=login");
	}
}
?>
