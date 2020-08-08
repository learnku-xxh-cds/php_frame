<?php

function response()
{
    return App::getApp('response');
}


function app($name)
{
    return App::get($name);
}