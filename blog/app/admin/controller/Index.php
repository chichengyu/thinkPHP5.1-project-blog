<?php
namespace app\admin\controller;
use think\Db;
use app\admin\validate\Admin;
use app\admin\controller\Base;

class Index extends Base
{
    public function index()
    {
        $this->assign('title','后台首页');
        return $this->fetch();
    }


}
