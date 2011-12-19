// This file was automatically generated from simple.soy.
// Please don't edit this file by hand.

if (typeof examples == 'undefined') { var examples = {}; }
if (typeof examples.simple == 'undefined') { examples.simple = {}; }


examples.simple.helloWorld = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div style="min-height: 48px"><div style="float:left; position:relative"><a href="#as"><img alt="" src="http://placehold.it/48x48" class="thumbnail"></a></div><div style="margin-left:60px"><div><a href="#">', soy.$$escapeHtml(opt_data.authorName), '</a> - ', soy.$$escapeHtml(opt_data.date), '</div><div>', soy.$$escapeHtml(opt_data.body), '</div><div style="padding:10px"><a href="#">Comentar</a> - <a href="#">Me gusta</a> - <a href="#">No me gusta</a></div></div></div>');
  return opt_sb ? '' : output.toString();
};
