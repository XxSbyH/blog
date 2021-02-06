<?php
namespace app\common\validate;
use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title|文章标题'         =>      'require|max:18|unique:article',
        'tags|文章标签'          =>      'require',
        'desc|文章概述'          =>      'require|max:20',
        'content|文章内容'       =>      'require|max:1500'
    ];
    
    //文章新增
    public function sceneAdd()
    {
        return $this->only(['title','tags','desc','content']);
    }

    public function sceneModify() {
        return $this->only(['title','tags','desc','content']);
    }
}