var NewnessView = Backbone.View.extend({
    
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

    	$(this.el).html(template.newnessView.newness(this.model.toJSON()));

      return this;
    }
});