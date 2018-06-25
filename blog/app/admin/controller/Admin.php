<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use app\admin\controller\Base;

class Admin extends Base
{
    public function index()
    {
        $this->assign('title','后台管理员');
        return $this->fetch();
    }

    public function lst()
    {
        //查询用户
        $adminDate = Db::name('admin')->order('id','desc')->paginate(10);
        $this->assign(array(
            'adminDate' => $adminDate
        ));
        $this->assign('title','管理员列表');
        return $this->fetch();
    }

    public function add()
    {
        if (Request()->isPost()) {
            $data = [
                'username'=>input('username'),
                'password'=>md5(input('password'))
            ];

            $validate = new \app\admin\validate\Admin;
            if (!$validate->scene('add')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
            if (Db::name('admin')->insert($data)) {
                return $this->redirect(url('lst'));
            }else{
                return $this->error('1添加失败');
            }
        }
        $this->assign('title','添加用户');
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('id');
        $actionAdminDate = Db('admin')->where('id',$id)->find();
        if (Request()->isPost()) {
            $data = [
                'username'=>input('username'),
                'password'=>md5(input('password'))
            ];
            $validate = new \app\admin\validate\Admin;
            if (!$validate->scene('edit')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
            $res = Db('admin')->where('id',$id)->update($data);
            if ($res != false) {
                $this->redirect('lst');
            }else{
                $this->error('1更新失败'.$res);
            }
        }
        $this->assign('actionAdminDate',$actionAdminDate);
        $this->assign('title','用户编辑');
        return $this->fetch();
    }

    public function del()
    {
        $id = input('id');
        if ($id != 1) {
            if (Db('admin')->where('id',$id)->delete()) {
                $this->redirect('lst');
            }
        }else{
            return $this->error('1超级管理员不能删除');
        }
    }

    public function login()
    {
        //
        $this->assign('title','登陆后台');
        return $this->fetch();
    }

}
