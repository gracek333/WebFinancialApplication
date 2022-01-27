<?php
	session_start();

	if((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn']==true))
	{
		header('Location:main-menu.php');
		exit();
	}

?>


<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width initial-scale=1.0" />
	<link rel="stylesheet" href="css/bootstrap.css"/>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
	<meta name="description" content="Data of logging in" />
	<meta name="keywords" content="finance, financial, application, logging, in, sign" />
	<title>Sign in</title>  
	<!--<a target="_blank" href="https://icons8.com/icon/61247/rent">Rent</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>-->
</head>

<body class="text-center d-flex flex-column min-vh-100">
	<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-money">
		<div class="container-fluid px-4">
			<a class="navbar-brand" href="#">
				<img src="img/dollar.png" alt="...">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<span class="navbar-text">Twój domowy budżet online!</span>
				<form class="ms-auto text-center">
					<a class="btn btn-md btn-warning me-2 mt-1" href="registration.php" >Zarejestruj się</a>
				</form>
			</div>
		</div>
	</nav>
  
	<main class="form-signin pb-4 mb-5">
		<form action="logging-in.php" method="post">
			<h1 class="mb-4">Logowanie</h1>
			<div class="row mb-3 pt-2">
				<label for="inputEmail" class="col-sm-5 col-form-label">Podaj adres email:</label>
				<div class="col-sm-7 mt-1">
					<input type="email" class="form-control" id="inputEmail" name="email">
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputPassword" class="col-sm-5 col-form-label">Podaj hasło:</label>
				<div class="col-sm-7 mt-1">
					<input type="password" class="form-control" id="inputPassword" name="password">
					<?php
						if (isset($_SESSION['error_log_in']))
						{
							echo '<div class="error">'.$_SESSION['error_log_in'].'</div>';
							unset($_SESSION['error_log_in']);
						}
					?>
				</div>
			</div>
			<button class="w-100 btn btn-lg" type="submit">Zaloguj się</button>
		</form>
	</main>  

	<footer class="footer mt-auto">
		<div class="container-fluid">
			<span>2021 &copy; tdbo.pl  |  Zapraszam do współpracy </span>
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
				<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
			</svg>
			<span> michalgracon@wp.pl</span>
		</div>
	</footer>
	
	<script src="https://unpkg.com/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
	<script src="js/bootstrap.js"></script>

</body>
</html>