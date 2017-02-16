<?PhP
function run_hooks($hook){
	global $esHooks;
	foreach($esHooks[$hook] as $funcao){
		$funcao();
	}
}

?>
