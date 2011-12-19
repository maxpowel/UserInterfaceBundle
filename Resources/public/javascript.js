window.viewer = null;

window.getViewer = function() {
	return viewer;
}
$(document).ready(function(){
	//Starts the magic	
	window.viewer = new User({id:57, thumbnail:"http://placehold.it/90x90"});
	//window.viewer.fetch({url:"/whoAmI"});
	var app = new AppView();
	$("#app").html(app.el);
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
