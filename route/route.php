<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;



//设置全局的 变量规则
// Route::pattern([
//     'name'      =>  '\d+'
// ]);

//闭包形式，不需要通过控制器输出
// Route::get('think/', function () {
//     return 'hello,ThinkPHP5!';
// });

// Route::get('think/:name', function ($name) {
//     return 'hello,ThinkPHP5!'.$name;
// });

//Route::get('hello/:name', 'app\index\controller\Index@hello');

//设置登录提交验证用户名密码路由 (\类的命名空间\类名@方法名——\类的命名空间\类名::静态方法名)
//Route::get('CheckLogin','app\index\controller\Users@hCheckLogin')->name('cl');

//Route::get('url','index/role');

//可将路由绑定到模型
//Route::get('user/:user_id','index/getUsers')->model('user_id','\app\index\model\Users');

//快速注册路由
//Route::controller('short','Short');

//验证成功后跳转
//Route::get('index','index/index')->name('SecondIn');

//设置登录页面路由
//Route::get('login/[:content]','Index/loginRe')->name('lg');


//设置php实现百度 子页面路由
//Route::get('phpbaidu','Index/phpbaidu')->name('pb');

//后台主页
// Route::get('admin','admin/index/index')->name('adminBie');

// Route::get('data','admin/index/data')->name('dataBie');

// Route::get('maps','admin/index/maps')->name('mapsBie');

// Route::get('manage','admin/index/manage')->name('manageBie');

// Route::get('preferences','admin/index/preferences')->name('preBie');


//博客路由 管理员分组路由
Route::group('admin',function() {
    //登录路由
    Route::rule('/','admin/index/login','get|post');
    //注册路由
    Route::rule('reg','admin/index/reg','get|post');
    //验证密码-发送验证码
    Route::rule('forget','admin/index/forget','get|post');
    //验证验证码
    Route::rule('reset','admin/index/reset','post');
    //后台主页
    Route::rule('index','admin/home/index','get')->name('ind');
    //退出登录
    Route::rule('logout','admin/home/logout','post');

    //栏目添加
    Route::rule('add','admin/cate/add','get|post');
    //栏目展示
    Route::rule('showlist','admin/cate/showlist','get');
    //栏目修改
    Route::rule('CateEdit/[:id]','admin/cate/CateEdit','get|post');
    //栏目删除
    Route::rule('CateDelete','admin/cate/CateDelete','post');

    //文章新增
    Route::rule('ArticleAdd','admin/article/ArticleAdd','get|post');
    //文章显示
    Route::rule('ArticleShow','admin/article/ArticleShow','get');
    //文章修改
    Route::rule('ArticleEdit/[:id]','admin/article/ArticleEdit','get|post');
    //文章删除
    Route::rule('ArticleDel','admin/article/ArticleDel','get|post');

    //会员新增
    Route::rule('MemAdd','admin/member/MemAdd','get|post');
    //会员列表
    Route::rule('MemList','admin/member/MemList','get');
    //会员删除
    Route::rule('MemDel','admin/member/MemDel','get|post');
    //会员修改
    Route::rule('MemEdit/[:id]','admin/member/MemEdit','get|post');

    //管理员添加
    Route::rule('AdminAdd','admin/Admin/AdminAdd','get|post');
    //管理员列表
    Route::rule('AdminList','admin/Admin/AdminList','get|post');
    //管理员修改
    Route::rule('AdminEdit','admin/Admin/AdminEdit','get|post');
    //管理员删除
    Route::rule('AdminDel','admin/Admin/AdminDel','get|post');
    //管理员状态
    Route::rule('AdminStatus','admin/Admin/status','get|post');

    //评论显示
    Route::rule('ComList','admin/commo/ComList','get|post');

    //测试专用
    Route::rule('aaa','admin/article/aaa','get');
});



