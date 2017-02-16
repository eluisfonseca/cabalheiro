<?php
if(!function_exists('devolveFaq')){
	function devolveFaq(){
		global $bd;
		$resposta	= $bd->query("SELECT Pergunta, Resposta FROM faq");
		$faq 	= array();
		while($row = $bd->dados($resposta)){
			$faq[] = array('Pergunta' => $row[0], 'Resposta' => $row[1]);
		}
		header('Content-Type: application/json');
		echo json_encode($faq);
	}
}

if(!function_exists('printFaq')){
    function printFaq(){
        global $bd;
        $resposta	= $bd->query("SELECT Pergunta, Resposta FROM faq ORDER BY Id ASC");
        $faq 	= "";
        while($row = $bd->dados($resposta)){
            $faq = $faq.'<div class="col-xs-12 faq-entry-container clear-padding">
                        <div class="col-xs-12 clear-padding faq-title-container">
                            <div class="col-xs-12 clear-margin clear-padding faq-title">
                                <h5 class="faq-title-h">'.$row[0].'</h5>
                            </div>
                        </div>
                        <div class="col-xs-12 clear-padding faq-text-container">
                            <p>'.$row[1].'</p>
                        </div>
                    </div>';
        }
        echo $faq;
    }
}
?>
