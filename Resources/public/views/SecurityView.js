var SecurityView = Backbone.View.extend({
    
	events: {
    	"click #manageGroups-btn":  "loadGroups",
    	"click #profilePermissions-btn":  "loadPermissions",
    },
    initialize: function() {

    },
    
    loadGroups: function(){
    	this.unbind();
    	
    	var manageGroups = new ManageGroupsView();
    	var groupEdit = new GroupEditView();
    	
    	var menu = new MultimenuView({original:manageGroups, subsections:[groupEdit]});
    	
    	
    	$(this.el).html(menu.render().el);
    },
    
    loadPermissions: function(){
    	
    },
    render: function() {
    	
    	$(this.el).html(template.preferencesView.security());

      return this;
    }
});