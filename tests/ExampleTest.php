<?php


class ExampleTest extends \core\TestCase
{


    // 测试config
    public function testDatabaseDefault()
    {
        // 断言内容是 "mysql_one"
        $this->assertEquals('mysql_one',
          config('database.default')
        );
    }


    // 测试路由
    public function testGetRoute()
    {
        $this->get('/')
            ->assertStatusCode(200); // 断言状态码是200
    }


    // 测试路由
    public function testPostRoute()
    {
        $res = $this->post('/');

        // 断言返回的内容是 "post"
        $this->assertEquals('post',
            $res->getContent());

    }

}