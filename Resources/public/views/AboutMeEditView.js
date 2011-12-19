var AboutMeEditView = Backbone.View.extend({
    
    initialize: function() {

    },
    
      
    render: function() {
    	
    	$(this.el).html(template.preferencesView.aboutMe({elements:[{title:"hola", body:"que tal"}]} ));

      return this;
    }
});