<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"])."/app/util/misc.php";
fullImport();

use app\entity\Redirect ;
use app\entity\ClientModel ;
use app\entity\Client ;

$R = new Redirect(basename($_SERVER['PHP_SELF']));

//saving the user data in a cookie
if(!empty($_POST)){
    $form2 = $_POST['form2']; //retrieve posted infos
    $saveResult = "" ;
    $badFormatError = "" ;
    if(isset($form2["submit"])){
        //verify all the values given by the user
        $verif = True ;
        foreach($form2 as $type=>$value){
            $verif = $verif && verify_data($value, $type);
            if(!verify_data($value, $type)){
                $badFormatError .= "<mark id='warning'>erreur: format invalide pour la valeur '".$type."'</mark><br/>" ;
            }
        }

        if($verif){

            $CM = new ClientModel();
            $attributs = clientAttribution($form2) ;

            $Clients = $CM->findAll();
            $present = False ;
            foreach($Clients as $Client){
                $present = $present || ($attributs['username']==$Client->getUsername()) ;
            }

            if(!$present){
                //sauvegarde dans la base de données
                $CM->save($attributs);

                $saved = cookieSave($form2);
                //save in a cookie named "client"
                if(!$saved){
                    $saveResult =  "<mark id='error'>erreur lors de la sauvegarde du cookie</mark>" ;
                } else {
                    //redirecting to connexion page
                    $saveResult =  'enregistrement effectué, veuillez vous connecter <a href="http://'.$_SERVER['HTTP_HOST'].'\app\BDD\connexion.php">ici</a>' ;
                }
            } else {
                $badFormatError = "<mark id='error'>erreur : ce nom est déjà enregistré</mark>" ;
            }
        }
    }
}

?>

<!DOCTYPE HTML>
<!--
	Verti by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<?=headEcho()?>
	<body class="is-preload no-sidebar">
		<div id="page-wrapper">

			<?=headerEcho($R)?>

			<!-- Main -->
				<div id="main-wrapper">
					<div class="container">
						<div id="content">

							<!-- Content -->
								<article>
                                    <h2>Inscription</h2>
                                    <?php if(empty($saveResult)):?>
                                    <p>
									    <?=formulaire(2, array("nom"=>"text", "prénom"=>"text", "âge"=>"number", "adresse"=>"text", "codePostal"=>"text", "ville"=>"text", "email"=>"text"))?>
                                    </p>
                                    <p><?php echo $badFormatError ?></p>
                                    <?php else :?>
                                    <p>
                                        <?php echo $saveResult?>
                                    </p>
                                    <?php endif ;?>
                                    
								</article>
						</div>
					</div>
				</div>

			<!--foot (links+contacts)-->
			<?=footerEcho()?>
			</div>

		<!-- Scripts -->

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>