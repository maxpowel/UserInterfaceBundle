// This file was automatically generated from agendaSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.agenda = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sidebar"><div class="well"><div align="center"><input type="text" placeholder="Search..." class="span3"></div><br><br><h5>Show</h5><ul class="inputs-list"><li><label><input type="checkbox" value="option1" name="optionsCheckboxes"><span style="margin-left: 4px">Meetings</span></label></li><li><label><input type="checkbox" value="option2" name="optionsCheckboxes"><span style="margin-left: 4px">Tasks</span></label></li><li><label><input type="checkbox" value="option2" name="optionsCheckboxes"><span style="margin-left: 4px">Birthdays</span></label></li><li><label class="disabled"><input type="checkbox" value="option2" name="optionsCheckboxes"><span style="margin-left: 4px">Other</span></label></li></ul><br><br><button class="btn primary">New task</button></div></div><div class="content-big"><div id="calendar" /></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from agendaView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.agendaView == 'undefined') { template.agendaView = {}; }


template.agendaView.nearbyTask = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<li><span class="label ', soy.$$escapeHtml(opt_data.type), '"><a href="#', soy.$$escapeHtml(opt_data.endUrl), '">', soy.$$escapeHtml(opt_data.text), '</a></span> ', soy.$$escapeHtml(opt_data.date), '</li>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from appView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.appView == 'undefined') { template.appView = {}; }


template.appView.app = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div id="navbar" class="navbar navbar-fixed-top"><div class="navbar-inner"><div class="container"><ul class="nav"><li id="menu-start"><a href="#start">Start</a></li><li id="menu-profile"><a href="#profile">Profile</a></li><li id="menu-search"><a href="#search">Search</a></li><li id="menu-multimedia"><a href="#multimedia">Multimedia</a></li><li id="menu-messages"><a href="#messages">Messages</a></li><li id="menu-agenda"><a href="#agenda">Agenda</a></li><li id="menu-settings"><a href="#preferences">Preferences</a></li></ul><form class="navbar-search pull-left"><input type="text" class="search-query" placeholder="Quick search"><button id="uploadPhotos-but" style="margin-left:15px; margin-top:0px" class="btn btn-success btn-small"><span class="upload">Upload photos</span><span class="uploading" style="display:none">Uploading <span id="totalPercent"></span>%</span></button></form><ul class="nav" id="chat-dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Chat<b class="caret"></b></a><ul class="dropdown-menu"><li><a href="#">Action</a></li><li><a href="#">Another action</a></li><li><a href="#">Something else here</a></li><li class="divider"></li><li><a href="#">Separated link</a></li></ul></li></ul></div></div></div><div id="content"></div>');
  return opt_sb ? '' : output.toString();
};


template.appView.multimenu = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div id="original"></div>');
  var subsectionList74 = opt_data.subsections;
  var subsectionListLen74 = subsectionList74.length;
  for (var subsectionIndex74 = 0; subsectionIndex74 < subsectionListLen74; subsectionIndex74++) {
    var subsectionData74 = subsectionList74[subsectionIndex74];
    output.append('<div style="display:none" id="', soy.$$escapeHtml(subsectionData74.subSectionId), '" class="submenu"><button style="margin-left:11px" class="btn span6 btn-', soy.$$escapeHtml(subsectionData74.buttonClass), ' back-but">Back</button><br><br><div class="subSection-content"></div></div>');
  }
  return opt_sb ? '' : output.toString();
};


template.appView.uploadEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<tr><td>', soy.$$escapeHtml(opt_data.filename), '</td><td>', soy.$$escapeHtml(opt_data.size), '</td></tr>');
  return opt_sb ? '' : output.toString();
};


template.appView.uploadPhoto = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal-header"><h3>Upload photos</h3></div><div class="modal-body" align="center"><h4>Save photos in the album</h4><select id="albumDes" name="mediumSelect" class="medium">');
  var albumList98 = opt_data.albumList;
  var albumListLen98 = albumList98.length;
  for (var albumIndex98 = 0; albumIndex98 < albumListLen98; albumIndex98++) {
    var albumData98 = albumList98[albumIndex98];
    output.append('<option value="', soy.$$escapeHtml(albumData98.id), '">', soy.$$escapeHtml(albumData98.name), '</option>');
  }
  output.append('</select><h4>Select your photos</h4><div>You can select multiple files</div><form id="photoForm" enctype="multipart/form-data" method="post" action="/upload"><input type="file" id="files" multiple="multiple"/><div id="fileInfo" style="display:none; overflow: auto; max-height:400px"><table class="bordered-table zebra-striped"><thead><tr><th>Filename</th><th>Size</th></tr></thead><tbody></tbody></table></div></form></div><div class="modal-footer"><button class="btn upload btn-secondary secondary disabled">Upload</button><button class="btn cancel btn-primary primary">Cancel</button></div>');
  return opt_sb ? '' : output.toString();
};


