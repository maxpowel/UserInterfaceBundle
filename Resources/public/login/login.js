$(document).ready(function(){

	new LoginApp({el: $("#content")});
	var loadTimeout = null;//Used to avoid disturb when fast loadings 
	$("#loading").hide().ajaxStart(function(){
		var e = $(this);
		loadTimeout = setTimeout(function(){
			e.show();
		},1200);
		   
	}).ajaxStop(function(){
		clearTimeout(loadTimeout);
		$(this).hide();
	});
});
