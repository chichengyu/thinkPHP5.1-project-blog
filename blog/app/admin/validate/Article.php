<?php 
namespace app\admin\validate;
use think\Validate;

class Article extends Validate
{
    protected $rule = [
    	'title'=>'require|unique:article|max:25',
        'desc'=>'max:100'
    ];
    protected $message = [
    	'title.require'=> '文章标题不能为空',
    	'title.unique'=> '文章标题已经存在',
        'title.max' => '文章标题长度不能大于25位',
    	'desc.max' => '文章描述长度不能大于100位',
    ];
    protected $scene = [
        'edit' => ['title' => 'require|max:25','desc'],
    ];
}
 ?>