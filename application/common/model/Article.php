<?php

namespace app\common\model;

use app\common\validate\Article as ValidateArticle;
use think\Db;
use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{

    use SoftDelete;
    //关联模型 Cate
    public function Cate() {
        return $this->belongsTo('Cate','cate_id','id');

    }
    //关联评论表
    public function commo() {
        return $this->hasMany('commo','article_id','id');
    }
    //新增文章
    public function add($data) {
        $ArtiVali = new ValidateArticle;
        if(!$ArtiVali->scene('add')->check($data)) {
            return $ArtiVali->getError();
        } 
        $cate = new Cate;
        $res = $cate->where('catename',$data['daohang'])->find();
        if($res) {
            
            $data['cate_id'] = $res->id;
            $result = $this->allowField(true)->save($data);
            if($result) {
                return 1;
            } else {
                return "插入失败";
            }
        } else {
            "栏目不存在";
        }
        


    }

    //修改文章
    public function modify($data) {
        $vail = new ValidateArticle;
        if(!$vail->scene('modify')->check($data)){
            $vail->getError();
        }

        $result = $this->find($data['id']);

        $result->title      = $data['title'];
        $result->tags       = $data['tags'];
        $result->cate_id    = $data['daohang'];
        $result->desc       = $data['desc'];
        $result->content    = $data['content'];
        //执行修改
        $res = $result->save();
        if($res) {
            return 1;
        } else {
            return "修改失败";
        }

    }
}
