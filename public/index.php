<?php


define('FRAME_BASE_PATH',__DIR__.'/../');
require FRAME_BASE_PATH.'/vendor/autoload.php';
$app = require FRAME_BASE_PATH.'/app.php';

echo $app->get('request')->getMethod();

