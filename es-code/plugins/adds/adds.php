<?php
if(!function_exists('devolveDiscount')){
	function devolveDiscount(){
		global $bd;
		//global $slDados;
		$resposta	= $bd->query("SELECT Marca, Link, Descricao, Banner FROM Descontos WHERE Estado=1");
		$descontos 	= array();
		$i = 0;
		while($row = $bd->dados($resposta)){
			$descontos[$i] = array('Marca' => $row[0],'Link' => $row[1],'Descricao' => $row[2], 'Banner' => $row[3]);
			$i++;
		}
		header('Content-Type: application/json');
		echo json_encode($descontos);
	}
}

if(!function_exists('printAdd')) {
    function printAdd($addID)
    {
        global $bd;
        //global $slDados;
        $resposta = $bd->query("SELECT ID, Imagem, Estado, Link FROM Adds WHERE ID=" . $addID . " AND Estado=1 AND IMAGEM IS NOT NULL
       AND IMAGEM != ''");
        $i = 0;
        $add_string = '';
        if ($addID == 1) {
            $add_string = '<div class="hidden-xs col-sm-2" id="main-recent-container-add">';
        }
        else {
            $add_string = '<div class="col-xs-12 clear-padding site-add-container">';
        }
        if ($resposta && $bd->tem_linhas($resposta)) {
            $row = $bd->dados($resposta);
            if($row[3]!=null && trim($row[3])!='') {
                $add_string = $add_string . '<a href="'.$row[3].'" target="_blank"><img class="add-img" id="add_space_' . $row[0] . '" src="' . SITE_ROOT . DATA_DIR . '/adds/' . $row[1] . '"></a>';
            }
            else {
                $add_string = $add_string . '<img class="add-img" id="add_space_' . $row[0] . '" src="' . SITE_ROOT . DATA_DIR . '/adds/' . $row[1] . '">';
            }

            $add_string = $add_string . '</div>';
            echo $add_string;
        }
        else {
            echo '<div class="col-xs-12 clear-padding site-add-placeholder"></div>';
        }
    }
}

?>