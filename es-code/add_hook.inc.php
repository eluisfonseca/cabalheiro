<?PhP
function add_hook($hook, $funcao){
	global $esHooks;
	array_push($esHooks[$hook], $funcao);
}
?>
