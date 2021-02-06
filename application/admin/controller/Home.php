<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Session;

class Home extends Base
{
    //后台首页
    public function index (){

        // $nickname = Session::get('admin.nickname');

        // $this->assign('nickname',$nickname);
        return $this->fetch();
    }
    //退出登录
    public function logout () {

        Session::delete('admin');

        if(Session::has('admin')){
            $this->error('退出失败');
        } else {
            $this->success('退出登录成功','admin/index/login');
        }
    }
}
