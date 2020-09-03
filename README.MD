## 设计方向
### 闭门造轮子
听到很多,不要创建重复轮子了!

做框架,直接用轮子确实会方便超级多,比如用[symfony](http://www.symfonychina.com/doc/current/components/index.html)的轮子就可以组装一个完善框架。

最后终究还是要 `学习框架底层` = `学习轮子`,这也此框架目的之一。
 
`闭门造轮` 成为这个框架最大的特色。
### 不完善全部代码
指不是框架运行必要的代码, 本教程不会写!

读者自行完善, 这也可以加深读者的印象。

比如路由, `get` `post`写好了,
![http://cdn.lblog.club/cdn/files/php_frame_route.png](http://cdn.lblog.club/cdn/files/php_frame_route.png)

`put` `post` `delete` 让读者去完善。
### 最少代码
我个人较为讨厌长代码,每个字都需要去解读。

因为 `不完善全部代码` , 所以代码量才少。

如果全部都完善了,那为什么不去看 `轮子` 源码?

因为代码量多呗 !
## 目录结构
```
+---app             // 用户主要都app文件夹编写
|   +---controller   // 控制器
|   +---exceptions  // 用户自定义的异常
|   +---middleware // 用户中间件
|   \---models // 用户模型
+---config // 配置文件 参考laraevl
├─core
│  │  Config.php
│  │  Controller.php
│  │  HandleExceptions.php
│  │  PipleLine.php
│  │  Request.php
│  │  Response.php
│  │  RouteCollection.php
│  │
│  ├─database
│  │  │  Database.php
│  │  │
│  │  ├─connection
│  │  │      Connection.php 
│  │  │      ConnectionInterface.php
│  │  │      MysqlConnection.php
│  │  │      SqlServerConnection.php
│  │  │
│  │  ├─model
│  │  │      Builder.php
│  │  │      Model.php 
│  │  │
│  │  └─query  // sql操作
│  │          Grammar.php   // 将数据编译成sql基类
│  │          MysqlGrammar.php // mysql编译成sql
│  │          QueryBuilder.php // 将数组整合
│  └─view
│          Blade.php   // blade的模板引擎
│          Thinkphp.php  // thinkphp的模板引擎
│          View.php // 适配器
│          ViewInterface.php 
+---public  // 公共文件入口
│  └─index.php // web端的入口
+---routes  // 路由文件  web.php和api.php都在这里
+---storage // 存储 
+---tests  // 单元测试文件
```


## 文章目录
### 基础篇
* 第一步 创建框架目录  
* 引入composer自动加载 
* 为什么php可用自动加载 (解释篇) 
* 创建容器 (反射解析依赖 注册树模式) 
* 初始化请求(Request) 
* 关于容器契约 依赖注入 (解释篇)
* 响应 (Response) 
* 路由一 (路由组实现)
* 路由二 (加入中间件)
* 配置信息 (类似laravel)
* 数据库连接 (多例模式)
* 查询构造器 (query builder)
### mvc实现
* M 模型实现 (数据映射 + 原型 模式) 
* C 控制器实现 + 控制器中间件
* V 视图实现 (Blade + Tp的模板引擎)
### 额外
* 日志
* 自定义异常 (异常托管)
* 单元测试 (phpunit)

~~* 缓存系统 (适配器模式)~~

* 替换成swoole的http服务器
* 发布到composer

