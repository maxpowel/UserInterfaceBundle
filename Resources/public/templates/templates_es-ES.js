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
  output.append('<div class="topbar" id="topbar"><div class="topbar-inner"><div class="container"><ul class="nav"><li id="menu-start"><a href="#start">Start</a></li><li id="menu-profile"><a href="#profile">Profile</a></li><li id="menu-search"><a href="#search">Search</a></li><li id="menu-multimedia"><a href="#multimedia">Multimedia</a></li><li id="menu-messages"><a href="#messages">Messages</a></li><li id="menu-agenda"><a href="#agenda">Agenda</a></li><li id="menu-settings"><a href="#preferences">Preferences</a></li></ul><form action="" id="quick-search-form" class="pull-left"><ul class="nav secondary-nav"><li class="dropdown" id="quick-search-result"><input id="quick-search-input" class="quick-search" class="dropdown-toggle" type="text" placeholder="Quick search"><button id="uploadPhotos-but" style="margin-left:15px" class="btn success small"><span class="upload">Upload photos</span><span class="uploading" style="display:none">Uploading <span id="totalPercent"></span>%</span></button><ul class="dropdown-menu" style="\tmax-width: 230px; top: 35px;"><li><a href="#">Nosequien - Estado de mierda</a></li><li><a href="#">Otra persona con un nick super super super largo</a></li><li class="divider"></li><li><a href="#">Settings</a></li></ul></li></ul></form><ul class="nav secondary-nav"><li class="dropdown"><a class="dropdown-toggle" href="#">Amigos</a><ul class="dropdown-menu"><li><a href="#">Nosequien - Estado de mierda</a></li><li><a href="#">Otra persona con un nick super super super largo</a></li><li class="divider"></li><li><a href="#">Configuración</a></li></ul></li></ul></div></div></div><div id="content"></div>');
  return opt_sb ? '' : output.toString();
};


template.appView.multimenu = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div id="original"></div>');
  var subsectionList74 = opt_data.subsections;
  var subsectionListLen74 = subsectionList74.length;
  for (var subsectionIndex74 = 0; subsectionIndex74 < subsectionListLen74; subsectionIndex74++) {
    var subsectionData74 = subsectionList74[subsectionIndex74];
    output.append('<div style="display:none" id="', soy.$$escapeHtml(subsectionData74.subSectionId), '" class="submenu"><button class="btn wlarge-btn ', soy.$$escapeHtml(subsectionData74.buttonClass), ' back-but">Back</button><div class="subSection-content"></div></div>');
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
  output.append('</select><h4>Select your photos</h4><div>You can select multiple files</div><form id="photoForm" enctype="multipart/form-data" method="post" action="/upload"><input type="file" id="files" multiple="multiple"/><div id="fileInfo" style="display:none; overflow: auto; max-height:400px"><table class="bordered-table zebra-striped"><thead><tr><th>Filename</th><th>Size</th></tr></thead><tbody></tbody></table></div></form></div><div class="modal-footer"><button class="btn upload secondary disabled">Upload</button><button class="btn cancel primary">Cancel</button></div>');
  return opt_sb ? '' : output.toString();
};


template.appView.uploadResume = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="arrow"></div><div class="inner"><h3 class="title"><button id="resume-but" class="btn" data-toggle="toggle" >Check uploaded photos</button><a href="javascript:void(0)" class="close">×</a></h3><div style="display:none" class="content"><p><ul class="media-grid"></ul></p></div></div>');
  return opt_sb ? '' : output.toString();
};


template.appView.resumeEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<a href="#"><img alt="" src="/thumbnail/profile?id=', soy.$$escapeHtml(opt_data.id), '" class="thumbnail"></a>');
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
  output.append('<table style="width:150px" class="hero-unit-simple"><tbody><tr><td colspan="2"><div align="center"><b>Access to my account</b></div></td></tr><tr><td>Username</td><td><input type="text" id="username"></td></tr><tr><td>Password</td><td><input type="password" id="password"></td></tr><tr><td colspan="2"><div align="center" class="alert-message block-message error" style="display:none"><a href="javascript:void(0)" class="close">×</a>The data entered are incorrect</div><div align="center"><button class="btn success" id="login-btn">Login</button></div></td></tr></tbody></table><a href="#newAccount" id="newAccount-btn"><span class="label warning">New account</span></a>&nbsp;&nbsp;<a href="#recoverPassword" id="recoverPassword-btn"><span class="label important">Recover password</span></a>');
  return opt_sb ? '' : output.toString();
};


