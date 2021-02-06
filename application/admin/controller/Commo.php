<?php

namespace app\admin\controller;

use app\common\model\Commo as ModelComment;
use think\Controller;

class Commo extends Base
{
    public function ComList () {
        $com = new ModelComment;
        $data = $com->with('member','article')->order('create_time','desc')->paginate(10);
        $this->assign('list',$data);

        return $this->fetch();
    }
}