template.appView.uploadResume = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"><button id="resume-but" class="btn" data-toggle="toggle" >Check uploaded photos</button><a href="javascript:void(0)" class="close">×</a></h3><div style="display:none" class="popover-content"><p><ul class="nav-list nav"></ul></p></div></div>');
  return opt_sb ? '' : output.toString();
};


template.appView.resumeEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<a href="#photo/', soy.$$escapeHtml(opt_data.id), '"><img alt="" src="/photo/thumbnail/', soy.$$escapeHtml(opt_data.id), '" class="thumbnail"></a>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from commentView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.commentView == 'undefined') { template.commentView = {}; }


template.commentView.commentList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="well"><textarea class="span9" id="comment-text"></textarea><button class="btn btn-success" id="comment-send">Comment</button></div><ul id="comment-list" class="nav nav-list"></ul><div class="pagination" style="width:205px"><span id="page-number"></span><ul><li class="prev disabled"><a href="javascript:void(0)" id="previousPage-btn">← Previous</a></li><li class="next disabled"><a href="javascript:void(0)" id="nextPage-btn">Next page →</a></li></ul></div>');
  return opt_sb ? '' : output.toString();
};


template.commentView.comment = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div><a href="#">', soy.$$escapeHtml(opt_data.authorName), '</a> - ', soy.$$escapeHtml(opt_data.date), '</div><div>', soy.$$escapeHtml(opt_data.body), '</div><hr>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from contactSuggestionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.contactSuggestionView == 'undefined') { template.contactSuggestionView = {}; }


template.contactSuggestionView.contactSuggestion = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<br><div><div style="float:left"><a href="#profile/<%= id %>"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><div style="margin-left: 52px"><div><a href="#profile/', soy.$$escapeHtml(opt_data.id), '">', soy.$$escapeHtml(opt_data.name), '</a></div><div style="font-size:10px"><button class="btn add" style="padding:3px 6px; font-size:10px">Invite</button>&nbsp;&nbsp;<a href="javascript:void(0)" class="reject">Omit</a></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from login.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.loginApp == 'undefined') { template.loginApp = {}; }


template.loginApp.login = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<table style="width:150px; padding: 5px;" class="well table table-bordered"><tbody><tr><td colspan="2"><div align="center"><b>Access to my account</b></div></td></tr><tr><td>Username</td><td><input type="text" id="username"></td></tr><tr><td>Password</td><td><input type="password" id="password"></td></tr><tr><td colspan="2"><div align="center" class="alert-message block-message error" style="display:none"><a href="javascript:void(0)" class="close">×</a>The data entered are incorrect</div><div align="center"><button class="btn btn-success" id="login-btn">Login</button></div></td></tr></tbody></table><a href="#newAccount" id="newAccount-btn"><span class="label label-warning">New account</span></a>&nbsp;&nbsp;<a href="#recoverPassword" id="recoverPassword-btn"><span class="label label-important">Recover password</span></a>');
  return opt_sb ? '' : output.toString();
};


template.loginApp.newAccount = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<table style="width:150px" class="well table table-bordered"><tbody><tr><td colspan="2"><div align="center"><b>Please complete the form</b></div></td></tr><tr><td>Name</td><td><input type="text" id="name"></td></tr><tr><td>Email</td><td><input type="text" id="email"></td></tr><tr><td>Password</td><td><input type="password" id="password"></td></tr><tr><td>Repeat password</td><td><input type="password" id="rpassword"></td></tr><tr><td>Birthdate</td><td><select id="day" class="tinySelect"><option>Day</option>');
  for (var i214 = 1; i214 < 32; i214++) {
    output.append('<option value="', soy.$$escapeHtml(i214), '">', soy.$$escapeHtml(i214), '</option>');
  }
  output.append('</select><select id="month" name="tinySelect" class="tinySelect"><option>Month</option><option value="1">Jaunary</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select><select id="year" name="tinySelect" class="tinySelect"><option>Year</option>');
  for (var year257 = -2010; year257 < -1900; year257++) {
    output.append('<option>', soy.$$escapeHtml(-year257), '</option>');
  }
  output.append('</select></td></tr><tr><td colspan="2"><div id="nameError" style="display:none" align="center" class="alert-message block-message error"><a href="javascript:void(0)" class="close">×</a>Please write your name</div><div id="passError" style="display:none" align="center" class="alert-message block-message error"><a href="javascript:void(0)" class="close">×</a>The passwords does not match</div><div id="dateError" style="display:none" align="center" class="alert-message block-message error"><a href="javascript:void(0)" class="close">×</a>Please select your birthdate</div><div id="emailError" style="display:none" align="center" class="alert-message block-message error"><a href="javascript:void(0)" class="close">×</a>Please write a valid email address</div><div id="allOk" style="display:none" align="center" class="alert-message block-message success">Creating account...</div></td></tr><tr><td colspan="2"><div align="center"><button class="btn btn-primary" id="createAccount-btn">Create account</button></div></td></tr></tbody></table><a href="#" id="goLogin-btn"><span class="label label-success">Login</span></a>&nbsp;&nbsp;<a href="#recoverPassword" id="recoverPassword-btn"><span class="label label-important">Recover password</span></a>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from meeting.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.meetingView == 'undefined') { template.meetingView = {}; }


template.meetingView.meeting = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<li><a href="#', soy.$$escapeHtml(opt_data.endUrl), '">', soy.$$escapeHtml(opt_data.text), '</a></li>');
  return opt_sb ? '' : output.toString();
};


