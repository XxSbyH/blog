<?php
namespace app\common\model;

use app\common\validate\CateVali;
use think\Model;
use think\model\concern\SoftDelete;

class Cate extends Model
{
    use SoftDelete;

    //关联文章表
    public function article() {
        return $this->hasMany('article','cate_id','id');
    }

   //栏目添加
    public function add($data) {
        $valie = new CateVali;

        if(!$valie->scene('add')->check($data)) {
            return $valie->getError();
        }

        $res = $this->allowField(true)->save($data);

        if($res) {
            return 1;
        } else {
            return "栏目插入失败";
        }

 
        
    }

   //栏目修改
   public function CateEdit($data) {
        $CateVali = new CateVali;
        if(!$CateVali->scene('edit')->check($data)){
            return $CateVali->getError();
        }
        $result = $this->where('id',$data['id'])->find();

        $result;
        if($result) {
            $result->catename = $data['catename'];
            $res = $result->save();
            if($res) {
                return 1;
            } else {
                return "修改失败";
            }
        } else {
            return "不存在";
        }
   }

}
