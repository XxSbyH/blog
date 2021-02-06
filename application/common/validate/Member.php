<?php
namespace app\common\validate;
use think\Validate;

class Member extends Validate
{
    protected $rule = [
        'username|用户名'      =>  'require|unique:member|max:12',
        'pass|密码'          =>  'require',
        'nickname|名称'      =>  'require',
        'email|邮箱'         =>  'require|unique:member|email'
    ];

    public function sceneAdd()
    {   
        return $this->only(['username','pass','nickname','email']); 
    }
    public function sceneEdit() {
        return $this->only(['pass','nickname']);
    }
}