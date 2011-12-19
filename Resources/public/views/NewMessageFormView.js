var NewMessageFormView = Backbone.View.extend({
    
	/*subSection: "new-message-form",//Subsection name inside central column
	el: "#new-message-form .subSection-content",
    */
    events: {
    	"click #attachFile-btn":  "attachFileForm",
    },
    initialize: function() {
    	
    	
    },
    
    render: function() {
    	
    	$(this.el).html(template.messagesView.newMessage(this.options));
    	var to = $(this.el).find("#to");
    	$(this.el).find("#to").autocomplete("/datos",
    			{    minChars: 2,
	            	 formatItem: function(data, i, n) {
	            		 
	            		 //return "hola";
	            		 
	            		 
	                     return "<div style='height:40px'><img style='float:left' src='" + data[2] + "'/> <a style='margin-left: 10px' href='javascript:void(0)'>" + data[0]+"</a></div>";
	             }

    			}).result(function(event, item) {
    				to.attr({to:"cojer id del item"});
    			});
    	

      return this;
    },
    
    attachFileForm: function(){
    	alert($(this.el).find("#body").val());
    }
});