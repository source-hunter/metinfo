define(function(require, exports, module) {
	var $ = require('jquery');
	var common = require('common');
	var langtxt = common.langtxt();
	var doa = getQueryString('a');

	if(doa!='doemailset'){
		$("a.morodllist").click(function(){
			var d = $("dl.morodllist");
			if(d.is(":hidden")){
				d.slideDown();
			}else{
				d.slideUp();
			}
			return false;
		});
		
		$("a.emailtest").click(function(){
			var d = $(this);
			d.next('span').html(langtxt.jsx18);
			$.ajax({
				url: d.attr('href'),
				type: "POST",
				data: $(".ui-from").serialize(),
				timeout: 30000,
				error: function(dom, text, errors) {
					if (text == 'timeout'){
						d.next('span').html(langtxt.jsx19);
					}
				},
				success: function(data) {
					d.next('span').html(data);
				}
			});
			return false;
		});
	}

});