template.meetingView.doMeeting = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<h3>Main information</h3><table class="table table-bordered"><tbody id="meetingInformation"><tr><td>Title</td><td><input type="text" id="title" class="xlarge"/></td></tr><tr><td>Date</td><td><input type="text" id="date" class="xlarge" /></td></tr><tr><td>Description</td><td><textarea id="description" class="xlarge" ></textarea></td></tr><tbody></table><button class="btn" id="addField-but">Add field</button><div id="invitePeople-form"></div><br><br></div><button class="btn btn-primary" id="create-but">Create meeting</button></div>');
  return opt_sb ? '' : output.toString();
};


template.meetingView.doMeetingRow = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<td>', soy.$$escapeHtml(opt_data.text), '</td><td><input type="text" class="xlarge"/><a href="javascript:void(0)" class="close">×</a></td>');
  return opt_sb ? '' : output.toString();
};


template.meetingView.invitedPeopleList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<h3 style="margin-top:17px">Participants</h3><div>Invite people to your meeting</div><br><div><span class="span4"><input id="invitedName-txt" type="text" placeholder="Name of the person or group"></span><span class="span2"><button class="btn" id="invite-but">Invite</button></span></div><br><br><div style="max-height: 300px; overflow:auto"><ul id="invited-people"></ul></div>');
  return opt_sb ? '' : output.toString();
};


template.meetingView.doMeetingAddField = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal hide fade" style="display: none;"><div class="modal-header"><a class="close" href="#">×</a><h3>New field</h3></div><div class="modal-body">Field name:&nbsp;&nbsp;<input type="text"></div><div class="modal-footer"><button class="btn btn-secondary secondary">Cancel</button><button class="btn btn-primary primary">Accept</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.meetingView.invitedPeopleEntryExternal = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<a href="javascript:void(0)" class="close">×</a></td><div class="row"><div class="span3">', soy.$$escapeHtml(opt_data.name), '</div><div class="span5">Email: <input type="text" class="email"/></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from messagesSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.messages = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span3"><div class="well"><h5>Folders</h5><div id="folderList"></div><br><br><div id="newButton-cont"></div><br><br><div id="newFolder-cont"></div></div></div><div class="span9"><div id="multimenu" class="content-big"></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from messagesView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.messagesView == 'undefined') { template.messagesView = {}; }


