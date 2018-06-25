<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use app\admin\controller\Base;

class Links extends Base
{
    
    public function lst()
    {
        //查询用户
        $linkDate = Db::name('links')->order('id','desc')->paginate(10);
        $this->assign(array(
            'linkDate' => $linkDate
        ));
        $this->assign('title','友情列表');
        return $this->fetch();
    }

    public function add()
    {
        if (Request()->isPost()) {
            $data = [
                'title'=>input('title'),
                'url'=>input('url'),
                'desc'=>input('desc')
            ];

            $validate = new \app\admin\validate\Links;
            if (!$validate->scene('add')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
                if (Db::name('links')->insert($data)) {
                    return $this->redirect(url('lst'));
                }else{
                    return $this->error('1添加失败');
                }
            }
        $this->assign('title','添加友情');
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('id');
        $actionLinkDate = Db('links')->where('id',$id)->find();
        if (Request()->isPost()) {
            $data = [
                'title'=>input('title'),
                'url'=>input('url'),
                'desc'=>input('desc')
            ];
            $validate = new \app\admin\validate\Links;
            if (!$validate->scene('edit')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
            $res = Db('links')->where('id',$id)->update($data);
            if ($res !== false) {
                $this->redirect('lst');
            }else{
                $this->error('1更新失败'.$res);
            }
        }
        $this->assign('actionLinkDate',$actionLinkDate);
        $this->assign('title','编辑友情');
        return $this->fetch();
    }

    public function del()
    {
        $id = input('id');
        if ($id) {
            if (Db('links')->where('id',$id)->delete()) {
                $this->redirect('lst');
            }else{
                return $this->error('1超级管理员不能删除');
            }
        }
    }
}
