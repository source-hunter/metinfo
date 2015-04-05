define(function(require, exports, module) {

	var common = require('common');   		//公用类
	
	require('epl/font-awesome/css/font-awesome.min.css');//图标字体
	
	require('epl/include/box');
	
	if(met_mobile){
		require.async('epl/include/ini_mobile');
	}
	
	/*---------页面组件加载---------*/
	
	common.AssemblyLoad($("body"));
		
	/*表单验证*/
	if($('form.ui-from').length>0)require.async('epl/form/form');
	
	/*操作成功，失败提示信息*/
	if($('.returnover').length>0)require.async('epl/include/ptips');
	
	/*升级控件*/	
	if($('.metcms_upload_download').length>0)require.async('epl/include/download');
	
	/*自动补丁*/
	if($('#met_automatic_upgrade').val() == 1)require.async('epl/include/patch');
	
	/*---------动态事件绑定-----------------*/
	/*输入状态*/
	$(document).on('focus',"input[type='text'],input[type='input'],input[type='password'],textarea",function(){
		$(this).addClass('met-focus');
	});
	$(document).on('focusout',"input[type='text'],input[type='input'],input[type='password'],textarea",function(){
		$(this).removeClass('met-focus');
	});
	
	/*显示隐藏选项*/
	function showhidedom(m){
		var c = m.attr("data-showhide"),d=$("."+c);
		d.stop(true,true);
		if(d.is(":hidden")){
			d.removeClass('none').hide().slideDown();
			if(m.attr("type")=='radio'){
				m.parents('.fbox').find("input").not(m).change(function(){
					d.slideUp();
				});
			}
		}
	}
	$(document).ready(function(){ 
		var p = $(".ui-from input[type='radio'][data-showhide]:checked,.ui-from input[type='checkbox'][data-showhide]:checked");
		if(p.length>0){
			p.each(function(){
				showhidedom($(this));
			});
		}
	});
	$(document).on('change',".ui-from input[type='radio'][data-showhide]",function(){
		showhidedom($(this));
	});
	$(document).on('change',".ui-from input[type='checkbox'][data-showhide]",function(){
		var s = $(this).attr("checked")== 'checked'?true:false;
		if(s){
			showhidedom($(this));
		}else{
			var c = $(this).attr("data-showhide"),d=$("."+c);
			d.stop(true,true);
			d.slideUp();
		}
	});
	
	var dlp = '';
	/*浏览器兼容*/
	if($.browser.msie || ($.browser.mozilla && $.browser.version == '11.0')){  
		var v = Number($.browser.version);
		if(v<10){
			function dlie(dl){
				var dw;
				dl.each(function(){
					var dt = $(this).find("dt"),dd = $(this).find("dd");
					if(dt.length>0){
						dt.css({"float":"left","overflow":"hidden"});
						dd.css({"float":"left","overflow":"hidden"});
						var wd = $(this).width() - (dt.width()+30) - 15;
						dd.width(wd);
						dw = wd;
					}
				});
				dl.each(function(){
					var dt = $(this).find("dt"),dd = $(this).find("dd");
					if(dt.length>0){
						dd.width(dw);
					}
				});
			}
			var dl = $(".v52fmbx dl");
			dlie(dl);
			dlp = 1;
		}
		if(v<12){
			/*提示文字兼容*/
			function searchzdx(dom,label){
				if(dom.val()==''){
					label.show();
				}else{
					label.hide();
				}
				dom.keyup(function(){
					if($(this).val()==''){
						label.show();
					}else{
						label.hide();
					}
				});
				label.click(function(){
					$(this).next().focus();
				});
			}
			$(document).ready(function(){ 
				var pd = $("input[type!='hidden'][placeholder],textarea[placeholder]");
				pd.each(function(){
					var t = $(this).attr("placeholder");
					$(this).removeAttr("placeholder");
					$(this).wrap("<div class='placeholder-ie'></div>");
					$(this).before("<label>"+t+"</label>");
					searchzdx($(this),$(this).prev("label"));
				});
				setInterval(function(){
					pd.each(function(){
						searchzdx($(this),$(this).prev("label"));
					});
				}, "200"); 
			});
		}
	}
	
	/*宽度变化后调整*/
	$("body").attr("data-body-wd",$("body").width());
	$(window).resize(function() {
		if($("body").attr("data-body-wd")!=$("body").width()){
			if(dlp==1){
				dlie(dl);
			}
			$(".ui-table").width("100%");
			$("body").attr("data-body-wd",$("body").width());
		}
	});
	
	
});
