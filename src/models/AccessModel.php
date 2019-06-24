<?php
class AccessModel extends Model
{
    public function checkEmailIsUnique($email)
    {
        $req = $this->bdd->prepare('select email from users where email=?');
        $req->execute(array($email));
        $emailTaken = $req->fetch();
        if ($emailTaken) {
            return true;
        } else {
            return false;
        }
    }
    public function saveNewUser($name, $email, $password, $confirmation_token, $confirmation_token_created_at)
    {
        $req = $this->bdd->prepare('insert into users set name=?, email=?, password=?, confirmation_token=?, confirmation_token_created_at=?');
        $req->execute(array($name, $email, $password, $confirmation_token, $confirmation_token_created_at));
        if ($this->bdd->lastInsertId()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUserExists($email)
    {
        $req = $this->bdd->prepare('select * from users where email=?');
        $req->execute(array($email));
        $userExists = $req->fetch();
        if ($userExists) {
            return $userExists;
        } else return false;
    }
}
