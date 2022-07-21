<?php

include_once "misc.php" ;

/**
 * echo the head beacon with absolute path to avoid errors
 */
function headEcho(){
    return '
    <head>
        <title>'.str_replace( ".php" , "" , basename($_SERVER["PHP_SELF"])).'</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        '.style().'
    </head>';
}

/**
 * construction of the nav beacon with absolute paths
 */
function menu($r){
    $list = "" ;
    foreach($r->getDEST() as $name=>$link){
        if($name!="0"){
            $name = str_replace ( ".php" , "" , $name);
            if($r->getSrc()==$link){
                $list .= "<li class='current'><a href=".$link.">".$name."</a></li>" ;
            } else {
                $list .= "<li><a href=".$link.">".$name."</a></li>" ;
            }
        }
    }
    return '
    <nav id="nav">
    <ul>
        '.$list.'
    </ul>
    </nav>' ;
}

/**
 * constructor of the top of the page with absolute paths
 */
function headerEcho($r){
    echo 
    '
    <!-- Header -->
    <div id="header-wrapper">
        <header id="header" class="container">

            <!-- Logo -->
            <div id="logo">
                <h1><a href="index.php">Nautica</a></h1>
                <span>by Julien Crambes</span>
            </div>

            <!-- Nav -->
            '.menu($r).'
        </header>
    </div>
    '
    ;
}

/**
 * use the BtLinks array created in misc.php to create the "links" section in the footer
 */
function links(){
    $BtLinks = linksInit();
    $list = "" ;
    foreach($BtLinks as $name=>$link){
        $list .= '<li><a href='.$link.'>'.$name.'</a></li>';
    }

    return '
    <div class="col-3 col-6-medium col-12-small">
    <!-- Links -->
        <section class="widget links">
            <h3>Liens utiles</h3>
            <ul class="style2">
                '.$list.'
            </ul>
        </section>
    </div>' ;
}

/**
 * creates the "contacts" section of the footer
 */
function contacts(){
    return 
    '<div class="col-3 col-6-medium col-12-small">
        <!-- Contact -->
        <section class="widget contact last">
            <h3>Contactez nous</h3>
            <ul>
                <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
            </ul>
            <p>783 avenue de Losa,<br />40460, Landes,<br />Sanguinet, France</p>
        </section>
    </div>';
}

/**
 * empty column used to center the infos in the footer
 */
function emptyCol(){
    return 
    '
    <div class="col-3 col-6-medium col-12-small">
        <!-- Contact -->
        <section class="widget contact last">
        </section>
    </div>
    ';
}

/**
 * echo of the footer
 * has a copyright claim for the author of the open source page design.
 */
function footerEcho(){
    echo
    '
    <!-- Footer -->
    <div id="footer-wrapper">
        <footer id="footer" class="container">
            <div class="row">'
                .emptyCol()
                .links()
                .contacts()
                .emptyCol().'
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="copyright">
                        <ul class="menu">
                            <li>&copy; Nautica compagny. All rights reserved</li>
                            <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    ';
}

?>