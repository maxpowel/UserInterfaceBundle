var DoMeetingView = Backbone.View.extend({
    
    events: {
    	"click #addField-but":  "addFieldForm",
    },
    initialize: function() {

    	this.fieldCollection = new MeetingFieldList();
    	
    	new MeetingFieldListView({ collection: this.fieldCollection});
    	

    },
    
    addFieldForm: function(){
    	
    	this.addFieldModal.modal('show');
    	
    },
    
    callBackFunction: function(item){
    	console.log("Bieeen");
    	
    },
    render: function() {
    	
    	$(this.el).html(template.meetingView.doMeeting( this.options));
		var callBackFunction = this.callBackFunction;
    	$(this.el).find("input").autocomplete("/datos",
    			{    minChars: 2,
    				 mustMatch: true,
	            	 formatItem: function(data, i, n) {
	            		 
	            		 //return "hola";
	            		 
	            		 
	                     return "<div style='height:40px'><img style='float:left' src='" + data[2] + "'/> <a style='margin-left: 10px' href='javascript:void(0)'>" + data[0]+"</a></div>";
	             }

    			}).result(function(event, item) {
    				callBackFunction(item);
    			});
    	
		if($("#doAddField").length == 0){
			var modalTemplate = template.meetingView.doMeetingAddField( this.options );

		    this.addFieldModal = $(modalTemplate);
		    this.addFieldModal.attr({id: "doAddField"});
		    this.addFieldModal.modal({backdrop:true, keyboard: true});
		    
		    var form = this.addFieldModal;

		    var fieldCollection = this.fieldCollection;
		    //Insert the new field
		    this.addFieldModal.find(".primary").click(function(){
		    	//Only insert if text is written
		    	var val = form.find("input").val().trim();
		    	if(val.length)
		    		fieldCollection.add(new MeetingField({text: val}));
		    	
		    	form.modal('hide');
		    	form.find("input").val("");
		    });
		    
		    //Cancel butotn
		    this.addFieldModal.find(".secondary").click(function(){
		    	form.modal('hide');
		    	form.find("input").val("");
		    });
		    
		}else this.addFieldModal = $("#doAddField");
    	

      return this;
    }
});