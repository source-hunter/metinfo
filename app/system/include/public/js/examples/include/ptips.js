define(function(require, exports, module) {

	var common = require('common');
	
	overlay.hide();
	iosOverlay({
		text: $('.returnover').html(),
		duration: 2e3,
		icon: "../app/system/include/public/js/examples/loading/img/check.png"
	});
	
});
