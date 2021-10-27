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
  
  <meta name="description" content="Show balance" />
  <meta name="keywords" content="finance, financial, application, show, balance" />
  <title>Show balance</title>  
  
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="pieChart.js"></script>

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
			<a class="nav-link" href="add-expense.php">Dodaj wydatek</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link active" href="show-balance.php">Przeglądaj bilans</a>
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
	
  <main class="container-fluid">
    <div class="container-of-balance">
      <div class="row">
	    <div class="col-sm-8 me-3  mt-2">
	      <h1 class="pb-4">Przeglądaj bilans</h1>
		</div>
	    <div class="col-sm-2">
	      <div class="dropdown">
		    <button class="dropbtn">Wybierz okres</button>  			  
		    <div class="dropdown-content">
		      <a href="#">bieżący miesiąc</a>
			  <a href="#">poprzedni miesiąc</a>
			  <a href="#">bieżący rok</a>
			  <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">niestandardowy</a>
			</div>
		  </div> 
		</div>
	  </div>
	  
	  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog" role="document">
		  <div class="modal-content">
		    <div class="modal-header ">
		      <h2 class="modal-title justify-content-center" id="exampleModalLabel">Wyznacz okres</h2>
			  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <form>
			    <div class="row mb-3 justify-content-center">
		          <label for="inputDateFrom" class="col-sm-5 me-sm-3 col-form-label">Od:</label>
		          <div class="col-sm-5">
		            <input type="date" class="form-control" id="inputDateFrom">
		          </div>
	            </div>
	            <div class="row mb-3 justify-content-center">
		          <label for="inputDateTo" class="col-sm-5 me-sm-3 col-form-label">Do:</label>
		          <div class="col-sm-5">
		            <input type="date" class="form-control" id="inputDateTo">
		          </div>
	            </div>
	          </form>
	        </div>
		    <div class="modal-footer justify-content-center">
		      <button type="button" class="btn btn-md me-sm-3" data-bs-dismiss="modal">Zamknij</button>
			  <button type="button" class="btn btn-md">Zapisz</button>
	        </div>
		  </div>
	    </div>
	  </div>
	  
	  <h3 class="h3First h3ColorForIncomes pb-3">Przychody</h3>
	  <table class="table table-sm incomes">
	    <thead>
	      <tr>
		    <th>Kategoria przychodu</th> <th>Przychód [zł]</th> 
		  </tr>
	    </thead>
		<tbody>
	      <tr>
		    <th>Wynagrodzenia</th> <td>1000,35</td> 
		  </tr>
		  <tr>
		    <th>Odsetki bankowe</th> <td>1500,65</td> 
		  </tr>
		  <tr>
		    <th>Sprzedaż na allegro</th> <td>102,48</td>
		  </tr>
		  <tr>
		    <th>Inne</th> <td>955,36</td> 
		  </tr>
		</tbody>
		<tfoot>
		  <tr>
		    <th class="table-dark">Suma</th> <td class="table-dark">3558,84</td> 
		  </tr>
		</tfoot>
	  </table>
	  
	  <h3 class="h3ColorForExpenses pb-3">Wydatki</h3>
	  <table class="table table-sm expenses">
	    <thead>
	  	  <tr>
		    <th>Kategoria wydatku</th> <th>Wydatek [zł]</th> 
		  </tr>
		</thead>
	    <tbody>
	      <tr>
		    <th>Jedzenie</th> <td>1000,35</td> 
		  </tr>
		  <tr>
		    <th>Mieszkanie</th> <td>1500,65</td> 
		  </tr>
		  <tr>
		   <th>Transport</th> <td>102,48</td>
		  </tr>
		  <tr>
		   <th>Telekomunikacja</th> <td>100,59</td> 
		  </tr>
		  <tr>
		   <th>Opieka zdrowotna</th> <td>0,00</td> 
		  </tr>
		  <tr>
		   <th>Ubranie</th> <td>0,00</td> 
		  </tr>
		  <tr>
		   <th>Higiena</th> <td>50,00</td>
		  </tr>
		  <tr>
		   <th>Dzieci</th> <td>200,00</td> 
		  </tr>
		  <tr>
		   <th>Rozrywka</th> <td>100,00</td> 
		  </tr>
		  <tr>
		   <th>Wycieczka</th> <td>0,00</td> 
		  </tr>
		  <tr>
		   <th>Szkolenia</th> <td>0,00</td>
		  </tr>
		  <tr>
		   <th>Książki</th> <td>100,00</td> 
		  </tr>
		  <tr>
		   <th>Oszczędności</th> <td>200,00</td> 
		  </tr>
		  <tr>
		   <th>Na emeryturę</th> <td>0,00</td> 
		  </tr>
		  <tr>
		   <th>Spłata długów</th> <td>0,00</td>
		  </tr>
		  <tr>
		   <th>Darowizna</th> <td>0,00</td> 
		  </tr>
		  <tr>
		   <th>Inne</th> <td>0,00</td> 
		  </tr>
		  <tr>
		   <th class="table-dark">Suma</th> <td class="table-dark">3354,07</td> 
		  </tr>
		</tbody>
	  </table>
	  
	  <h3 class="h3Color pb-3">Bilans</h3>
	  <table class="table table-dark">
	    <thead>
	      <tr>
		    <th class="table-dark">Bilans [zł]</th> <td class="table-dark">204,77</td>
		  </tr>
		</thead>
	  </table>
	  <div class="row">
	    <label class="pb-3">Gratulacje. Świetnie zarządzasz finansami!</label>
	  </div>
	  
	  <h3 class="h3ColorForExpenses pb-3">Diagram kołowy wydatków</h3>
	  <div class="row">
	    <div class="col">
	      <div id="piechart"></div>
		</div>
	  </div>
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