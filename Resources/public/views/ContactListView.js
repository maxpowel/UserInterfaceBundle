var ContactListView = Backbone.View.extend({
    
    initialize: function() {
      this.contactCollection = this.options.collection;
    },
    
    
    render: function(){
    	var list = this.contactCollection.toJSON();
    	list = list[0]
    	//console.log(list["out"])
    	$(this.el).html(template.profileView.contactList( {list: list  }));
    }
});
