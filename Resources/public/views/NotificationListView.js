var NotificationListView = ListView.extend({
    
	events:{
		"click #newFriendsLink": "showFriends"
	},
    addOne: function(notification){
    	this.list.append(new NotificationView({model:notification}).render().el);
    	
    },
    
    render: function(){
    	$(this.el).html(template.notificationView.list());
    	this.list = $(this.el).find("#notificationList");
    	this.options.collection.fetch();
    	return this;
    },
    
    showFriends: function(){
    	this.options.newFriendsList.changeTo(this.options.newFriendsList.subSectionId, this.options.newFriendsList);
    }
});