template.loginApp.newAccount = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<table style="width:150px" class="hero-unit-simple"><tbody><tr><td colspan="2"><div align="center"><b>Please complete the form</b></div></td></tr><tr><td>Name</td><td><input type="text" id="name"></td></tr><tr><td>Email</td><td><input type="text" id="email"></td></tr><tr><td>Password</td><td><input type="text" id="password"></td></tr><tr><td>Repeat password</td><td><input type="text" id="rpassword"></td></tr><tr><td>Birthdate</td><td><select id="day" class="tinySelect"><option>Day</option>');
  for (var i192 = 1; i192 < 32; i192++) {
    output.append('<option value="', soy.$$escapeHtml(i192), '">', soy.$$escapeHtml(i192), '</option>');
  }
  output.append('</select><select id="mediumSelect" name="tinySelect" class="tinySelect"><option>Month</option><option value="1">Jaunary</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select><select id="mediumSelect" name="tinySelect" class="tinySelect"><option>Year</option>');
  for (var year235 = -2010; year235 < -1900; year235++) {
    output.append('<option>', soy.$$escapeHtml(-year235), '</option>');
  }
  output.append('</select></td></tr><tr><td colspan="2"><div align="center"><button class="btn primary" id="createAccount-btn">Create account</button></div></td></tr></tbody></table><a href="#" id="goLogin-btn"><span class="label success">Login</span></a>&nbsp;&nbsp;<a href="#recoverPassword" id="recoverPassword-btn"><span class="label important">Recover password</span></a>');
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
  output.append('\t<h3>Main information</h3><table><tbody id="meetingInformation"><tr><td>Title</td><td><input type="text" class="xlarge"/></td></tr><tr><td>Date</td><td><input type="text" class="xlarge" /></td></tr><tr><td>Description</td><td><textarea class="xlarge" ></textarea></td></tr><tbody></table><button class="btn" id="addField-but">Add field</button><h3 style="margin-top:17px">Participants</h3><div>Invite people to your meeting</div><br><div><input type="text" placeholder="Name of the person or group"></div>');
  return opt_sb ? '' : output.toString();
};


template.meetingView.doMeetingRow = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<td>', soy.$$escapeHtml(opt_data.text), '</td><td><input type="text" class="xlarge"/><a href="javascript:void(0)" class="close">×</a></td>');
  return opt_sb ? '' : output.toString();
};


template.meetingView.doMeetingAddField = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal hide fade" style="display: none;"><div class="modal-header"><a class="close" href="#">×</a><h3>New field</h3></div><div class="modal-body">Field name:&nbsp;&nbsp;<input type="text"></div><div class="modal-footer"><button class="btn secondary">Cancel</button><button class="btn primary">Accept</button></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from messagesSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.multimedia = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sidebar"><div class="well"><h5>Albums</h5><div id="folderList"></div><br><br><br><br><div id="newFolder-cont"></div></div></div><div id="multimenu" class="content-big"></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from messagesView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.messagesView == 'undefined') { template.messagesView = {}; }


