## ps

没时间写, 赶公司项目。

9-1以后才有时间写。

## 框架介绍

为了帮助 `phper` 理解框架的运行原理。

以后装逼的时候, 被问到 `服务容器` `中间件` `模型` 是怎么实现? 框架是怎么运行的。 

希望你能根据 `你的理解` 并 `自信的` 说出来,而不是背出来, 这就是此框架的目的 !

## 框架使用要求

`php: ^7.3 || ^8.0`

## 设计方向

`简单为主`: 除了必要的验证,一般都不会有其他逻辑验证

`简洁`: 尽量不出现废话,以最少的字数来表达

`现代化`: 技术遵守最新的操作

一切都是为了让 `理解` 更为简单 !

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
* 自定义异常 (异常托管)
* 日志
* 单元测试 (phpunit)
* 缓存系统 (适配器模式)
* 自定义session (session托管)
* 替换成swoole的http服务器
* 发布到composer

