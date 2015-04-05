<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
$weblangok = count($_M['user']['langok'])>1?1:0;//还需要验证权限
$weblang = $_M['langlist']['web'][$_M['lang']];

$toparr = get_adminnav();
$foot = str_replace('$metcms_v',$_M['config']['metcms_v'], $_M['config']['met_agents_copyright_foot']);
$foot = str_replace('$m_now_year',date('Y',time()), $foot);

if ($_M['config']['met_agents_type'] >= 2) {
	$met_admin_logo = "{$_M[url][site]}".str_replace('../', '', $_M['config']['met_agents_logo_index']);
	$query = "SELECT * FROM {$_M['table']['config']} WHERE lang='{$_M['langset']}-metinfo'";
	$result = DB::query($query);
	while($list_config= DB::fetch_array($result)){
		$lang_agents[$list_config['name']]=$list_config['value'];
	}
	
	$_M['word']['indexthanks'] = $lang_agents['met_agents_thanks'];
	$_M['word']['metinfo'] = $lang_agents['met_agents_name'];
	$_M['word']['copyright'] = $lang_agents['met_agents_copyright'];
	$_M['word']['oginmetinfo'] = $lang_agents['met_agents_depict_login'];
	
	$met_agents_display = "style=\"display:none\"";
}else{
	$met_admin_logo = "{$_M[url][ui]}images/logo.png";
}

$msecount = DB::counter($_M['table']['infoprompt'], " WHERE lang='{$_M[lang]}' and see_ok='0'", "*");
echo <<<EOT
-->
<link rel="stylesheet" href="{$_M[url][pub]}ui/admin/css/box.css?{$jsrand}" />
<div id="metcmsbox" 
	data-anyid="{$_M[form][anyid]}" 
	data-iframeurl="{$_M[form][iframeurl]}"
	data-own_form="{$_M[url][own_form]}"
	data-own_name="{$_M[url][own_name]}"
	data-tem="{$_M[url][own_tem]}"
	data-adminurl="{$_M[url][adminurl]}"
	data-apppath="{$_M[url][api]}"
>
<dl class="metmobile_footer">
	<dd><a href="{$_M[url][site_admin]}index.php?n=system&c=news&a=doindex&lang={$_M[lang]}"><i class="fa fa-envelope-o"><span class="mes_{$msecount}">{$msecount}</span></i>消息</a></dd>
	<dd><a href=""><i class="fa fa-globe"></i>语言</a></dd>
	<dd><a href=""><i class="fa fa-user"></i>账户</a></dd>
	<dd><a href=""><i class="fa fa-life-ring"></i>支持</a></dd>
</dl>
<div class="metcms_top">
<div class="metcms_top_box">
	 <div class="metcms_top_left">
		<div class="metcms_top_left_fixed">
		<a href="{$_M[url][site_admin]}index.php?lang={$_M[lang]}" hidefocus="true">
			<img 
				src="{$met_admin_logo}"
				alt="{$_M[word][metinfo]}"
				title="{$_M[word][metinfo]}"
			/>
		</a>
		</div>
	 </div>
	 <div class="metcms_top_right">
		<div class="metcms_top_right_box">
			<div class="metcms_top_right_box_div"> 
<!--
EOT;
if($_M['form']['iframeurl']){
	function get($str){
		$data = array();
		$parameter = explode('&',end(explode('?',$str)));
		foreach($parameter as $val){
			$tmp = explode('=',$val);
			$data[$tmp[0]] = $tmp[1];
		}
		return $data;
	}
	$str = $_M['form']['iframeurl'];
	$data = get($str);
	$_M['form']['anyid'] = $data['anyid'];
	$_M['form']['n'] = $data['n'];
}

$adminnav = get_adminnav();
$adminapp = load::mod_class('myapp/class/getapp', 'new');
$adminapplist = $adminapp->get_app();
if($_M['form']['anyid'] == '44'){
	foreach ($adminapplist as $key => $val) {
		if ($val['m_name'] == $_M['form']['n']) {
			$nav_3 = $val;
			$nav_3 ['name'] = get_word($val['appname']);
			break;
		}
	}
	if(!$nav_3)$nav_3 = $adminnav[$_M['form']['anyid']];
} else {
	$nav_3 = $adminnav[$_M['form']['anyid']];
}
$weizhi = '';
if(!$_M['form']['anyid'])$weizhi = $_M['word']['background_page'];
if($_M['form']['anyid'] == 44 && M_NAME!='myapp')$adminnav[$adminnav[$_M['form']['anyid']]['bigclass']]['name'] = "<a href=\"{$adminnav[44]['url']}\">{$adminnav[44]['name']}";
echo <<<EOT
-->
				<div class="position">
					<i class="fa fa-globe"></i>
					{$_M['langlist']['web'][$_M['lang']]['name']}
					<i class="fa fa-angle-right"></i>
					{$adminnav[$adminnav[$_M['form']['anyid']]['bigclass']]['name']}
					{$weizhi}
<!--
EOT;
if($_M['form']['anyid']){
echo <<<EOT
-->
					<i class="fa fa-angle-right"></i>
					<a href="{$nav_3[url]}">{$nav_3['name']}</a>
<!--
EOT;
}
echo <<<EOT
-->
				</div>
				<ol>
