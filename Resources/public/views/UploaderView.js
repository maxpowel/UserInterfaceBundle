var UploaderView = Backbone.View.extend({
	className:"modal hide fade",
    
	events:{
		"click .cancel": "closeWindow",
		"click .upload": "uploadFiles",
		"change input":  "updateFileInfo"
		
	},
    initialize: function() {
    	//this.model.bind('destroy', this.remove, this);
    	this.reset();
    },
    
    remove: function() {
        //$(this.el).remove();
     },
     
     destroyModel: function(){
    	 this.model.destroy();
     },
      
    render: function() {
    	//TODO hacer que esto cambie
    	$(this.el).css({display: "none"});
    	
    	$(this.el).html(template.appView.uploadPhoto());
    	

      return this;
    },
     
    updateFileInfo: function(){
    	var fInfo = $(this.el).find("#fileInfo");
    	var files = document.getElementById('files').files;
    	
        
        var tbody = $(this.el).find("tbody");
        tbody.html("");
        
        for(i=0; i <files.length; i++ ){
        	var file = files[i];
        	var fileSize = 0;
            if (file.size > 1024 * 1024)
              fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            else
              fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
            
            tbody.append(template.appView.uploadEntry({filename: file.name, size: fileSize}));
        }
        
        $(this.el).find(".upload").removeClass("disabled");
        
    	/*fInfo.find("#filename").text(file.name);
    	fInfo.find("#size").text(fileSize);*/
    	fInfo.show();
    },
    
    uploadFiles: function(){
    	if($(this).hasClass("disabled") == false){
    		this.closeWindow();
    		this.options.context.trigger('uploading',document.getElementById('files').files);
		}
    },
    reset: function(){
    	$(this.el).find(".file").val("");
		$(this.el).find(".upload").addClass("disabled");
		var tbody = $(this.el).find("tbody");
		tbody.html("");
		$(this.el).find("#fileInfo").hide();
		
    },
    
    closeWindow: function(){
    	$(this.el).modal('hide');
    }
});