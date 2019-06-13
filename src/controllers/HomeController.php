<?php
class HomeController extends Controller
{
    public function index()
    {

        $data['example'] = $this->getModel('UserModel')->getUsers();
        $data['site'] = 'test site';
        return $this->renderView('index', $data);
    }
    public function about()
    {
        $uriParts = explode('/', $_GET['url']);

        $id = $uriParts[1];
        $name = $uriParts[2];
        echo "home controller run about function id={$id}, name={$name}";
    }
}
