<?PhP

if(!function_exists('trataComboCategoria')){
    function trataComboCategoria(){
    	if(isset($_POST['get_option'])){
        	global $bd;

         	$sec = $_POST['get_option'];
         	$resp = $bd->query("SELECT Id, Descricao FROM Categorias WHERE Seccao = ".$sec."");
         	while($row = $bd->dados($resp)){
           		echo "<option value=".$row[0].">".$row[1]."</option>";
         	}
       
        	exit;
     	}
    }
}
?>