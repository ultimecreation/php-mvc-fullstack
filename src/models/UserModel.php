<?php

class UserModel extends Model
{
    public function getUsers()
    {
        // $req = $this->bdd->prepare('select * from users');
        // $req->execute();
        // return $req->fetchAll();
        $example = "Bienvenue sur le site";
        return $example;
    }
}
