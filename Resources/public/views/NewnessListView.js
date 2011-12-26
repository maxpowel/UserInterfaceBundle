var NewnessListView = Backbone.View.extend({
    
    //el: '#newness',
	newnessContainer: null,
	input: null,
	page: 1,
    events: {
    	"keypress #new-share":  "createOnEnter",
    	"click #more-newness":  "loadMoreNewness"
    },
    
    
    initialize: function() {
      this.collection.bind('add',   this.addOne, this);
      this.collection.bind('reset', this.addAll, this);
      //this.options.collection.bind('all',   this.render, this);

    },
    
    render: function(){
    	$(this.el).html(template.newnessView.newnessList(this.options));
    	this.newnessContainer = $(this.el).find("#newness-container");
    	
    	this.loadMoreNewness();
    	this.input = $(this.el).find("#new-share");
    	return this;
    },
    loadMoreNewness: function(){
    	this.collection.fetch({ data:{page: this.page}});
    	this.page = this.page + 1;
    },
    createOnEnter: function(e) {
      var text = this.input.val();
      if (!text || e.keyCode != 13) return;
      var newness = new Newness();
      var collection = this.collection;
      newness.save({body: text},{success: function(){
    	  collection.add(newness);
      }
      });

      this.input.val('');
    },
    
    addAll: function() {
      var cont = this.newnessContainer;
      this.collection.each(function(newness){
    	  var view = new NewnessView({model: newness});
          cont.prepend(view.render().el);
      });
    },
    
    addOne: function(newness) {
      var view = new NewnessView({model: newness});
      this.newnessContainer.prepend(view.render().el);
    }
});

