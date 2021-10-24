<?php

  session_start();

  if(isset($_POST['repeatedEmail'])) //klikniecie submit spowoduje ze zostanie utworzona zmienna email1
  {
	  
	//udana walidacja
	$wszystko_OK = true;
	
	//sprawdz poprawnosc name'a
	$username = $_POST['name'];
	
	//sprawdzenie dlugosci name'a
	if ((strlen($username)<3) || (strlen($username)>50))
	{
	  $wszystko_OK = false;
	  $_SESSION['e_username'] = "Imię musi posiadać od 3 do 50 znaków!";
	}
	
	//sprawdzenie skladu name'a

	/*if (ctype_alnum($username)==false)
	{
	  $wszystko_OK = false;
	  $_SESSION['e_username'] = "Imię może składać się tylko z liter i cyfr (bez polskich znaków)";
	}*/
	
	//sprawdzenie poprawnosci adresu email

	$email = $_POST['email'];
	$repeatedEmail = $_POST['repeatedEmail'];
	$safetyEmail = filter_var($email,FILTER_SANITIZE_EMAIL);
	
	if ($email != $repeatedEmail)
	{
	  $wszystko_OK = false;
	  $_SESSION['e_email'] = "Podane adresy są różne!";
	}
	else if ((filter_var($safetyEmail, FILTER_VALIDATE_EMAIL) == false) || ($safetyEmail != $email))
	{
	  $wszystko_OK = false;
	  $_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
	}
	
	//sprawdzenie poprawnosci hasla
	$password = $_POST['password'];
	$repeatedPassword = $_POST['repeatedPassword'];
	
	if ((strlen($password)<8) || (strlen($password)>50))
	{
	  $wszystko_OK = false;
	  $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 50 znaków!";
	}
	else if ($password != $repeatedPassword)
	{
	  $wszystko_OK = false;
	  $_SESSION['e_password'] = "Podane hasła są różne!";
	}
	
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	
	//sprawdzenie captchy
	$secretKey = "6LdAWRMcAAAAADatY2U5nG2wNVVuAaQFJPz4Hbcg";
	
	$checkCaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
	
	$response = json_decode($checkCaptcha);
	
	if($response->success == false)
	{
	  $wszystko_OK = false;
	  $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
	}
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			//Czy email juz istnieje?
			$result = $connection->query("SELECT id FROM users WHERE email='$email'");
			
			if (!$result) throw new Exception($connection->error);
			
			$how_many_emails = $result->num_rows;
			
			if ($how_many_emails>0)
			{
				$wszystko_OK = false;
				$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email";
			}
			
			if ($wszystko_OK == true)
			{
			  //wszystkie testy zaliczone! dodajemy gracza do bazy
			  if ($connection->query("INSERT INTO users VALUES (NULL, '$username', '$hashedPassword', '$email')"))
			  {
				  
				  if ($result2 = $connection->query("SELECT * FROM users WHERE email='$email'"))
				  {
					  $row = $result2->fetch_assoc();
					  $userId = $row['id'];
				
					  $connection->query("INSERT INTO expenses_category_assigned_to_users (id, user_id, name) SELECT NULL, '$userId', expenses_category_default.name FROM expenses_category_default");
				  }
				  
				  
				  $_SESSION['registrationSucceeded'] = true;
				  header('Location: welcome.php'); 
			  }
			  else
			  {
				  throw new Exception($connection->error);
			  }
			}
	
			$connection->close();
		}
	}
	catch(Exception $serverError)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		echo '<br/>Informacja developerska: '.$serverError;
	}
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
  <script src='https://www.google.com/recaptcha/api.js'></script>
  
  <meta name="description" content="Data of registration" />
  <meta name="keywords" content="finance, financial, application, registration" />
  <title>Registration</title>  
  
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
		<span class="navbar-text">
		  Twój domowy budżet online!
		</span>
		<form class="ms-auto text-center">
		  <a class="btn btn-md btn-primary me-2 mt-1" href="log-in.php">Zaloguj się</a>
		</form>
	  </div>
	</div>
  </nav>

  <main class="form-signin pb-4 mb-5">
    <form method="post">
	  <h1 class="mb-4">Formularz rejestracyjny</h1>
	  <div class="row mb-3 pt-2">
		<label for="inputName" class="col-sm-5 col-form-label">Podaj imię:</label>
		<div class="col-sm-7">
		  <input type="text" class="form-control" id="inputName" name="name">
		  <?php
		    if (isset($_SESSION['e_username']))
			{
			  echo '<div class="error">'.$_SESSION['e_username'].'</div>';
			  unset($_SESSION['e_username']);
			}
		  ?>
		</div>
		 
	  </div>
	  <div class="row mb-3">
		<label for="inputEmail" class="col-sm-5 col-form-label">Podaj adres email:</label>
		<div class="col-sm-7">
		  <input type="email" class="form-control" id="inputEmail" name="email">
		  <?php
		    if (isset($_SESSION['e_email']))
			{
			  echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			  unset($_SESSION['e_email']);
			}
		  ?>
		</div>
	  </div>
	  <div class="row mb-3">
	    <label for="repeatEmail" class="col-sm-5 col-form-label">Powtórz adres email:</label>
		<div class="col-sm-7">
		  <input type="email" class="form-control" id="repeatEmail" name="repeatedEmail">
		</div>
	  </div>
	  <div class="row mb-3">
		<label for="inputPassword" class="col-sm-5 col-form-label">Podaj hasło:</label>
		<div class="col-sm-7">
		  <input type="password" class="form-control" id="inputPassword" name="password">
		  <?php
		    if (isset($_SESSION['e_password']))
			{
			  echo '<div class="error">'.$_SESSION['e_password'].'</div>';
			  unset($_SESSION['e_password']);
			}
		  ?>
		</div>
	  </div>
	  <div class="row mb-4">
		<label for="repeatPassword" class="col-sm-5 col-form-label">Powtórz hasło:</label>
		<div class="col-sm-7">
		  <input type="password" class="form-control" id="repeatPassword" name="repeatedPassword">
		</div>
	  </div>
	  
	  <div class="row empty-row mb-3">
	    
	  </div>
	  <div class="row mb-3">
	    <div class="d-flex justify-content-center g-recaptcha" data-sitekey="6LdAWRMcAAAAADx2WWHVI1SQYzag0vn4XKRk5qOa">
		</div>
		<?php
		    if (isset($_SESSION['e_bot']))
			{
			  echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
			  unset($_SESSION['e_bot']);
			}
		  ?>
	  </div>
	  
	  <button class="w-100 btn btn-lg" type="submit">Zarejestruj się</button>
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