template.messagesView.messageList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3 id="folderName">', soy.$$escapeHtml(opt_data.folder), '</h3></div><div align="right" class="breadcrumb"><div style="float:left; margin-top:20px; margin-left:20px">Check <a id="check-all" href="javascript:void(0)">All</a> <a id="check-none" href="javascript:void(0)">None</a>&nbsp;&nbsp;&nbsp;<button class="btn error small disabled" id="remove-btn">Remove checked</button>&nbsp;&nbsp;&nbsp;<button class="btn info small disabled" id="move-btn">Move checked</button>&nbsp;&nbsp;&nbsp;<span id="optButCont"></span></div><div style="width:200px;float:right;">Page <span id="start-page"></span> of <span id="last-page"></span></div><div class="pagination" style="width:205px"><ul><li class="prev disabled"><a href="javascript:void(0)" id="previousPage-btn">← Previous</a></li><li class="next disabled"><a href="javascript:void(0)" id="nextPage-btn">Next page →</a></li></ul></div></div><div id="message-list"><table class="zebra-striped"><tbody id="message-table"></tboby></table></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.message = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<td><div style="cursor:pointer;cursor:hand" id="message"><span class="span"><input type="checkbox" class="ckbox"></span><span class="span">R</span><span class="span3">Alvaro García Gómez</span><span class="span6">ASUNTO</span><span style="text-align:right" class="span2">FECHA</span></div><div></div></td>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newMessage = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t', (opt_data.to == null) ? '<h3>New message</h3>' : '', '<table><tbody><tr>', (opt_data.to == null) ? '<td>Send to</td><td><input type="text" id="to" class="xlarge"/></td>' : '<td>Send to</td><td>' + soy.$$escapeHtml(opt_data.to.name) + '<input type="hidden" id="to" class="xlarge"/></td>', '</tr><tr><td>Subject</td><td><input type="text" class="xlarge" id="subject"/></td></tr><tr><td>Body</td><td><textarea class="xlarge" id="body"></textarea></td></tr><tbody></table><div class="row show-grid"><div class="span2"><button class="btn" id="attachFile-btn">Attach file</button></div><div class="span2"><button class="btn primary" id="attachFile-btn">Send</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.folderOptions = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<h3>Options</h3><table><tbody><tr><td>Folder name</td><td><input value="', soy.$$escapeHtml(opt_data.name), '" type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn" id="save-folder-btn">Save changes</button></div><div class="span"><button id="remove-folder-btn" class="btn error">Remove folder</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newFolder = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<h3>New folder</h3><table><tbody><tr><td>Folder name</td><td><input type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn primary" id="save-folder-btn">Create</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.removeFolderAsk = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal hide fade" style="display: none;"><div class="modal-header"><h3>Remove folder</h3></div><div class="modal-body">Are you really sure you want to delete the folder ', soy.$$escapeHtml(opt_data.folder), '?</div><div class="modal-footer"><button class="btn remove secondary">Remove</button><button class="btn cancel primary">Cancel</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.messageFolder = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<label><span style="margin-left: 4px"><a href="javascript:void(0)" class="load">', soy.$$escapeHtml(opt_data.name), '</a></span></label>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newMessageButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button id="new-message-btn" class="btn success">New message</button>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.folderOptionsButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button class="btn primary small" id="options-btn">Options</button>');
  return opt_sb ? '' : output.toString();
};


template.messagesView.newFolderButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button id="new-folder-btn" class="btn info">New folder</button>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from multimediaSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.messages = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sidebar"><div class="well"><h5>Folders</h5><div id="folderList"></div><br><br><div id="newButton-cont"></div><br><br><div id="newFolder-cont"></div></div></div><div id="multimenu" class="content-big"></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from multimediaView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.multimediaView == 'undefined') { template.multimediaView = {}; }


