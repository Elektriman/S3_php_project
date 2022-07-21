<?php

/**
 * autoloads a class
 */
function autoload(){
    //autoload
    function chargerClasse($classe)
    {
    $classe=str_replace('\\','/',$classe);        
    require $classe . '.php';
    }

    spl_autoload_register('chargerClasse'); //fin Autoload
}

/**
 * does an absolute import of the stylesheet
 */
function style(){
    echo
    '
    <link rel="stylesheet" href="http://'. $_SERVER['HTTP_HOST'] .'/assets/css/main.css" />
    ';
}

/**
 * multiple absolute imports for usefull php documents
 */
function fullImport(){
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    include_once $root."/app/util/blocs.php";
    include_once $root."/app/entity/Redirect.php";
    include_once $root."/app/entity/ClientModel.php";
    include_once $root."/app/entity/Client.php";
    include_once $root."/app/entity/Model.php";
    include_once $root."/app/entity/DataBase.php";
    
}

/**
 * initialisation of an array of links for the footer
 */
function linksInit(){
    $BtLinks = array() ;
    $BtLinks['connexion']='http://'. $_SERVER['HTTP_HOST']."\app\BDD\connexion.php" ;
    $BtLinks['inscription']='http://'. $_SERVER['HTTP_HOST']."\app\BDD\inscription.php" ;

    return $BtLinks ;
}

/**
 * creates a form beacon
 * id is the number of the form,
 * data is the assoc array name=>type of data you want to have in your form,
 * the type being the string unsed by the input beacon
 */
function formulaire(int $id, array $data){
    if(!isset($_POST['form'.$id])){
        $lines = "" ;
        foreach($data as $name=>$type){
            $lines .= "<label>".$name."</label><input type=".$type." name=form".$id."[".$name."] />";
        }
    } else {
        $lines = "" ;
        foreach($data as $name=>$type){
            $lines .= "<label>".$name."</label><input type=".$type." name=form".$id."[".$name."] value='".str_replace("/", "", $_POST["form".$id][$name])."' />";
        }
    }
    
    echo '
    <form action="'.$_SERVER["PHP_SELF"].'" method="post">
        '.$lines.'
        <p></p>
        <input type="submit" name=form'.$id."[submit] value='valider' />
    </form>
    " ;
}

/**
 * this function saves the data array into a cookie
 * returns a boolean on wether the save was successfull or not
 */
function cookieSave(array $data){
    $saved = True ;
    foreach($data as $name=>$value){
        $saved = $saved && setcookie("client[".$name."]", $value, time()+3600*24*182); //expires in six months after creation
    }
    return $saved ;
}

/**
 * verifies if the given data has a valid format
 */
function verify_data($data, $type){
    $data = htmlspecialchars($data);
    switch($type){
        case("adresse"):
            return preg_match("([0-9]+( bis| ter){0,1},[0-9a-z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]+)", $data)==1;
        case("codePostal"):
            return preg_match("$[0-9]{5,5}$", $data)==1;
        case("ville"):
            return preg_match('#^([^0-9]*)$#', $data)==1;
        case("âge"):
            return $data>0 && $data<150 ;
        case("email"):
            return filter_var($data, FILTER_VALIDATE_EMAIL)!=False;
        case("nom"):
            return preg_match('#^([^0-9]*)$#', $data)==1;
        case("prénom"):
            return preg_match('#^([^0-9]*)$#', $data)==1;
        default :
            return True;
    }
}

global $PBKeys ;

/**
 * attributes a username and a password to a client
 * (also rsa keys but it doesn't work for now)
 */
function clientAttribution($data){
    //generation of username using names
    $username = $data['nom'].'.'.$data['prénom'] ;

    //generating moderately strong password
    $password = bin2hex(random_bytes(5)); //random alphanumeric characters

    $possibleChar = array(0,1,2,3,4,5,6); //avoid repetition
    $chars = array_rand ( $possibleChar , 2 );
    $place1 = random_int(0, strlen($password)-1);
    $place2 = random_int(0, strlen($password)-1);
    $randchar = substr("-_*()&$", $possibleChar[$chars[0]], 1);
    $randchar = substr("-_*()&$", $possibleChar[$chars[1]], 1);
    $password = substr($password, 0, $place1).$randchar.substr($password, $place1+1);
    $password = substr($password, 0, $place2).$randchar.substr($password, $place2+1);


    //send an email to give the password
    $msg = "Merci pour votre inscription !\n
            Voici votre identifiant et votre mot de passe vous permettant de vous connecter au site :\n
            identifiant : ".$username."\n
            mot de passe : ".$password."\n";
    
    //mail($data['email'], "Inscription Nautica", $msg);

    /*
    require '../scripts/rsa clés.html' ;
    //generate rsa public and private keys
    do {
        $keys = "<script type='text/javascript'></script>" ;
        $keys = explode(',', $keys);
        print_r($keys."<br/>");
    } while(!in_array($keys, $PBKeys));
    */


    return array("username"=>$username, "password"=>$password); //return infos in an array
}

?>