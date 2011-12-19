var ToolbarView = Backbone.View.extend({
	uploadPhotosWindow: null,
	totalFileSize: 0,
	uploader: null,
	uploading: false,
	uploadRefreshInterval: null,
	files: null,
	fileCounter: 0,
	percentCont: null,
	events: {
			"keypress #quick-search-input": "quickSearch",
			"blur #quick-search-input": "onBlurQuickSearch",
			"submit #quick-search-form": "cancelSubmit",
			"click #uploadPhotos-but": "uploadPhotosForm"
	},
	initialize: function() {
		this.bind('uploading', this.changeToUploading, this);
		this.uploader = new UploaderView({context: this});
		$(this.el).dropdown();
		this.percentCont = $(this.el).find("#totalPercent");
	},
  
	quickSearch: function ( event ){
		text = $(event.currentTarget).val();
		
		if(event.keyCode == 13){
			this.options.router.navigate("search/"+text,true);
			$("#quick-search-result").removeClass('open');
		}else{
			//Autocomplete
			$("#quick-search-result").addClass('open');
		}

	},
	
	uploadFile: function(files,index){
	     var fd = new FormData();
	     var localThis = this;
	     fd.append("file", files[index]);
	     
	     var xhr = new XMLHttpRequest();
	     xhr.upload.addEventListener("progress", 
	    		 function(evt){
	    	 		if (evt.lengthComputable) {
	    	 			localThis.percentCont.text(Math.round(evt.loaded * 100 / localThis.totalFileSize));
	    	 		}
	    	 		else {
	    	 			alert('Unable to compute');
	    	 		}  
	     }, false);
	     
	     xhr.addEventListener("load", function(){
	 				localThis.fileCounter++;
	 				if(localThis.fileCounter < localThis.files.length){
	 					localThis.uploadFile(localThis.files, localThis.fileCounter);
					}else{
						//Finished all photos
						//Return to normal upload button
						var button = $(localThis.el).find("#uploadPhotos-but");
						button.find(".uploading").hide();
						button.find(".upload").show();
						localThis.uploading = false;
						
						//Show photo list resume						
						var resume = new UploadedResumeView({element: button});
						resume.render();


				       
					}
	     }, false);
	     xhr.addEventListener("error", this.uploadFailed, false);
	     //xhr.addEventListener("abort", uploadCanceled, false);
	     xhr.open("POST", "/upload");
	     xhr.send(fd);
	},
	
	uploadFailed: function(){
		alert("Error while uploading file");
	},
	
	changeToUploading: function(files){
		$(this.el).find("#uploadPhotos-but").find(".uploading").show();
		$(this.el).find("#uploadPhotos-but").find(".upload").hide();
		this.uploading = true;
		//
		this.files = files;
		this.fileCounter = 0;
		this.totalFileSize = 0;
		for(i=0; i<files.length; i++){
			this.totalFileSize += files[i].size;
		}
		
		this.uploadFile(files, 0);
	        
	},
	
	uploadPhotosForm: function(){
		if(this.uploading){
			
		}else{
			this.uploader.reset();
		    this.uploadPhotosWindow.modal('show');
		}
	},
	onBlurQuickSearch: function(){
		$("#quick-search-input").val('');
	},
	
	cancelSubmit: function(){
		return false;
	},
	
	render: function(){		
    	this.uploadPhotosWindow = $(this.uploader.render().el).modal({backdrop:true, keyboard: true});
	}
	
});