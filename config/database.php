<?php


return [
  'default' => 'mysql_one',
  'connections' => [
      'mysql_one' => [
          'driver' => 'mysql',
          'host' => '127.0.0.1',
          'username' => 'root',
          'dbname' => 'gch',
          'password' => '',
          'prefix' => '',
          'options' => [

          ]
      ],

      'mysql_two' => [
          'drive' => 'mysql',
          'host' => '127.0.0.1',
          'username' => 'xxh',
          'password' => 123456,
          'prefix' => '',
          'options' => [

          ]
      ]


  ],

];