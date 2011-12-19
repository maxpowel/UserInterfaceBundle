var NotificationView = Backbone.View.extend({
      
    render: function() {
    	
    	$(this.el).html(template.notificationView.notification( this.options));

      return this;
    }
});