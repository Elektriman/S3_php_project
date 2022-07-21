<?php

namespace app\entity ;

class Redirect {
    private string $src ;
    private static array $DEST = array("index.php") ;

    /**
     * constructor
     */
    function __construct($src){
        $this->src = $src ;

        //auto adds all pages to the menu of possible browsable pages
        $scan = scandir($_SERVER['DOCUMENT_ROOT'].'/app/pages');
        foreach($scan as $file) {
                $this->addtoDEST("index.php", "index");
            if (!is_dir("myFolder/$file") && $file!="." && $file!="..") {
                $this->addToDEST("app/pages/".$file, $file);
        }
}
    }

    /**
     * adding links to the destinations possibles
     */
    function addToDEST($link, $filename){
        $this::$DEST[$filename] = "http://".$_SERVER['HTTP_HOST'] . "/" . $link ;
    }

    function getDEST(){
        return $this::$DEST ;
    }

    /**
     * redirects to the given link.
     * the link must be in the list.
     * returns a success boolean
     */
    function gotolink($dest){
        if(in_array($dest, $this::$DEST)){
            header($dest);
            exit ;
            return true ;
        } else {
            return false ;
        }
    }

    /**
     * source setter and getter
     */
    function setSrc($link){
        $this->src = $link ;
    }

    function getSrc(){
        return $this->src ;
    }

    /**
     * redirects to index page
     */
    function home(){
        header($_SERVER['DOCUMENT_ROOT']);
        exit ;
    }

    function autoverifier($get){
        if(isset($get['check'])){
            return true ;
        } else {
            $this->gotolink($this->getSrc());
        }
    }
}

?>