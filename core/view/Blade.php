<?php

namespace core\view;

use duncan3dc\Laravel\BladeInstance;

class Blade extends View
{

    protected $template;
    public function init()
    {
        $config = \App::get('config')->get('view');
        $this->template = new BladeInstance($config['view_path'], $config['cache_path']);
    }

    public function render($path, $params = [])
    {
        return $this->template->render($path, $params);
    }
}