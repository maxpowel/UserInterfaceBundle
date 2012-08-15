var ContactList = Backbone.Collection.extend({
  model: User,
  
  url: function(){
	  if(this.get("profile") != null)
		  return '/profile/contacts/profile='+this.get("profile");
	  else
		  return '/profile/contacts';
  },

   parse: function(response) {
		  
	   return response;
	   
		  //In contact => my contact
		  //out contact => they have me as their contact
		  var inContacts = response.in;
		  for(i = 0; i < inContacts.length; i++){
			  inContacts[i]['type'] = "in"; 
		  }
		  
		  var outContacts = response.out;
		  for(i = 0; i < outContacts.length; i++){
			  outContacts[i]['type'] = "out";
		  }
		  
		  return outContacts.concat(outContacts);
	}
});