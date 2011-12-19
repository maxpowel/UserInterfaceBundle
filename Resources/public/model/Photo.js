var Photo = Backbone.Model.extend({
	url: function(){
		return "/photo?id="+this.get('id'); 
	}
});