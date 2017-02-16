<?php
if(!function_exists('devolveDiscount')){
	function devolveDiscount(){
		global $bd;
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

if(!function_exists('printDiscounts')){
    function printDiscounts(){
        global $bd;
        $resposta	= $bd->query("SELECT Marca, Link, Descricao, Banner FROM Descontos WHERE Estado=1");
        $descontos 	= "";
        $i = 0;
        while($row = $bd->dados($resposta)){
            if($row[3]==null || $row[3]=='') {
                $descontos = $descontos . '<div class="col-xs-12 disc-entry-container clear-padding">
                    <div class="clear-padding disc-logo-container">
                        <img src="' . SITE_ROOT . '/es-temas/' . config(1) . '/img/cab_welogo2_square.jpg" class="disc-logo">
                    </div>
                    <div class="col-xs-12 clear-padding disc-info-container">
                        <h5 class="disc-brand-name"><a href="'.$row[1].'" target="_blank">'.$row[0].'</a></h5>
                        <p class="disc-brand-text">'.$row[2].'</p>
                    </div>
                </div>';
            }
            else {
                $descontos = $descontos . '<div class="col-xs-12 disc-entry-container clear-padding">
                    <div class="clear-padding disc-logo-container">
                        <img src="' . SITE_ROOT . DATA_DIR . '/banner/'.$row[3].'" class="disc-logo">
                    </div>
                    <div class="col-xs-12 clear-padding disc-info-container">
                        <h5 class="disc-brand-name"><a href="'.$row[1].'" target="_blank">'.$row[0].'</a></h5>
                        <p class="disc-brand-text">'.$row[2].'</p>
                    </div>
                </div>';
            }
            $i++;
        }
        echo $descontos;
    }
}

?>