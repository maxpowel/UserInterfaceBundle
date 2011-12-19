var RawData = Backbone.Model.extend({
	
});

var CommonThingList = Backbone.Collection.extend({
  model: CommonThing
});

var CityList = Backbone.Collection.extend({
	  model: City
});

var FriendList = Backbone.Collection.extend({
	  model: Friend
});


///Search results
var SearchResult = Backbone.Model.extend({
	
});

var SearchResultList = Backbone.Collection.extend({
	  url: "/search",
	  model: SearchResult
});

var SearchResultListView = Backbone.View.extend({
    
	
    //el: '#search-result',
    
    events: {
    	"click #more-results":  "loadMoreResults"
    },
    
    
    render: function(){
    	$(this.el).html(template.searchView.resultList());

        return this;
    
    },
    initialize: function() {
      this.render();
      this.page = 1;
      
      this.options.collection.bind('add',   this.addOne, this);
      this.options.collection.bind('reset', this.addAll, this);
      //this.options.collection.bind('all',   this.render, this);

      var data = this.options.params;
      data.page = 1;
      this.options.collection.fetch({data:data});
    },
    
    loadMoreResults: function(){
    	var data = this.options.params;
    	this.page = this.page + 1;
        data.page = this.page;
        
    	this.options.collection.fetch({ data:data });
    	
    },
    
    addAll: function() {
      this.options.collection.each(this.addOne);
    },
    
    addOne: function(result) {
      var view = new SearchResultView({model: result});
      this.$("#result-container").append(view.render().el);
    }
});

var SearchResultView = Backbone.View.extend({
    
    initialize: function() {
    	this.model.bind('destroy', this.remove, this);
    	
    },
    
    remove: function() {
        $(this.el).remove();
     },
     
     destroyModel: function(){
    	 this.model.destroy();
     },
      
    render: function() {

    	$(this.el).html(template.searchView.searchResult({name: this.model.get("name"), 
    													  city: this.model.get("city"),
    													  thumbnail: this.model.get("thumbnail"),
    													  things: this.model.get("thingsInCommon"),
    													  friends: this.model.get("commonFriends"),
    													  other: this.model.get("other")
    													  }));

      return this;
    }
});

//Form views
var SimpleFormView = Backbone.View.extend({
	initialize: function(){
		this.model.bind('destroy', this.remove, this);
    	this.render();
    	var model = this.model;
    	$(this.el).find(".close").click(function(){
    		model.destroy();
    	});
	},
    remove: function() {
    	
        $(this.el).remove();
    }
});

var CommonThingFormView = SimpleFormView.extend({
	render: function(){
		$(this.el).html(template.searchView.commonThingRow({name:this.model.get("name") }));
	}
});

var FriendFormView = SimpleFormView.extend({
	render: function(){
		$(this.el).html(template.searchView.friendRow({name:this.model.get("name") }));
	}
});

var CityFormView = SimpleFormView.extend({
	render: function(){
		$(this.el).html(template.searchView.cityRow({name:this.model.get("name") }));
	}
});
////////////
var City = Backbone.Model.extend({
	
});

var Friend = Backbone.Model.extend({
	
});

var CommonThing = Backbone.Model.extend({
	
});

//Used to pack all collections
var SearchQuery = Backbone.Model.extend({
	toJSON: function(){
		var data = {};
		for (i in this.attributes){
			data[i] = this.attributes[i].toJSON();
		}
		return data;
	}
});