template.messagesView.messageList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3 id="folderName">', soy.$$escapeHtml(opt_data.folder), '</h3></div><div align="right" class="breadcrumb"><div style="float:left; margin-top:20px; margin-left:20px">Check <a id="check-all" href="javascript:void(0)">All</a> <a id="check-none" href="javascript:void(0)">None</a>&nbsp;&nbsp;&nbsp;<button class="btn btn-error btn-small disabled" id="remove-btn">Remove checked</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-info btn-small disabled" id="move-btn">Move checked</button>&nbsp;&nbsp;&nbsp;<span id="optButCont"></span></div><div style="width:200px;float:right;">Page <span id="start-page"></span> of <span id="last-page"></span></div><div class="pagination" style="width:205px"><ul><li class="prev disabled"><a href="javascript:void(0)" id="previousPage-btn">← Previous</a></li><li class="next disabled"><a href="javascript:void(0)" id="nextPage-btn">Next page →</a></li></ul></div></div><div id="message-list"><table class="table table-bordered table-striped"><tbody id="message-table"></tboby></table></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.message = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<td><div style="cursor:pointer;cursor:hand" id="message" class="row-fluid"><span class="span"><input type="checkbox" class="ckbox"></span><span class="span3">', (opt_data.isRead) ? soy.$$escapeHtml(opt_data.author.firstName) + ' ' + soy.$$escapeHtml(opt_data.author.lastName) : '<strong>' + soy.$$escapeHtml(opt_data.author.firstName) + ' ' + soy.$$escapeHtml(opt_data.author.lastName) + '</strong>', '</span><span class="span5">', (opt_data.isRead) ? soy.$$escapeHtml(opt_data.subject) : '<strong>' + soy.$$escapeHtml(opt_data.subject) + '</strong>', '</span><span style="text-align:right" class="span3">', soy.$$escapeHtml(opt_data.date), '</span></div><div style="display:none; clear: left" id="conversation"></div></td>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.conversation = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div><textarea id="body" class="span9" style="height: 50px"></textarea><br><br><button class="btn btn-primary" id="send-but">Send</button><br><br></div><table width="100%" class="table table-bordered table-striped" style="border:0"><tbody id="message-list"></table>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.conversationEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<td><div><a href="#">', soy.$$escapeHtml(opt_data.author.firstName), ' ', soy.$$escapeHtml(opt_data.author.lastName), '</a> - ', soy.$$escapeHtml(opt_data.date), '</div><div>', soy.$$escapeHtml(opt_data.body), '</div></td>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newMessage = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<br><br>', (opt_data.to == null) ? '<h3>New message</h3>' : '', '<div class="alert-message success" id="sentSuccess" style="display:none"><a href="javascript:void(0)" id="success-close" class="close">×</a><p>Message succesfully sent</p></div><table class="table table-bordered"><tbody><tr>', (opt_data.to == null) ? '<td>Send to</td><td><input type="text" id="to" class="xlarge"/></td>' : '<td>Send to</td><td>' + soy.$$escapeHtml(opt_data.to.name) + '<input value="' + soy.$$escapeHtml(opt_data.to.id) + '" type="hidden" id="to" class="xlarge"/></td>', '</tr><tr><td>Subject</td><td><input type="text" class="xlarge" id="subject"/></td></tr><tr><td>Body</td><td><textarea class="xlarge" id="body"></textarea></td></tr><tbody></table><div class="row show-grid"><div class="span2"><button class="btn" id="attachFile-btn">Attach file</button></div><div class="span2"><button class="btn btn-primary" id="sendMessage-btn">Send</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.folderOptions = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<br><br><h3>Options</h3><table class="table table-bordered"><tbody><tr><td>Folder name</td><td><input value="', soy.$$escapeHtml(opt_data.name), '" type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn" id="save-folder-btn">Save changes</button></div><div class="span"><button id="remove-folder-btn" class="btn btn-error">Remove folder</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newFolder = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<br><br><h3>New folder</h3><table class="table table-bordered"><tbody><tr><td>Folder name</td><td><input type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn btn-primary" id="save-folder-btn">Create</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.removeFolderAsk = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal hide fade" style="display: none;"><div class="modal-header"><h3>Remove folder</h3></div><div class="modal-body">Are you really sure you want to delete the folder ', soy.$$escapeHtml(opt_data.folder), '?</div><div class="modal-footer"><button class="btn remove btn-secondary">Remove</button><button class="btn cancel btn-primary">Cancel</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.messageFolder = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<label><span style="margin-left: 4px"><a href="javascript:void(0)" class="load">', soy.$$escapeHtml(opt_data.name), '</a></span></label>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newMessageButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button id="new-message-btn" class="btn btn-success">New message</button>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.folderOptionsButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button class="btn btn-primary btn-small" id="options-btn">Options</button>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newFolderButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button id="new-folder-btn" class="btn btn-info">New folder</button>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from multimediaSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.multimedia = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span3"><div class="well" style="padding: 8px 0;"><br><br><br><br><div id="newFolder-cont"></div></div></div><div class="span9"><div id="multimenu" class="content-big"></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from multimediaView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.multimediaView == 'undefined') { template.multimediaView = {}; }


template.multimediaView.photoList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3 id="folderName">', soy.$$escapeHtml(opt_data.folder), '</h3></div><div align="right" class="breadcrumb"><div style="float:left; margin-top:20px; margin-left:20px">Check <a id="check-all" href="javascript:void(0)">All</a> <a id="check-none" href="javascript:void(0)">None</a>&nbsp;&nbsp;&nbsp;<button class="btn btn-error btn-small disabled" id="remove-btn">Remove checked</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-info btn-small disabled" id="move-btn">Move checked</button>&nbsp;&nbsp;&nbsp;<span id="optButCont"></span></div><div style="width:200px;float:right;">Page <span id="start-page"></span> of <span id="last-page"></span></div><div class="pagination" style="width:205px"><ul><li class="prev disabled"><a href="javascript:void(0)" id="previousPage-btn">← Previous</a></li><li class="next disabled"><a href="javascript:void(0)" id="nextPage-btn">Next page →</a></li></ul></div></div><div><ul class="thumbnails" id="photo-list"></ul></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.photo = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<a class="thumbnail" href="#photo/', soy.$$escapeHtml(opt_data.id), '"><img alt="" src="/photo/thumbnail/', soy.$$escapeHtml(opt_data.id), '"></a><span class="span" style="margin-left:0px;"><input type="checkbox" class="ckbox"></span>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.albumOptions = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<h3>Options</h3><table><tbody><tr><td>Album name</td><td><input value="', soy.$$escapeHtml(opt_data.name), '" type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn" id="save-folder-btn">Save changes</button></div><div class="span"><button id="remove-folder-btn" class="btn btn-error">Remove album</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.newAlbum = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<h3>New album</h3><table><tbody><tr><td>Album name</td><td><input type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn btn-primary primary" id="save-folder-btn">Create</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.removeAlbumAsk = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal hide fade" style="display: none;"><div class="modal-header"><h3>Remove album</h3></div><div class="modal-body">Are you really sure you want to delete the album ', soy.$$escapeHtml(opt_data.folder), '?</div><div class="modal-footer"><button class="btn remove btn-secondary">Remove</button><button class="btn cancel btn-primary">Cancel</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.album = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<a href="javascript:void(0)" class="load">', soy.$$escapeHtml(opt_data.name), '</a>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.newMessageButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button id="new-message-btn" class="btn btn-success">New message</button>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.albumOptionsButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button class="btn btn-primary primary btn-small" id="options-btn">Options</button>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.newAlbumButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button style="margin-left:10px" id="new-folder-btn" class="btn btn-info">New album</button>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from newnessView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.newnessView == 'undefined') { template.newnessView = {}; }


