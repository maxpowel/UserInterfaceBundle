var Notification = Backbone.Model.extend({
	url:function(){
		return "notification/"+this.get('id')+"/"+this.get('type')
	}
});