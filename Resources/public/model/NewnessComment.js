var NewnessComment = Backbone.Model.extend({
	url: function(){
		if(this.get("id")){
			return '/newness/comment/'+this.get("id")
		}
		else
			return '/newness/comment'
	}
});