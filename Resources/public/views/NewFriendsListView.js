var NewFriendsListView = Backbone.View.extend({
    
	subSectionId: "friends-sub",
	buttonClass: "info",
	persistent: true,
	rendered: false,
    /*events: {
    	"click #allMeetings-but":  "showAllMeetings",
    	"click #doMeeting-but":  "doMeeting"
    },*/
    
    
    render: function() {
    	if(this.rendered == false){
	    	this.collection = new UserList();
	    	this.collection.url = "/newContacts";
	    	
	      this.collection.bind('add',   this.addOne, this);
	      this.collection.bind('reset', this.addAll, this);
	      //this.options.collection.bind('all',   this.render, this);
	      
	      this.collection.fetch();
	      this.rendered = true;
    	}
      
      return this;
    },
    
    
    addAll: function() {
      //this.collection.each(this.addOne, this);
      $(this.el).html(template.profileView.contactListSimple( {list: this.collection.toJSON()  }));
      	this.$el.find("a").click(function (){
      		var uid = $(this).attr("uid");
      		var notification = new Notification({id: uid, type:"VirtualUserMainGroup"})
      		notification.destroy();
      });
    },
    
    /*addOne: function(contact) {
    	console.log("aa")
      //var view = new MeetingView({model: meeting });
      //this.$("#meeting-list").append(view.render().el);
    },*/
    
    /*doMeeting: function( event ){
    	this.changeTo(this.subSectionId,new DoMeetingView({collection: this.options.collection}));
    }*/
});
