var NewAccountView = Backbone.View.extend({

	events:{
		"click #createAccount-btn": "createAccount"
	},
	
	initialize: function() {
		this.render();
	},
	
	render: function(){
		$(this.el).html(template.loginApp.newAccount());
	},
	
	createAccount: function(){
		var user = new User();
		user.set({nombre:"adsf"});
		user.save();
	}
});