<!--
EOT;
if($weblangok){
echo <<<EOT
-->
					<li class="list lang">
						<a href="#" class="lang_name">{$weblang['name']}<i class=" fa fa-caret-down"></i></a>
						<dl>
<!--
EOT;
foreach($_M['user']['langok'] as $key=>$val){
$url_now ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
if(!strstr($url_now, "lang=")) {
	$val['url'] = $_M[url][site_admin]."index.php?lang={$val['mark']}";
} else {
	$val['url'] = str_replace(array("lang={$_M['lang']}", "lang%3D{$_M['lang']}"), array("lang={$val['mark']}", "lang%3D{$val['mark']}"), $url_now);
}
echo <<<EOT
-->
							<dd><a href="{$val['url']}">{$val[name]}</a></dd>
<!--
EOT;
}
echo <<<EOT
-->
							<dd><a href="{$_M[url][site_admin]}system/lang/lang.php?anyid=10&langaction=add&lang={$_M[lang]}&cs=1" class="addlang"><i class="fa fa-plus"></i>{$_M['word']['langweb']}</a></dd>
						</dl>
					</li>
<!--
EOT;
}
echo <<<EOT
-->
					<li class="list mesage"><a href="{$_M[url][site_admin]}index.php?n=system&c=news&a=doindex&lang={$_M[lang]}"><i class="fa fa-envelope-o"></i>
					<span class="mes_{$msecount}">{$msecount}</span>
					</a>
					
					</li>
					<li class="list lang">
						<a href="index.php?lang={$_M[lang]}" class="lang_name">{$_M['user']['admin_name']}<i class=" fa fa-caret-down"></i></a>
						<dl>
							<dd><a target="_top" href="{$_M[url][site_admin]}admin/editor_pass.php?anyid=47&lang={$_M[lang]}">{$_M['word']['modify_information']}</a></dd>
							<dd><a target="_top" href="{$_M[url][site_admin]}login/login_out.php">{$_M[word][indexloginout]}</a></dd>
						</dl>
					</li>
					
					<li class="list lang sq" {$met_agents_display}>
<!--
EOT;
$auth = load::mod_class('system/class/auth', 'new');
$otherinfoauth = $auth->have_auth();
if(!$otherinfoauth) {
echo <<<EOT
-->				
						<a href="#" class="lang_name">{$_M['word']['indexbbs']}<i class=" fa fa-caret-down"></i></a>
						<dl>
							<dd>{$_M['word']['sys_authorization']}</dd>
							<dd><a href="{$_M['url']['adminurl']}&n=system&c=authcode&a=doindex">{$_M['word']['sys_authorization1']}</a></dd>
							<dd><a target="_blank" class="liaojie" href="http://www.metinfo.cn/web/product.htm">{$_M['word']['sys_authorization2']}</a></dd>
						</dl>
<!--
EOT;
} else {
echo <<<EOT
-->	
						<a href="#" class="lang_name">{$_M['word']['indexbbs']}<i class=" fa fa-caret-down"></i></a>
						<dl>
							<dd>{$_M['word']['authorization_level']}</dd>
							<dd><a href="#" style="margin-top:5px;">{$otherinfoauth['info1']}</a></dd>
							<dd><a class="liaojie" target="_blank" href="http://www.metinfo.cn/code/code.php?url={$_M['url']['site']}">{$_M['word']['technical_support']}</a></dd>
							<dd><a class="nobo" href="{$_M['url']['adminurl']}&n=system&c=authcode&a=doindex">{$_M['word']['entry_authorization']}</a></dd>
						</dl>
<!--
EOT;
}
echo <<<EOT
-->
			

					</li>
				</ol>
				<div class="metcms_top_right_box_border"></div>
			</div>
		</div>
	 </div>
</div>
</div>
<div class="metcms_cont">
	<div class="metcms_cont_left">
		<div class="metcms_cont_left_fixed">
		<dl class="jslist">
			<dt><a target="_blank" href="{$_M['config']['met_weburl']}index.php?lang={$_M['lang']}" title="{$_M[word][indexhome]}"><i class="fa fa-home"></i>{$_M[word][indexhome]}</a></dt>
		</dl>
<!--
EOT;
$i=0;
foreach($toparr as $key=>$val){
if($val['type']==1){
$cnm='';
$dt="{$val[name]}";
if($val[icon]!=''){
$cnm = 'class="jslist"';
$dt="{$val[icon]}{$val[name]}<i class=\"fa fa-angle-right\"></i>";
}
echo <<<EOT
-->
		<dl {$cnm}>
			<dt>{$dt}</dt>
			<dd>
<!--
EOT;
foreach($toparr as $key=>$val2){
if($val2['type']==2&&$val2['bigclass']==$val['id']){
$target = $val2[id]==70||$val2[id]==18?'target="_blank"':'';
echo <<<EOT
-->
					<a href="{$val2[url]}" {$val2[property]} title="{$val2[name]}" {$target} id="metnav_{$val2[id]}">{$val2[icon]}{$val2[name]}</a>
<!--
EOT;
}}
echo <<<EOT
-->	
			</dd>
		</dl>
<!--
EOT;
$i++;
}}
echo <<<EOT
-->
		</div>
	</div>
	<div class="metcms_cont_right">
		<div class="metcms_cont_right_box">
		<div class="metcms_cont_right_box_box">
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>