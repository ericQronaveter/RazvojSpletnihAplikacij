
<!DOCTYPE html>
<head>
	<title>Vaja 2</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-primary text-uppercase bg-gradient">
		<div class="container">
			<a class="navbar-brand text-white text-uppercase" href="index.php"><h1>Oglasnik - admin</h1></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="/RazvojSpletnihAplikacij/index.php">Domov</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="/RazvojSpletnihAplikacij/publish.php">Objavi oglas</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link text-white fw-bold" href="/RazvojSpletnihAplikacij/admin/index.php">Administracija</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="/RazvojSpletnihAplikacij/myads.php">Moji oglasi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white fw-bold" href="/RazvojSpletnihAplikacij/logout.php">Odjava</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- tukaj se bo vključevala koda pogledov, ki jih bodo nalagali kontrolerji -->
    <!-- klic akcije iz routes bo na tem mestu zgeneriral html kodo, ki bo zalepnjena v našo predlogo -->
    <?php require_once('routes.php'); ?> 
    </body>
</html>