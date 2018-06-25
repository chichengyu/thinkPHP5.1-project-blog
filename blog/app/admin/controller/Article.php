<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use app\admin\controller\Base;

class Article extends Base
{
    public function lst()
    {
        //查询所有文章
        $articleDate = Db::name('article')->field('a.id,a.title,a.keywords,a.time,a.state,a.author,a.click,b.catename')->alias('a')->leftJoin('cate b','a.cateid=b.id')->order('id','desc')->paginate(10);
        $this->assign('articleDate',$articleDate);
        $this->assign('title','列文章表');
        return $this->fetch();
    }
    public function add()
    {
        if (Request()->isPost()) {
            $data = [
                'title'=>input('title'),
                'author'=>input('author'),
                'desc'=>input('desc'),
                'keywords'=>str_replace('，', ',', input('keywords')),
                'content'=>input('content'),
                'pic'=>input('pic'),
                'time'=>time(),
                'cateid'=>input('cateid'),
            ];
            if (input('state') == 'on') {
                $data['state'] = 1;
            }

            $validate = new \app\admin\validate\Article;
            if (!$validate->scene('add')->check($data)) {
                return $this->error($validate->getError());
            }
            if (Db::name('article')->insert($data)) {
                return $this->redirect(url('lst'));
            }else{
                return $this->error('1添加失败');
            }
        }    
        //查询所有栏目    
        $cateDate = Db('cate')->select();
        $this->assign('cateDate',$cateDate);
        $this->assign('title','添加文章');
        return $this->fetch();
    }
    public function edit()
    {
        $id = input('id');
        $actionArticleDate = Db('article')->where('id',$id)->find();
        if (Request()->isPost()) {
            // 判断是否上传了缩略图
            if ($_POST['pic']) {
                $actionArticleDate['pic'] = input('pic');
            }
            $data = [
                'title'=>input('title'),
                'author'=>input('author'),
                'desc'=>input('desc'),
                'keywords'=>str_replace('，', ',', input('keywords')), 
                'content'=>input('content'), 
                'pic'=>$actionArticleDate['pic'],
                'time'=>time(),
                'cateid'=>input('cateid'),
            ];
            if (input('state') == 'on') {
                $data['state'] = 1;
            }else{
                $data['state'] = 0;
            }

            $validate = new \app\admin\validate\Article;
            if (!$validate->scene('edit')->check($data)) {
                return $this->error('1'.$validate->getError());
            }

            $res = Db('article')->where('id',$id)->update($data);
            if ($res !== false) {
                return $this->redirect(url('lst'));
            }else{
                $this->error('1更新失败'.$res);
            }
        }
        //查询所有栏目    
        $cateDate = Db('cate')->select();
        $this->assign(array(
            'cateDate' => $cateDate,
            'actionArticleDate' => $actionArticleDate
        ));
        $this->assign('title','编辑栏目');
        return $this->fetch();
    }
    public function del()
    {
        $id = input('id');
        if ($id) {
            if (Db('article')->where('id',$id)->delete()) {
                return $this->redirect('lst');
            }else{
                return $this->error('1超级管理员不能删除');
            }
        }
    }
}