template.multimediaView.photoList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3 id="folderName">', soy.$$escapeHtml(opt_data.folder), '</h3></div><div align="right" class="breadcrumb"><div style="float:left; margin-top:20px; margin-left:20px">Check <a id="check-all" href="javascript:void(0)">All</a> <a id="check-none" href="javascript:void(0)">None</a>&nbsp;&nbsp;&nbsp;<button class="btn error small disabled" id="remove-btn">Remove checked</button>&nbsp;&nbsp;&nbsp;<button class="btn info small disabled" id="move-btn">Move checked</button>&nbsp;&nbsp;&nbsp;<span id="optButCont"></span></div><div style="width:200px;float:right;">Page <span id="start-page"></span> of <span id="last-page"></span></div><div class="pagination" style="width:205px"><ul><li class="prev disabled"><a href="javascript:void(0)" id="previousPage-btn">← Previous</a></li><li class="next disabled"><a href="javascript:void(0)" id="nextPage-btn">Next page →</a></li></ul></div></div><div><ul class="media-grid" id="photo-list"></ul></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.photo = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<a href="#"><img alt="" src="/thumbnail/profile?id=', soy.$$escapeHtml(opt_data.id), '" class="thumbnail"></a><span class="span" style="margin-left:-20px; margin-top: 5px"><input type="checkbox" class="ckbox"></span>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.newMessage = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t', (opt_data.to == null) ? '<h3>New message</h3>' : '', '<table><tbody><tr>', (opt_data.to == null) ? '<td>Send to</td><td><input type="text" id="to" class="xlarge"/></td>' : '<td>Send to</td><td>' + soy.$$escapeHtml(opt_data.to.name) + '<input type="hidden" id="to" class="xlarge"/></td>', '</tr><tr><td>Subject</td><td><input type="text" class="xlarge" id="subject"/></td></tr><tr><td>Body</td><td><textarea class="xlarge" id="body"></textarea></td></tr><tbody></table><div class="row show-grid"><div class="span2"><button class="btn" id="attachFile-btn">Attach file</button></div><div class="span2"><button class="btn primary" id="attachFile-btn">Send</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.albumOptions = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<h3>Options</h3><table><tbody><tr><td>Album name</td><td><input value="', soy.$$escapeHtml(opt_data.name), '" type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn" id="save-folder-btn">Save changes</button></div><div class="span"><button id="remove-folder-btn" class="btn error">Remove album</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.newAlbum = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<h3>New album</h3><table><tbody><tr><td>Album name</td><td><input type="text" id="folderName-input" class="xlarge"/></td></tr><tbody></table><div class="row show-grid"><div class="span"><button class="btn primary" id="save-folder-btn">Create</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.removeAlbumAsk = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="modal hide fade" style="display: none;"><div class="modal-header"><h3>Remove album</h3></div><div class="modal-body">Are you really sure you want to delete the album ', soy.$$escapeHtml(opt_data.folder), '?</div><div class="modal-footer"><button class="btn remove secondary">Remove</button><button class="btn cancel primary">Cancel</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.messageFolder = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<label><span style="margin-left: 4px"><a href="javascript:void(0)" class="load">', soy.$$escapeHtml(opt_data.name), '</a></span></label>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.newMessageButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button id="new-message-btn" class="btn success">New message</button>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.albumOptionsButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button class="btn primary small" id="options-btn">Options</button>');
  return opt_sb ? '' : output.toString();
};


template.multimediaView.newAlbumButton = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<button id="new-folder-btn" class="btn info">New album</button>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from newnessView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.newnessView == 'undefined') { template.newnessView = {}; }


template.newnessView.newness = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div style="min-height: 48px"><div style="float:left; position:relative"><a href="#as"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><div style="margin-left:60px"><div><a href="#">', soy.$$escapeHtml(opt_data.authorName), '</a> - ', soy.$$escapeHtml(opt_data.date), '</div><div>', soy.$$escapeHtml(opt_data.body), '</div><div style="padding:10px"><a href="#">Comment</a> - <a href="#">I like it</a> - <a href="#">I don\'t like it</a></div></div></div><hr>');
  return opt_sb ? '' : output.toString();
};


template.newnessView.newnessList = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="hero-unit">', (opt_data.isOwner == true) ? '<h3>Share something</h3>' : '<h3>Share something with ' + soy.$$escapeHtml(opt_data.friendName) + '</h3>', '<input type="text" class="wlarge" id="new-share" placeholder="Write here"></div><div id="newness-container"></div><button class="btn wlarge-btn" id="more-newness">More</button>');
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
// This file was automatically generated from preferencesSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.preferences = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sidebar"><div class="well"><div id="folderList"><ul class="inputs-list"><li style="padding:10px"><label><span style="margin-left: 4px"><a id="personal-lnk" class="load" href="javascript:void(0)">Personal</a></span></label></li><li style="padding:10px"><label><span style="margin-left: 4px"><a id="aboutMe-lnk" class="load" href="javascript:void(0)">About me</a></span></label></li><li style="padding:10px"><label><span style="margin-left: 4px"><a id="favourites-lnk" class="load" href="javascript:void(0)">Favourites</a></span></label></li><li style="padding:10px"><label><span style="margin-left: 4px"><a id="security-lnk" class="load" href="javascript:void(0)">Security</a></span></label></li><li style="padding:10px"><label><span style="margin-left: 4px"><a id="customize-lnk" class="load" href="javascript:void(0)">Customize</a></span></label></li></ul></div></div></div></div><div id="bodyContent" class="content-big"></div></div></div>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from preferencesView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.preferencesView == 'undefined') { template.preferencesView = {}; }


