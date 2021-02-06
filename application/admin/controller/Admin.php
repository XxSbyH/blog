<?php

namespace app\admin\controller;

use app\common\model\Admin as ModelAdmin;
use think\facade\Request;

class Admin extends Base
{
    //管理员添加
    public function AdminAdd() {
        if(Request::isAjax()) {
            $data = [
                'username'    =>      input('post.username'),
                'pass'        =>      md5(input('post.pass')),
                'passRs'      =>      md5(input('post.passRs')),
                'nickname'    =>      input('post.nickname'),
                'email'       =>      input('post.email')
            ];
            $admin = new ModelAdmin;
            $res = $admin->AdminAdd($data);
            if($res ==1) {
                $this->success('新增成功','admin/Admin/AdminList');
            } else{
                $this->error($res);
            }
        }
    }

    //管理员列表
    public function AdminList() {

        $admin = new ModelAdmin;
        $data = $admin->order(['is_super'=>'asc','status'=>'asc'])->paginate(15);
        $this->assign('list',$data);
        return $this->fetch('admin_add');

    }

    //管理员状态更改
    public function status() {
        
        if(Request::isAjax()) {
            $data = [
                'id'        => input("post.id"),
                'status'    => input("stid") ? 0 : 1
            ];

            $admin = new ModelAdmin;
            $res = $admin->find($data['id']);
            $res->status = $data['status'];
            $result = $res->save();
            if($result) {
                $this->success('修改状态成功','admin/Admin/AdminList');
            } else {
                $this->error($result);
            }
        }
    }

    //管理员删除
    public function AdminDel() {

        if(Request::isAjax()) {
            $admin = new ModelAdmin;
            $res = $admin->find(input('post.id'));
            $result = $res->delete();

            if($result) {
                $this->success('删除成功','admin/Admin/AdminList');
            } else {
                $this->error($result);
            }

        }
    }
}
