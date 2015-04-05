<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('admin');

class index extends admin {
	public function doindex() {
		global $_M;
		
		/*获取统计数据*/
		function statime($ymd,$day=''){
			$day=$day==''?time():strtotime($day);
			$time=strtotime(date($ymd,$day));
			return $time;
		}
		
		$stat = array();
		for($i = 1; $i <= 5; $i++) {
			$stats = $i==1?statime("Y-m-d"):statime("Y-m-d",(0-$i+1)." day");
			$query = "select * from {$_M[table][visit_summary]} WHERE stattime ='{$stats}'";
			$stat[$i] = DB::get_one($query);
			if(!$stat[$i]){
				$stat[$i]['pv'] = 0;
				$stat[$i]['alone'] = 0;
				$stat[$i]['ip'] = 0;
			}
			$stat[$i]['day'] = date('Y-m-d', $stats);
			if($i==1)$stat[$i]['day'] = $_M['word']['today'];
			if($i==2)$stat[$i]['day'] = $_M['word']['yesterday'];
		}
		
		/*图表数据*/
		$dm = date('H', time());
		$dt = $dm - 8;
		$dt = $dt<0?$dt+24:$dt;
		for($i = 0; $i <= 23; $i++) {
			if($i<=$dm&&$i>=$dt){
				$d = $i<10?'0'.$i:$i;
				$chartdata['labels'][] = "{$d}:59";
			}
		}
		$chartcolor[0] = "#23b7e5";
		$chartcolor[1] = "#7266ba";
		$chartcolor[2] = "#23ad44";
		foreach($chartcolor as $key=>$val){
			$chartdata['datasets'][$key]['fillColor'] = $val;
			$chartdata['datasets'][$key]['strokeColor'] = $val;
			$chartdata['datasets'][$key]['pointColor'] = $val;
			$chartdata['datasets'][$key]['pointStrokeColor'] = '#fff';
		}
		$nowcrt = explode("|",$stat[1]['parttime']);
		$i=0;
		foreach($nowcrt as $val){
			if($i<=$dm&&$i>=$dt){
				$aowcrt='';
				if($val){
					$aowcrt = explode("-",$val);
					$val = array();
					$val[0] = $aowcrt[0];
					$val[1] = $aowcrt[1];
					$val[2] = $aowcrt[2];
				}else{
					$val[0] = 0;
					$val[1] = 0;
					$val[2] = 0;
				}
				$chartdata['datasets'][0]['data'][] = $val[0];
				$chartdata['datasets'][1]['data'][] = $val[1];
				$chartdata['datasets'][2]['data'][] = $val[2];
			}
			$i++;
		}
		$chartdata = jsonencode($chartdata);
		
		/*我的应用*/
		$query = "select * from {$_M['table']['admin_column']} where bigclass='44'";
		$app_in = DB::get_all($query);
		$privilege = background_privilege();
		require $this->template('tem/index');
	}
	
	public function doindex1() {
		$authinfo = DB::get_all("SELECT * FROM met_templates where lang='tc'");
		foreach($authinfo as $key=>$val){
		echo "INSERT INTO met_templates VALUES('{$val[id]}','{$val[no]}','{$val[pos]}','{$val[no_order]}','{$val[type]}','{$val[style]}','{$val[selectd]}','{$val[name]}','{$val[value]}','{$val[defaultvalue]}','{$val[valueinfo]}','{$val[tips]}','{$val[lang]}');"."<br>";
		}
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>