<?php
namespace app\index\controller;
use think\Controller;

class Base extends Controller
{
    public function initialize()
    {
        //查询所有栏目
        $cateDate = Db('cate')->select();
        //查询所有标签
        $tagsDate = Db('tags')->select();
        
        $this->assign(array(
            'cateDate' => $cateDate,
            'tagsDate' => $tagsDate
        ));
        $this->right();
    }
    //查询所有的热门文章与推荐文章
    public function right()
    {
    	//右侧
    	$clickRight = Db('article')->order('click desc')->limit(8)->select();
    	$stateDright = Db('article')->where('state',1)->order('click desc')->limit(8)->select();
        //友情链接
        $linksDate = Db('links')->field('title,url')->select();

    	$this->assign(array(
    		'clickRight' => $clickRight,
    		'stateDright' => $stateDright,
            'linksDate' => $linksDate
    	));
    }
}