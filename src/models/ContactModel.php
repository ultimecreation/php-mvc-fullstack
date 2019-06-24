<?php

class ContactModel extends Model
{
    public function getAll()
    {
        $req = $this->bdd->prepare('select * from contacts');
        $req->execute();
        return $req->fetchAll();
    }

    public function saveNewContact($name, $email, $contact_subject, $contact_message)
    {
        $req = $this->bdd->prepare('insert into contacts set name=?, email=?,contact_subject=?,contact_message=?');
        $req->execute(array($name, $email, $contact_subject, $contact_message));
        if ($this->bdd->lastInsertId()) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($idToDelete)
    {
        $req = $this->bdd->prepare('delete from contacts where id=?');
        if ($req->execute(array($idToDelete))) {
            return true;
        } else {
            return false;
        }
    }
}