template.newnessView.newness = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div style="min-height: 48px"><div style="float:left; position:relative"><a href="#as"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><div style="margin-left:60px"><div><a href="#">', soy.$$escapeHtml(opt_data.authorName), '</a> - ', soy.$$escapeHtml(opt_data.date), '</div><div>', soy.$$escapeHtml(opt_data.body), '</div><div style="padding:10px"><a href="javascript:void(0)" id="doComment">Comment</a> - <a href="#">I like it</a> - <a href="#">I don\'t like it</a></div><input style="display: none;" type="text" id="comment" class="span5" placeholder="Write your comment and push enter"><table style="margin-left:10px" width="100%" style="border:0" class="table table-striped"><tbody id="comments"></tbody></table></div></div><hr>');
  return opt_sb ? '' : output.toString();
};


template.newnessView.newnessComment = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<td><div><a href="#">', soy.$$escapeHtml(opt_data.authorName), '</a> - ', soy.$$escapeHtml(opt_data.date), '</div><div>', soy.$$escapeHtml(opt_data.body), '</div></td>');
  return opt_sb ? '' : output.toString();
};


template.newnessView.newnessList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="hero-unit" style="padding: 20px 40px 40px">', (opt_data.isOwner == true) ? '<h3>Share something</h3>' : '<h3>Share something with ' + soy.$$escapeHtml(opt_data.name) + '</h3>', '<input type="text" class="span5" id="new-share" placeholder="Write here and push enter"></div><div id="newness-container"></div><button class="btn span6" style="margin-left:10px" id="more-newness">More</button>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from notificationView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.notificationView == 'undefined') { template.notificationView = {}; }


template.notificationView.notification = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<li><a href="#', soy.$$escapeHtml(opt_data.endUrl), '">', soy.$$escapeHtml(opt_data.text), '</a></li><hr>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from photoSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.photo = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span9" id="photoContainer"><div id="photo" class="carousel"><!-- Carousel items --><div class="carousel-inner"><div class="active imgtag item" align="center"><img class="photoMain" src="/photo/normal/', soy.$$escapeHtml(opt_data.id), '" />', (opt_data.description != null) ? '<div class="carousel-caption"><p>' + soy.$$escapeHtml(opt_data.description) + '</p></div>' : '', '</div></div><!-- Carousel nav --><a class="carousel-control left" href="#photo" data-slide="prev">&lsaquo;</a><a class="carousel-control right" href="#photo" data-slide="next">&rsaquo;</a></div></div><div class="span3"><div class="well" style="padding: 8px 0;"><ul id="tagList" class="nav nav-list"><li class="active"><a id="tagDesc" href="#" rel="tooltip" title="Click the photo to add tags"><i class="icon-tags icon-white"></i> Tags</a></li></ul></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from preferencesSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.preferences = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span3"><div class="well" style="padding: 8px 0;"><div id="folderList"><ul class="nav nav-list"><li class="active"><a id="personal-lnk" class="load" href="javascript:void(0)">Personal</a></li><li><a id="aboutMe-lnk" class="load" href="javascript:void(0)">About me</a></li><li><a id="favourites-lnk" class="load" href="javascript:void(0)">Favourites</a></li><li><a id="security-lnk" class="load" href="javascript:void(0)">Security</a></li><li><a id="customize-lnk" class="load" href="javascript:void(0)">Customize</a></li></ul></div></div></div><div class="span9"><div id="bodyContent" class="content-big"></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from preferencesView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.preferencesView == 'undefined') { template.preferencesView = {}; }


