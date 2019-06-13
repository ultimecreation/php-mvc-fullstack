<?php
class Routes
{
    public static function getRoutes()
    {
        return array(
            array('pattern' => 'about/:id/:name', 'path' => array('HomeController', 'about'), 'params' => array('id' => 1, 'name' => 'jean')),
            array('pattern' => '/', 'path' => array('HomeController', 'index'), 'params' => null),
        );
    }
}
