var UploadedResumeView = Backbone.View.extend({
    
    className: "popover fade below in",
    /*events: {
    	"keypress #new-share":  "createOnEnter",
    	"click #more-newness":  "loadMoreNewness"
    },*/
    
    
    initialize: function() {
    	

    },
	
    render: function(){
    	
    	$(this.el).html(template.appView.uploadResume( ));
    	$(this.el).css({display: "block"})
    	
    	var button = this.options.element;
    	var pos = button.offset();
		var pop = $(this.el);
		$("body").append(pop)
		var height = button.height();
		var width = button.width();
		
		var actualWidth =  pop.width();
        var actualHeight =  pop.height();
        
	    var offset = 25
	    
	    var tp = {top: pos.top + height +offset, left: pos.left + width / 2 - actualWidth / 2}
	    
	    pop.css(tp);
	    $(pop).find("#resume-but").button('toggle');
	    
    	
    }
});
