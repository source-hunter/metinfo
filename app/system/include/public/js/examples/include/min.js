define(function(require, exports, module) {

	var common = require('common');
	
	common.loading('loading');
	
	require('epl/include/ini');//初始化
	
	require('tem/js/own');//加载默认文件

	$(document).ready(function(){
		overlay.hide();
	});
	
});