template.preferencesView.personalInformation = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>Personal information</h3></div><br><div><table class="table"><tr><td>First name</td><td><input type="text" id="firstName" class="span5" value="', soy.$$escapeHtml(opt_data.firstName), '"></td></tr><tr><td>Last name</td><td><input type="text" id="lastName" class="span5" value="', soy.$$escapeHtml(opt_data.lastName), '"></td></tr><!--<tr><td>Email name</td><td><input type="text" class="span5" value="', soy.$$escapeHtml(opt_data.email), '"></td></tr>--><tr><td colspan="2"><div class="alert alert-success span5" id="notif-success" style="display:none"><a href="javascript:void(0)" id="close-success" class="close">×</a><p>Your new information has been saved successfully</p></div></td></tr></table></div><div><button class="btn btn-primary" id="save-but">Save changes</button></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.aboutMeEditEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div align="center"><table><tr><td><input type="text" id="title" class="span7" placeholder="Title (ej. hobbies, books...)" value="', soy.$$escapeHtml(opt_data.title), '"></td></tr><tr><td><textarea type="text" id="body" class="span12" rows="12" placeholder="Description">', soy.$$escapeHtml(opt_data.body), '</textarea></td></tr><tr><td><div class="alert alert-success" id="notif-success" style="display:none"><a href="javascript:void(0)" id="close-success" class="close">×</a><p>Your new information has been saved successfully</p></div><div class="btn-toolbar"><button class="btn btn-primary" id="save">Save</button><button class="btn btn-danger" id="delete">Delete</button></div></td></tr></table></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.aboutMe = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>About me</h3></div><p>Be care about what you write here, this information is public and accesible by everyone and used by the search engine</p><div id="aboutMeList"></div><div class="row show-grid"><div class="span2"><button class="btn" id="newAboutMe-but">Add new</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.security = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>Security</h3></div><div align="center"><div><button class="btn" id="manageGroups-btn">Manage groups</button></button></div><br><div><button class="btn" id="profilePermissions-btn">Profile permissions</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.groupListEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<a href="javascript:void(0)" class="load">', soy.$$escapeHtml(opt_data.name), '</a><a style="display:none; margin-top:-35px" class="close" data-dismiss="alert">×</a>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.editGroup = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div><h4>Group name<h4></div><div><input type="text" class="span4" value="', soy.$$escapeHtml(opt_data.name), '"></div><br><div><h4>Group members<h4></div><div><select id="memberList" multiple="multiple" size="15" class="span7"></select></div><div><button id="removeSelected-btn" class="btn btn-danger disabled">Remove selected from the group</button></div><br><div><h4>Add members to the group<h4></div><div>Person name: <input type="text" id="personName-txt" class="span4"></div><div><button style="margin-top:4px" id="addMember-btn" class="btn btn-success">Add member to the group</button></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.manageGroups = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>Manage groups</h3></div><table class="table table-bordered"><tr><td><h4>Group list</h4></td></tr><tr><td><ul id="groupList" class="nav nav-pills nav-stacked"></ul></td></tr></table><br><table><tr><td colspan="2"><h4>New group</h4></td></tr><tr><td colspan><div>Name</td><td><input type="text" class="span3" id="newGroupName"></div></td></tr><tr><td colspan="2"><div><button class="btn btn-primary" id="createGroup-btn">Create</button></div></td></tr></table>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from profileSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.profile = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span3"><div class="well"><div class="media-grid"><a href="#"><img alt="" src="" class="thumbnail"></a></div><div id="personalInfo-cont"></div><div id="favourites-cont"></div></div></div><div class="span6"><div class="content" id="newness"><div><h2 id="profileTitle"></h2></div><div align="center"><ul class="nav nav-pills" style="width: 400px; height:50px"><li class="active"><a id="newness-pill" href="javascript:void(0)">Newness</a></li><li><a id="aboutMe-pill" href="javascript:void(0)">About me</a></li><li><a id="sendMessage-pill" href="javascript:void(0)">Send message</a></li><li><a id="albums-pill" href="javascript:void(0)">Albums</a></li></ul></div><!--newness--><div id="newness-list" class="subSection"><div id="newness-container"></div></div><!--newness end--><!--about me--><div id="aboutMe" style="display:none" class="subSection"><div id="aboutMe-container"></div></div><!--about me end--><!--send message--><div id="sendMessage" style="display:none" class="subSection"><div id="sendMessage-container"></div></div><!--send message end--><!--albumlist--><div id="albumList" style="display:none" class="subSection"><div id="albumList-container"></div></div><!--about me end--></div></div><div class="span3"><div class="well"><h5>Last photos</h5><div id="lastPhotos-cont"></div><h5>Friends</h5><div id="friends-cont"></div></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from profileView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.profileView == 'undefined') { template.profileView = {}; }


