## 模板输出

```php
public function index() {
    $data=[
            'ab'    =>  '21',
            'bc'    =>  '34'
        ];
    $this->assign('user',$data);
    
    return $this->fetch();
}
```

#### 在模板文件中包含其他文件

```php
{include file=""}
	
{/include}
```

#### 将css 和 js 文件前面的路径固定

```php
在 config/template.php 中添加代码
'tpl_replace_string'	=>	[
    '__JS__'	=>	'static/js',
    '__CSS__'	=>	'static/css',
]
```

#### 开始模板布局功能

```php
1.
在 config/template.php 中添加代码
'layout_on'		=>	true,
//可更改布局文件
'layout_name'	=>	'public/layout'
    
    
2.
{layout name='public/layout' replace='[__CONTENT__]'}
```

## 2.模板继承

### extend.html 做内容

![image-20201226092932320](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201226092932320.png)

### base.html  做布局

![image-20201226093018806](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201226093018806.png)