<?php


require_once realpath($_SERVER["DOCUMENT_ROOT"])."/app/util/misc.php";
fullImport();

use app\entity\Redirect ;
$R = new Redirect(basename($_SERVER['PHP_SELF']));

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

									<h2>Connexion</h2>
									<?=formulaire(1, array("identifiant"=>"text", "mot de passe"=>"text"))?>

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