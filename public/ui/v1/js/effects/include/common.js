define(function(require, exports, module) {

	if(met_mobile=='mobile'){
			require('effects/amazeui/css/font.css');
		$ = require('effects/amazeui/js/jquery.min');
			require('effects/amazeui/js/amazeui.min');
	}else{
		var $ = require('jquery');
	}
	window.jQuery = window.$ = $;
	
	/*语言文字*/
	exports.langtxt = function(){
		var bol = '';
			$.ajax({
				type: "GET",
				async:false,
				cache: false,
				dataType: "json",
				url: met_weburl + 'cache/lang_json_'+lang+'.php',
				success: function(json){
					bol = json;
				}
			});
		return bol;
	}
	
	/*列表自适应排版*/
	function listpun(zd,ld,min,h){//整体元素,列表元素,最小宽度
			h = h?h:ld.length;
		var z= zd.width(),
			p = parseInt(z/h);
		if(p>min){
			var w = 1/h*100;
			w = w.toFixed(5)+'%';
			ld.css({"width":w});
			/*
			var i =0,l=1;
			ld.each(function(){//等高
				i++;
				$(this).find('h1,h2,h3,h4,h5,h6').addClass("met_denggao_"+l);
				if(i==h){
					metHeight($(".met_denggao_"+l));
					i=0;
					l++;
				}
			});
			*/
		}else{
			listpun(zd,ld,min,h-1);
		}
	}
	exports.listpun = function(zd,ld,min){//整体元素,列表元素,最小宽度
		if(ld.length>0)listpun(zd,ld,min);
	}
	
	function metHeight(group){
		tallest=0;
		group.each(function(){
			thisHeight=$(this).height();
			if(thisHeight>tallest){
				tallest=thisHeight;
			}
		});
		group.height(tallest);	
	}
	//等高
	exports.metHeight = function(group){
		metHeight(group);
	}
});