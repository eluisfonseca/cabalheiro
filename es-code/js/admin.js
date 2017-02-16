function enableUpload(){
	if($("#uploadZone").length > 0){
		var uploadZone	= new Dropzone("#uploadZone", {
			dictDefaultMessage: "Largue os ficheiros aqui!<br>(Ou clique para seleccionar o ficheiro)",
			parallelUploads: 1,
			success: function(file, result){
				window.location.href = result;
			}
		});
	}
}

function fetch_select(val){
	$.ajax({
		type: "post",
		url: "index.php?h=trataComboCategoria&IDsec=",
		data: {
			get_option: val
		},
		success: function (response) {
		    document.getElementById("categorias").innerHTML=response; 
		}
	});
}

tinymce.init({
	height: 300,
	mode : "specific_textareas",
	editor_selector : "mceEditor",
	content_css: "content.css",
	relative_urls: false,
	entity_encoding : "named",
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor emoticons", 
	
	file_browser_callback: explorer,
	
	plugins: [
		"autolink link image lists",
		"searchreplace insertdatetime media",
		"save table emoticons paste textcolor",
		"advlist contextmenu code",
		"charmap",
	]

 });
function explorer(field_name, url, type, win) {
	tinyMCE.activeEditor.windowManager.open({
		url				: "../es-code/admin/explorer/explorer.php",
		width			: 700,
		height			: 500,
		inline			: "yes",
		close_previous	: "no",
		title			: "File Explorer"
	},{
		window			: win,
		input			: field_name
	});
}

/*$(document).ready(function(){
	alert("FUUUUUUUU!!!!");
});*/

function setTextLimit(areaID, limit) {
	$('#'+areaID).maxlength({  
    events: [], // Array of events to be triggerd   

    maxCharacters: limit, // Characters limit  

    status: true, // True to show status indicator bewlow the element   

    statusClass: "status", // The class on the status div 

    statusText: "character left", // The status text 

    notificationClass: "notification",  // Will be added when maxlength is reached 

    showAlert: false, // True to show a regular alert message   

    alertText: "You have typed too many characters.", // Text in alert message  

    slider: false // True Use counter slider   

  });
}

function setTextLimitStatus(areaID, limit, showStatus) {
	$('#'+areaID).maxlength({  
    events: [], // Array of events to be triggerd   

    maxCharacters: limit, // Characters limit  

    status: showStatus, // True to show status indicator bewlow the element   

    statusClass: "status", // The class on the status div 

    statusText: "character left", // The status text 

    notificationClass: "notification",  // Will be added when maxlength is reached 

    showAlert: false, // True to show a regular alert message   

    alertText: "You have typed too many characters.", // Text in alert message  

    slider: false // True Use counter slider   

  });
}

/*Verifica se o campo de texto (textarea, texfield, etc.) foi modificado desde o seu valor inicial.
O valor de entrada (elementID) deve ser o ID desse campo de texto sem o '#'
NÃO FUNCIONA EM TEXTAREAS COM O TINYMCE, USAR O MÉTODO EM BAIXO*/
function checkChanges(elementID){ 
	var field = document.getElementById(elementID);
	if (field.value != field.defaultValue) {
	return true;}
	else {return false;}
}

