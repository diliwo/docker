$(document).ready(function(){
    $(".dropdown-submenu>a").on("click", function(e){
        $(this).next("ul").toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});


//***dialog help overlay*** //
$(".dhelp").on("click", function() {	 
	
	if ( $(".dactive").length ) {
		$(".dhelp").next(".doverlay").fadeOut(100);
	}
	
	$(this).next(".doverlay").addClass("dactive").fadeIn(500);
	
});

$(".doverlay").on("click", function() {
	
	$(".dhelp").next(".doverlay").fadeOut(500);
	
});