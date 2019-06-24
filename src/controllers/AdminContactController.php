<?php

class AdminContactController extends Controller
{

    public function index()
    {
        // verify if the current user has the admin role, else we redirect the user
        if (getUserData('role') !== 'ADMIN') redirectTo('/');
        // get messages from db and render the view
        $data['contacts'] = $this->getModel('ContactModel')->getAll();

        return $this->renderView('admin/contact/index', $data);
    }

    public function delete()
    {
        // verify if the current user has the admin role, else we redirect the user
        if (getUserData('role') !== 'ADMIN') redirectTo('/');
        // check incoming data
        if (!empty($_POST['idToDelete'])) {
            // validate data
            if (filter_var($_POST['idToDelete'], FILTER_VALIDATE_INT)) {
                $idToDelete = $_POST['idToDelete'];
                $success = $this->getModel('ContactModel')->delete($idToDelete);
                if ($success) {
                    // remove succeeded from db failed,we set the flash message and redirect to admin contact page
                    $this->setFlash('messages', 'success', 'remove_ok', "Le contact a été supprimé");
                    redirectTo('/admin/contacts');
                } else {
                    // remove from db failed,we set the flash message and redirect to admin contact page
                    $this->setFlash('messages', 'danger', 'remove_failed', "Une erreur inattendue est survenue");
                    redirectTo('/admin/contacts');
                }
            } else {
                // incoming data is not an integer,we set the flash message and redirect to admin contact page
                $this->setFlash('messages', 'danger', 'id_not_integer', "Une erreur inattendue est survenue");
                redirectTo('/admin/contacts');
            }
        } else {
            // no incoming data,we set the flash message and redirect to admin contact page
            $this->setFlash('messages', 'danger', 'no_id', "Une erreur inattendue est survenue");
            redirectTo('/admin/contacts');
        }
    }
}
