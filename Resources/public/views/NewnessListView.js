var NewnessListView = Backbone.View.extend({
    
	newnessContainer: null,
	profileId: null,
	input: null,
	page: 1,
	linkEnabled: false,
    events: {
    //	"keypress #new-share":  "createOnEnter",
    		"focus #fakeContent input": "toogleRealContent",
    		"click .closeAllowed": "removeAllowed",
    		"click #addLink": "addLink",
    		"click #closeUpdate": "toogleRealContent",
    		
    	
    	"click #more-newness":  "loadMoreNewness"
    },
    
    
    initialize: function() {
      this.collection.bind('add',   this.addOne, this);
      this.collection.bind('reset', this.addAll, this);
      this.profileId = this.options.profileId;
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
    	this.collection.fetch({ data:{page: this.page, id: this.profileId}});
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
    },
    
    removeAllowed: function(event){
		$(event.target).parent().parent().remove();
		
	},
	toogleRealContent: function(){
		var fakeContent = this.$el.find("#fakeContent");
		
		if(fakeContent.is(":visible")){
					this.$el.find("#fakeContent").hide();
					this.$el.find("#content").show().find("textarea").focus();
		}else{
				this.$el.find("#fakeContent").show();
				this.$el.find("#content").hide();
		}
	},
	
	addLink: function(){
			var form = this.$el.find("#addLinkForm");
			if(form.is(":visible")){
				form.hide()
				this.$el.find(".updateAction").css({ 'opacity' : 1 });
			}else{
				form.show().find("input").focus();
				this.$el.find(".updateAction").css({ 'opacity' : 0.25 });
				this.$el.find("#addLink").css({ 'opacity' : 1 });
			}
	}
});

