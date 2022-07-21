<?php

namespace app\entity;

require_once realpath($_SERVER["DOCUMENT_ROOT"])."/app/util/misc.php";
fullImport();

use app\entity\Client ;
use app\entity\Model ;


class ClientModel extends Model{

    public function __construct()
    {
        $this->table = "clients";
        parent::__construct();
        
        //creation de la table clients si elle n'existe pas déjà
        $tables = $this->connexion->query("SHOW TABLES;");
        $tables = $tables->fetchAll(\PDO::FETCH_ASSOC);
        if(!in_array($this->table, $tables)){
            $sql = "CREATE TABLE clients (
                username char(255) primary key,
                password char(255)
            );" ;
            $this->connexion->query($sql);
        }
    }

    public function findAll(){
        $arrayClient=$this->find();

        $newTab=array();        //$newTab=[];

        foreach ($arrayClient as $id=>$attributes){
            $newTab[]=new Client($attributes['username'], $attributes['password']);
        }

        return $newTab;

    }

    public function findOne($id){
        $data=$this->read($id);

        //var_dump($data);
        if($data===False){
            return ;
        }

        return new Client($data['username'], $data['password']);
    }
}