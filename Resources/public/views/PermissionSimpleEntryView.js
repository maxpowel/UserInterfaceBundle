var PermissionSimpleEntryView = Backbone.View.extend({
    tagName: "tr",
    events:{
    	"click #remove-btn":"removePermission",
    	"click #save-btn":"savePermission"
    },
    
    removePermission: function(){
    	this.model.destroy();
    },
    
    savePermission: function(){
    	this.model.save();
    },
    
    render: function() {
    	
    	$(this.el).html(template.permission.simpleEntry({name: this.model.get('name'), type:this.model.get('type')}));

      return this;
    }
});