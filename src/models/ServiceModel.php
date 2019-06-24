<?php

class ServiceModel extends Model
{
    public function getAll()
    {
        $req = $this->bdd->prepare('select * from services');
        $req->execute();
        return $req->fetchAll();
    }

    public function getOne($idToEdit)
    {
        $req = $this->bdd->prepare('select * from services where id=?');
        $req->execute(array($idToEdit));
        return $req->fetch();
    }

    public function updateService($name, $description, $image, $idToUpdate)
    {
        $req = $this->bdd->prepare('update services set name=?, description=?,image=? where id=?');
        $req->execute(array($name, $description, $image, $idToUpdate));
    }
    public function saveNewService($name, $description, $image)
    {
        $req = $this->bdd->prepare('insert into services set name=?,description=?,image=?');
        $req->execute(array($name, $description, $image));
        if ($this->bdd->lastInsertId()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($idToDelete)
    {

        $req = $this->bdd->prepare('delete from services where id=?');
        if ($req->execute(array($idToDelete))) {
            return true;
        } else {
            return false;
        }
    }
}
