<?php

namespace app\entity ;

class Client {
    private $username ;
    private $password ;

    //constructor
    function __construct($id, $password){
        $this->username = $id ;
        $this->password = $password ;
    }

    //getters for username and password

    function getUsername(){
        return $this->username ;
    }

    function getPassword(){
        return $this->password ;
    }

    //setters and getters for the public and private keys
    function setPubK($key){
        $this->PubK = $key ;
    }
    
    function setPriK($key){
        $this->PriK = $key ;
    }

    function getPubK(){
        return $this->PubK ;
    }

    function getPriK(){
        return $this->PriK ;
    }
}

?>