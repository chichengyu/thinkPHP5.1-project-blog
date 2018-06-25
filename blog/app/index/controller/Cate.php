<?php
namespace app\index\controller;
use app\index\controller\Base;

class Cate extends Base
{

    public function lst()
    {
        $cateid = input('cateid');
        $cateArticleLst = Db('article')->field('a.id,a.title,a.pic,a.desc,a.time,b.catename')
                ->alias('a')
                ->join('cate b','a.cateid=b.id')
                ->where('a.cateid',$cateid)
                ->order('a.id','desc')
                ->paginate(10);
        $this->assign('cateArticleLst',$cateArticleLst);
        return $this->fetch();
    }

    public function article()
    {
    	return $this->fetch();
    }
}
