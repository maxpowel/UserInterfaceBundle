var AlbumOptionsFormView = Backbone.View.extend({
    removeWindow: null,
    events: {
    	"click #save-folder-btn":  "saveAlbum",
    	"click #remove-folder-btn": "removeAlbum",
    },
    initialize: function() {

    	
    },
    
    saveAlbum: function(){
    	var name = $.trim($(this.el).find("#folderName-input").val());
    	console.log(name);
    	if(name.length > 0){
    		this.options.folder.set({name:name});
    		this.options.folder.save();
    		this.options.context.backToMain();
    	}
    },
    removeAlbum: function(){
    	
    	if(this.removeWindow == null){
    		var modalTemplate = template.multimediaView.removeAlbumAsk( {folder:this.options.folder.get('name')});
    		var folder = this.options.folder;
	    	this.removeWindow = $(modalTemplate);
	    	var remWin = this.removeWindow;
	    	this.removeWindow.modal({backdrop:true, keyboard: true});
	    	this.removeWindow.find(".remove").click(function(){
	    		folder.destroy();
	    		remWin.modal('hide');
	    	});
	    	this.removeWindow.find(".cancel").click(function(){
	    		remWin.modal('hide');
	    	});
    	}
	    this.removeWindow.modal('show');

    },
    render: function() {
    	$(this.el).html(template.multimediaView.albumOptions({name:this.options.folder.get('name')}));
    	this.$el.append(new PermissionManagerSimpleView({model: this.options.folder}).render().el)
		
    	

      return this;
    }
});