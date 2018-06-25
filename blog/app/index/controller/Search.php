<?php
namespace app\index\controller;
use app\index\controller\Base;

class Search extends Base
{

    public function index()
    {
        $keywords = input('keywords');
        if ($keywords) {
            $searhDate = Db('article')->where('title','like','%'.$keywords.'%')
                        ->order('id desc')->paginate(10);
        }
        $this->assign('searhDate',$searhDate);
        return $this->fetch();
    }
}
