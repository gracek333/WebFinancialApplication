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
	  <a class="navbar-brand" href="#">
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
	
  <main>
    <div class="form-signin pb-2 mb-5">
	  <h1 class="mb-4">Dodaj wydatek</h1>
	  <div class="row mb-3 pt-2 justify-content-center">
		<label for="inputExpense" class="col-sm-5 me-sm-3 col-form-label">Kwota:</label>
		<div class="col-sm-5">
		  <input type="text" class="form-control" id="inputExpense" required placeholder="np. 12,34" onfocus="this.placeholder=''" onblur="this.placeholder='np. 12,34'">
		</div>
	  </div>
	  <div class="row mb-3 justify-content-center">
		<label for="inputDate" class="col-sm-5 me-sm-3 col-form-label">Data:</label>
		<div class="col-sm-5">
		  <input type="date" class="form-control" id="inputDate">
		</div>
	  </div>
	  <div class="row mb-3 justify-content-center">
		<label for="inputPaymentMethod" class="col-sm-5 me-sm-3 col-form-label">Sposób płatności:</label>
		<div class="col-sm-5">
		  <select class="form-select" name="inputPaymentMethod" id="inputPaymentMethod">
			<option value="g">Gotówka</option>
			<option value="d">Karta debetowa</option>
			<option value="k" selected>Karta kredytowa</option>
		  </select>
		</div>
	  </div>
	  <div class="row mb-3 justify-content-center">
		<label for="inputCategoryOfExpense" class="col-sm-5 me-sm-3 col-form-label">Kategoria:</label>
		<div class="col-sm-5">
		  <select class="form-select" name="inputCategoryOfExpense" id="inputCategoryOfExpense">
			<option value="j" selected>Jedzenie</option>
			<option value="m">Mieszkanie</option>
			<option value="t">Transport</option>
			<option value="e">Telekomunikacja</option>
			<option value="o">Opieka zdrowotna</option>
			<option value="u">Ubranie</option>
			<option value="h">Higiena</option>
			<option value="d">Dzieci</option>
			<option value="r">Rozrywka</option>
			<option value="w">Wycieczka</option>
			<option value="s">Szkolenia</option>
			<option value="k">Książki</option>
			<option value="c">Oszczędności</option>
			<option value="y">Emerytura</option>
			<option value="p">Spłata długów</option>
			<option value="i">Darowizna</option>
			<option value="n">Inne wydatki</option>
		  </select>
	    </div>
	  </div>
	  <div class="row mb-3 justify-content-center">
		<label for="inputComment" class="col-sm-5 me-sm-3 col-form-label">Komentarz:</label>
		<div class="col-sm-5">
		  <input type="text" class="form-control" id="inputComment" required placeholder="opcjonalnie" onfocus="this.placeholder=''" onblur="this.placeholder='opcjonalnie'">
		</div>
	  </div>
	  <form class="ms-auto text-center mt-btn-sm">
		<button class="btn btn-md my-sm-3 me-sm-2" type="submit">Anuluj</button>
		<button class="btn btn-md my-sm-3 " type="submit">Dodaj</button>
	  </form>
	</div>
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