var file	= null;
var nome	= null;
var CaixaExplorador	= {
    init	: function(){
		
    },
    Select	: function(){
		if(file != null){
			var args	= top.tinymce.activeEditor.windowManager.getParams();
			var win		= args.window;
			var input	= args.input;
        	win.document.getElementById(input).value = file;
			top.tinymce.activeEditor.windowManager.close();
		}
    },
	Close	: function(){
		top.tinymce.activeEditor.windowManager.close();
	},
	Set		: function(sfile, snome){
		file	= sfile;
		nome	= snome;
	}
}
function enviar(){
	document.forms.item(0).submit();
}
function rename(){
	if(nome != null){
		document.forms.item(0).elements.item(0).value	= nome;
		document.forms.item(0).submit();
	}
}
function remove(){
	if(nome != null){
		document.forms.item(1).elements.item(0).value	= nome;
		document.forms.item(1).submit();
	}
}

