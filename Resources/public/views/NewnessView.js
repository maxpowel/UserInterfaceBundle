var NewnessView = Backbone.View.extend({
	events:{
		"keypress #comment": "commentOnEnter",
		"click #doComment": "showCommentForm"
	},
    initialize: function() {
    	//this.model.bind('destroy', this.remove, this);
    	this.commentList = new NewnessCommentList();
    	
    	this.commentList.bind('add',   this.addOne, this);
        this.commentList.bind('reset', this.addAll, this);
    },
    
    
    addAll: function() {
        var cont = this.commentListContainer;
        this.commentList.each(function(comment){
      	  var view = new NewnessCommentView({model: comment});
            cont.prepend(view.render().el);
        });
      },
      
      addOne: function(comment) {
        var view = new NewnessCommentView({model: comment});
        this.commentListContainer.prepend(view.render().el);
      },
      
      
    /*remove: function() {
        $(this.el).remove();
     },
     
     destroyModel: function(){
    	 this.model.destroy();
     },*/
      
    render: function() {
    	//TODO hacer que esto cambie

    	$(this.el).html(template.newnessView.newness(this.model.toJSON()));
    	this.commentInput = $(this.el).find("#comment");
    	
    	//this.commentList.fetch({data:{id: this.model.get('id') }});
    	this.commentListContainer = $(this.el).find("#comments");
    	this.commentList.reset( this.model.get("comments") );
    	/*var cont = commentListContainer = $(this.el).find("#comments");
    	this.commentList.each(function(comment){
    		var view = new NewnessCommentView({model: comment});
            cont.append(view.render().el);
    	});*/
    	
      return this;
    },
    
    showCommentForm: function(){
    	this.commentInput.show();
    },
    commentOnEnter: function(e) {
        var text = this.commentInput.val();
        if (!text || e.keyCode != 13) return;
        /*var newness = new Newness();
        var collection = this.collection;
        newness.save({body: text},{success: function(){
      	  collection.add(newness);
      	  this.commentInput.("#comment").hide();
        }
        });*/
        
        var comment = new NewnessComment({body: this.commentInput.val()});
        this.addOne(comment);
        this.commentInput.val('');
        this.commentInput.hide();
      },
      
});