/*Verifica se o campo de texto (textarea, texfield, etc.) foi modificado desde o seu valor inicial.
Os valores de entrada devem ser o ID desse campo de texto (sem o '#') e o valor inicial mal este é carregado da base de dados.
Tal é necessário porque após o carregamento inicial do editor de texto, a única forma de obter o conteúdo do mesmo é usando o método próprio tinymce.get(elementID).getContent(), que devolve o conteúdo com as opções de formatação aplicadas. Uma vez que os browsers interpretam estas formatações, se usássemos as propriedades "value" e "defaultValue" do jquery, estas usariam as strings sem informação de formatação nas comparações.
Por exemplo, o que estaria guardado como "<p><bold>Ol&aacute;<bold></p>", seria comparado com "Olá".
FUNCIONA APENAS COM TEXTAREAS QUE USEM O TINYMCE*/
function checkEditorChanges(elementID, dfContent){
	var content = tinymce.get(elementID).getContent().replace(/(\r\n|\n|\r)/gm," ");
	var c2;
	if(typeof dfContent != 'undefined'){
		c2 = dfContent.replace(/(\r\n|\n|\r|\s)/gm," ");
		c2 = dfContent.replace(/\s+/g," ");
		c2 = c2.replace(/\s</g,"<");
		c2 = c2.replace(/>\s/g,">");
		c2 = c2.replace(/"/g,"\'");
		c2 = c2.replace(new RegExp("&amp;", 'g'), "&").replace(new RegExp("&gt;", 'g'), ">").replace(new RegExp("&lt;", 'g'), "<").replace(new RegExp("&quot;", 'g'), "\"");
		}
	else {c2 = "";}
	content = content.replace(/(\r\n|\n|\r|\s)/gm," ");
	content = content.replace(/\s</g,"<");
	content = content.replace(/>\s/g,">");
	content = content.replace(/"/g,"\'");
	content = content.replace(new RegExp("&amp;", 'g'), "&").replace(new RegExp("&gt;", 'g'), ">").replace(new RegExp("&lt;", 'g'), "<").replace(new RegExp("&quot;", 'g'), "\"");
	if (content != c2) {return true;}
	else {return false;}
}

function gravarex(form, caminho, destino){
	var dados1 = form;
	var nome, valor;
	var coisa = "";
	for(var i = 0; i < form.length; i++){
		if(form.elements[i].name.length > 0){
			if(form.elements[i].className=="mceEditor"){
				coisa	= coisa+form.elements[i].name+"="+tinymce.get(form.elements[i].id).getContent()+"&";
			}
			else{ coisa	= coisa+form.elements[i].name+"="+form.elements[i].value+"&";}
		}
	}
	var pedido	= $.ajax({url: caminho, type: "POST", data: coisa});
	pedido.done(function(saveresult){
		if(saveresult!=0) {
			alert("gravado");
			if(destino!=null) {window.location.replace(destino);}
		}
		else {alert("Erro na gravação. \n Reveja os dados e tente novamente.");}
	});
	pedido.fail(function(jqXHR, textStatus){
		alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
	})
}

function execFunc(caminho, destino) {
	var pedido	= $.ajax({url: caminho, type: "POST"});
	pedido.done(function(saveresult){
		if(saveresult!=0) {
			if(destino!=null) {
				if(saveresult=='a') {window.location.replace(destino);}
				else {window.location.replace(destino+saveresult);}
			}
		}
		else {alert("Erro na gravação. \n Reveja os dados e tente novamente.");}
	});
	pedido.fail(function(jqXHR, textStatus){
		alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
	})
}


function gravarForm(form, caminho, destino){
	var dados1 = form;
	var nome, valor;
	var coisa = "";
	for(var i = 0; i < form.length; i++){
		if(form.elements[i].name.length > 0){
			
			if(form.elements[i].className=="mceEditor"){
				var content = tinymce.get(form.elements[i].id).getContent();
				content = content.replace(new RegExp("&amp;", 'g'), "%26");
				content = content.replace(new RegExp("&", 'g'), "%26");
				coisa	= coisa+form.elements[i].name+"="+content+"&";
			}
			else{
				if(form.elements[i].type=="radio") {
					if(form.elements[i].value==$('input[name="'+form.elements[i].name+'"]:checked').val()){
						var content2=form.elements[i].value;
						coisa	= coisa+form.elements[i].name+"="+content2+"&";
					}
				}
				else {
					if(form.elements[i].type=="checkbox") {
						
						if(form.elements[i].value==$('input[name="'+form.elements[i].name+'"]:checked').val()){
							var content2=form.elements[i].value;
							coisa	= coisa+form.elements[i].name+"="+content2+"&";
						}
					}
					else {
						var content2 = encodeURIComponent(form.elements[i].value);
						coisa	= coisa+form.elements[i].name+"="+content2+"&";
					}
					
				}
			}
		}
	}
	var pedido	= $.ajax({url: caminho, type: "POST", data: coisa});
	pedido.done(function(saveresult){
		if(saveresult!=0) {
			if(destino!=null) {
				if(saveresult=='a') {window.location.replace(destino);}
				else {window.location.replace(destino+saveresult);}
			}
		}
		else {alert("Erro na gravação. \n Reveja os dados e tente novamente.");}
	});
	pedido.fail(function(jqXHR, textStatus){
		alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
	})
}



function gravarNoticias(form, caminho, destino){
	var dados1 = form;
	var nome, valor;
	var coisa = "";
	for(var i = 0; i < form.length; i++){
		if(form.elements[i].name.length > 0){
			
			if(form.elements[i].className=="mceEditor"){
				var content = tinymce.get(form.elements[i].id).getContent();
				content = content.replace(new RegExp("&amp;", 'g'), "%26");
				content = content.replace(new RegExp("&", 'g'), "%26");
				coisa	= coisa+form.elements[i].name+"="+content+"&";
			}
			else{
				if(form.elements[i].type=="radio") {
					if(form.elements[i].value==$('input[name="'+form.elements[i].name+'"]:checked').val()){
						var content2=form.elements[i].value;
						coisa	= coisa+form.elements[i].name+"="+content2+"&";
					}
				}
				else {
					if(form.elements[i].type=="checkbox") {
						alert(form.elements[i].name);
						if(form.elements[i].value==$('input[name="'+form.elements[i].name+'"]:checked').val()){
							var content2=form.elements[i].value;
							coisa	= coisa+form.elements[i].name+"="+content2+"&";
						}
					}
					else {
						var content2 = encodeURIComponent(form.elements[i].value);
						coisa	= coisa+form.elements[i].name+"="+content2+"&";
					}
					
				}
			}
		}
	}
	var pedido	= $.ajax({url: caminho, type: "POST", data: coisa});
	pedido.done(function(saveresult){
		if(Number($.trim(saveresult))!=0) {
			alert("gravado");
			if(destino!=null) {
				if($.trim(saveresult)=="a") {window.location.replace(destino);}
				else {window.location.replace($.trim(destino)+$.trim(saveresult));}
			}
		}
		else {alert("Erro na gravação. \n Reveja os dados e tente novamente.");}
	});
	pedido.fail(function(jqXHR, textStatus){
		alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
	})
}

$(document).ready(function(){

	//disable on page load
    $('#checkgeral :input').attr('disabled', true);


	$('input[type=radio][name=inlineRadio1]').change(function() {
        if (this.value == '1') {
             $('#checkgeral :input').attr('disabled', true);
			 $('#checkgeral :input').attr('checked', false);
        }
        else if (this.value == '2') {
             $('#checkgeral :input').attr('disabled', false);
        }
    });
});