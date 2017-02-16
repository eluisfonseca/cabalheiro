<?PhP
function title($des = FALSE, $sep = ' - '){
	global $bd;
	$string		= '<title>' . config(3);
	if($des){
		$string	.= $sep . config(5);
	}
	$string		.= '</title>';
	return $string;
}
?>
