<?php
	session_start();

    if(!isset($_SESSION['loggedIn']))
    {
		header('Location:log-in.php');
		exit();
    }
	
	$min = new DateTime("first day of last month");
    $max = new DateTime("last day of this month");
	
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
			$userId = $_SESSION['id'];
			$sql = "SELECT * FROM expenses_category_assigned_to_users WHERE expenses_category_assigned_to_users.user_id='$userId'";
			$categories_of_expenses = mysqli_query($connection, $sql);
			$sql2 = "SELECT * FROM payment_methods_assigned_to_users WHERE payment_methods_assigned_to_users.user_id='$userId'";
			$payment_methods = mysqli_query($connection, $sql2);
			
			if(isset($_POST['inputExpense']))
			{
				$dataIsCorrect = true;
				
				$amountInString = $_POST['inputExpense'];
				$amountWithDot = str_replace(',', '.', $amountInString);
				if (!(is_numeric($amountWithDot)))
				{
					$dataIsCorrect = false;  
					$_SESSION['e_amount'] = "Niewłaściwy format kwoty!";
				}
				else
				{
					$amountOfExpense = number_format($amountWithDot, 2, '.', '');
				}
				
				$enteredDate = $_POST['inputDate'];
				$selectedCategory = $_POST['inputCategoryOfExpense'];
				$selectedPaymentMethod = $_POST['inputPaymentMethod'];
				$enteredComment = $_POST['inputComment'];
				
				if ($dataIsCorrect == true)
				{
					if ($connection->query("INSERT INTO expenses VALUES (NULL, '$userId', '$selectedCategory', '$selectedPaymentMethod', '$amountOfExpense', '$enteredDate', '$enteredComment')"))
					{
						$_SESSION['added_expense'] = "Dodano wydatek!";
					}
					else
					{
					  throw new Exception($connection->error);
					}
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
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o dodanie przychodu w innym terminie!</span>';
		echo '<br/>Informacja developerska: '.$serverError;
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
  
    <meta name="description" content="Add expense" />
    <meta name="keywords" content="finance, financial, application, add, expense" />
    <title>Add expense</title>  
  
    <!--<a target="_blank" href="https://icons8.com/icon/61247/rent">Rent</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>-->
</head>

<body class="text-center d-flex flex-column min-vh-100">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-money">
	    <div class="container-fluid px-4">
			<a class="navbar-brand" href="main-menu.php">
				<img src="img/dollar.png" alt="...">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-sm-0 px-10 mt-1">
				<li class="nav-item">
					<a class="nav-link" href="add-income.php">Dodaj przychód</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="add-expense.php">Dodaj wydatek</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="show-balance.php">Przeglądaj bilans</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Ustawienia</a>
				</li>
			</ul>
			<form class="ms-auto text-center">
				<a class="btn btn-md btn-danger me-2 mt-1" href="logging-out.php">Wyloguj się</a>
			</form>
			</div>
		</div>
	</nav>
	
	<main class="form-signin pb-2 mb-5">
		<form method="post">
			<h1 class="mb-1">Dodaj wydatek</h1>
			<div class="row mb-3 pt-3 justify-content-center">
				<?php
					if (isset($_SESSION['added_expense']))
					{
					    echo '<div class="addedTransaction">'.$_SESSION['added_expense'].'</div>';
					    unset($_SESSION['added_expense']);
					}
			    ?>
				<label for="inputExpense" class="col-sm-5 me-sm-3 col-form-label">Kwota:</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" name="inputExpense" id="inputExpense" required placeholder="np. 1234,56" onfocus="this.placeholder=''" onblur="this.placeholder='np. 1234,56'">
						<?php
							if (isset($_SESSION['e_amount']))
							{
							    echo '<div class="error">'.$_SESSION['e_amount'].'</div>';
							    unset($_SESSION['e_amount']);
							}
						?>
				</div>
			</div>
			<div class="row mb-3 justify-content-center">
				<label for="inputDate" class="col-sm-5 me-sm-3 col-form-label">Data:</label>
				<div class="col-sm-5">
					<input type="date" class="form-control" value="<?php print(date("Y-m-d")); ?>" min=<?=$min->format("Y-m-d")?> max=<?=$max->format("Y-m-d")?> name="inputDate" id="date" required>
				</div>
			</div>
			<div class="row mb-3 justify-content-center">
				<label for="inputPaymentMethod" class="col-sm-5 me-sm-3 col-form-label">Sposób płatności:</label>
				<div class="col-sm-5">
					<select class="form-select" name="inputPaymentMethod" id="inputPaymentMethod">
						<?php 
							while ($temporary_methods = mysqli_fetch_array($payment_methods,MYSQLI_ASSOC)):; 
						?>
						<option value="<?php echo $temporary_methods["id"];?>">
							<?php echo $temporary_methods["name"];?>
						</option>
						<?php 
							endwhile; 
						?>
					</select>
				</div>
			</div>
			<div class="row mb-3 justify-content-center">
				<label for="inputCategoryOfExpense" class="col-sm-5 me-sm-3 col-form-label">Kategoria:</label>
				<div class="col-sm-5">
					<select class="form-select" name="inputCategoryOfExpense" id="inputCategoryOfExpense">
						<?php 
							while ($temporary_categories = mysqli_fetch_array($categories_of_expenses,MYSQLI_ASSOC)):; 
						?>
						<option value="<?php echo $temporary_categories["id"];?>">
							<?php echo $temporary_categories["name"];?>
						</option>
						<?php 
							endwhile; 
						?>
					</select>
				</div>
			</div>
			<div class="row mb-3 justify-content-center">
				<label for="inputComment" class="col-sm-5 me-sm-3 col-form-label">Komentarz:</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" name="inputComment" placeholder="opcjonalnie" onfocus="this.placeholder=''" onblur="this.placeholder='opcjonalnie'">
				</div>
			</div>
			<form class="ms-auto text-center mt-btn-sm">
				<a class="btn btn-md my-sm-3 me-sm-2 likeButton" href="main-menu.php">Anuluj</a>
				<button class="btn btn-md btn-primary my-sm-3 " type="submit">Dodaj</button>
			</form>
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