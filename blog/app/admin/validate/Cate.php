<?php 
namespace app\admin\validate;
use think\Validate;

class Cate extends Validate
{
    protected $rule = [
    	'catename'=>'require|unique:cate|max:25',
    ];
    protected $message = [
    	'catename.require'=> '栏目名称不能为空',
    	'catename.unique'=> '栏目名称已经存在',
    	'catename.max' => '栏目名称长度不能大于25位',
    ];
    // protected $scene = [
    //     'edit'  =>  ['catename'=>'require|max'],
    // ];
}
 ?>