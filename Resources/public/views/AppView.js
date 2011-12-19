var AppView = Backbone.View.extend({
	actualSection: null,
	topbar: null,
	toolbar: null,
	sectionContainer: null,
	activeMenuSection: function( section ){
		//Activate the menu toolbar button
		this.topbar.find(".active").removeClass("active");
		this.topbar.find("#menu-"+section).addClass("active");
	},
	  
	clean: function(){
		if(this.actualSection != null){
			  this.actualSection.unbind();
			  this.actualSection.remove();
		}
	},
    loadView: function(view){
	    this.clean();
        this.actualSection = view;
	    this.sectionContainer.html(view.render().el);
    },
	initialize: function() {
		this.render();
		this.topbar = $(this.el).find("#topbar");
		this.sectionContainer = $(this.el).find("#content"); 
		var app = this;
		var Controller = Backbone.Router.extend({
			  topbar: $("#topbar"),
			  
			  routes: {
			    "start":                 "loadStart",
			    "search":                 "loadSearch",
			    "messages":                 "loadMessages",
			    "agenda/:year/:month":   "loadAgenda",
			    "agenda":   "loadAgenda",
			    "profile/:id":           "loadProfile",
			    "profile":           "toProfile",
			    "multimedia/:id":             "loadMultimedia",
			    "multimedia":                 "toMultimedia",
			    "preferences":             "loadPreferences",
			    "" :"goToStart"
			  },
			  goToStart: function(){
				  this.navigate("start", true);
			  },
			  
			  loadStart: function() {
				  app.activeMenuSection("start");
				  app.loadView(new StartSectionView());
			  },

			  loadProfile: function(id) {
				  app.activeMenuSection("profile");
				  app.loadView(new ProfileSectionView({userId:id}));
				  /*
				  this.activeMenuSection("profile");
				  
				  var view = new ProfileSectionView({profileId:id});*/
			  },
			  
			  toProfile: function() {
				  this.navigate("profile/"+getViewer().get('id'),true);
				  //this.activeMenuSection("profile");
				  
				  //var view = new ProfileSectionView();
			  },
			  
			  loadPreferences: function() {
				  app.activeMenuSection("preferences");
				  app.loadView(new PreferencesSectionView());
				  /*
				  this.activeMenuSection("profile");
				  
				  var view = new ProfileSectionView({profileId:id});*/
			  },
			  
			  loadMultimedia: function(id) {
				  app.activeMenuSection("multimedia");
				  app.loadView(new MultimediaSectionView({profileId:id}));
				  /*
				  this.activeMenuSection("profile");
				  
				  var view = new ProfileSectionView({profileId:id});*/
			  },
			  
			  toMultimedia: function() {
				  this.navigate("multimedia/"+getViewer().get('id'),true);
				  //this.activeMenuSection("profile");
				  
				  //var view = new ProfileSectionView();
			  },
			  
			  loadAgenda: function(year, month) {
				  app.activeMenuSection("agenda");
				  if(app.sections.agenda == null)
					  app.sections.agenda = new AgendaSectionView();
				  app.sectionContainer.html(app.sections.agenda.el);
			  },
			  
			  loadSearch: function() {
				  this.activeMenuSection("search");
				  
				  var view = new SearchSectionView();
			  },
			  
			  loadMessages: function() {
				  app.activeMenuSection("messages");
				  app.loadView(new MessagesSectionView());
			  }

			});

			Backbone.emulateHTTP = true;
			var controller = new Controller();
			this.toolbar = new ToolbarView({router: controller, el: $(this.el).find("#topbar")});
			this.toolbar.render();
			Backbone.history.start();
			
			//var template = _.template( this.template, this.options);
			//$(this.el).html(template);
	},

	//Estos estan en toolbar
	/*quickSearch: function ( event ){
		text = $(event.currentTarget).val();
		
		if(event.keyCode == 13){
			this.options.router.navigate("search/"+text,true);
			$("#quick-search-result").removeClass('open');
		}else{
			//Autocomplete
			$("#quick-search-result").addClass('open');
		}

	},
	
	onBlurQuickSearch: function(){
		$("#quick-search-input").val('');
	},
	
	cancelSubmit: function(){
		return false;
	},*/
	
	render: function(){
		$(this.el).html(template.appView.app());
	}
	
});
