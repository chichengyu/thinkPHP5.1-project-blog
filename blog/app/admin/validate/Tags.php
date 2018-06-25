<?php 
namespace app\admin\validate;
use think\Validate;

class Tags extends Validate
{
    protected $rule = [
    	'tagname'=>'require|unique:tags|max:5',
    ];
    protected $message = [
    	'tagname.require'=> '标签名称不能为空',
    	'tagname.unique'=> '标签名称已经存在',
    	'tagname.max' => '标签名称长度不能大于5位',
    ];
    protected $scene = [
        'edit' => ['tagname'=>'require|max:5'],
    ];
}
 ?>