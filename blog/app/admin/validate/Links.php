<?php 
namespace app\admin\validate;
use think\Validate;

class Links extends Validate
{
    protected $rule = [
    	'title'=>'require|unique:links|max:25',
        'url'=>'max:50',
        'desc'=>'max:50'
    ];
    protected $message = [
    	'title.require'=> '链接标题不能为空',
    	'title.unique'=> '链接标题已经存在',
    	'desc.max' => '链接长度不能大于50位',
    ];
    protected $scene = [
        'edit'  =>  ['title'=>'require|max','url','desc'],
    ];
}
 ?>