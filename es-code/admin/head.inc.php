<?PhP
function head(){
	global $bd;
	global $esJSInit;
	global $esJSResize;

	/*<!-- Bootstrap core CSS -->*/
    echo '<link href="' . SITE_ROOT . '/es-admin/temas/' . config(7) . '/css/bootstrap.css" rel="stylesheet">';
    echo '<link href="' . SITE_ROOT . '/es-admin/temas/' . config(7) . '/css/style.css" rel="stylesheet" type="text/css" />';

    /*<!-- Add custom CSS here -->*/
     echo '<link href="' . SITE_ROOT . '/es-admin/temas/' . config(7) . '/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css" />';
      echo '<link href="' . SITE_ROOT . '/es-admin/temas/' . config(7) . '/css/plugins/dataTables.bootstrap.css" rel="stylesheet">';
    echo '<link href="' . SITE_ROOT . '/es-admin/temas/' . config(7) . '/css/sb-admin-2.css" rel="stylesheet" type="text/css" />';
    echo '<link href="' . SITE_ROOT . '/es-code/js/bootstrapselect/bootstrap-select.min.css" rel="stylesheet">';
    echo '<link href="' . SITE_ROOT . '/es-admin/temas/' . config(7) . '/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">';
	
	echo '<link href="' . SITE_ROOT . '/es-code/admin/explorer/explorer.css" rel="stylesheet" type="text/css" />';
	echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/jquery-1.11.1.js"></script>';
	echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/tinymce/tinymce.min.js"></script>';
	echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/jquery.maxlength-min.js"></script>';
	echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/explorador.js"></script>';
	echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/dropzone.js"></script>';
	echo '<script type="text/javascript" src="' . SITE_ROOT . '/es-code/js/admin.js"></script>';

	addJSinit('preventLinks();');
	/*ADICIONEI ISTO PARA IMPEDIR QUE ADICIONE UM POR CADA MÓDULO QUE USE O DROPZONE*/
	addJSInit('Dropzone.autoDiscover		= false;');
	addJSInit('enableUpload();');
	/**/
	run_hooks('admin_head');
	echo '<script type="text/javascript">';
	echo '$(document).ready(function(){';
	foreach($esJSInit as $funcJS){
		echo $funcJS;
	}
	echo '});';
	
	echo '$(window).resize(function(){';
	foreach($esJSResize as $funcJS){
		echo $funcJS;
	}
	echo '});</script>';
}
?>
