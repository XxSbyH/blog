<?php
namespace app\common\model;

use app\common\validate\Admin as ValidateAdmin;
use think\facade\Session;
use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    use SoftDelete;
    //登录
    public function login($data) 
    {
        $va = new ValidateAdmin;

        //验证数据
        if(!$va->scene('login')->check($data)) {
            return $va->getError();
        }

        //在数据库中查找 是否有这个用户
        $result = $this->where($data)->find();
        if($result) {
            //判断用户是否可用
            if($result['status'] != 1) {
                return "账户不可用";
            }

            //存储用户的 session 
            $sessionData = [
                'id'        =>       $result['id'],
                'nickname'  =>       $result['nickname'],
                'is_super'  =>       $result['is_super']
            ];
            
            Session::set('admin',$sessionData);
            return 1;
        } else {
            return '用户名或密码错误';
        }
    }
    //注册
    public function reg($data) {
        $validate = new ValidateAdmin;

        //判断验证器 验证数据的结果
        if(!$validate->scene('reg')->check($data)) {
            return $validate->getError();
        }
        //插入数据 allowField (根据数据库字段插入)
        $res = $this->allowField(true)->save($data);

        //判断插入结果
        if ($res) 
        {
            mailto($data['email'],'注册成功','注册成功');
            return 1;

        } else {
            return "注册失败";
        }

    }

    //忘记密码--发送验证码
    public function forget($data) {
        $validate = new ValidateAdmin;

        if(!$validate->scene('for')->check($data)) {
            return $validate->getError();
        }
        //判断邮箱是否已注册
        $res = $this->where('email',$data['email'])->find();

        if($res) {
            $code = Session::get('code');
            $eres = mailto($data['email'],'重置密码验证码','您的验证码为：'.$code.' 有效期为5分钟');
            if($eres == 1) {

                return "1";
            } else {
                return "发送失败";
            }
        } else {
            return "该邮箱没有注册";
        }
        
    }

    //重置密码
    public function reset($data) {
        $valiedate = new ValidateAdmin;
        if(!$valiedate->scene('reset')->check($data)){
            return $valiedate->getError();
        }
        $code = Session::get('code');
        if($data['code'] == $code) {
            $jilu = $this->where('email',$data['email'])->find();
            if($jilu) {
                $jilu->pass = $data['pass'];
                $result = $jilu->save();

                if($result) {
                    return 1;
                } else {
                    return "修改失败";
                }

            }
        } else {
            return "验证不一致";
        }
    }

    //管理员新增
    public function AdminAdd($data) {
        $admin = new ValidateAdmin;
        if(!$admin->scene('add')->check($data)){
            return $admin->getError();
        }
        $res = $this->allowField(true)->save($data);
        if($res) 
        {
            return 1;

        } else {
            return "新增失败";
        }
    } 
}
