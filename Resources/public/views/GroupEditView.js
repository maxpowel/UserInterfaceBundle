var GroupEditView = Backbone.View.extend({
	subSectionId: "edit-sub",
	buttonClass: "primary",
	events: {
		"click #removeSelected-btn": "removeUsers"
	},
	
    initialize: function() {

    },
    
    removeUsers: function(){
    	var self = this;
    	$.each(this.$el.find("#memberList option:selected"),function(i,element){
    		$.getJSON("/permission/removeGroup/"+$(element).val()+"/"+self.model.get("id"), function(data){
    			if(data.error)
    				alert("Error while removing user")
    			else
    				$(element).remove();
    		});
    	});
    },
    
    render: function() {
    	/*this.model.set({name:"jajajajaja"})
    	$(this.el).html(this.model.get("name"));
    	this.model.save();*/
    	var self = this;
    	$(this.el).html(template.preferencesView.editGroup({name: this.model.get("name")}));
    	memberListContainer = $(this.el).find("#memberList");
    	this.model.getMemberList(function(list){
    		list.each(function(user){
    			memberListContainer.append("<option value='"+ user.get('id') +"'>"+ user.get('name') +"</option>");
    		});
    		memberListContainer.bind('change', function(){
    			self.$el.find("#removeSelected-btn").removeClass("disabled");
    		})
    	});
    	

      return this;
    }
});