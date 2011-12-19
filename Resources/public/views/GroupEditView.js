var GroupEditView = Backbone.View.extend({
	subSectionId: "edit-sub",
	buttonClass: "primary",
	/*events: {
		"click .load": "loadAlbum"
	},
	*/
    initialize: function() {

    },
    

    render: function() {
    	/*this.model.set({name:"jajajajaja"})
    	$(this.el).html(this.model.get("name"));
    	this.model.save();*/
    	
    	$(this.el).html(template.preferencesView.editGroup({name: this.model.get("name")}));
    	this.memberListContainer = $(this.el).find("#memberList");
    	this.model.getMemberList();
    	

      return this;
    }
});