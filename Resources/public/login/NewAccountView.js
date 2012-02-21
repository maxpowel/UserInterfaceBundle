var NewAccountView = Backbone.View.extend({

	csrfToken: null,
	
	events:{
		"click #createAccount-btn": "createAccount",
		"click .close": "closeNotice"
	},
	
	
	closeNotice: function(e){
		$(e.target).parent().hide();
	},
	
	initialize: function() {
		//Get the csrftoken
		var localThis = this;
		$.get("/register",function(data){
			var html = $(data);
			localThis.csrfToken = html.find("#fos_user_registration_form__token").val();
		});
		this.render();
	},
	
	render: function(){
		$(this.el).html(template.loginApp.newAccount());
	},
	
	createAccount: function(){
		//Check if passwords match
		var pass, rpass,email;
		var error = false;
		var html = $(this.el);
		
		html.find(".error").hide();
		
		pass = $.trim(html.find("#password").val());
		rpass = $.trim(html.find("#rpassword").val());
		name = $.trim(html.find("#name").val());
		email = $.trim(html.find("#email").val());
		
		day = html.find("#day").val();
		month = html.find("#month").val();
		year = html.find("#year").val();
		
		
		if(pass.length == 0){
			html.find("#password").focus();
		}else{
		
			if(pass != rpass){
				html.find("#passError").show();
				error = true;
			}
			
			if(name.length == 0){
				html.find("#nameError").show();
				error = true;
			}
			
			if(email.length == 0){
				html.find("#emailError").show();
				error = true;
			}
			
			if(isNaN(day) || isNaN(month) || isNaN(year)){
				html.find("#dateError").show();
				error = true;
			}
			
			
			if(error == false){
				html.find("#allOk").show();
				var user = new UserRegistration();
				//fos_user_registration_form_email">Email:</label><input type="email" id="fos_user_registration_form_email" name="fos_user_registration_form[email]" required="required" value="" /></div><div><label for="fos_user_registration_form_plainPassword_first">Contraseña:</label><input type="password" id="fos_user_registration_form_plainPassword_first" name="fos_user_registration_form[plainPassword][first]" required="required" value="" /></div><div><label for="fos_user_registration_form_plainPassword_second">Verificación:</label><input type="password" id="fos_user_registration_form_plainPassword_second" name="fos_user_registration_form[plainPassword][second]" required="required" value="" />
				
				user.set({
					fos_user_registration_form__token:this.csrfToken,
				//	fos_user_registration_form[username]:
				});
				user.save();
			}
		}
	}
});