var SecurityView = Backbone.View.extend({
    
	events: {
    	"click #manageGroups-btn":  "loadGroups"
    },
    initialize: function() {
    	this.permissions = new PermissionList();
    	this.permissions.bind('reset', this.addAll, this);
    },
    
    loadGroups: function(){
    	this.unbind();
    	
    	var manageGroups = new ManageGroupsView();
    	var groupEdit = new GroupEditView();
    	
    	var menu = new MultimenuView({original:manageGroups, subsections:[groupEdit]});
    	
    	
    	$(this.el).html(menu.render().el);
    },
    
    
    addAll: function() {
    	
    	this.permissions.each(this.addOne);
    },
    
    addOne: function(permission, context) {
      var view = new PermissionRowView({model: permission});
      this.$("#permissionTable").append(view.render().el);
    },
    render: function() {
    	
    	$(this.el).html(template.preferencesView.security());
    	this.permissions.fetch();
      return this;
    }
});