var AboutMeList = Backbone.Collection.extend({
  model: AboutMe,
  
  url: function(){
	  if(this.get("profile") != null)
		  return '/aboutMe?profile='+this.get("profile");
	  else
		  return '/aboutMe';
  }
});