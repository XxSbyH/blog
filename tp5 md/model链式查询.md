## 一、URL路由解析

## 二、MVC模式

### 1.模块   config/app.php 进行设置i

##### 1.单模块、多模块 	'app_multi_module'  是否开启多模块

##### 2.默认模块、空模块

##### 3.环境变量  ( Env 类库)

![image-20201209220226961](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201209220226961.png)

### 2.控制器

##### 1.控制器定义=>

```php
类名和文件名大小保持一致 采用驼峰(首字母大写)
use think\Controller //继承基类控制器（不是必须的）
class Index extends Controller

如果为 class HelloWorld URL访问时为 public/hello_world

如果想改变根命名空间的 app 为其他时，可在根目录下创建 .env 文件
采用键值对 app_namespace =application; 即可
```

##### 2.渲染输出

```php
1.采用 方法内 return 返回的方式进行输出 相当于 echo 
2.使用 json 输出 
    $data = array('a'=>1,'b'=>2,'c'=>3);
	return json($data);
3.使用 view 模板输出
    return view();

```

##### 3.前置方法

```php
1.前置方法（内部调用）
需继承基类控制器 extends Controller;
protected $beforeActionList = [
    'first',
    'third' => ['except'=>'hello'], //除了 hello 方法不调用
    'second' => ['only'=>'hello']	//只能 hello 方法用
]
protected function first() {
    echo "自动调用11111";
}
protected function second() {
    echo "自动调用22222";
}
protected function third() {
    echo "自动调用333333";
}

public function hello() {
    return "hello world";
}
public function two() {
    return "two ;
}
    
```

##### 3-2 跳转和重定向

```php
Controller类
    $this->success(提示语句,URL)	方法

2.跳转的模板页面 app.php 里的 dispatch_success_tmpl 进行设置
```

```php
//空方法拦截 
public function __empty($name) {
    return '次方法不存在'.$name;
}
//空控制器拦截
class Error{
    public function index(Request $r) {
        return '控制器不存在:'.$r->controller();
    }
}
```

## 连接数据库

![image-20201215162109637](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201215162109637.png)

```php
//不会自动添加表名前缀
$data = Db::table('users')->select();
//会自动添加表名前缀 （name 方法）
$data = Db::name('tp_users')->select();

一、查询
    1.只查询一条数据 find() 方法
    $data = Db::table('users')->find();
	
查看 sql 的方法
    return Db::getLastSql();
	
	2.where 条件查询
    $data = Db::table('users')->where('user_id',2)->find();

	表达式 '<>' 为不等于
	$data = Db::table('users')->where('user_id','<>','2')->select();
	！！！  模糊查询
	$data = Db::table('users')->where('email','like','70%')->select();
	$data = Db::table('users')->where('username','like',['THE%','a%'],'or')->select();
	$data = Db::table('users')->whereLike('username',['THE%','a%'],'or')->select();

	'in' [1,3] 查询出 2 条数据
	$data = Db::table('users')->where('user_id','in',[1,3])->select();
	'between' [1,3] 查询出 3 条数据
	$data = Db::table('users')->where('user_id','between',[1,3])->select();
	'exp' 自定义 SQL 语句
	$data = Db::table('users')->where('user_id','exp','between 1 and 2')->select();
	3.查询所有数据
    $data = \db('users')->select();
	$data = Db::table('users')->where('user_id',2)->selectOrFail();
	
	4.查询特定字段的值 （单个值）
    $data = Db::table('users')->value('username');

	5.查询特定列的值 （某一列）
    $data = Db::table('users')->column('username');
	将 id 作为列的索引
    $data = Db::table('users')->column('username','user_id');

	6.时间查询
    $data = Db::table('users')->whereTime('data_time','>','2018-12-1')->select();
	$data = Db::table('users')->whereBetween('data_time',['2018-12-1','2019-9-4'])->select();


	7.保存好链接数据库资源，避免浪费
	$user = Db::table('users');
	$d1 = $user->where('user_id',2)->order('id','desc')->find();
	$d2 = $user->removeOption('where')->removeOption('order')->select();
```

![image-20201216172935038](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201216172935038.png)

![image-20201215211614199](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201215211614199.png)

### 数据库链式查询

![image-20201215220732474](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201215220732474.png)

```php
1、数据库的增删改 操作
    一、数据插入
    $data 为数组
    插入数据 insert()第二个参数为 true 时 使用 replace 写入 即有唯一主键的话会替换掉之前的数据
    
    $res = Db::table('forum')->insert($data,true);

	！！ insertGetId($data) 插入成功后返回当前数据的ID值
        
    ！！批量插入数据
    insertAll($data); 此时 $data 为二位数组
    
    二、数据修改
    $data [
        'username' =>	'张三'
    ];
    Db::table('forum')->where('user_id',3)->update($data);

	！！！
	$data = [
        'username' 		=>	'张三',
        'first_name'	=>	Db::raw('LOWER(first_name)')
    ];
	Db::table('forum')->update($data);
```

![image-20201216155603096](C:\Users\刘莹莹\AppData\Roaming\Typora\typora-user-images\image-20201216155603096.png)

### 子查询

```php
闭包方法
$res = Db::table('users')->where('user_id','in',function ($query) {
            $query->table('messages')->field('user_id')->where('message_id',2);
        })->select();
相当于
SELECT * FROM `users` WHERE `user_id` IN (SELECT `user_id` FROM `messages` WHERE `message_id` = 2)
```