template.preferencesView.personalInformation = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>Personal information</h3></div><div><table><tr><td>First name</td><td><input type="text" class="span5" value="', soy.$$escapeHtml(opt_data.name), '"></td></tr><tr><td>Last name</td><td><input type="text" class="span5" value="', soy.$$escapeHtml(opt_data.lastName), '"></td></tr><tr><td>Email name</td><td><input type="text" class="span5" value="', soy.$$escapeHtml(opt_data.email), '"></td></tr></table></div><div><button class="btn primary">Save changes</button></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.aboutMeEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div align="center"><table><tr><td><input type="text" class="span7" placeholder="Title" value="', soy.$$escapeHtml(opt_data.title), '"></td></tr><tr><td><textarea type="text" class="span12" rows="12" placeholder="Description">', soy.$$escapeHtml(opt_data.body), '</textarea></td></tr></table></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.aboutMe = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>About me</h3></div>');
  var elementList677 = opt_data.elements;
  var elementListLen677 = elementList677.length;
  for (var elementIndex677 = 0; elementIndex677 < elementListLen677; elementIndex677++) {
    var elementData677 = elementList677[elementIndex677];
    template.preferencesView.aboutMeEntry(elementData677, output);
  }
  output.append('<div class="row show-grid"><div class="span2"><button class="btn">Add new</button></button></div><div class="span3"><button class="btn primary">Save changes</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.security = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>Security</h3></div><div align="center"><div><button class="btn" id="manageGroups-btn">Manage groups</button></button></div><br><div><button class="btn" id="profilePermissions-btn">Profile permissions</button></div></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.groupListEntry = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<label><span style="margin-left: 4px"><a href="javascript:void(0)" class="load">', soy.$$escapeHtml(opt_data.name), '</a></span></label>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.editGroup = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div><h4>Group name<h4></div><div><input type="text" class="span4" value="', soy.$$escapeHtml(opt_data.name), '"></div><br><div><h4>Group members<h4></div><div><select id="memberList" multiple="multiple" size="15" class="span7"></select></div><div><button id="removeSelected-btn" class="btn danger disabled">Remove selected from the group</button></div><br><div><h4>Add members to the group<h4></div><div>Person name: <input type="text" id="personName-txt" class="span4"></div><div><button style="margin-top:4px" id="addMember-btn" class="btn success">Add member to the group</button></div>');
  return opt_sb ? '' : output.toString();
};


template.preferencesView.manageGroups = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t\t\t<div><h3>Manage groups</h3></div><table><tr><td><h4>Group list</h4></td></tr><tr><td><ul id="groupList" class="inputs-list"></ul></td></tr></table><br><table><tr><td colspan="2"><h4>New group</h4></td></tr><tr><td colspan><div>Name</td><td><input type="text" class="span3" id="newGroupName"></div></td></tr><tr><td colspan="2"><div><button class="btn primary" id="createGroup-btn">Create</button></div></td></tr></table>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from profileSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.profile = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sidebar"><div class="well"><div class="media-grid"><a href="#"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><div id="personalInfo-cont"></div><div id="favourites-cont"></div></div></div><div class="sidebar-right"><div class="well"><h5>Last photos</h5><div id="lastPhotos-cont"></div><h5>Friends</h5><div id="friends-cont"></div></div></div><div class="content" id="newness"><div><h2>', soy.$$escapeHtml(opt_data.ownerName), '\'s profile</h2></div><div align="center"><ul class="pills" style="width: 400px; height:50px"><li class="active"><a id="newness-pill" href="javascript:void(0)">Newness</a></li><li><a id="aboutMe-pill" href="javascript:void(0)">About me</a></li><li><a id="sendMessage-pill" href="javascript:void(0)">Send message</a></li><li><a id="albums-pill" href="javascript:void(0)">Albums</a></li></ul></div><!--newness--><div id="newness-list" class="subSection"><div id="newness-container"></div></div><!--newness end--><!--about me--><div id="aboutMe" style="display:none" class="subSection"><div id="aboutMe-container"></div></div><!--about me end--><!--send message--><div id="sendMessage" style="display:none" class="subSection"><div id="sendMessage-container"></div></div><!--send message end--><!--albumlist--><div id="albumList" style="display:none" class="subSection"><div id="albumList-container"></div></div><!--about me end--></div></div>');
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
  var favouriteList818 = opt_data.favourites;
  var favouriteListLen818 = favouriteList818.length;
  for (var favouriteIndex818 = 0; favouriteIndex818 < favouriteListLen818; favouriteIndex818++) {
    var favouriteData818 = favouriteList818[favouriteIndex818];
    output.append('<li><a href="#', soy.$$escapeHtml(favouriteData818.url), '">', soy.$$escapeHtml(favouriteData818.title), '</li>');
  }
  output.append('</ul>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from searchSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.search = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sidebar"><div class="well"><input type="text" id="query" class="span3" placeholder="Search..."/><br><br><button class="btn primary" id="but-search">Search</button><br><br><h5>City</h5><input type="text" id="city" class="span3" placeholder="City, town or villate"/><div id="city-container" style="margin:10px" /><br><br><h5>Things in common</h5><span class="help-block">Study places, hobbies, etc</span><input type="text" id="thing" class="span3"/><div id="thing-container" style="margin:10px" /><br><br><h5>Aproximately age</h5><input type="text" style="width:23px" maxlength="3" id="years"/> years</div></div><div class="sidebar-right"><div class="well"><h5>Is friend of...</h5><input type="text" class="span3" id="friend" placeholder="Friend name"/><div id="friend-container" style="margin:10px" /><br><br><h5>About me</h5><span class="help-block">Some extra information about what are you looking for</span><textarea id="other" class="span3" rows="7"></textarea><br><br></div></div><div class="content" id="search-result"><table class="hero-unit-simple"><tr><td><h3>Please fill any field</h3></td></tr></table></div>');
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


