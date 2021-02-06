<?php

namespace app\admin\controller;

use app\common\model\Article as ModelArticle;
use app\common\model\Cate;
use think\Db;
use think\facade\Request;

class Article extends Base
{
    //新增文章
    public function ArticleAdd() {


        if(Request::isAjax()){

            $data = [
                'title'         =>      input('post.title'),
                'tags'          =>      input('post.tags'),
                'desc'          =>      input('post.desc'),
                'content'       =>      input('post.content'),
                'daohang'       =>      input('post.daohang'),
            ];

            $arricle = new ModelArticle();
            $res = $arricle->add($data);
            if($res ==1) {
                $this->success('新增成功','admin/article/ArticleShow');
            } else{
                $this->error($res);
            }
        }

        $cate = new Cate();
        //把文章类别传递到模板
        $cates = $cate->select();
        $this->assign('cates',$cates);
        return $this->fetch();
    }
    //文章列表
    public function ArticleShow() {

        $art = new ModelArticle;
        //关联预载入
        $data = $art->with('Cate')->order('create_time')->select();


        $this->assign('data',$data);

        return $this->fetch();
    }
    //修改文章
    public function ArticleEdit() {

        $art = new ModelArticle;
        if(Request::isAjax()) {
            $data = [
                'title'         =>      input('post.title'),
                'tags'          =>      input('post.tags'),
                'daohang'       =>      input('post.daohang'),
                'desc'          =>      input('post.desc'),
                'content'       =>      input('post.content'),
                'id'            =>      input('post.id')
            ];

            $res = $art->modify($data);
            if($res ==1) {
                $this->success('文章修改成功','admin/article/ArticleShow');
            } else {
                $this->error($res);
            }   

        }   
        $data = $art->find(input('id'));

        $cate = new Cate;
        $cateData= $cate::select();

        $this->assign([
            'list'      =>      $data,
            'cate'      =>      $cateData
        ]);

        return $this->fetch();
    }
    //删除文章
    public function ArticleDel() {
        if(Request::isAjax()) {
            $art = new ModelArticle;

            $res=$art->with('commo')->find(input('post.id'));
            $result = $res->together('commo')->delete();
            if($result) {
                $this->success('删除文章成功','admin/article/ArticleShow');
            } else {
                $this->error($result);
            }
        }

    }


    //测试专用
    public function aaa() {
        //$arricle = ModelArticle::get([1,2,3]);
        $arricle = ModelArticle::has('Cate')->select();

        dump($arricle);
    }
}
