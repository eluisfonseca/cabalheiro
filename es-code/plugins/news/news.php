<?PhP
//Nome: Notícias
//Descrição: Cria uma área de notícias

require_once("getVideoID.php");

if(!isset($slDados)){
	$slDados	= NULL;
	$slID		= NULL;
	$slTitle	= NULL;
	$slDate		= NULL;
	$slResumo	= NULL;
	$slFoto		= NULL;
	$slTexto	= NULL;
}

/*Fradelos*/
/*** A MAIS RECENTE**/
if(!function_exists('noticiaRecente')){
	function noticiaRecente(){
		global $bd;
		$resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' ORDER BY N.Data DESC LIMIT 1");

		$noticias 	= array();
		$i = 0;
		while($row = $bd->dados($resposta)){
			$noticias[$i] = array('title' => $row[0], 'seccao' => $row[1], 'video' => $row[2], 'image' => DATA_DIR.'/'.$row[3], 'data' => $row[4], 'id' => $row[5], 'autor' => $row[6] );
			$i++;
		}
		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

if(!function_exists('printnoticiaRecente')){
    function printnoticiaRecente(){
        global $bd;
        $resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' ORDER BY N.Data DESC LIMIT 1");

        $noticias 	= "";
        $i = 0;

        if(!($bd->tem_linhas($resposta))) {
            $noticias 	= '<div class="col-xs-12 col-md-9 recent-text">
                                <h3>Sorry. No content has been uploaded yet. Check back later.</h3></div>';
        }
        else {
            $noticias 	= "";
            while($row = $bd->dados($resposta)){
                $preview = "";
                if($row[2]==null || $row[2]=='') {
                    if ($row[3]!=null && $row[3]!='') {
                        $preview = '<div class="videoWrapper thumb"><img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[3].'"></div>';
                    }
                    else {
                        $preview = '<div class="videoWrapper placeholder_thumb"><img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg"></div>';
                    }
                }
                else  {
                    $videoURL = getEmbedVideo($row[2]);
                    if(!($videoURL)) {
                        if ($row[3]!=null && $row[3]!='') {
                            $preview = '<div class="videoWrapper thumb"><img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[3].'"></div>';
                        }
                        else {
                            $preview = '<div class="videoWrapper placeholder_thumb"><img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg"></div>';
                        }
                    }
                    else {
                        $preview = $videoURL;
                    }

                }
                $noticias = $noticias.'<div class="col-xs-12 recent-text">'.$preview.'

                        </div>
                        <div id="most-recent-title-container" class="col-xs-12">
                            <div class="col-xs-12 col-sm-8 col-md-10 to-upper clear-margin clear-padding" id="most-recent-title">
                                <a href="?p=post&ID='.$row[5].'"><h2>'.$row[0].'</h2></a>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-2" id="most-recent-btn-container">
                                <a id="most-recent-btn-link" href="?p=post&ID='.$row[5].'">
                                    <span> FULL POST </span>
                                    <span class="most-recent-btn-link-i-container"><i class="fa fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>';
                $i++;
            }
        }
        echo $noticias;
    }
}

/******** AS 5 mais vistas ***********/
if(!function_exists('noticiasMaisVistas')){
	function noticiasMaisVistas(){
		
		global $bd;
		$resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id WHERE Publicada = '1' ORDER BY N.View DESC LIMIT 5");
		
		$noticias 	= array();
		$i = 0;
		while($row = $bd->dados($resposta)){
			$noticias[$i] = array('title' => $row[0], 'seccao' => $row[1], 'video' => $row[2], 'image' => DATA_DIR.'/'.$row[3], 'id' => $row[5] );
			$i++;
		}
		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

if(!function_exists('noticiasMaisVistasMain')){
    function noticiasMaisVistasMain(){

        global $bd;
        $resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id WHERE Publicada = '1' ORDER BY N.View DESC LIMIT 5");

        $noticias 	= "";
        if(!($bd->tem_linhas($resposta))) {
            $noticias 	= '<div class="col-xs-12 top-five-entry-container">
                                <h5>No content has been uploaded yet.</h5></div>';
        }
        $i = 1;
        while($row = $bd->dados($resposta)){
            if ($row[3]!=null && $row[3]!='') {
                $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[3].'">';
                $noticias = $noticias.'<div class="col-xs-12 top-five-entry-container">
                            <div class="top-five-entry-position-container">
                                <h4>'.$i.'</h4>
                            </div>
                            <div class="top-five-entry-info-container">
                                <div class="top-five-entry-thumbnail-container fleft"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                </div>
                                <div class="top-five-entry-title-container fleft">
                                    <a href="?p=post&ID='.$row[5].'"><h6>'.$row[0].'</h6></a>
                                </div>
                            </div>
                        </div>';
            }
            else {
                $imageURL = getVideoThumbnailByUrl($row[2], $format = 'medium');
                if(!$imageURL || ($row[2]==null || $row[2]=='')) {
                    $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg">';;
                    $noticias = $noticias.'<div class="col-xs-12 top-five-entry-container">
                            <div class="top-five-entry-position-container">
                                <h4>'.$i.'</h4>
                            </div>
                            <div class="top-five-entry-info-container ">
                                <div class="top-five-entry-thumbnail-container fleft iwy-view-img-container"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                </div>
                                <div class="top-five-entry-title-container fleft">
                                    <a href="?p=post&ID='.$row[5].'"><h6>'.$row[0].'</h6></a>
                                </div>
                            </div>
                        </div>';
                }
                else {
                    $noticias = $noticias.'<div class="col-xs-12 top-five-entry-container">
                            <div class="top-five-entry-position-container">
                                <h4>'.$i.'</h4>
                            </div>
                            <div class="top-five-entry-info-container ">
                                <div class="top-five-entry-thumbnail-container fleft iwy-view-img-container"><a href="?p=post&ID='.$row[5].'">
                                    <img src="'.$imageURL.'"></a>
                                </div>
                                <div class="top-five-entry-title-container fleft">
                                    <a href="?p=post&ID='.$row[5].'"><h6>'.$row[0].'</h6></a>
                                </div>
                            </div>
                        </div>';
                }
            }
            $i++;
        }
        echo $noticias;
    }
}


if(!function_exists('noticiasMaisRecentesMain')){
    function noticiasMaisRecentesMain(){

        global $bd;
        $resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id WHERE Publicada = '1' ORDER BY N.Data DESC LIMIT 5 OFFSET 1");

        $noticias 	= "";
        if(!($bd->tem_linhas($resposta))) {
            $noticias 	= '<div class="col-xs-12 top-five-entry-container">
                                <h5>No content has been uploaded yet.</h5></div>';
        }
        $i = 1;
        while($row = $bd->dados($resposta)){
            if ($row[3]!=null && $row[3]!='') {
                $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[3].'">';
                $noticias = $noticias.'<div class="col-xs-12 top-five-entry-container">
                            <div class="top-five-entry-position-container">
                                <h4>'.$i.'</h4>
                            </div>
                            <div class="top-five-entry-info-container">
                                <div class="top-five-entry-thumbnail-container fleft"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                </div>
                                <div class="top-five-entry-title-container fleft">
                                    <a href="?p=post&ID='.$row[5].'"><h6>'.$row[0].'</h6></a>
                                </div>
                            </div>
                        </div>';
            }
            else {
                $imageURL = getVideoThumbnailByUrl($row[2], $format = 'medium');
                if(!$imageURL || ($row[2]==null || $row[2]=='')) {
                    $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg">';;
                    $noticias = $noticias.'<div class="col-xs-12 top-five-entry-container">
                            <div class="top-five-entry-position-container">
                                <h4>'.$i.'</h4>
                            </div>
                            <div class="top-five-entry-info-container ">
                                <div class="top-five-entry-thumbnail-container fleft iwy-view-img-container"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                </div>
                                <div class="top-five-entry-title-container fleft">
                                    <a href="?p=post&ID='.$row[5].'"><h6>'.$row[0].'</h6></a>
                                </div>
                            </div>
                        </div>';
                }
                else {
                    $noticias = $noticias.'<div class="col-xs-12 top-five-entry-container">
                            <div class="top-five-entry-position-container">
                                <h4>'.$i.'</h4>
                            </div>
                            <div class="top-five-entry-info-container ">
                                <div class="top-five-entry-thumbnail-container fleft iwy-view-img-container"><a href="?p=post&ID='.$row[5].'">
                                    <img src="'.$imageURL.'"></a>
                                </div>
                                <div class="top-five-entry-title-container fleft">
                                    <a href="?p=post&ID='.$row[5].'"><h6>'.$row[0].'</h6></a>
                                </div>
                            </div>
                        </div>';
                }
            }
            $i++;
        }
        echo $noticias;
    }
}

/*** todas de uma seccao**/
if(!function_exists('todasSeccao')){
	function todasSeccao(){
		global $bd;
		$resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' AND N.Seccao = ".reqvlr("section")." ORDER BY N.Data DESC");
		
		$noticias 	= array();
		$i = 0;
		while($row = $bd->dados($resposta)){
			$noticias[$i] = array('title' => $row[0], 'seccao' => $row[1], 'video' => $row[2], 'image' => DATA_DIR.'/'.$row[3], 'data' => $row[4], 'id' => $row[5], 'autor' => $row[6], 'resumo' => $row[7] );
			$i++;
		}
		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}



if(!function_exists('printSeccao')){
    function printSeccao(){
        global $bd;
        if(reqvlr("cat")) {
            $resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' AND N.Seccao = ".reqvlr("section")." AND N.Categoria = ".reqvlr("cat")." ORDER BY N.Data DESC");
        }
        else {
            $resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' AND N.Seccao = ".reqvlr("section")." ORDER BY N.Data DESC");
        }

        $noticias 	= "";
        if(!($bd->tem_linhas($resposta))) {
            $noticias 	= '<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                <h5>No posts in this category yet.</h5></div>';
        }
        else {
            $noticias 	= "";
            while($row = $bd->dados($resposta)){
                if ($row[3]!=null && $row[3]!='') {
                    $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[3].'">';
                    $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[5].'">'.$row[0].'</a></h5>
                                        <p>'.$row[7].'</p>
                                    </div>
                                </div>';
                }
                else {
                    $imageURL = getVideoThumbnailByUrl($row[2], $format = 'medium');
                    if(!$imageURL || ($row[2]==null || $row[2]=='')) {
                        $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg">';
                        $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[5].'">'.$row[0].'</a></h5>
                                        <p>'.$row[7].'</p>
                                    </div>
                                </div>';
                    }
                    else {

                        $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4">
                                        <a href="?p=post&ID='.$row[5].'"><img src="'.$imageURL.'"></a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[5].'">'.$row[0].'</a></h5>
                                        <p>'.$row[7].'</p>
                                    </div>
                                </div>';
                    }
                }

            }
        }

        echo $noticias;
    }
}

if(!function_exists('filterSeccao')){
    function filterSeccao(){
        global $bd;
        if(reqvlr("cat")) {
            $resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' AND N.Seccao = ".reqvlr("section")." AND N.Categoria = ".reqvlr("cat")." ORDER BY N.Data DESC");
        }
        else {
            $resposta	= $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' AND N.Seccao = ".reqvlr("section")." ORDER BY N.Data DESC");
        }

        $noticias 	= array();
        $i = 0;
        while($row = $bd->dados($resposta)){


            if ($row[3]!=null && $row[3]!='') {
                $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[3].'">';
                $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[5].'">'.$row[0].'</a></h5>
                                        <p>'.$row[7].'</p>
                                    </div>
                                </div>';
            }
            else {
                $imageURL = getVideoThumbnailByUrl($row[2], $format = 'medium');
                if(!$imageURL || ($row[2]==null || $row[2]=='')) {
                    $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg">';
                    $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[5].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[5].'">'.$row[0].'</a></h5>
                                        <p>'.$row[7].'</p>
                                    </div>
                                </div>';
                }
                else {

                    $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4">
                                        <a href="?p=post&ID='.$row[5].'"><img src="'.$imageURL.'"></a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[5].'">'.$row[0].'</a></h5>
                                        <p>'.$row[7].'</p>
                                    </div>
                                </div>';
                }
            }
        }
        echo $noticias;
    }
}

/*** todas de uma seccao**/
if(!function_exists('printCategoriasSeccao')){
    function printCategoriasSeccao(){
        global $bd;
        $resposta	= $bd->query("SELECT C.ID, C.Descricao FROM Categorias AS C WHERE C.Seccao = ".reqvlr("section")."");
        $categorias = '<ul id="section_menu_'.reqvlr("section").'">';
        if(reqvlr("cat")) {
            $categorias 	= $categorias.'<li id="all-parent"><i class="fa fa-caret-down"></i><a id="all" class="cat" href="">All</a></li>';
        }
        else {
            $categorias 	= $categorias.'<li id="all-parent" class="active" ><i class="fa fa-caret-down"></i><a id="all" class="cat" href="">All</a></li>';
        }

        while($row = $bd->dados($resposta)){
            if(reqvlr("cat") && (reqvlr("cat")==$row[0])) {
                $categorias = $categorias.'<li class="active"><i class="fa fa-caret-down"></i><a id="cat'.$row[0].'" class="cat" href="">'.$row[1].'</a></li>';
            }
            else {
                $categorias = $categorias.'<li><i class="fa fa-caret-down"></i><a id="cat'.$row[0].'" class="cat" href="">'.$row[1].'</a></li>';
            }
        }
        echo $categorias.'</ul>';
    }
}


/*** todas de uma seccao e categorias**/
//vou começar as categorias por 0
if(!function_exists('todasSeccaoCaegorias')){
	function todasSeccaoCaegorias(){
		global $bd;
		$num = reqvlr("num");
		$str = "";
		if($num>0){
			
			$i = 0;
			while($i < $num){
				if($i == 0){
					$str .= reqvlr("cat".$i);
				}else{
					$str .= ",".reqvlr("cat".$i);
				}
				$i++;
			}
			
			$str.= " AND C.ID IN (".$str.")";

		}

		$resposta = $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo, C.Descricao 
			FROM Noticias AS N 
			INNER JOIN Seccao AS S ON N.Seccao = S.Id
			INNER JOIN Categorias AS C ON N.Categoria = C.Id
			INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID
			WHERE N.Publicada = '1' AND N.Seccao = ".reqvlr("section")." ".$str." ORDER BY N.Data DESC");
		
		
		//construir o array
		$noticias 	= array();
		$i = 0;
		while($row = $bd->dados($resposta)){

			$noticias[$i] = array('title' => $row[0], 'seccao' => $row[1], 'video' => $row[2], 'image' => DATA_DIR.'/'.$row[3], 'data' => $row[4], 'id' => $row[5], 'autor' => $row[6], 'resumo' => $row[7], 'categoria' => $row[8]);
			
			$i++;
		}

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

/**********Mes e Ano*************/
if(!function_exists('todasMesAnoSeccaoCategoria')){
	function todasMesAnoSeccaoCategoria(){
		global $bd;

		$num = reqvlr("num");
		$str = "";
		if($num>0){
			
			$i = 0;
			while($i < $num){
				if($i == 0){
					$str .= reqvlr("cat".$i);
				}else{
					$str .= ",".reqvlr("cat".$i);
				}
				$i++;
			}
			
			$str.= " AND C.ID IN (".$str.")";

		}

		$resposta = $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo, C.Descricao 
			FROM Noticias AS N 
			INNER JOIN Seccao AS S ON N.Seccao = S.Id
			INNER JOIN Categorias AS C ON N.Categoria = C.Id
			INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID
			WHERE N.Publicada = '1' AND YEAR(N.Data) = '".reqvlr("ano")."' AND MONTH(N.Data) = '".reqvlr("mes")."' AND N.Seccao = ".reqvlr("section")." ".$str." ORDER BY N.Data DESC");
		
		//construir o array
		$noticias 	= array();
		$i = 0;
		while($row = $bd->dados($resposta)){
			$noticias[$i] = array('title' => $row[0], 'seccao' => $row[1], 'video' => $row[2], 'image' => DATA_DIR.'/'.$row[3], 'data' => $row[4], 'id' => $row[5], 'autor' => $row[6], 'resumo' => $row[7], 'categoria' => $row[8]);
			$i++;
		}

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

/**********Palavras Chave*************/
//está a procurar no titulo e no resumo
if(!function_exists('todasPalavrasChave')){
	function todasPalavrasChave(){
		global $bd;

		$num = reqvlr("num");
		$str = "";
		if($num>0){
			
			$i = 0;
			while($i < $num){
				if($i == 0){
					$str .= " AND ( (UPPER(N.Titulo) LIKE UPPER('%".reqvlr("pal".$i)."%') OR UPPER(N.Resumo) LIKE UPPER('%".reqvlr("pal".$i)."%')) ";
				}else{
					$str .= " OR (UPPER(N.Titulo) LIKE UPPER('%".reqvlr("pal".$i)."%') OR UPPER(N.Resumo) LIKE UPPER('%".reqvlr("pal".$i)."%'))";
				}

				$i++;
			}
			
			$str.= " )";

		}
		
		$resposta = $bd->query("SELECT N.Titulo, S.Descricao, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo, C.Descricao 
			FROM Noticias AS N 
			INNER JOIN Seccao AS S ON N.Seccao = S.Id
			INNER JOIN Categorias AS C ON N.Categoria = C.Id
			INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID
			WHERE N.Publicada = '1' ".$str." ORDER BY N.Data DESC");
		
		//construir o array
		$noticias 	= array();
		$i = 0;
		while($row = $bd->dados($resposta)){
			$noticias[$i] = array('title' => $row[0], 'seccao' => $row[1], 'video' => $row[2], 'image' => DATA_DIR.'/'.$row[3], 'data' => $row[4], 'id' => $row[5], 'autor' => $row[6], 'resumo' => $row[7], 'categoria' => $row[8]);
		}

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}


if(!function_exists('printAll')){
    function printAll(){
        global $bd;
        $resposta	= $bd->query("SELECT N.Titulo, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo FROM Noticias AS N INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' ORDER BY N.Data DESC");
        $noticias 	= "";
        if(!($bd->tem_linhas($resposta))) {
            $noticias 	= '<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                <h5>No posts in this category yet.</h5></div>';
        }
        else {
            $noticias 	= "";
            while($row = $bd->dados($resposta)){
                if ($row[2]!=null && $row[2]!='') {
                    $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[2].'">';
                    $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[4].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                }
                else {
                    $imageURL = getVideoThumbnailByUrl($row[1], $format = 'medium');
                    if(!$imageURL || ($row[1]==null || $row[1]=='')) {
                        $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg">';
                        $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[4].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                    }
                    else {
                        $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4">
                                        <a href="?p=post&ID='.$row[4].'"><img src="'.$imageURL.'"></a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                    }
                }
            }
        }

        echo $noticias;
    }
}

if(!function_exists('printBlog')){
    function printBlog(){
        global $bd;
        $resposta	= $bd->query("SELECT N.Titulo, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo FROM Noticias AS N INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID WHERE N.Publicada = '1' AND N.Seccao = '3' ORDER BY N.Data DESC");
        $noticias 	= "";
        if(!($bd->tem_linhas($resposta))) {
            $noticias 	= '<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                <h5>No posts in this category yet.</h5></div>';
        }
        else {
            $noticias 	= "";
            while($row = $bd->dados($resposta)){
                if ($row[2]!=null && $row[2]!='') {
                    $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[2].'">';
                    $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[4].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                }
                else {
                    $imageURL = getVideoThumbnailByUrl($row[1], $format = 'medium');
                    if(!$imageURL || ($row[1]==null || $row[1]=='')) {
                        $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg">';
                        $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[4].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                    }
                    else {
                        $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4">
                                        <a href="?p=post&ID='.$row[4].'"><img src="'.$imageURL.'"></a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                    }
                }
            }
        }

        echo $noticias;
    }
}


//IMPRIME SEARCH RESULTS
if(!function_exists('printSearch')){
    function printSearch(){
        global $bd;

        $num = reqvlr("num");
        $str = "";
        if(reqvlr("section")) {
            $str = $str." AND N.Seccao= '".reqvlr("section")."'";
        }
        if(reqvlr("cat") && reqvlr("cat")!=0) {
            $str = $str."AND N.Categoria= '".reqvlr("cat")."'";
        }

        if($num>0){

            $i = 0;
            while($i < $num){
                if($i == 0){
                    $str .= " AND ( (UPPER(N.Titulo) LIKE UPPER('%".reqvlr("pal".$i)."%') OR UPPER(N.Resumo) LIKE UPPER('%".reqvlr("pal".$i)."%')) ";
                }else{
                    $str .= " OR (UPPER(N.Titulo) LIKE UPPER('%".reqvlr("pal".$i)."%') OR UPPER(N.Resumo) LIKE UPPER('%".reqvlr("pal".$i)."%'))";
                }

                $i++;
            }

            $str.= " )";

        }

        $resposta = $bd->query("SELECT N.Titulo, N.UrlVideo, N.Imagem, N.Data, N.ID, A.Nome, N.Resumo
			FROM Noticias AS N
			INNER JOIN ".BD_PREFIXO."Utilizadores AS A ON N.Utilizador = A.ID
			WHERE N.Publicada = '1' ".$str." ORDER BY N.Data DESC");

        //construir o array
        $noticias 	= "";
        $i = 0;
        while($row = $bd->dados($resposta)){
            if ($row[2]!=null && $row[2]!='') {
                $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[2].'">';
                $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[4].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
            }
            else {
                $imageURL = getVideoThumbnailByUrl($row[1], $format = 'medium');
                if(!$imageURL || ($row[1]==null || $row[1]=='')) {
                    $imageTag = '<img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg">';
                    $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4"><a href="?p=post&ID='.$row[4].'">'.$imageTag.'</a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                }
                else {

                    $noticias = $noticias.'<div class="arc-entry-container" class="col-xs-12 clear-margin clear-padding">
                                    <div class="arc-entry-image-container col-xs-6 col-sm-5 col-md-4">
                                        <a href="?p=post&ID='.$row[4].'"><img src="'.$imageURL.'"></a>
                                    </div>
                                    <div class="arc-entry-info-container col-xs-6 col-sm-7 col-md-8">
                                        <h5><a href="?p=post&ID='.$row[4].'">'.$row[0].'</a></h5>
                                        <p>'.$row[6].'</p>
                                    </div>
                                </div>';
                }
            }
        }

        if(!($bd->tem_linhas($resposta))) {
            $noticias = '<h3 class="cabalheiro-color ta-center">Sorry. No posts meet your criteria.</h3>';
        }
        echo $noticias;
    }
}

/**********Funções de get*************/

/********* get de texto **************/

if(!function_exists('getNoticia')){
    function getNoticia(){
        global $bd;

        $id = reqvlr("ID");

        $resposta = $bd->query("SELECT N.Titulo, N.UrlVideo, N.Imagem, DATE_FORMAT(N.Data,'%D %M %Y'), N.Id, N.Texto FROM Noticias AS N WHERE N.Id = ".$id."");

        $noticia 	= "";
        $row = $bd->dados($resposta);
        $noticia = '<div id="post-title-container" class="col-xs-12 clear-padding">
                                <div class="col-xs-12 clear-margin clear-padding" id="post-title">
                                    <h2 id="post-title-h">'.$row[0].'</h2>
                                    <p id="post-date">'.$row[3].'</p>
                                </div>
                            </div>
                            <div id="post-text-container" class="col-xs-12 clear-padding">'.$row[5].'</div>';
        echo $noticia;
    }
}


if(!function_exists('getTexto')){
	function getTexto(){
		global $bd;

		$id = reqvlr("ID");

		$resposta = $bd->query("SELECT N.Texto FROM Noticias AS N WHERE N.Id = ".$id."");

		$noticias 	= array();
		$row = $bd->dados($resposta);
		$noticias[0] = array('texto' => $row[0]);

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

/********* get de video **************/
if(!function_exists('getVideo')){
	function getVideo(){
		global $bd;

		$id = reqvlr("ID");
		
		$resposta = $bd->query("SELECT N.UrlVideo FROM Noticias AS N WHERE N.Id = ".$id."");

		$row = $bd->dados($resposta);
        echo $row[0];
	}
}

if(!function_exists('getVideoFrame')){
    function getVideoFrame(){
        global $bd;

        $id = reqvlr("ID");

        $resposta = $bd->query("SELECT N.UrlVideo, N.Imagem FROM Noticias AS N WHERE N.Id = ".$id."");


        $row = $bd->dados($resposta);
        $preview = "";
        if($row[0]==null || $row[0]=='') {
            if ($row[1]!=null && $row[1]!='') {
                $preview = '<div class="videoWrapper thumb"><img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[1].'"></div>';
            }
            else {
                $preview = '<div class="videoWrapper placeholder_thumb"><img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg"></div>';
            }
        }
        else  {
            $videoURL = getEmbedVideo($row[0]);
            if(!($videoURL)) {
                if ($row[1]!=null && $row[1]!='') {
                    $preview = '<div class="videoWrapper thumb"><img src="'.SITE_ROOT.DATA_DIR.'/posts/'.$row[1].'"></div>';
                }
                else {
                    $preview = '<div class="videoWrapper placeholder_thumb"><img src="'.SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg"></div>';
                }
            }
            else {
                $preview = $videoURL;
            }

        }
        echo $preview;
    }
}

if(!function_exists('getID')){
    function getID(){
        global $bd;

        $id = reqvlr("ID");

        $resposta = $bd->query("SELECT N.Id FROM Noticias AS N WHERE N.Id = ".$id."");
        $row = $bd->dados($resposta);
        echo $row[0];
    }
}

/********* get de resumo **************/
if(!function_exists('getResumo')){
	function getResumo(){
		global $bd;

		$id = reqvlr("ID");
		
		$resposta = $bd->query("SELECT N.Resumo FROM Noticias AS N WHERE N.Id = ".$id."");
		
		$noticias 	= array();
		$row = $bd->dados($resposta);
		$noticias[0] = array('resumo' => $row[0]);

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

/********* get de Imagem **************/
if(!function_exists('getImagem')){
	function getImagem(){
		global $bd;

		$id = reqvlr("ID");
		
		$resposta = $bd->query("SELECT N.Imagem FROM Noticias AS N WHERE N.Id = ".$id."");
		
		$noticias 	= array();
		$row = $bd->dados($resposta);
		$noticias[0] = array('imagem' => SITE_ROOT.DATA_DIR.'/'.$row[0]);

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

/********* get de video **************/

if(!function_exists('printTitulo')){
    function printTitulo(){
        global $bd;

        $id = reqvlr("ID");

        $resposta = $bd->query("SELECT N.Titulo, N.UrlVideo, N.Imagem, DATE_FORMAT(N.Data,'%D %M %Y'), N.Id, N.Texto FROM Noticias AS N WHERE N.Id = ".$id."");

        $noticia 	= "";
        $row = $bd->dados($resposta);
        $noticia = '<div id="post-title-container" class="col-xs-12 clear-padding">
                                <div class="col-xs-12 clear-margin clear-padding" id="post-title">
                                    <h2 id="post-title-h">'.$row[0].'</h2>
                                    <p id="post-date">'.$row[3].'</p>
                                </div>
                            </div>';
        echo $noticia;
    }
}

if(!function_exists('getTitulo')){
    function getTitulo(){
        global $bd;

        $id = reqvlr("ID");

        $resposta = $bd->query("SELECT N.Titulo FROM Noticias AS N WHERE N.Id = ".$id."");

        $noticias 	= array();
        $row = $bd->dados($resposta);
        $noticias[0] = array('titulo' => $row[0]);

        header('Content-Type: application/json');
        echo json_encode($noticias);
    }
}

/********* get Seccao **************/
if(!function_exists('getSeccao')){
	function getSeccao(){
		global $bd;

		$id = reqvlr("ID");
		
		$resposta = $bd->query("SELECT S.Descricao FROM Noticias AS N INNER JOIN Seccao AS S ON N.Seccao = S.Id WHERE N.Id = ".$id."");
		
		$noticias 	= array();
		$row = $bd->dados($resposta);
		$noticias[0] = array('seccao' => $row[0]);

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

/********* get Categoria **************/
if(!function_exists('getCategoria')){
	function getCategoria(){
		global $bd;

		$id = reqvlr("ID");
		
		$resposta = $bd->query("SELECT C.Descricao FROM Noticias AS N 
			INNER JOIN Categorias as C ON N.Categoria = N.Id WHERE N.Id = ".$id."");
		
		$noticias 	= array();
        $i = 0;
		$row = $bd->dados($resposta);
		$noticias[$i] = array('categoria' => $row[0]);

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}

/********* get Utilizador **************/
if(!function_exists('getUtilizador')){
	function getUtilizador(){
		global $bd;

		$id = reqvlr("ID");
		
		$resposta = $bd->query("SELECT U.Nome FROM Noticias AS N INNER JOIN es_Utilizadores AS U ON N.Utilizador = U.ID WHERE N.Id = ".$id."");
		
		$noticias 	= array();
        $i = 0;
		$row = $bd->dados($resposta);
		$noticias[$i] = array('Utilizador' => $row[0]);

		header('Content-Type: application/json');
		echo json_encode($noticias);
	}
}


if(!function_exists('addView')){
    function addView(){
        global $bd;

        $id = reqvlr("ID");

        $resposta = $bd->query("UPDATE Noticias SET View = View+1 WHERE Id = ".$id."");

        if($resposta) {
            return true;
        }
        else {
            return false;
        }
    }
}

if(!function_exists('printSocialHeader')) {
    function printSocialHeader() {

        global $bd;

        if(reqvlr('ID') && (reqvlr('p') && trim(reqvlr('p'))=='post') ) {
            $id = reqvlr("ID");

            $resposta = $bd->query("SELECT N.Titulo, N.UrlVideo, N.Imagem, DATE_FORMAT(N.Data,'%D %M %Y'), N.Id, N.Texto, N.Resumo FROM Noticias AS N WHERE N.Id = ".$id."");

            if($bd->tem_linhas($resposta)) {
                $row = $bd->dados($resposta);

                $imageTag = "";

                if ($row[2]!=null && $row[2]!='') {
                    $imageTag = SITE_ROOT.DATA_DIR.'/posts/'.$row[2].'';
                }
                else {
                    $imageURL = getMaxVideoThumbnailByUrl($row[1], 'medium');
                    if(!$imageURL || ($row[1]==null || $row[1]=='')) {
                        $imageTag = SITE_ROOT.DATA_DIR.'/cab_welogo2.jpg';
                    }
                    else {
                        $imageTag = $imageURL;
                    }
                }

                echo '<html itemscope itemtype="http://schema.org/Article">';
                echo '<title>'.$row[0].' - The Original Cabalheiro</title>'
                    .'<meta name="description" content="'.$row[6].'" />';
                //<!-- Schema.org markup for Google+ -->
                echo '<meta itemprop="name" content="'.$row[0].' - The Original Cabalheiro">'
                    .'<meta itemprop="description" content="'.$row[6].'">'

                    .'<meta itemprop="image" content="'.$imageTag.'">';
                //<!-- Twitter Card data -->
                echo '<meta name="twitter:card" content="summary_large_image">'
                    .'<meta name="twitter:title" content="'.$row[0].' - The Original Cabalheiro">'
                    .'<meta name="twitter:description" content="'.$row[6].'">';
                //<!-- Twitter summary card with large image must be at least 280x150px -->
                echo '<meta name="twitter:image:src" content="'.$imageTag.'">';
                //<!-- Open Graph data -->.'<meta property="og:url" content="http://www.cabalheiro.com/index.php?p=post&ID='.$id.'" />'
                echo '<meta property="og:title" content="'.$row[0].' - The Original Cabalheiro" />'
                    .'<meta property="og:type" content="article" />'
                    .'<meta property="og:image" content="'.$imageTag.'" />'
                    .'<meta property="og:description" content="'.$row[6].'" />'
                    .'<meta property="og:site_name" content="The Original Cabalheiro" />';
            }
            else {
                return '0';
            }
        }
        else {
            echo '0';
        }
    }
}

?>
