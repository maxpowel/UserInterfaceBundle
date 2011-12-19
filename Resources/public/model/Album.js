var Album = Backbone.Model.extend({
	url: function(){
		if(this.get('id') != null)
			return "/album?id="+this.get('id');
		else
			return "/album";
	}
});