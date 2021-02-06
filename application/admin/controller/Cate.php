<?php

namespace app\admin\controller;

use app\common\model\Cate as ModelCate;
use think\Controller;
use think\facade\Request;

class Cate extends Base
{

    //栏目展示
    public function showlist () {
        
        $cate = new ModelCate;
        $data = $cate->order('sort')->paginate(5);

       
        $this->assign('list',$data);

        return $this->fetch('add');
    }
    //栏目添加
    public function add () {
        
        if(Request::isAjax()) {
            $data = [
                'catename'      =>  input('post.catename'),
                'sort'          =>  input('post.sort')
            ];

           $cate = new ModelCate;

           $res = $cate->add($data);

           if($res ==1) {
               $this->success('添加栏目成功','admin/cate/showlist');

           } else {
               $this->error($res);
           }

        }
        return $this->fetch();
    }
    //栏目修改
    public function CateEdit() {

        $cate = new ModelCate;
        $data = $cate->find(input('id'));
        //return json($data);
        $this->assign('list',$data);

        if(Request::isAjax()) {
            $data = [
                'id'          =>  input('post.id'),
                'catename'    =>  input('post.catename')
            ];

            $res = $cate->CateEdit($data);

            if($res ==1) {
                $this->success('修改成功','admin/cate/showlist');
            } else {
                $this->error($res);
            }
        }

        return $this->fetch();
    }

    //栏目删除
    public function CateDelete () {

        if(Request::isAjax()) {


            $cate = new ModelCate;
            $result = $cate->with('article')->find(input('post.id'));

            if($result) {
                $res = $result->together('article')->delete();
                if($res ==1) {
                    $this->success('删除成功','admin/cate/showlist');
                } else {
                    $this->error('删除失败');
                }
            }

            
        }
    }

}
