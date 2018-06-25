<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use app\admin\controller\Base;

class Tags extends Base
{
    
    public function lst()
    {
        //查询用户
        $tagsDate = Db::name('tags')->order('id','desc')->paginate(10);
        $this->assign(array(
            'tagsDate' => $tagsDate
        ));
        $this->assign('title','标签列表');
        return $this->fetch();
    }

    public function add()
    {
        if (Request()->isPost()) {
            $data = [
                'tagname'=>input('tagname')
            ];

            $validate = new \app\admin\validate\Tags;
            if (!$validate->scene('add')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
            if (Db::name('tags')->insert($data)) {
                return $this->redirect(url('lst'));
            }else{
                return $this->error('1添加失败');
            }
        }
        $this->assign('title','添加标签');
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('id');
        $actionTagsDate = Db('tags')->where('id',$id)->find();
        if (Request()->isPost()) {
            $data = [
                'tagname'=>input('tagname')
            ];
            $validate = new \app\admin\validate\Tags;
            if (!$validate->scene('edit')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
            $res = Db('tags')->where('id',$id)->update($data);
            if ($res !== false) {
                $this->redirect('lst');
            }else{
                $this->error('1更新失败'.$res);
            }
        }
        $this->assign('actionTagsDate',$actionTagsDate);
        $this->assign('title','编辑标签');
        return $this->fetch();
    }

    public function del()
    {
        $id = input('id');
        if ($id) {
            if (Db('tags')->where('id',$id)->delete()) {
                $this->redirect('lst');
            }else{
                return $this->error('1超级管理员不能删除');
            }
        }
    }
}
