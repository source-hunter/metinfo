<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
$filpy = basename(dirname(__FILE__));
$fmodule=3;
if(@$_GET['metid']){
	if(@$_GET['list'] == 1){
		$cmodule='product_list';
	}else{
		$cmodule='product_show';
	}
}else{
	$cmodule='product_list';
}
require_once '../include/module.php';
require_once $module;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>