<?php
namespace app\common\validate;

use think\Validate;

class CateVali extends Validate
{
    protected $rule = [
        'catename|栏目名称'          =>  'require|unique:cate',
        'sort|排序'                  =>  'require|number'
    ];
    //栏目新增场景
    public function sceneAdd()
    {
        return $this->only(['catename','sort']);
    }

    //栏目修改场景
    public function sceneEdit() {
        return $this->only(['catename']);
    }
}