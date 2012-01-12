var NewnessCommentView = Backbone.View.extend({
	tagName:"tr",
	events:{
		"click .close": "destroyModel"
	},
	
    initialize: function() {
    	this.model.bind('destroy', this.remove, this);
    },
    
    remove: function() {
        $(this.el).remove();
     },
     
     destroyModel: function(){
    	 this.model.destroy();
     },
      
    render: function() {
    	//TODO hacer que esto cambie
    	$(this.el).html(template.newnessView.newnessComment( this.model.toJSON() ));
    	
      return this;
    }
      
});