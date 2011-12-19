var ProfileSectionView = Backbone.View.extend({
	className: "container-fluid",
    events: {
    	"click #newness-pill": "showNewness",
    	"click #aboutMe-pill": "showAboutMe",
    	"click #sendMessage-pill": "showSendMessage",
    	"click #albums-pill": "showAlbums"
    },
    
    initialize: function() {
    	this.userId = this.options.userId;
    	this.favouriteList = new FavouriteList();
    	this.personalInfo = new PersonalInfo();
    	this.favouriteList.bind('reset', this.renderFavourites, this);
    	this.personalInfo.bind('change', this.renderPersonalInfo, this);
    },
    
    renderFavourites: function(){
    	this.favourites.html(template.profileView.favourites( {favourites:this.favouriteList.toJSON() }));
    },
    renderPersonalInfo: function(){
    	this.personalInfoCont.html(template.profileView.personalInformation( this.personalInfo.toJSON() ));
    	

    },
    
    render: function(){
    	var params = this.options;
    	//params.thumbnail = window.getViewer().get('thumbnail');
    	params.thumbnail = "http://placehold.it/170x150";
    	params.isOwner = false;
    	params.friendName = "Pepito";
		$(this.el).html(template.section.profile( params ));
		
		

	      this.subSections = this.$(".subSection");
	      this.newnessList = this.$("#newness-list");
	      this.aboutMe = this.$("#aboutMe");
	      this.sendMessage = this.$("#sendMessage");
	      this.albums = this.$("#albums");
	      this.activePill = this.$(".active");
	    
	      
	      this.favourites = $(this.el).find("#favourites-cont");
	      this.favouriteList.fetch({data:{id:this.userId}});
	      
	      
	      this.personalInfoCont = $(this.el).find("#personalInfo-cont");
	      this.personalInfo.fetch({data:{id:this.userId}});
	    
	      
	      //personalInfo.html(template.profileView.personalInformation( {name:"cosas"}));
	      
	      this.showNewness(null);
	      return this;
	      
		/*var favouritesList;
		var photos;
		var friends;
		var profileGadget;
		//
    	var newnessList = new NewnessListView({ collection: new NewnessList()});

    	var notificationList = new NotificationListView({ collection: new NotificationList()});

    	var contactSuggestionList = new ContactSuggestionListView({ collection: new ContactSuggestionList()});

    	var nearbyTaskList = new AgendaNearbyTaskListView({ collection: new AgendaNearbyTaskList()});
    	
    	var meetingList = new MeetingListView({ collection: new MeetingList()});
		*/
    	
    },
    
    changeToSimple: function(subSection,event){
    	//Se hace así (en vez de pasar un objeto nuevo) para sólo cargarlos una vez
    	this.subSections.filter(":visible").hide();
    	
    	subSection.show();
    	this.activePill.removeClass("active");
    	if(event != null)
    		this.activePill = $(event.currentTarget).parent();
    	
    	this.activePill.addClass("active");
    },
    showNewness: function(event){
    	this.changeToSimple(this.newnessList,event);
    	if(this.newness == null){
    		var newness = new NewnessListView({collection: new NewnessList()});
    		this.newness = newness;
    		$(this.el).find("#newness-container").html(this.newness.render().el);
    	}
    	
    	
    },
    showAboutMe: function(event){
    	this.changeToSimple(this.aboutMe,event);
    	if(this.aboutMeView == null){
    		var aboutMe = new AboutMe();
    		aboutMe.fetch({data:{profile:1}});
    		this.aboutMeView = new AboutMeView({model: aboutMe});
    	}
    },
    showSendMessage: function(event){
    	this.changeToSimple(this.sendMessage,event);
    	if(this.sendMessageView == null){
    		/*var aboutMe = new AboutMe();
    		aboutMe.fetch({data:{profile:1}});
    		this.aboutMeView = new AboutMeView({model: aboutMe});*/
    		this.sendMessageView = new NewMessageFormView({
    				to:{ 
    					name: "Un pavo",
    					id: this.options.id
    				}
    		});
    		
    		$(this.el).find("#sendMessage-container").html(this.sendMessageView.render().el);
    		//.html();
    	}
    },
    showAlbums: function(){
    	
    }
});
