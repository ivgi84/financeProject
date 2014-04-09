<?php

class User{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $username;
    private $password;

    function __construct($id, $firstName, $lastName, $email, $username, $password){

        $this->id=$id;
        $this->firstName=$firstName;
        $this->lastName=$lastName;
        $this->email=$email;
        $this->username=$username;
        $this->password=$password;
    }

    function getUserId(){
        return $this->id;
    }

    function getFirstName(){
        return $this->firstName;
    }
    function  getLastName(){
        return $this->lastName;
    }
    function getEmail(){
        return $this->email;
    }
    function getUsername(){
        return $this->username;
    }
    function getPassword(){
        return $this->password;
    }

}