template.profileView.personalInformation = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<ul class="unstyled">', (opt_data.name != null) ? '<li>Name: <b>' + soy.$$escapeHtml(opt_data.name) + '</b></li>' : '', (opt_data.city != null) ? '<li>City: <b>' + soy.$$escapeHtml(opt_data.city) + '</b></li>' : '', (opt_data.age != null) ? '<li>Age: <b>' + soy.$$escapeHtml(opt_data.age) + ' years</b></li>' : '', (opt_data.gender != null) ? '<li>Gender: <b>' + soy.$$escapeHtml(opt_data.gender) + '</b></li>' : '', (opt_data.country != null) ? '<li>Country: <b>' + soy.$$escapeHtml(opt_data.country) + '</b></li>' : '', '</ul>');
  return opt_sb ? '' : output.toString();
};


template.profileView.favourites = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<h5>Favourites</h5><ul>');
  var favouriteList902 = opt_data.favourites;
  var favouriteListLen902 = favouriteList902.length;
  for (var favouriteIndex902 = 0; favouriteIndex902 < favouriteListLen902; favouriteIndex902++) {
    var favouriteData902 = favouriteList902[favouriteIndex902];
    output.append('<li><a href="#', soy.$$escapeHtml(favouriteData902.url), '">', soy.$$escapeHtml(favouriteData902.title), '</li>');
  }
  output.append('</ul>');
  return opt_sb ? '' : output.toString();
};


template.profileView.aboutMe = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  var elementList911 = opt_data.list;
  var elementListLen911 = elementList911.length;
  for (var elementIndex911 = 0; elementIndex911 < elementListLen911; elementIndex911++) {
    var elementData911 = elementList911[elementIndex911];
    output.append('<div class="well"><h3>', soy.$$escapeHtml(elementData911.title), '</h3></div><p>', soy.$$escapeHtml(elementData911.body), '</p>');
  }
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from searchSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.search = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span3"><div class="well"><h3>Search filter</3><br><br><form class="form-horizontal"><div class="control-group"><input type="text" id="query" class="input-medium" placeholder="Person name"/></div><div class="control-group"><input type="text" id="query" class="input-medium" placeholder="City"/></div><div class="control-group"><input type="text" id="query" class="input-medium" placeholder="Place"/></div><div class="control-group"><input type="text" id="query" class="input-medium" placeholder="Interest"/></div><div class="control-group"><label class="checkbox"><input type="checkbox" value="random" id="optionsCheckbox">Interests in common</label></div></form></div></div><div class="span9" id="search-result"><form style="margin-top:10px" class="form-search" id="initSearchContainer"><input type="text" class="span7 search-query" id="search-query" placeholder="What are you looking for?"> <button class="btn btn-primary" id="but-search">Search <i class="icon-search icon-white"></i></button></form><div id="resultContainer" style="display:none"><ul class="nav nav-tabs"><li class="active"><a href="#">All</a></li><li><a href="#">People</a></li><li><a href="#">Places</a></li><li><a href="#">Groups</a></li></ul><div id="results"><!--<div style="min-height: 48px"><div style="float:left; position:relative"><a href="#as"><img alt="" src="" class="thumbnail"></a></div><div style="margin-left:60px"><div><a href="#">Alvaro Garcia</a> <button class="btn btn-success btn-small" id="addGroup">Add to group</button> </div><div>City: Ciudad</div><div><strong>Interests</strong></div><ul><li>Cosa</li><li>Bbbb</li></ul><div><pre><div style="padding:10px">Otros</div></pre></div>--!></div><div>Page <span id="start-page"></span> of <span id="last-page"></span></div><div class="pagination" style="width:205px"><ul><li class="prev disabled"><a href="javascript:void(0)" id="previousPage-btn">← Previous</a></li><li class="next disabled"><a href="javascript:void(0)" id="nextPage-btn">Next page →</a></li></ul></div></div></div></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from searchView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.searchView == 'undefined') { template.searchView = {}; }


template.searchView.cityRow = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div>Search by: ', soy.$$escapeHtml(opt_data.name), '<a class="close" href="javascript:void(0)">×</a></div>');
  return opt_sb ? '' : output.toString();
};


template.searchView.commonThingRow = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div>', soy.$$escapeHtml(opt_data.name), '<a class="close" href="javascript:void(0)">×</a></div>');
  return opt_sb ? '' : output.toString();
};


template.searchView.friendRow = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div>', soy.$$escapeHtml(opt_data.name), '<a class="close" href="javascript:void(0)">×</a></div>');
  return opt_sb ? '' : output.toString();
};


template.searchView.resultList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div id="original"><div><ul class="tabs"><li class="active"><a href="#">All</a></li><li><a href="#">People</a></li><li><a href="#">Places</a></li><li><a href="#">Groups</a></li></ul></div><div id="result-container"></div><button class="btn wlarge-btn" id="more-results">More</button></div>');
  return opt_sb ? '' : output.toString();
};


