<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
   //登陆验证 自定义方法
	public function login($data)
	{
		/*
			注意：error中的 1 2 用于判断登陆错误信息
			因为我们重写了跳转提示信息
		*/
		//验证验证码
        if(!captcha_check($data['code'])){
         	// 验证失败  
        	$this->error = '1验证码输入不正确！';
			return false;
        };
		$res = Db('Admin')->where('username','=',$data['username'])->find();
		if (!empty($res)) {
			if ($res['password'] == md5($data['password'])) {
				session('username',$res['username']);
				session('uid',$res['id']);
				return true;
			}else{
				$this->error = '2密码输入不正确！';
				return false;
			}
		}else{
			$this->error = '1用户不存在！';
			return false;
		}
	}
	//退出登陆
	public function logout()
	{
		session('username',null);
		session('uid',null);
		return true;
	}
}
