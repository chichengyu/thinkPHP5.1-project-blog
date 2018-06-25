<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use app\admin\controller\Base;

class Cate extends Base
{
    
    public function lst()
    {
        //查询用户
        $cateDate = Db::name('cate')->order('id','desc')->paginate(10);
        $this->assign(array(
            'cateDate' => $cateDate
        ));
        $this->assign('title','栏目列表');
        return $this->fetch();
    }

    public function add()
    {
        if (Request()->isPost()) {
            $data = [
                'catename'=>input('catename'),
            ];

            $validate = new \app\admin\validate\Cate;
            if (!$validate->scene('add')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
                if ($res = Db::name('cate')->insert($data)) {
                    return $this->redirect(url('lst'));
                }else{
                    return $this->error('1添加栏目失败'.$res);
                }
            }
        $this->assign('title','添加栏目');
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('id');
        $actionCateDate = Db('cate')->where('id',$id)->find();
        if (Request()->isPost()) {
            $data = [
                'catename'=>input('catename'),
            ];
            $validate = new \app\admin\validate\Cate;
            if (!$validate->scene('edit')->check($data)) {
                return $this->error('1'.$validate->getError());
            }
            $res = Db('cate')->where('id',$id)->update($data);
            if ($res !== false) {
                return $this->redirect('lst');
            }else{
                return $this->error('1更新失败'.$res);
            }
        }
        $this->assign('actionCateDate',$actionCateDate);
        $this->assign('title','编辑栏目');
        return $this->fetch();
    }

    public function del()
    {
        $id = input('id');
        if ($id) {
            if (Db('cate')->where('id',$id)->delete()) {
                return $this->redirect('lst');
            }else{
                return $this->error('1超级管理员不能删除');
            }
        }
    }
}
