var MeetingFieldListView = Backbone.View.extend({
    
    el: '#meetingInformation',

    initialize: function() {
      this.options.collection.bind('add',   this.addOne, this);
      this.options.collection.bind('reset', this.addAll, this);
      this.options.collection.bind('remove', this.removeOne, this);
      //this.options.collection.bind('all',   this.render, this);
      
      //this.options.collection.fetch();
    },
    
    
    addAll: function() {
      this.options.collection.each(this.addOne);
    },
    
    addOne: function(meetingField) {
    	
      var view = new MeetingFieldView({collection: this.options.collection, model: meetingField });
      $("#meetingInformation").append(view.el);
    },
    removeOne: function(meetingField) {
        meetingField.destroy();
      }
    
});
