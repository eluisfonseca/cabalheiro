function goto(id){
	$('html, body').animate({scrollTop:$(id).offset().top}, 750);
}

function enableUpload(){
	if($("#uploadZone").length > 0){
		var uploadZone	= new Dropzone("#uploadZone", {
			dictDefaultMessage: "Largue os ficheiros aqui!<br>(Ou clique para seleccionar o ficheiro)",
			parallelUploads: 1
		});
	}
}
