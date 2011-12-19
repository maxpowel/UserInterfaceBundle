var MessageView = Backbone.View.extend({
    
	tagName: "tr",
	
	events: {
		"click #message":  "showConversation",
		"change input": "checkState",
		"removeIfChecked .ckbox": "removeIfChecked"
	},
	
    initialize: function() {
    	this.render();
    },
    
      
    render: function() {
    	$(this.el).html(template.messagesView.message( this.model.toJSON()) );

      return this;
    },
    
    checkState: function(){
    	if($(".ckbox:checked").length > 0){
	    	$.each(this.options.actionButtons, function(i,button){
	    		$(button).removeClass("disabled");
	    		
	    	});
    	}else{
    		$.each(this.options.actionButtons, function(i,button){
    			$(button).addClass("disabled");
	    	});
    	}
    	
    },
    showConversation: function(event){
    	if(!$(event.target).hasClass("ckbox"))
    		console.log(event.target);
    },
    
    removeIfChecked: function(){
    	if(this.$(".ckbox:checked").length > 0){
    		//Not necessary because list is reloaded
    		//this.remove();
    		
    		this.model.destroy();
    	}
    }
});