<?php
namespace app\admin\controller;

use app\common\model\Admin as ModelAdmin;
use think\Controller;
use think\facade\Request;
use think\facade\Session;

class Index extends Controller
{
    //防止重复登录
    public function initialize () {

        if(Session::has('admin.id')) {
            $this->redirect('admin/home/index');
        }
    }

    //后台登录
    public function login() {
        //判断是否ajax 传值过来
        if(Request::isAjax()){

            //获取表单数据
            $data = [
                'username'          =>   input('post.username'),
                'pass'              =>   input('post.pass')
            ];
            $Admin = new ModelAdmin;
            $res = $Admin->login($data);
            if($res == 1){

                $this->success("登录成功",'admin/home/index');
            } else {
                $this->error($res);
            }
        }
        return $this->fetch();
    }

    //后台注册
    public function reg() {

        
        if(Request::isAjax()) {
            $data = [
                'username'              =>   input('post.usernameR'),
                'pass'                  =>   input('post.passR'),
                'passRs'                 =>   input('post.passRs'),
                'nickname'              =>   input('post.nicknameR'),
                'email'                 =>   input('post.emailR')
            ];
            $Admin = new ModelAdmin;
            //执行 注册 方法
            $res = $Admin->reg($data);
            
            if($res ==1) {
                $this->success("注册成功",'admin/index/login');
            } else {
                $this->error($res);
            }

        }
        return $this->fetch('login');
    }

    //忘记密码-发送验证码
    public function forget() {

        if(Request::isAjax()) {
            $data = [
                'email'              =>   input('post.email')
            ];
            //随机生成验证码
            $code = mt_rand(1000,9999);
            Session::set('code',$code);
            $Admin = new ModelAdmin;

            $res = $Admin->forget($data);
            
            if($res == 1){
                
                return $this->success('验证码发送成功');
            } else {
                return $this->error($res);
            }
        }

        return $this->fetch();
    }

    //忘记密码-验证验证码
    public function reset() {
        if(Request::isAjax()) {
            $data = [
                'code'              =>   input('post.code'),
                'pass'              =>   input('post.pass'),
                'email'             =>   input('post.email')
            ];

            $Admin = new ModelAdmin;

            $res = $Admin->reset($data);

            if($res == 1){
                $this->success('修改密码成功','admin/index/login');
            } else {
                 $this->error($res);
            }
        }
    }

}
