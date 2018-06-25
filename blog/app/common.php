<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//函数  二维数组去重
function arr_unique($arr)
{
	$key = array();//存放下标
	$temp = array();
	foreach ($arr as $k=>$v) {
		$key[] = join('+',array_keys($v));
		$v = join('+',$v);
		$temp[] = $v;
	}
	//此处每个数据的下标都是一样的
	//$key = array_unique($key);
	$temp = array_unique($temp);

	$new_key = array();
	$new_temp = array();
	//进行去重后再分割成二维数组
	foreach ($temp as $k=>$v) {
		$new_key[] = explode('+',$key[$k]);
		$new_temp[] = explode('+',$v);
	}

	// 再把新的下标数组$new_key与值数组$new_temp进行对应成一个新的一维数组
	$new_arr = array();
	foreach ($new_temp as $k=>$v) {
		foreach ($v as $k1=>$v1) {
			$new_arr[$k][$new_key[$k][$k1]] = $v1;
		}
	}
	return $new_arr;
}

//跳转美化函数
function alert($msg='',$url='',$icon='',$time=3)
{ 
    $str='<script type="text/javascript" src="'.config('login_static').'/layer/jquery.min.js"></script><script type="text/javascript" src="'.config('login_static').'/layer/layer.js"></script>';//加载jquery和layer
    $str.='<script>$(function(){layer.msg("'.$msg.'",{icon:'.$icon.',time:'.($time*1000).'});setTimeout(function(){self.location.href="'.$url.'"},2000)});</script>';//主要方法
    return $str;
}