var MessageFolder = Backbone.Model.extend({
	url: function(){
		if(this.get('id') != null)
			return "/messageFolder?id="+this.get('id');
		else
			return "/messageFolder";
	}
});