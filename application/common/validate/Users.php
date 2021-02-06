<?php
namespace app\common\validate;

use think\Validate;

class Users extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'username'      =>      'require|max:5|checkName:爸爸',
        'pass'          =>      'number|max:16',
        'email'         =>      'email'
    ];
    
    //场景验证设置
    protected $scene = [
        'insert'        =>      ['username','pass','emial'],
        'edit'          =>      ['username','pass']
    ];



    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'username.require'      =>      '用户名不能为空'
    ];

    //自定义规则
    protected function checkName($value , $rule) {
        return $value==$rule ? '不可以使用这个' : true ;
    }
}
