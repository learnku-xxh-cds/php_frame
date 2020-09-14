见: [[手摸手带你创建php现代化框架] 教程终于写完了](https://learnku.com/articles/49496)
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
+---app
|   |   helpers.php // 函数
|   +---controller
|   |       UserController.php // 示例控制器
|   +---exceptions
|   |       ErrorMessageException.php // 错误消息返回
|   |       HandleExceptions.php // 继承core/HandleExceptions
|   +---middleware
|   |       ApiMiddleWare.php
|   |       ControllerMiddleWare.php
|   |       IsAuthMiddleWare.php 
|   |       WebMiddleWare.php // web.php加载的中间件
|   \---models
|           User.php // 示例模型
+---config
|       database.php // 数据库配置
|       log.php // 日志配置
|       view.php // 视图配置
+---core
|   |   Config.php  // 配置
|   |   Controller.php      // 基础控制器
|   |   HandleExceptions.php    // 异常&错误 托管处理
|   |   PipleLine.php   // 管道
|   |   Response.php    // 响应
|   |   RouteCollection.php // 路由
|   |   SwooleContext.php // 协程上下文管理
|   |   TestCase.php // 基础测试文件
|   +---database
|   |   |   Database.php 
|   |   +---connection
|   |   |       Connection.php
|   |   |       ConnectionInterface.php
|   |   |       MysqlConnection.php // mysql链接
|   |   |       SqlServerConnection.php 
|   |   +---model
|   |   |       Builder.php // 模型构造器
|   |   |       Model.php // 基础模型
|   |   \---query
|   |           Grammar.php
|   |           MysqlGrammar.php // 编译成sql语句
|   |           QueryBuilder.php // 查询构造器
|   +---log
|   |   |   Logger.php // 日志管理
|   |   \---driver // 不同类型日志实现
|   |           DailyLogger.php
|   |           StackLogger.php
|   |
|   +---request
|   |       PhpRequest.php  // 请求
|   |       RequestInterface.php 
|   \---view
|           Blade.php       // laravel模板引擎
|           Thinkphp.php    // tp模板引擎
|           View.php    // 视图适配器
|           ViewInterface.php 
+---public
|       index.php // 单一入口文件
+---routes
|       api.php 
|       web.php // 大部分功能可以在这里运行
+---storage
|       daily.log       // 框架日志 按日期类型 
|       php_frame.log // 框架日志 
|       swoole.pid // swoole的进程pid
+---tests
|       ExampleTest.php // 测试示例文件
+---phpunit.xml // phpunit的配置
+---app.php     // 框架要经过这个加载
+---swoole.php     // swoole的http服务器
```



## 文章目录
### 基础篇
* 第一步 创建框架目录  
* 引入composer自动加载 
* composer自动加载 (解释篇) 
* 添加函数文件helpers.php
* 创建容器 (反射解析依赖 注册树模式) 
* 关于psr规范解释
* 关于"容器" "契约" "依赖注入" (解释篇)
* 初始化请求(Request) 
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
* 替换成swoole的http服务器 
* 协程上下文解决request问题
* 发布到composer
