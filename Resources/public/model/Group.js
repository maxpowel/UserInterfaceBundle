var Group = Backbone.Model.extend({

	getMemberList: function(){
		if(this.memberList == null){
			this.list = new GroupMemberList({id: this.get("id")});
			this.list.fetch();
		}
		return this.memberList;
	}
});