<?php
namespace app\index\controller;
use app\index\controller\Base;

class Index extends Base
{
    
    public function index()
    {
        $articleDate = Db('article')->order('id','desc')->paginate(5);
        $this->assign('articleDate',$articleDate);
        return $this->fetch();
    }

    public function article()
    {
        $articleId = input('id');
        //点击量+1
        Db('article')->where('id',$articleId)->setInc('click');
        $articleContent = Db('article')->where('id',$articleId)->find();

        //查询当前文章关键词keywords查询相关文章
        static $ralateres = array();//存放相关文章
        $arr = explode(',',$articleContent['keywords']);//存放当前文章的关键词
        foreach ($arr as $k=>$v) {
            $map = [
                ['keywords','like','%'.$v.'%'],
                ['id','<>',$articleContent['id']],
            ];
            //当前文章就不用查询了
            //$map['id'] = ['<>',$articleContent['id']];
            $artres = Db('article')->where($map)->order('id desc')->limit(8)->select();
            //然后去重合并到$ralateres数组中，
            // 注意 $ralateres 数组必须是静态static的
            $ralateres = array_merge($ralateres,$artres);
        }
        $ralateres = arr_unique($ralateres);
        
        //查询当前文章下被推荐的所有文章
        $reces = Db('article')->where('state',1)->limit(8)->select();
        
        $this->assign(array(
            'articleContent' => $articleContent,
            'ralateres' => $ralateres,
            'reces' => $reces
        ));
    	return $this->fetch();
    }

}
