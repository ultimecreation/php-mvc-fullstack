<?php
class HomeController extends Controller
{
    public function index()
    {
        return $this->renderView('home/home');
    }
    public function prestations()
    {
        // get all services from db
        $data['services'] = $this->getModel('ServiceModel')->getAll();

        // render view and data
        return $this->renderView('home/prestations', $data);
    }
}
