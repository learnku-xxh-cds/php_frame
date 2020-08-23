<?php


class ConfigTest extends \core\TestCase
{


    public function testDatabaseDefault()
    {
        $this->assertEquals('mysql_one',
            App::getContainer()->get('config')->get('database.default')
        );
    }

//    public function testGetRoute()
//    {
//        $request = new \core\Request();
//    }

}