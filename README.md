# php-mvc-fullstack


1. Config du projet config > config.php

            define('DB_HOST', 'localhost');
            define('DB_NAME', 'my_website');
            define('DB_USER', 'root');
            define('DB_PASS', '');

            // site CONSTANTS
            define('SITENAME', '');
            define('BASE_URL', 'http://localhost/php-mvc-framework');
            define('PUBLIC_URL', BASE_URL.'/public');

2. Création d'un modèle src > models > SomeModelModel.php

            <?php
            class HomeModel extends Model
            {
                public function getAllUsers()
                {
                    $req = $this->bdd->prepare('select * from users');
                    $req->execute();
                    return $req->fetchAll();
                }
            }
            
3. Création d'un contrôleur src > controllers > SomeControllersController            

            <?php

            // $data = array(
            //     'template' => 'custom'
            // );


            class HomeController extends Controller
            {    
                public function index()
                {

                    return $this->renderView('pages/index');
                }
            }

4.Défission d'une route src > Route > routes.php

<?php
class Routes
{
    public static function getRoutes()
    {
        /**
         * route format url|goto
         * url String (ie: '/',....)
         * Controller/method/params (ie: 'HomeController','index')
         * params Regex (ie: '(\d+)','(\W+)')
         * examples
         * ========
         * array('url' => '/test/(\d+)',  'goto' =>  array('TestController', 'index')),
         * array('url' => '/test/save', 'goto' =>  array('TestController', 'save')),
         * array('url' => '/retest/update',  'goto' =>  array('RetestController', 'update')),
         * array('url' => '/retest/delete',  'goto' =>  array('RetestController', 'delete')),
         */
        return [
            

            array('url' => '/admin', 'goto' =>  array('AdminHomeController', 'index')),
            array('url' => '/db-setup', 'goto' =>  array('DbSetupController', 'index')),
          
            array('url' => '/', 'goto' =>  array('HomeController', 'index')),
        ];
    }
}


