var PersonalInformationView = Backbone.View.extend({
    
    initialize: function() {

    },
    
      
    render: function() {
    	
    	$(this.el).html(template.preferencesView.personalInformation({name: "Alvaro", firstName:"Garcia", email: "maxpowel@gmail.com"} ));

      return this;
    }
});