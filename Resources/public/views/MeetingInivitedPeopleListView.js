var MeetingInvitedPeopleListView = Backbone.View.extend({
    input: null,	
    invitedList: null,
    events: {
    	"click #invite-but":  "invite"
    },
	
	
    initialize: function() {
    	this.invitedPeople = new PeopleList();
    	this.invitedGroups = new GroupList();
    	
        this.invitedPeople.bind('add',   this.addOnePerson, this);
        this.invitedPeople.bind('remove', this.removeOnePerson, this);
        this.invitedGroups.bind('add',   this.addOneGroup, this);
        this.invitedGroups.bind('remove', this.removeOneGroup, this);
        
    },
    
    callBackFunction: function(item){
    	console.log("Bieeen");
    	
    },
    
    invite: function(){
    	var entryType = this.input.attr("entrytype");
    	if( entryType == "person"){
    		//Do person things
    	}else if(entryType == "group"){
    		//Do group things
    	}else{
    		//External person
    		var person = new User();
    		person.set({type:"external",  name: $.trim(this.input.val())});
    		this.invitedPeople.add(person);
    	}
    	this.input.attr({entrytype: null});
    	this.input.val("");
    },
    
    addOnePerson: function(person) {
      var view = new MeetingInvitedPeopleEntryView({type:"person", model: person });
      this.invitedList.append(view.render().el);
      
    },
    removeOnePerson: function(person) {
        person.destroy();
    },
    
    addOneGroup: function(group) {
    	
        var view = new MeetingInvitedPeopleEntryView({type:"group", model: group });
        this.invitedList.append(view.el);
      },
    removeOneGroup: function(group) {
          group.destroy();
      },
    
    
    render: function() {
    	
    	$(this.el).html(template.meetingView.invitedPeopleList());

    	this.invitedList = $(this.el).find("#invited-people");
    	//
		var callBackFunction = this.callBackFunction;
		this.input = $(this.el).find("input");
    	$(this.el).find("input").autocomplete("/contacts",
    			{    minChars: 2,
    				 mustMatch: true,
	            	 formatItem: function(data, i, n) {
	            		 
	            		 //return "hola";
	            		 
	            		 
	                     return "<div style='height:40px'><img style='float:left' src='" + data[2] + "'/> <a style='margin-left: 10px' href='javascript:void(0)'>" + data[0]+"</a></div>";
	             }

    			}).result(function(event, item) {
    				callBackFunction(item);
    			});
    	
      return this;
    }
});
