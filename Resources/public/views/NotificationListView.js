var NotificationListView = Backbone.View.extend({
    
    el: '#notification',
    
    
    initialize: function() {

      this.options.collection.bind('reset', this.addAll, this);

      this.options.collection.fetch();
    },
    
    
    addAll: function() {
      var container = $(this.el);
      this.options.collection.each(function(notification){
    	  
    	  var view = new NotificationView({model: notification, endUrl: notification.get("endUrl"), text: notification.get("text") });
          container.append(view.render().el);
      });
    }
});
