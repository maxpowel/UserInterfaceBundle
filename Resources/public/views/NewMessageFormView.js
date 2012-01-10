var NewMessageFormView = Backbone.View.extend({
    
	/*subSection: "new-message-form",//Subsection name inside central column
	el: "#new-message-form .subSection-content",
    */
    events: {
    	"click #attachFile-btn":  "attachFileForm",
    	"click #sendMessage-btn":  "sendMessage",
    	"click #success-close": "successClose"
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
    
    successClose: function(){
    	$(this.el).find("#sentSuccess").hide();
    },
    sendMessage: function(){
    	var data = {body: $(this.el).find("#body").val(), profile_id: $(this.el).find("#to").val(), subject: $(this.el).find("#subject").val()};
    	var message = new Message();
    	var localThis = this;
    	message.save(data,{success:function(){
    		$(localThis.el).find("#sentSuccess").show();
    		$(localThis.el).find("#body").val("");
    		$(localThis.el).find("#subject").val("");
    	}});
    },
    
    attachFileForm: function(){
    	alert("N/A");
    	//alert($(this.el).find("#body").val());
    }
});