var PermissionRowView = Backbone.View.extend({
    tagName:"tr",
    events: {
    	"click #save-btn":  "saveChanges",
    	"click #delete-btn":  "deletePermission"
    },
    
    
    initialize: function() {
    	

    },
	
    saveChanges: function(){
    	this.model.set({
    			readGranted: this.$el.find("#readGranted").is(":checked"),
    			readDenied: this.$el.find("#readDenied").is(":checked"),
    			writeGranted: this.$el.find("#writeGranted").is(":checked"),
    			writeDenied: this.$el.find("#writeDenied").is(":checked"),
    	})
    	this.model.save();
    },
    
    deletePermission: function(){
    	var self = this;
    	this.model.destroy({
    	success:function(){
    		self.$el.remove()
    	}
    	,
    	error:function(){
    		alert("Error while deleting permission")
    	}});
    },
    
    render: function(){
    	$(this.el).html(template.preferencesView.permissionRow( {permission: this.model.toJSON()} ));
    	return this;
    }
});
