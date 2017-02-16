var file	= null;
var nome	= null;
var campo	= null;
var img 	= null;
/*
destino -> caminho até a imagem
imagem -> nome na base de dados
*/
function ExpAbrir(destino, imagem){
	campo	= destino;
	img		= imagem;
	if (!(campo == null || campo.length === 0 || campo === undefined || campo === null)) {
		window.open("?h=explorador&c="+campo, "_blank", "width=700,height=400");
	}
	else {
		window.open("?h=explorador", "_blank", "width=700,height=400");
	}
	
}

function ExpAbrir2(destino, imagem, campo_form){
	nome = campo_form;
	campo	= campo_form;
	img		= imagem;
	if (!(destino == null || destino.length === 0 || destino === undefined || destino === null)) {
		window.open("?h=explorador&c="+destino, "_blank", "width=700,height=400");
	}
	else {
		window.open("?h=explorador", "_blank", "width=700,height=400");
	}
	
}

function ExpGetDestino(){
	return campo;
}
//Devolve nome da imagem
function ExpGetImagem(){
	return img;
}

/*
 muda o valor do campo do formulário para o nome da nova imagem escolhida
 muda o src da imagem para esta
*/
function ExpSet(){
	window.opener.document.getElementById(window.opener.ExpGetDestino()).value	= nome;
	window.opener.document.getElementById(window.opener.ExpGetImagem()).setAttribute("src",file);
	window.close();
}
function ExpChoose(dest, ficheiro){
	file	= dest;
	nome	= ficheiro;
}
function ExpEnviar(){
	document.forms.item(0).submit();
}
function ExpRename(){
	if(nome != null){
		document.forms.item(0).elements.item(0).value	= nome;
		document.forms.item(0).submit();
	}
}
function ExpRemove(){
	if(nome != null){
		document.forms.item(1).elements.item(0).value	= nome;
		document.forms.item(1).submit();
	}
}

/*Função ai buscar nome do campo onde quero por o caminho para o ficheiro.
Admin: variável javascript onde guardo nome da variável onde guardar valor. 
Explorador: parent.
*/

