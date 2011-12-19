var Message = Backbone.Model.extend({
	url: function(){
		return "/message?id="+this.get('id'); 
	}
});