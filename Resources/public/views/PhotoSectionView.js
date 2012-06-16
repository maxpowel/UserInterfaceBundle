var PhotoSectionView = Backbone.View.extend({
    className: "container-fluid",

    modalWindow: null,
    
    events: {

        "click .right": "nextPhoto",
        "click .left": "prevPhoto",
        "click #setTitle": "setTitle",
        "click #saveModalChanges": "saveModalWindowData"
    },
    
    nextPhoto: function(){
    	if(this.nextPhoto != null)
    		location.href="#photo/"+this.nextPhoto;
    },
    prevPhoto: function(){
    	if(this.prevPhoto != null)
    		location.href="#photo/"+this.prevPhoto;
    },
    
    initialize: function() {
    	this.photoId = this.options.photoId;

    },
    
    saveModalWindowData: function(){
    	this.photo.set({name: this.$el.find("#newTitle").val(),
    					description: this.$el.find("#newDescription").val()});
    	this.photo.save();
    },
    setTitle: function(){
    	if(this.modalWindow == null){
    		this.modalWindow = this.$el.find("#setTitleModal").modal();
    	}else
    		this.modalWindow.modal('show');
    },
    
    photoChanged: function(photo){
    	if(photo.get('description')!= null && photo.get('description').length > 0){
    		this.$el.find(".carousel-caption").show().find("p").text(photo.get('description'));
    	}else
    		this.$el.find(".carousel-caption").hide();
    	
    	if(photo.get('name')!= null && photo.get('name').length > 0){
    		this.$el.find("#photoTitleTop").text(photo.get('name')).show();
    	}else
    		this.$el.find("#photoTitleTop").hide();
    },
    
    
    render: function(){
    	
    	
    	var self = this;
    	
    	$.getJSON("photo/"+this.options.photoId,function(data){
    				
    		$(self.el).html(template.section.photo( data ));
    		
        	self.photo = new PhotoPreview({id: data.id});
        	self.photo.on('change', self.photoChanged, self)
        	
    		var commentList = new CommentListView({photoId: data.id});

    	
    		self.nextPhoto = data.next;
    		self.prevPhoto = data.prev;
    		$(self.el).find("#photoContainer").append(commentList.render().el);
    		
    		var photo = $(self.el).find("#photoContainer").find("img");
    		var photoTagger = new PhotoTagListView({tags: data.tags,photo: photo, el: $(self.el).find("#tagList")});
    		photoTagger.render();
        	

        	self.$el.find("#tagDesc").tooltip({placement: "bottom"});
        	
        	self.photo.set({description: data.description, name: data.name})
        	
    	});
    	
    	    
		return this;
    }
    

});
