<?PhP
function theID(){
	global $esID;
	return $esID;
}
function theTitle(){
	global $esTitle;
	return $esTitle;
}
function theLink(){
	global $esLink;
	return $esLink;
}
function theTarget(){
	global $esTarget;
	if($esTarget == 1){
		return '_self';
	}else{
		return '_blank';
	}
}
function theContent(){
	global $esContent;
	return $esContent;
}

function theisParent(){
    global $isParent;
    return $isParent;
}

?>
