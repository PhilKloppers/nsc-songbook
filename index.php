<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<title>NSC Songbook</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
	<!-- Google Fonts Roboto -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
	<!-- MDB -->
	<link rel="stylesheet" href="css/mdb.min.css" />
	<!-- Custom styles -->
	<link rel="stylesheet" href="css/style.css" />
</head>

<body>
	<header>
		<nav class="navbar navbar-dark bg-primary">
			<div class="container-fluid justify-content-center">
				<span class="navbar-brand mb-0 h1">NSC Songbook</span>
			</div>
		</nav>
	</header>
	<!--Main layout-->
	<main class="my-3"">
		<div class="container">
		<!--Section: Content-->
			<div class="accordion" id="accordionExample">
<?php
	$configFile = __DIR__ . '/config/active-songs.json';
	$directory = 'songs-library';
	if (file_exists($configFile)) {
		$activeSongs = json_decode(file_get_contents($configFile), true);
		if (is_array($activeSongs)) {
			foreach ($activeSongs as $file) {
				$path = $directory . '/' . $file;
				if (file_exists($path)) {
					include($path);
				}
			}
		}
	} else {
		// Fallback: scan songs-active directory (legacy behaviour)
		$directory = 'songs-active';
		$filelist = array_diff(scandir($directory), array('..', '.'));
		foreach ($filelist as $file) include_once($directory . '/' . $file);
	}
?>
			</div>
		</div>
	</main>
	<!--Main layout-->

	<!--Footer-->
	<footer class="bg-light text-lg-start">
		<hr class="m-0" />
		<!-- Downloadable copy -->
		<div class="text-center py-4 align-items-center">
			<a href="SonriseService.pdf" target="_blank"><strong>Download a printable PDF of this songbook</strong></a>
		</div>
		<!--Downloadable copy-->

		<div class="text-center py-4 align-items-center">
			<p>Follow NSC on social media</p>
			<a href="https://www.youtube.com/nscmarburg" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
				<i class="fab fa-youtube"></i>
			</a>
			<a href="https://www.facebook.com/nscmarburg" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
				<i class="fab fa-facebook-f"></i>
			</a>
		</div>

		<!-- Copyright -->
		<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
			© 2025 Copyright:
			<a class="text-dark" href="https://www.nsc.za.org/">Norwegian Settlers Church</a>
		</div>
		<!-- Copyright -->
	</footer>
	<!--Footer-->
	<!-- MDB -->
	<script type="text/javascript" src="js/mdb.min.js"></script>
	<!-- Custom scripts -->
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>