<?php
namespace app\common\validate;
use think\Validate;

class Admin extends Validate
{

    //定义验证规则
    protected $rule = [
        'username|管理者账号'            =>     'require|min:5',
        'pass|密码'                     =>      'require|min:6|max:40',
        'passRs|两次的密码'              =>      'require|confirm:pass',
        'nickname|名称'                 =>      'require',
        'email|邮箱'                   =>      'require|email',
        'code|验证码'                   =>      'require'

    ];

    //自定义错误信息
    protected $message = [
        'passRs.confirm'                  =>      '输入的密码不一致'
    ];

    //场景验证
    protected $scene = [
        'login'             =>      ['username,pass'],
        'insert'            =>      ['username','pass','email']
    ];
    //登录验证 场景
    public function sceneLogin() {
        return $this->only(['username','pass']);
    }

    //注册场景
    public function sceneReg() {
        return $this->only(['username','pass','passRs','nickname','email'])
                    ->append('username','unique:admin')
                    ->append('email','unique:admin');
    }

    //忘记密码 场景
    public function sceneFor() {
        return $this->only(['email']);
    }
    //重置密码 场景
    public function sceneReset () {
        return $this->only(['code','pass']);
    }
    //新增管理员 场景
    public function sceneAdd () {
        return $this->remove('code')
                    ->append('username|管理员账号','unique:admin');
    }
}