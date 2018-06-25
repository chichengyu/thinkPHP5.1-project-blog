<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\Admin;

class Login extends Controller
{
    //登陆
    public function login()
    {
        if (Request()->isPost()) {
            $data = input('post.');
            $adminModel = new Admin;
            if ($adminModel->login($data)) {
                return $this->success('登陆成功！正在加载...请稍后',url('admin/index/index'));
            }
            return $this->error($adminModel->getError());
        }
        $this->assign('title','登陆后台');
        return $this->fetch();
    }
    //退出登陆
    public function logout()
    {
        $adminModel = new Admin;
        if ($adminModel->logout()) {
            return $this->redirect('admin/login/login');
        }
    }
}