template.searchView.addGroupDialog = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal fade"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3>Please select the group</h3></div><div class="modal-body"><p align="center"><select id="select01"><option>something</option><option>2</option><option>3</option><option>4</option><option>5</option></select></p></div><div class="modal-footer"><a href="javascript:void(0)" class="btn cancel">Cancel</a><a href="javascript:void(0)" class="btn add btn-primary">Add user to group</a></div></div>');
  return opt_sb ? '' : output.toString();
};


template.searchView.queryResult = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div style="min-height: 48px"><div style="float:left; position:relative"><a href="#', soy.$$escapeHtml(opt_data.type), '/', soy.$$escapeHtml(opt_data.id), '"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><div style="margin-left:60px"><div><a href="#', soy.$$escapeHtml(opt_data.type), '/', soy.$$escapeHtml(opt_data.id), '">', soy.$$escapeHtml(opt_data.name), '</a>', (opt_data.group == null) ? '<button style="float:right" class="btn btn-success btn-small" id="addGroup">Add to group</button>' : '<div style="float:right" class="alert alert-info">' + soy.$$escapeHtml(opt_data.group.name) + '</div>', '</div>', (opt_data.city != null) ? '<div>City: ' + soy.$$escapeHtml(opt_data.city.name) + '</div>' : '');
  if (opt_data.favourites != null) {
    output.append('<div><strong>Interests</strong></div><ul>');
    var favouriteList1034 = opt_data.favourites;
    var favouriteListLen1034 = favouriteList1034.length;
    for (var favouriteIndex1034 = 0; favouriteIndex1034 < favouriteListLen1034; favouriteIndex1034++) {
      var favouriteData1034 = favouriteList1034[favouriteIndex1034];
      output.append('<li>', soy.$$escapeHtml(favouriteData1034.name), '</li>');
    }
    output.append('</ul>');
  }
  if (opt_data.friends != null) {
    output.append('<div><strong>Friends in common</strong></div><ul>');
    var friendList1046 = opt_data.friends;
    var friendListLen1046 = friendList1046.length;
    for (var friendIndex1046 = 0; friendIndex1046 < friendListLen1046; friendIndex1046++) {
      var friendData1046 = friendList1046[friendIndex1046];
      output.append('<li>', soy.$$escapeHtml(friendData1046.name), '</li>');
    }
    output.append('</ul>');
  }
  if (opt_data.highlights != null) {
    output.append('<div><pre>');
    var resList1055 = opt_data.highlights;
    var resListLen1055 = resList1055.length;
    for (var resIndex1055 = 0; resIndex1055 < resListLen1055; resIndex1055++) {
      var resData1055 = resList1055[resIndex1055];
      output.append('<div style="padding:10px"><strong>', soy.$$escapeHtml(resData1055.title), '</strong><div>', soy.$$escapeHtml(resData1055.body), '</div></div>');
    }
    output.append('</pre></div>');
  }
  output.append('</div></div><hr>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from startSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.start = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span3"><div class="well"><div class="media-grid"><a href="#"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><h5>Notifications</h5><ul id="notification"></ul><h5>Agenda</h5><ul class="agenda-short-list" id="agendaTask-list"></ul></div></div><div class="span6"><div class="content" id="multimenu"></div></div><div class="span3"><div class="well"><h5>Suggestions</h5><div id="contact-suggestion"></div><br><h5>Meetings</h5><div>Start a new meeting to organize an event</div><br><div id="meetings"><div><button class="btn btn-success" id="doMeeting-but">Create meeting</button></div><br><ul id="meeting-list"></ul><div><button id="allMeetings-but" class="btn btn-info small">All</button></div></div><br><h5>Find friends</h5><div>Send invitations to your friends or search them in other social networks</div><br><div><button class="btn btn-danger">Send invitations</button></div><br><div><button class="btn btn-primary">Search in other networks</button></div><br></div></div>');
  return opt_sb ? '' : output.toString();
};


template.section.start_old = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="row-fluid"><div class="span2"><div class="well"><div class="media-grid"><a href="#"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><h5>Notifications</h5><ul id="notification"></ul><h5>Agenda</h5><ul class="agenda-short-list" id="agendaTask-list"></ul></div></div></div><div class="row-fluid"><div class="span2"><div class="well"><h5>Suggestions</h5><div id="contact-suggestion"></div><br><h5>Meetings</h5><div>Start a new meeting to organize an event</div><br><div id="meetings"><div><button class="btn success" id="doMeeting-but">Create meeting</button></div><br><ul id="meeting-list"></ul><div><button id="allMeetings-but" class="btn info small">All</button></div></div><br><h5>Find friends</h5><div>Send invitations to your friends or search them in other social networks</div><br><div><button class="btn danger">Send invitations</button></div><br><div><button class="btn primary">Search in other networks</button></div><br></div></div><div class="content" id="multimenu"></div></div></div></div>');
  return opt_sb ? '' : output.toString();
};
