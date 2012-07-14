var SecurityView = Backbone.View.extend({
    
	events: {
    	"click #manageGroups-btn":  "loadGroups"
    },
    initialize: function() {
    	this.permissions = new PermissionList();
    	this.permissions.bind('reset', this.addAll, this);
    	
    	//
    	this.profilePermissions = new PermissionList();
    	this.profilePermissions.url = this.profilePermissions.url+"UserProfile/"+getViewer().get("id");
    	//
    	this.profilePermissions.bind('add',   this.addOneProfilePermission, this);
        this.profilePermissions.bind('reset', this.addAllProfilePermissions, this);
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
    
    addAllProfilePermissions: function(){
    	
    	this.profilePermissionContainer = this.$el.find("#permissionsBody");
    	var self = this;
    	this.profilePermissions.each(function(permission){
      	  self.addOneProfilePermission(permission,self);
        });
    },
    
    addOneProfilePermission: function(permission){
    	
    	this.profilePermissionContainer.append(new PermissionSimpleEntryView({model: permission}).render().el)
    },
    
    render: function() {
    	
    	$(this.el).html(template.preferencesView.security());
    	this.permissions.fetch();
    	
    	this.profilePermissions.fetch();
    	var self = this
    	this.$el.find("#newPermissionEntity").typeahead({
			source: "/autocomplete/contactsGroups",
			onSelect: function(item){
				self.profilePermissions.add(new Permission({isNew: true, read_granted:1, read_denied:0, write_granted:1, write_denied:0, object_id: getViewer().get("id") ,type: item.data, object_type: "UserProfile", entity_id: item.id, name: item.value}));
				
			}

    	});
    	
      return this;
    }
});