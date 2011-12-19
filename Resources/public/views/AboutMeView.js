var AboutMeView = Backbone.View.extend({
    
    el: '#aboutMe',
    
    /*events: {
    	"keypress #new-share":  "createOnEnter",
    	"click #more-newness":  "loadMoreNewness"
    },*/
    
    
    initialize: function() {
    	
      this.render();
  
      //this.options.collection.fetch({data:{page:1}});*/
    },
	
    render: function(){
    	$(this.el).html(template.profileView.aboutMe( this.options ));
    }
});
