<?php
namespace app\common\model;
use think\Model;
use think\model\concern\SoftDelete;

class Commo extends Model
{
    use SoftDelete;
    //关联文章表
    public function article() {
        return $this->belongsTo('article','article_id','id');
    }
    //关联用户表
    public function member() {
        return $this->belongsTo('member','member_id','id');
    }
}