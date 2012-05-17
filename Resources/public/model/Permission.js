var Permission = Backbone.Model.extend({
	url: function(){
		if(this.get('id') != undefined)
			return "/permission/"+this.get('type')+"/"+this.get('id');
		else
			return "/permission";
	}
});