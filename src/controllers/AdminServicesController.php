<?php

class AdminServicesController extends Controller
{
    public function index()
    {
        // verify if the current user has the admin role, else we redirect the user
        if (getUserData('role') !== 'ADMIN') redirectTo('/');
        // get all services from db
        $data['services'] = $this->getModel('ServiceModel')->getAll();

        // render view and data
        return $this->renderView('admin/services/index', $data);
    }

    public function add()
    {
        // verify if the current user has the admin role, else we redirect the user
        if (getUserData('role') !== 'ADMIN') redirectTo('/');
        $data = array(
            'name' => '',
            "description" => "",
            'file_error' => '',
        );
        // check if method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // check the csrf
            if (validateCsrf($_POST) === true) {
                // sanitize inputs
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $name = trim(htmlspecialchars($_POST['name']));
                $description = trim(htmlspecialchars($_POST['description']));

                // validate inputs
                if (empty($name)) $data['name_error'] = "Le nom est requis";
                if (empty($description)) $data['description_error'] = "La description est requise";

                $file = $_FILES['image'];
                // check if file is under 1Go
                if ($file['size'] / pow(1024, 3) > 1) {
                    $data['file_error'] = "L'image doit être inférieur à 1 Go (taille du fichier: {$file['size']} Go";
                }

                // check if file is an image
                if (getimagesize($file["tmp_name"]) === false) {
                    $data['file_error'] = "Le fichier n'est pas une image";
                }

                // check for image upload
                if (empty($file['name'])) $data['file_error'] = "L' image est requise";
                // if errors, render add page with errors
                if (!empty($data['name_error']) || !empty($data['description_error']) || !empty($data['file_error'])) {
                    $data = array(
                        'name' => $name,
                        'description' => $description,
                        'name_error' => $data['name_error'],
                        'description_error' => $data['description_error'],
                        'file_error' => $data['file_error']
                    );
                    // return page and errors
                    return $this->renderView('admin/services/add', $data);
                }
                // if no errors, process the data
                if (empty($data['name_error']) && empty($data['description_error']) && empty($data['file_error'])) {

                    // sanitize image name
                    $image = trim(htmlspecialchars($file['name']));
                    $image = generate_token(10) . '_' . $image;
                    $image = basename($image);
                    // set the file target
                    $image_target_location = "uploads/prestations/{$image}";
                    // store the file
                    move_uploaded_file($file['tmp_name'], $image_target_location);

                    // save the data in db
                    $success = $this->getModel('ServiceModel')->saveNewService($name, $description, $image);
                    if ($success === true) {
                        // data saved,we set the flash message , clear the csrf and redirect to admin prestations page
                        clearCsrf();
                        $this->setFlash('messages', 'success', 'service_saved', "Les données ont été sauvegardé");
                        redirectTo('/admin/prestations');
                    } else {
                        // data not saved,we set the flash message , clear the csrf and redirect to admin prestations page
                        clearCsrf();
                        $this->setFlash('messages', 'danger', 'service_not saved', "Une erreur inattendue s'est produite");
                        redirectTo('/admin/prestations');
                    }
                }
            } else {
                // token is not ok,we reset the token check ,send a flash message and redirect to homepage
                clearCsrf();
                $this->setFlash('messages', 'danger', 'add_service_failed', "Une erreur inattendue est survenue");
                redirectTo('/');
            }
        } else {
            // method is not POST,we render the view
            return $this->renderView('admin/services/add');
        }
    }
    public function edit()
    {
        // verify if the current user has the admin role, else we redirect the user
        if (getUserData('role') !== 'ADMIN') redirectTo('/');
        // set data with empty values 
        $data = array(
            'name' => '',
            "description" => "",
            'file_error' => '',
            'name_error' => '',
            'description_error' => ''
        );
        // check if method is GET
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // check for incoming data
            if (!empty($_GET['idToEdit'])) {
                // validate incoming data
                if (filter_var($_GET['idToEdit'], FILTER_VALIDATE_INT)) {
                    // process the data
                    $idToEdit = $_GET['idToEdit'];

                    // get service data from db
                    $service = $this->getModel('ServiceModel')->getOne($idToEdit);
                    $data = array(
                        'name' => $service->name,
                        'description' => $service->description,
                        'image_old' => $service->image,
                        'idToUpdate' => $service->id
                    );
                } else {
                    // data not valid,we clear the csrf check ,send a flash message and redirect to admin prestations page
                    clearCsrf();
                    $this->setFlash('messages', 'danger', 'edit_failed', "Une erreur inattendue s'est produite");
                    redirectTo('/admin/prestations');
                }
            }
        }
        // check if method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // check if csrf is ok
            if (validateCsrf($_POST) === true) {
                // check for incoming data
                if (!empty($_POST['idToUpdate'])) {
                    //sanitize incoming data
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


                    $name = trim(htmlspecialchars($_POST['name']));
                    $description = trim(htmlspecialchars($_POST['description']));
                    $image_old = trim(htmlspecialchars(strip_tags($_POST['image_old'])));
                    $idToUpdate = trim(htmlspecialchars(strip_tags($_POST['idToUpdate'])));
                    // validate incoming data
                    if (empty($name)) $data['name_error'] = "Le nom est requis";
                    if (empty($description)) $data['description_error'] = "La description est requise";

                    $newFile = $_FILES['image'];
                    // check if file was uploaded
                    if ($newFile['size'] > 0) {
                        // check if file is under 1Go
                        if ($newFile['size'] / pow(1024, 3) > 1) {
                            $data['file_error'] = "L'image doit être inférieur à 1 Go (taille du fichier: {$file['size']} Go";
                        }

                        // check if file is an image
                        if (getimagesize($newFile["tmp_name"]) === false) {
                            $data['file_error'] = "Le fichier n'est pas une image";
                        }

                        // check for image upload
                        if (empty($newFile['name'])) $data['file_error'] = "L' image est requise";
                    } else {
                        // we keep the old image as reference
                        $image = $image_old;
                    }
                    // if errors
                    if (!empty($data['name_error']) || !empty($data['description_error']) || !empty($data['file_error'])) {
                        $data = array(
                            'name' => $name,
                            'description' => $description,
                            'name_error' => $data['name_error'],
                            'description_error' => $data['description_error'],
                            'file_error' => $data['file_error']
                        );
                        // return page and errors
                        return $this->renderView('admin/services/add', $data);
                    }
                    // if no errors, process the data
                    if (empty($data['name_error']) && empty($data['description_error']) && empty($data['file_error'])) {

                        if ($newFile['size'] > 0) {
                            // sanitize image name, and prepare it
                            $image = trim(htmlspecialchars($newFile['name']));
                            $image = generate_token(10) . '_' . $image;
                            $image = basename($image);
                            // set the file target
                            $image_target_location = "uploads/prestations/{$image}";
                            // store the file
                            move_uploaded_file($newFile['tmp_name'], $image_target_location);
                            // move the old one
                            unlink("../public/uploads/prestations/{$image_old}");
                        }

                        // save the data in db
                        $success = $this->getModel('ServiceModel')->updateService($name, $description, $image, $idToUpdate);
                        if ($success === true) {
                            // data saved,we clear the csrf check ,send a flash message and redirect to admin prestations page
                            clearCsrf();
                            $this->setFlash('messages', 'success', 'service_saved', "Les données ont été sauvegardé");
                            redirectTo('/admin/prestations');
                        } else {
                            // data not saved,we clear the csrf check ,send a flash message and redirect to admin prestations page
                            clearCsrf();
                            $this->setFlash('messages', 'danger', 'service_not saved', "Une erreur inattendue s'est produite");
                            redirectTo('/admin/prestations');
                        }
                    }
                } else {

                    clearCsrf();
                    $this->setFlash('messages', 'danger', 'invalid_token', "Une errue inattendue est survenue");
                    redirectTo('/admin/prestations');
                }
            } else {
                // invalid token,we clear the csrf check ,send a flash message and redirect to admin prestations page
                clearCsrf();
                $this->setFlash('messages', 'danger', 'invalid_token', "Une errue inattendue est survenue");
                redirectTo('/admin/prestations');
            }
        }
        // we render the view
        return $this->renderView('admin/services/edit', $data);
    }

    public function delete()
    {
        // verify if the current user has the admin role, else we redirect the user
        if (getUserData('role') !== 'ADMIN') redirectTo('/');
        // check for incoming data
        if (isset($_POST['idToDelete'])) {
            //validate data
            if (filter_var($_POST['idToDelete'], FILTER_VALIDATE_INT)) {
                $idToDelete = $_POST['idToDelete'];

                $success = $this->getModel('ServiceModel')->delete($idToDelete);
                if ($success) {
                    // data removed from db,we clear the csrf check ,send a flash message and redirect to admin prestations page
                    clearCsrf();
                    $this->setFlash('messages', 'success', 'remove_ok', "La prestation a été supprimé");
                    redirectTo('/admin/prestations');
                }
            } else {
                // invalid incoming data,we clear the csrf check ,send a flash message and redirect to admin prestations page
                clearCsrf();
                $this->setFlash('messages', 'danger', 'remove_failed', "La suppression a échoué");
                redirectTo('/admin/prestations');
            }
        } else {
            // no incoming data,we clear the csrf check ,send a flash message and redirect to admin prestations page
            clearCsrf();
            $this->setFlash('messages', 'danger', 'no_idToDelete', "La suppression a échoué");
            redirectTo('/admin/prestations');
        }
    }
}