var SearchSectionView = Backbone.View.extend({
    
    el: '#content',
    events: {
    	"click #but-search": "clickSearch",
    	"keypress #query": "checkEnter",
    	"change #years": "setAge",
    	"change #other": "setOther",
    	"change #query": "setQuery"
    },

    resultsView: null,
    initialize: function() {
    	//console.log(($("#but-search").length));
      this.render();
      var thingList = new CommonThingList();
      var friendList = new FriendList();
      var cityList = new CityList();
      
      this.searchQuery = new SearchQuery({thingList: thingList, friendList: friendList, cityList: cityList});
      
      //Thing list
      thingList.bind('add',   this.addCommonThing, this);
      thingList.bind('remove',   this.doSearch, this);
      //
      //Friend list
      friendList.bind('add',   this.addFriend, this);
      friendList.bind('remove',   this.doSearch, this);
      //
      //City list
      cityList.bind('add',   this.setCity, this);
      cityList.bind('remove',   this.doSearch, this);
      //
      //City autocomplete
		//var setCityCallback = this.setCity;
    	$(this.el).find("#city").autocomplete("/datos",
    			{    minChars: 2,
    				 mustMatch: true,
	            	 formatItem: function(data, i, n) {
	            		 
	            		 //return "hola";
	            		 
	            		 
	                     return "<div style='height:40px'><img style='float:left' src='" + data[2] + "'/> <a style='margin-left: 10px' href='javascript:void(0)'>" + data[0]+"</a></div>";
	             }

    			}).result(function(event, item) {
    				
    				var city = new City({name: item[0], cityId: item[1]});
    				var old = cityList.at(0);
    				if(old != null){
    					old.destroy({silent:true});
    				}
    				
    				cityList.add(city);
    	});
        //Common thing autocomplete
    	$(this.el).find("#thing").autocomplete("/datos",
    			{    minChars: 2,
    				 mustMatch: true,
	            	 formatItem: function(data, i, n) {
	            		 
	            		 //return "hola";
	            		 
	            		 
	                     return "<div style='height:40px'><img style='float:left' src='" + data[2] + "'/> <a style='margin-left: 10px' href='javascript:void(0)'>" + data[0]+"</a></div>";
	             }

    			}).result(function(event, item) {
    				thingList.add(new CommonThing({name: item[0], thingId: item[0]}));
    	});   
    	//Common friends autocomplete
    	$(this.el).find("#friend").autocomplete("/datos",
    			{    minChars: 2,
    				 mustMatch: true,
	            	 formatItem: function(data, i, n) {
	            		 
	            		 //return "hola";
	            		 
	            		 
	                     return "<div style='height:40px'><img style='float:left' src='" + data[2] + "'/> <a style='margin-left: 10px' href='javascript:void(0)'>" + data[0]+"</a></div>";
	             }

    			}).result(function(event, item) {
    				friendList.add(new Friend({name: item[0], friendId: item[0]}));
    	});
      //
    	//Age filter (only numbers)
    	$("#years").keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 8 || 
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    	this.doSearch();
    },
    
    
    setCity: function(city){
    	var view =  new CityFormView({model: city });
        $("#city-container").append(view.el);
        this.doSearch();
    },
    
    addCommonThing: function(thing){
    	var view =  new CommonThingFormView({model: thing });
        $("#thing-container").append(view.el);
        this.doSearch();
    },
    
    addFriend: function(friend){
    	var view =  new FriendFormView({model: friend });
        $("#friend-container").append(view.el);
        this.doSearch();
    },
    
    clickSearch: function(context){
    	this.doSearch();
    },
    
    setAge: function(event){
    	this.searchQuery.set({age: new RawData({data:$(event.currentTarget).val()})});
    },
    setQuery: function(event){
    	this.searchQuery.set({query: new RawData({data:$(event.currentTarget).val()})});
    },
    
    setOther: function(event){
    	this.searchQuery.set({other: new RawData({data:$(event.currentTarget).val()})});
    },
    doSearch: function(){
    	//console.log("esto va "+this.mensaje);
    	//console.log(JSON.stringify(this.searchQuery.toJSON()));
    	if(this.resultsView != null)
    		this.resultsView.remove();
    	
    	this.resultsView = new SearchResultListView({collection: new SearchResultList(), params: this.searchQuery.toJSON()});
    	
    	$('#search-result').html(this.resultsView.el);
    },
    
    checkEnter: function(event){
    	if(event.keyCode == 13)
    		this.doSearch();
    },
    
    render: function(){
		$(this.el).html(template.section.search( this.options));
		
    }
});
