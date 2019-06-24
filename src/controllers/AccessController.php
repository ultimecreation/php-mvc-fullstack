<?php
class AccessController extends Controller

{
    public function register()
    {
        // set data value to avoid issues
        $data = array(
            'name' => '',
            'email' => '',
            'name_error' => '',
            'email_error' => '',
            'password_error' => '',
            'confirm_password_error' => ''
        );

        // check method is POST
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            // check crsf token from utils/csrf
            if (validateCsrf($_POST) === true) {
                // sanitize inputs
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $name = trim(htmlspecialchars($_POST['name']));
                $email = trim(htmlspecialchars($_POST['email']));
                $password = trim(htmlspecialchars($_POST['password']));
                $confirm_password = trim(htmlspecialchars($_POST['confirm_password']));

                // validate inputs
                if (empty($name)) {
                    $data['name_error'] = "Le nom est requis";
                }
                if (empty($email)) {
                    $data['email_error'] = "L'email est requis";
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data['email_error'] = "L'email n'est pas valide";
                } else {
                    $emailTaken = $this->getModel('AccessModel')->checkEmailIsUnique($email);
                    if ($emailTaken) {
                        $data['email_error'] = "L'email est déjà prit";
                    }
                }
                if (empty($password)) {
                    $data['password_error'] = "Le mot de passe est requis";
                }
                if (strlen($password) < 6) {
                    $data['password_error'] = "Le mot de passe doit avoir au moins 6 charactères";
                }
                if (empty($confirm_password)) {
                    $data['confirm_password_error'] = "La confirmation du mot de pass est requise";
                }
                if ($password !== $confirm_password) {
                    $data['password_error'] = "Les mots de passe ne correspondent pas";
                }
                if (!empty($data['name_error']) || !empty($data['email_error']) || !empty($data['password_error']) || !empty($data['confirm_password_error'])) {
                    // return errors and view
                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'name_error' => $data['name_error'],
                        'email_error' => $data['email_error'],
                        'password_error' => $data['password_error'],
                        'confirm_password_error' => $data['confirm_password_error']
                    );

                    return $this->renderView('access/register', $data);
                }
                if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                    // all is ok ,we process the data
                    $password = password_hash($confirm_password, PASSWORD_BCRYPT, array('cost' => 13));
                    $confirmation_token = generate_token();
                    $confirmation_token_created_at = (new \DateTime('now'))->format("Y-m-d H:i:s");
                    // save data to the db
                    $userExists = $this->getModel('AccessModel')->saveNewUser($name, $email, $password, $confirmation_token, $confirmation_token_created_at);
                    if ($userExists) {
                        $this->setFlash('messages', 'success', 'user_registered', "Le compte a été créé avec succès");
                        clearCsrf();
                        redirectTo('/');
                    }
                }
            } else {
                // the token has expired
                clearCsrf();
                $this->setFlash('messages', 'danger', 'token expired', "Le jeton de sécurité a expiré");
                redirectTo('/');
            }
        } else {
            // method is not POST
            return $this->renderView('access/register');
        }
    }
    public function login()
    {

        // check for POST method
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            // validate csrf from utils/csrf
            if (validateCsrf($_POST) === true) {
                // sanitize inputs
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $email = trim(htmlspecialchars($_POST['email']));
                $password = trim(htmlspecialchars($_POST['password']));
                // validate inputs
                if (empty($email)) {
                    $data['email_error'] = "L'email est requis";
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data['email_error'] = "L'email n'est pas valide";
                }
                if (empty($password)) $data['password_error'] = "Le mot de passe est requis";

                if (!empty($data['email_error']) || !empty($data['password_error'])) {
                    // if errors, render view and display errors
                    return $this->renderView('access/login', $data);
                }
                if (empty($data['email_error']) && empty($data['password_error'])) {
                    // no errors, we process the data
                    $userExists = $this->getModel('AccessModel')->checkUserExists($email);
                    if ($userExists) {
                        // we verify the password
                        if (password_verify($password, $userExists->password)) {
                            // we set user data to the session
                            $data = array(
                                'name' => $userExists->name,
                                'email' => $userExists->email,
                                'role' => $userExists->role,
                            );
                            setUserData($data);
                            // set flash message , clear the csrf check and redirect to homepage
                            $this->setFlash('messages', 'success', 'user_logged', "Vous êtes connecté(e)");
                            clearCsrf();
                            redirectTo('/');
                        } else {
                            // wrond password, we send a flash message ,reset the csrf and redirect the user
                            $this->setFlash('messages', 'danger', 'wrong_password', "Identifiants inconnus");
                            clearCsrf();
                            redirectTo('/connexion');
                        }
                    } else {
                        // no user found, we clear the csrf check and redirect the user to homepage
                        clearCsrf();
                        redirectTo('/');
                    }
                }
            } else {
                // the token is not ok, we send a flash message, clear the csrf check and redirect to homepage
                clearCsrf();
                $this->setFlash('messages', 'danger', 'token expired', "Le jeton de scurité a expiré");
                redirectTo('/');
            }
        } else {
            // method is not POST,we render the view
            return $this->renderView('access/login');
        }
    }

    public function logout()
    {
        // delete the user data from session,send a flash message and redirect to homepage
        userLogoutRequest();
        $this->setFlash('messages', 'success', 'user_logged_out', "Vous êtes déconnecté(e)");
        redirectTo('/');
    }
}
