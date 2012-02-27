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
	
	uploadFile: function(files,index, albumId){
	     var fd = new FormData();
	     var localThis = this;
	     var aId = albumId;
	     this.button = $(localThis.el).find("#uploadPhotos-but");
	     this.resume = new UploadedResumeView({element: this.button});
	     fd.append("file", files[index]);
	     fd.append("albumId", albumId);
	     
	     var xhr = new XMLHttpRequest();
	     xhr.upload.addEventListener("progress", 
	    		 function(evt){
	    	 		if (evt.lengthComputable) {
	    	 			localThis.percentCont.text(Math.round((localThis.totalUploaded + evt.loaded) * 100 / localThis.totalFileSize));
	    	 		}
	    	 		else {
	    	 			alert('Unable to compute');
	    	 		}  
	     }, false);
	     
	     xhr.addEventListener("load", function(evt){
	    	 		//localthis.addChisme
	    	 		var res = eval("("+evt.target.responseText+")");
	    	 		localThis.resume.addItem(res.id);
	    	 		localThis.totalUploaded += localThis.files[localThis.fileCounter].size;
	 				localThis.fileCounter++;
	 				if(localThis.fileCounter < localThis.files.length){
	 					localThis.uploadFile(localThis.files, localThis.fileCounter, aId);
					}else{
						//Finished all photos
						//Return to normal upload button
						localThis.button.find(".uploading").hide();
						localThis.button.find(".upload").show();
						localThis.uploading = false;
						
						//Show photo list resume						
						localThis.resume.render();


				       
					}
	     }, false);
	     xhr.addEventListener("error", this.uploadFailed, false);
	     //xhr.addEventListener("abort", uploadCanceled, false);
	     xhr.open("POST", "/photo/upload");
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
		this.totalUploaded = 0;
		for(i=0; i<files.length; i++){
			this.totalFileSize += files[i].size;
		}
		
		this.uploadFile(files, 0, $("#albumDes").val());
	        
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
    	this.uploadPhotosWindow = $(this.uploader.render().el).modal({backdrop:true, keyboard: true, show:false});
	}
	
});