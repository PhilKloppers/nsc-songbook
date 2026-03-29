<?php require_once __DIR__ . '/includes/song-renderer.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
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
	<script>(function(){var t=localStorage.getItem('nsc-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>
</head>

<body>
	<header>
		<nav class="navbar navbar-dark">
			<div class="container-fluid">
				<div style="position:relative;">
					<button class="btn btn-link text-white p-2" id="menuBtn" aria-label="Menu">
						<i class="fas fa-bars fa-lg"></i>
					</button>
					<div class="theme-dropdown" id="menuDropdown">
						<div class="menu-item">
							<span><i class="fas fa-moon"></i> Dark Mode</span>
							<div class="form-check form-switch mb-0">
								<input class="form-check-input" type="checkbox" id="themeSwitch" checked>
							</div>
						</div>
					</div>
				</div>
				<span class="navbar-brand mb-0 h1">NSC Songbook</span>
				<span style="width:40px;"></span>
			</div>
		</nav>
	</header>

	<!--Main layout-->
	<main class="my-3">
		<div class="container">
		<!--Section: Content-->
			<div class="accordion" id="accordionExample">
<?php
	$configFile = __DIR__ . '/config/active-songs.json';
	$directory = __DIR__ . '/songs-library';
	if (file_exists($configFile)) {
		$activeSongs = json_decode(file_get_contents($configFile), true);
		if (is_array($activeSongs)) {
			foreach ($activeSongs as $file) {
				$path = $directory . '/' . $file;
				if (file_exists($path)) {
					renderSong($path);
				}
			}
		}
	}
?>
			</div>
		</div>
	</main>
	<!--Main layout-->

	<!-- Font size controls -->
	<div class="font-controls">
		<button onclick="changeFontSize(1)" aria-label="Increase font size" title="Larger text">A+</button>
		<button onclick="changeFontSize(-1)" aria-label="Decrease font size" title="Smaller text">A&minus;</button>
	</div>

	<!--Footer-->
	<footer>
		<hr class="m-0" />
		<div class="text-center py-4 align-items-center">
			<a href="SonriseService.pdf" target="_blank"><strong>Download a printable PDF of this songbook</strong></a>
		</div>

		<div class="text-center py-4 align-items-center">
			<p>Follow NSC on social media</p>
			<a href="https://www.youtube.com/nscmarburg" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
				<i class="fab fa-youtube"></i>
			</a>
			<a href="https://www.facebook.com/nscmarburg" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
				<i class="fab fa-facebook-f"></i>
			</a>
		</div>

		<div class="text-center p-3" style="background-color: rgba(0,0,0,0.2);">
			&copy; 2025 Copyright:
			<a href="https://www.nsc.za.org/">Norwegian Settlers Church</a>
		</div>
	</footer>
	<!--Footer-->

	<!-- MDB -->
	<script type="text/javascript" src="js/mdb.min.js"></script>
	<!-- Custom scripts -->
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
