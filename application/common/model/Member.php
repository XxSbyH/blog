<?php

namespace app\common\model;

use app\common\validate\Member as ValidateMember;
use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    use SoftDelete;

    protected $readonly = ['username','email'];
    //会员新增
    public function Add($data) {

        $vali = new ValidateMember;
        if(!$vali->scene('add')->check($data)) {
            return $vali->getError();
        }
        
        $res = $this->save($data);
        if($res) {
            return 1;
        } else {
            return "插入失败";
        }
    }

    public function Edit($data) {
        $vali = new ValidateMember;
        if(!$vali->scene('edit')->check($data)) {
            return $vali->getError();
        }

        $result = $this->find($data['id']);
        $result->nickname = $data['nickname'];
        $result->pass     = $data['pass'];
        $res = $result->save();
        if($res) {
            return 1;
        } else {
            return "修改会员会员信息失败";
        }
        
    }

}
