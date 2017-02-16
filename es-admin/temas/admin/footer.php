<?PhP
if((isset($_SESSION["ERR_A"])) && ($_SESSION["ERR_A"] != 0)){
	if($_SESSION["ERR_A"] == 1){
		echo '<div id="err1">'.$_SESSION["ERR_B"].'</div>';
	}elseif($_SESSION["ERR_A"] == -1){
		echo '<div id="err2">'.$_SESSION["ERR_B"].'</div>';
	}
	$_SESSION["ERR_A"]	= 0;
}



	
	

echo '<script src="' . SITE_ROOT . '/es-code/js/plugins/metisMenu/metisMenu.min.js"></script>';

echo '<script src="' . SITE_ROOT . '/es-code/js/plugins/dataTables/jquery.dataTables.js"></script>';
echo '<script src="' . SITE_ROOT . '/es-code/js/plugins/dataTables/dataTables.bootstrap.js"></script>';

 echo "<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>";

    echo "
    <script type=\"text/javascript\">
    $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
</script>
"
?>
</div>
</body>
</html>
