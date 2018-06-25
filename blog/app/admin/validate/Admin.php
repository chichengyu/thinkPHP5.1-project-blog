<?php 
namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule = [
    	'username'=>'require|unique:admin|max:25',
        'password'=>'require'
    ];
    protected $message = [
    	'username.require'=> '用户名不能为空',
    	'username.unique'=> '用户名已经存在',
    	'username.max' => '用户长度不能大于25位',
        'password.require' => '密码不能为空',
    ];
    protected $scene = [
        'edit' => ['username'=>'require|max:25']
    ];
}
 ?>