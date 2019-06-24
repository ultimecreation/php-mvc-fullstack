<?php
class ContactController extends Controller
{
    public function index()
    {
        // set init data to empty value
        $data = array(

            'name_error' => '',
            'email_error' => '',
            'contact_subject' => '',
            'contact_message_error' => ''

        );
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // check for csrf
            if (validateCsrf($_POST) === true) {
                //sanitize inputs
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $name = trim(htmlspecialchars($_POST['name']));
                $email = trim(htmlspecialchars($_POST['email']));
                $contact_subject = trim(htmlspecialchars($_POST['contact_subject']));
                $contact_message = trim(htmlspecialchars($_POST['contact_message']));

                // validate inputs
                if (empty($name)) $data['name_error'] = "Le nom est requis";
                if (empty($email)) $data['email_error'] = "L'email est requis";
                if (empty($contact_subject)) $data['contact_subject_error'] = "Le message est requis";
                if (empty($contact_message)) $data['contact_message_error'] = "Le message est requis";

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $data['email_error'] = "L'email n'est pas valide";

                // if error ,display the form with errors
                if (!empty($data['name_error']) || !empty($data['email_error']) || !empty($data['contact_message_error'])) {
                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'contact_message' => $contact_message,
                        'name_error' => $data['name_error'],
                        'email_error' => $data['email_error'],
                        'contact_subject' => $data['contact_subject_error'],
                        'contact_message_error' => $data['contact_message_error']

                    );

                    return $this->renderView('contact/index', $data);
                }


                // if no errors 
                if (empty($data['name_error']) && empty($data['email_error']) && empty($data['contact_message_error'])) {
                    // save contact
                    $success = $this->getModel('ContactModel')->saveNewContact($name, $email, $contact_subject, $contact_message);
                    if ($success) {
                        // send email for confirmation
                        $to = $email;
                        $subject = 'Confirmation de contact';
                        $message = "
                        Nous avons bien recu votre message: <br>
                        <h1>{$contact_subject}</h1>
                        <p>{$contact_message}</p>";
                        $headers = "From: ultimecreation.com <br> 
                        Reply-to: ultimecreation@test.com";
                        mail($to, $subject, $message, $headers);
                        // reset csrf , send flash message and redirect homepage
                        clearCsrf();
                        $this->setFlash('messages', 'success', 'message_saved', "Le message a été sauvegardé");
                        redirectTo('/');
                    } else {
                        // message not saved reset csrf , send flash message and redirect homepage
                        clearCsrf();
                        $this->setFlash('messages', 'danger', 'contact_not_saved', "Une erreur inattendue est survenue");
                        redirectTo('/');
                    }
                }
            } else {
                // csrf failed, reset csrf , send flash message and redirect homepage
                clearCsrf();
                $this->setFlash('messages', 'danger', 'token_expired', 'Le jeton de sécurité a expiré');
                redirectTo('/');
            }
        } else {
            // method is not GET
            return $this->renderView('contact/index');
        }
    }
}
