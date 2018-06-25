<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    public function initialize()
    {
        //验证登陆权限
        if (!session('username')) {
            return $this->error('1请先登陆',url('admin/login/login'));
        }
    }
}
