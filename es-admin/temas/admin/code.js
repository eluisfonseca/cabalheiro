function preventLinks() {
    $(".unobtrusive").click(function(e) {
      e.preventDefault();
    });
    return false;
  }

function displayForm(thingID){
	$( "#"+thingID ).css("display","inline");
}

function hideForm(thingID){
	$( "#"+thingID ).css("display","none");
}

function gotolocation(ele){
	$(window).scrollTop(ele.offset().top).scrollLeft(ele.offset().left);
}



$( document ).ready(function() {
   $( "#checkBi" ).change(function() {
  		if ($("#checkBi").is(":checked")) {
  			$("#diaSelect").prop("disabled", false);
  		}
  		else {
  			$('select#diaSelect option').removeAttr("selected");
  			$("#diaSelect").prop("disabled", true);

  		}
	});
});