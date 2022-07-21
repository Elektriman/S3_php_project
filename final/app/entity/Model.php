<?php

namespace app\entity;

use app\entity\Database;
use \PDO;



class Model{

    protected $table;

    protected $connexion;

    public function __construct(){

        $db = new Database();
        $this->connexion = $db->getConnection();

    }

    public function read($id)
    {
        //if($fields==null){$fields="*";}

        $sql="SELECT * FROM ".$this->table." WHERE id=".$id;
        /*$req=mysql_query($sql) or die(mysql_error());
        $data=mysql_fetch_assoc($req);*/


        $retour = $this->connexion->query($sql);
        if($retour===False){
            return $retour ;
        } else {
            $content = $retour->fetch(PDO::FETCH_ASSOC);
        }
        
        return $content;

    }

    public function save($data){
        //UPDATE
        if(isset($data["id"]) && !empty($data["id"]))
        {

            //print_r($data);

            $sql="UPDATE ".$this->table." SET ";
            foreach ($data as $key => $value) {
                if($key!=='id')
                    $sql.="$key='$value',";
            }
            //suppression de la virgule
            $sql=substr($sql,0,-1);
            $sql.=" WHERE id=".$data['id'];

        }
        //INSERT
        else
        {
            $sql="INSERT INTO ".$this->table."(";
            foreach ($data as $key => $value) {
                unset($data["id"]);
                $sql.="$key,";
            }
            //suppression de la virgule
            $sql=substr($sql,0,-1);
            $sql.=" ) VALUES (";
            foreach ($data as $key => $value) {
                $sql.="'$value',";
            }
            $sql=substr($sql,0,-1);
            $sql.=" )";
        }

        //echo $sql;
        //Envoie de la requete
        //mysql_query($sql) or die(mysql_error()."<p> =>".mysql_query()."</p>");

        $retour=$this->connexion->exec($sql);

        //init de la valeur de l'id
        if(!isset($data["id"]))
        {
            $this->id=$this->connexion->lastInsertId();
        }
        else
        {
            $this->id=$data["id"];
        }

        return true;
    }



    public function find($data=array())
    {
      /*
        $conditions="1";
        $fields="*";
        $limit="";
        $order=$this->table.".id DESC";
        $othertable="";
        if(isset($data["conditions"])){$conditions=$data["conditions"];}
        if(isset($data["fields"])){$fields=$data["fields"];}
        if(isset($data["limit"])){$limit="LIMIT".$data["limit"];}
        if(isset($data["order"])){$order=$data["order"];}
        if(isset($data["othertable"])){$othertable=','.$data["othertable"];}
*/

       // $prepa=$this->connexion->prepare('SELECT :fields FROM :table :othertable WHERE :conditions ORDER BY :order :limit');
        
        /*$sql="SELECT $fields FROM ". $this->table." ".$othertable." WHERE $conditions ORDER BY $order $limit";*/

        //echo $sql;

  //      $sql='SELECT '.$fields.' FROM '. $this->table.' '.$othertable.' WHERE 1 ORDER BY '.$order;

        //$sql='SELECT * FROM ville where id= :num';
        //echo $sql;

        //$prepa=$this->connexion->query($sql);
            $val=1;
    //   $prepa=$this->connexion->prepare($sql);
      // $prepa->execute();

        //$prepa->debugDumpParams();
        
        //$data=$prepa->fetchAll(PDO::FETCH_ASSOC);


       // return $data;



        //V2

        $sql = "select * from ".$this->table. " where 1";
        $prepa = $this->connexion->prepare($sql);
        $prepa->execute();

        //$prepa->debugDumpParams();

        $data = $prepa->fetchAll(PDO::FETCH_ASSOC);

        return $data;


    }


    public function deleteAll($id=null)
    {
        if($id==null){$id=$this->id;}



        $sql="DELETE FROM ".$this->table." WHERE id=$id";
        //echo $sql;
        //$req=mysql_query($sql) or die(mysql_error());

        $req=$this->connexion->exec($sql);

    }
}