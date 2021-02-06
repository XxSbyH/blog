<?php

namespace app\admin\controller;

use app\common\model\Member as ModelMember;
use think\Controller;
use think\facade\Request;

class Member extends Controller
{
    //会员添加
    public function MemAdd(){

        if(Request::isAjax()) {
            $data = [
                'username'      =>  input('post.username'),
                'pass'          =>  md5(input('post.pass')),
                'nickname'      =>  input('post.nickname'),
                'email'         =>  input('post.email')
            ];

           $member = new ModelMember;

           $res = $member->Add($data);

           if($res == 1) {
               $this->success('会员新增成功','admin/member/MemList');
           } else {
               $this->error($res);
           }

        }
        
        return $this->fetch();
    }
    //会员展示
    public function MemList() {

        $member = new ModelMember;
        $data = $member->order(['create_time' =>'desc'])->paginate(5);

        $this->assign('list',$data);

        return $this->fetch('mem_add');
    }

    //会员修改
    public function MemEdit() {

        $member = new ModelMember;
        $data = $member->find(input('id'));
        $this->assign('list',$data);

        if(Request::isAjax()) {
            $data = [
                'id'        =>  input('post.id'),
                'pass'      =>  md5(input('post.pass')),
                'nickname'  =>  input('post.nickname')
            ];

            $res = $member->Edit($data);

            if($res ==1) {
                $this->success('修改成功','admin/member/MemList');
            } else {
                $this->error($res);
            }
        }
        
        return $this->fetch();
    }

    //会员删除
    public function MemDel() {
        if(Request::isAjax()) {

            $member = new ModelMember;
            $res = $member->find(input('post.id'));
            $result = $res->delete();
            if($result) {
                $this->success('删除会员成功','admin/member/MemList');
            } else {
                $this->error($result);
            }
        }
    }
}