template.searchView.searchResult = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div style="min-height: 48px"><div style="float:left; position:relative"><a href="#as"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><div style="margin-left:60px"><div><a href="#">', soy.$$escapeHtml(opt_data.name), '</a></div>', (opt_data.city != null) ? '<div>City: ' + soy.$$escapeHtml(opt_data.city.name) + '</div>' : '');
  if (opt_data.things != null) {
    output.append('<div><strong>Things in common</strong></div><ul>');
    var thingList903 = opt_data.things;
    var thingListLen903 = thingList903.length;
    for (var thingIndex903 = 0; thingIndex903 < thingListLen903; thingIndex903++) {
      var thingData903 = thingList903[thingIndex903];
      output.append('<li>', soy.$$escapeHtml(thingData903.name), '</li>');
    }
    output.append('</ul>');
  }
  if (opt_data.friends != null) {
    output.append('<div><strong>Friends in common</strong></div><ul>');
    var friendList915 = opt_data.friends;
    var friendListLen915 = friendList915.length;
    for (var friendIndex915 = 0; friendIndex915 < friendListLen915; friendIndex915++) {
      var friendData915 = friendList915[friendIndex915];
      output.append('<li>', soy.$$escapeHtml(friendData915.name), '</li>');
    }
    output.append('</ul>');
  }
  output.append((opt_data.other != null) ? '<div><pre><div style="padding:10px">' + soy.$$escapeHtml(opt_data.other) + '</div></pre></div>' : '', '</div></div><hr>');
  return opt_sb ? '' : output.toString();
};

;
// This file was automatically generated from startSectionView.soy.
// Please don't edit this file by hand.

if (typeof template == 'undefined') { var template = {}; }
if (typeof template.section == 'undefined') { template.section = {}; }


template.section.start = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sidebar"><div class="well"><div class="media-grid"><a href="#"><img alt="" src="', soy.$$escapeHtml(opt_data.thumbnail), '" class="thumbnail"></a></div><h5>Notifications</h5><ul id="notification"></ul><h5>Agenda</h5><ul class="agenda-short-list" id="agendaTask-list"></ul></div></div><div class="sidebar-right"><div class="well"><h5>Suggestions</h5><div id="contact-suggestion"></div><br><h5>Meetings</h5><div>Start a new meeting to organize an event</div><br><div id="meetings"><div><button class="btn success" id="doMeeting-but">Create meeting</button></div><br><ul id="meeting-list"></ul><div><button id="allMeetings-but" class="btn info small">All</button></div></div><br><h5>Find friends</h5><div>Send invitations to your friends or search them in other social networks</div><br><div><button class="btn danger">Send invitations</button></div><br><div><button class="btn primary">Search in other networks</button></div><br></div></div><div class="content" id="multimenu"></div></div>');
  return opt_sb ? '' : output.toString();
};
