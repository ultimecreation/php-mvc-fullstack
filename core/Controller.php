<?php
class Controller
{
    public function getModel($model)
    {
        require_once("../src/Models/{$model}.php");
        return new $model;
    }

    public function renderView($content, $data = [], $template = null)
    {
        // load content
        if ($content) {
            if (file_exists("../src/views/{$content}.php")) {
                $content = "../src/views/{$content}.php";
            }
        }
        //load template
        if ($template === null) {
            require_once('../src/views/templates/base_template.php');
        } elseif (!empty($template)) {

            if (file_exists("../src/views/templates/{$template}.php")) {
                require_once("../src/views/templates/{$template}.php");
            }
        } else {
            die('Template inexistant');
        }
    }

    public function redirectTo($endPath)
    {
        $path = SITEURL . $endPath;
        header("Location: {$path}");
    }
}
