var PhotoSectionView = Backbone.View.extend({
    className: "container-fluid",

    
    events: {

        "click .right": "nextPhoto",
        "click .left": "prevPhoto"
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
    
    render: function(){
    	var self = this;
    	$.getJSON("photo/"+this.options.photoId,function(data){
    		$(self.el).html(template.section.photo( data ));
    	
    		var commentList = new CommentListView({photoId: data.id});

    	
    		self.nextPhoto = data.next;
    		self.prevPhoto = data.prev;
    		$(self.el).find("#photoContainer").append(commentList.render().el);
    		
    		var photo = $(self.el).find("#photoContainer").find("img");
    		var photoTagger = new PhotoTagListView({tags: data.tags,photo: photo, el: $(self.el).find("#tagList")});
    		photoTagger.render();
        	

        	$(self.el).find("#tagDesc").tooltip({placement: "bottom"});
        	
    	});
    	
    	    
		return this;
    }
    

});
