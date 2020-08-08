<?php

namespace App\controller;

use App\middleware\ControllerMiddleWare;
use core\Controller;
class UserController extends Controller
{

    protected $middleware = [
        ControllerMiddleWare::class
    ];
 //   public function index($request)
    public function index()
    {
        return 'user controller';
    }

    public function view()
    {

    }
}