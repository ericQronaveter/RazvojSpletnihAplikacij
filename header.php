<?php
	session_start();
	
	//Seja poteče po 30 minutah - avtomatsko odjavi neaktivnega uporabnika
	if(isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800){
		session_regenerate_id(true);
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	
	//Poveži se z bazo
	$conn = new mysqli('localhost', 'root', '', 'vaja1');
	//Nastavi kodiranje znakov, ki se uporablja pri komunikaciji z bazo
	$conn->set_charset("UTF8");
?>
<html>
<head>
	<title>Vaja 1</title>
	<style>
		.bg-custom-blue {
  			background-color: #3AAFA9;
		}
		html,
		body {
		margin: 0;
		padding: 0;
		height: 100%;
		}
		footer {
			margin-top: 25%;
		}
	</style>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-primary text-uppercase bg-gradient">
		<div class="container">
			<a class="navbar-brand text-white text-uppercase" href="index.php"><h1>Oglasnik</h1></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="index.php">Domov</a>
					</li>
					<?php
					if(isset($_SESSION["USER_ID"])) {
					?>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="publish.php">Objavi oglas</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="myads.php">Moji oglasi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="logout.php">Odjava</a>
					</li>
					<?php
					} else {
					?>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="login.php">Prijava</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="register.php">Registracija</a>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container mb-5">
  	<div class="row justify-content-center mb-5">