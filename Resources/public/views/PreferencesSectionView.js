var PreferencesSectionView = Backbone.View.extend({
	className: "container-fluid",
    events: {
    	"click #personal-lnk":  "loadPersonal",
    	"click #aboutMe-lnk":  "loadAboutMe",
    	"click #favourites-lnk": "loadFavourites",
    	"click #security-lnk": "loadSecurity",
    	"click #customize-lnk": "loadCustomize"
    },
    
    initialize: function() {
      
      
    },
    
    render: function(){
    	$(this.el).html(template.section.preferences());
    	this.content = $(this.el).find("#bodyContent");
    	this.loadPersonal();
		return this;
    },
    
    loadPersonal: function(){
    	var view = new PersonalInformationView();
    	this.content.html(view.render().el);
    },
    
    loadAboutMe: function(){
    	var view = new AboutMeEditView();
    	this.content.html(view.render().el);
    },
    
    loadFavourites: function(){
    	alert("hola");
    },
    
    loadSecurity: function(){
    	var view = new SecurityView();
    	this.content.html(view.render().el);
    },
    
    loadCustomize: function(){
    	alert("hola");
    }
});
