## 框架介绍

为了帮助 `phper` 理解框架的运行原理。

以后装逼的时候, 被问到 `服务容器` `中间件` `模型` 是怎么实现? 框架是怎么运行的。 

希望你能根据 `你的理解` 并 `自信的` 说出来,而不是背出来, 这就是此框架的目的 !

## 框架使用要求

1. `php: ^7.3 || ^8.0`

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



