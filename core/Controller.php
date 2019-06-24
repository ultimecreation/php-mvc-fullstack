<?php
class Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function setFlash($field, $class, $msg_id, $message)
    {
        $_SESSION[$field][$class][$msg_id] = $message;
    }
    public function getModel($model)
    {
        require_once("../src/Models/{$model}.php");
        return new $model;
    }

    public function renderView($content, $data = null)
    {

        include_once("../src/views/{$content}.php");
    }
}
