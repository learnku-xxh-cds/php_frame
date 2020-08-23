<?php

namespace core;


use PHPUnit\Framework\TestCase as BaseTestCase;
class TestCase extends BaseTestCase
{

    // 基境共享
    protected function setUp(): void
    {
         require_once __DIR__.'/../app.php';
    }




}