<?php
class Routes
{
    public static function getRoutes()
    {
        return array(
            array('pattern' => 'deconnexion', 'path' => array('AccessController', 'logout'), 'params' => null),
            array('pattern' => 'inscription', 'path' => array('AccessController', 'register'), 'params' => null),
            array('pattern' => 'connexion', 'path' => array('AccessController', 'login'), 'params' => null),
            array('pattern' => 'contact', 'path' => array('ContactController', 'index'), 'params' => null),
            array('pattern' => 'prestations', 'path' => array('HomeController', 'prestations'), 'params' => null),
            array('pattern' => '/', 'path' => array('HomeController', 'index'), 'params' => null),
            array('pattern' => 'admin/contacts', 'path' => array('AdminContactController', 'index'), 'params' => null),
            array('pattern' => 'admin/suppression-contact', 'path' => array('AdminContactController', 'delete'), 'params' => null),
            array('pattern' => 'admin/nouvelle-prestation', 'path' => array('AdminServicesController', 'add'), 'params' =>  null),
            array('pattern' => 'admin/modification-prestation', 'path' => array('AdminServicesController', 'edit'), 'params' => null),
            array('pattern' => 'admin/suppression-prestation', 'path' => array('AdminServicesController', 'delete'), 'params' => null),
            array('pattern' => 'admin/prestations', 'path' => array('AdminServicesController', 'index'), 'params' => null),
        );
    }
}
// @([0-9]+)/([a-z_-]+)@
