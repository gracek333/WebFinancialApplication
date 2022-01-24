<?php

  session_start();

  if(!isset($_SESSION['loggedIn']))
  {
	header('Location:log-in.php');
	exit();
  }
	
	//biezacyMiesiac
	$firstDayOfThisMonth = new DateTime("first day of this month");
	$lastDayOfThisMonth = new DateTime("last day of this month");
	
	//poprzedniMiesiac
	$firstDayOfLastMonth = new DateTime("first day of last month");
	$lastDayOfLastMonth = new DateTime("last day of last month");
	
	//biezacyRok
	$firstDayOfThisYear = new DateTime("now");
	$firstDayOfThisYear->setDate($firstDayOfThisYear->format('Y'), 1, 1);
	$lastDayOfThisMonth = new DateTime("last day of this month");
	
	$minInString =  date_format($firstDayOfThisMonth, 'Y-m-d');
	$maxInString =  date_format($lastDayOfThisMonth, 'Y-m-d');
	
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
			
			if(isset($_POST['peer']))
			{
				
				$selectedPeriod = $_POST['peer'];
				
				if($selectedPeriod == 'bieżący miesiąc')
				{
					$minInString =  date_format($firstDayOfThisMonth, 'Y-m-d');
					$maxInString =  date_format($lastDayOfThisMonth, 'Y-m-d');
				}
				else if($selectedPeriod == 'poprzedni miesiąc')
				{
					$minInString =  date_format($firstDayOfLastMonth, 'Y-m-d');
					$maxInString =  date_format($lastDayOfLastMonth, 'Y-m-d');
				}
				else if($selectedPeriod == 'bieżący rok')
				{
					$minInString =  date_format($firstDayOfThisYear, 'Y-m-d');
					$maxInString =  date_format($lastDayOfThisMonth, 'Y-m-d');
				}
				else
				{
					if(isset($_POST['inputDateFrom']))
					{
						$firstEnteredDate =  date_format((date_create_from_format('Y-m-d', $_POST['inputDateFrom'])), 'Y-m-d');
						$secondEnteredDate =  date_format((date_create_from_format('Y-m-d', $_POST['inputDateTo'])), 'Y-m-d');
						
						if ($firstEnteredDate < $secondEnteredDate)
						{
							$minInString = $firstEnteredDate;
							$maxInString = $secondEnteredDate;
						}
						else
						{
							$minInString = $secondEnteredDate;
							$maxInString = $firstEnteredDate;
						}	
						
					}
				}
			}

			
			$userId = $_SESSION['id'];
			
			$sql = "SELECT ecatu.name, SUM(expenses.amount) AS suma_wydatkow FROM expenses INNER JOIN expenses_category_assigned_to_users ecatu ON ecatu.id=expenses.expense_category_assigned_to_user_id WHERE expenses.user_id='$userId' AND expenses.date_of_expense BETWEEN '$minInString' AND '$maxInString' GROUP BY ecatu.name ORDER BY suma_wydatkow DESC";
			
			$result = mysqli_query($connection, $sql);
			
			
			$sql2 = "SELECT icatu.name, SUM(incomes.amount) AS suma_przychodow FROM incomes INNER JOIN incomes_category_assigned_to_users icatu ON icatu.id=incomes.income_category_assigned_to_user_id WHERE incomes.user_id='$userId' AND incomes.date_of_income BETWEEN '$minInString' AND '$maxInString'GROUP BY icatu.name ORDER BY suma_przychodow DESC ";
			
			$result2 = mysqli_query($connection, $sql2);
			
			
			$sql3 = "SELECT ecatu.name, SUM(expenses.amount) AS suma_wydatkow FROM expenses INNER JOIN expenses_category_assigned_to_users ecatu ON ecatu.id=expenses.expense_category_assigned_to_user_id WHERE expenses.user_id='$userId' AND expenses.date_of_expense BETWEEN '$minInString' AND '$maxInString' GROUP BY ecatu.name ORDER BY suma_wydatkow DESC";
			
			$result3 = mysqli_query($connection, $sql3);
				
			
			$connection->close(); 
		}
	}
	catch(Exception $serverError)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o dodanie przychodu w innym terminie!</span>';
		echo '<br/>Informacja developerska: '.$serverError;
	}
	

?>

<html lang="pl">

<head runat="server>
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
  <!--<script src="pieChart.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <script type="text/javascript">
  
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
	  var data = google.visualization.arrayToDataTable([
	  ['Kategoria wydatków', 'Wydatki [zł]'],
	  <?php
		
			while($row = $result3->fetch_assoc())
			{
				echo "['".$row['name']."',".$row['suma_wydatkow']."],";
			}
  
	  ?>
	]);
	
	var w = window.innerWidth
	var f = 0
	
	if (w > 360)
	{
		f = 12
	}
	else
	{
		f = 8.5
	}
	
	  var options = {
		  'width': 'auto', 
		  'height': 400,
		  chartArea:{top:50,width:'100%',height:'75%'},
		  legend:{position:'top',alignment:'center',maxLines:10,textStyle:{fontSize:f}}
		  
		  };

	  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
	  chart.draw(data, options);
	}
  </script>
  <script>
        $(function () {
            $("#type").on("change", function () {
				
				localStorage.setItem('selectedtem', document.getElementById("_activity").value);
				
                var type = $('#type').find("option:selected").val();
                if (type.toUpperCase() == 'NIESTANDARDOWY') {
                    $("#Div1").modal("show");
                } 
				if (localStorage.getItem('item')) {
					document.getElementById("selectedtem").options[localStorage.getItem('selectedtem')].selected = true;
				}​
				
            });
            $('[id*=btnClosePopup]').click('on', function () {
                $("#MyPopup").modal("hide");
            });
            $('[id*=Button1]').click('on', function () {
                $("#Div1").modal("hide");
            });
        });
    </script>
	
	<script>
		function change(){
			
			localStorage.setItem('selectedItem', document.getElementById("myform").value);
			 var type = $('#myform').find("option:selected").val();
                if (type.toUpperCase() == 'NIESTANDARDOWY') {
                    $("#Div1").modal("show");
                }
				else
				{
					document.getElementById("myform").submit();
				}
		}
	</script>
	
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
		  <a class="btn btn-md btn-danger me-2 mt-3" href="logging-out.php">Wyloguj się</a>
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
		  <form id="myform" method="post">
			<label class="select" for="type">
			<select id="peer" name="peer" class="select" required="required" onchange="change()" id="_activity">
			
					<option value="" disabled="disabled" selected="selected"><?php
			
						if(isset($_POST['peer']))
						{
							
							$peer = $_POST['peer'];
							
							unset($_POST['peer']);
							echo $peer;
						}
						else 
						{
							echo "Wybierz okres";
						}

					
	        ?></option>
					<option>bieżący miesiąc</option>
					<option>poprzedni miesiąc</option>
					<option>bieżący rok</option>
					<option>niestandardowy</option>
			</select>
			</label>
			
			<div id="Div1" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			
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
							<input type="date" class="form-control" id="inputDateFrom" name="inputDateFrom" required>
						  </div>
						</div>
						<div class="row mb-3 justify-content-center">
						  <label for="inputDateTo" class="col-sm-5 me-sm-3 col-form-label">Do:</label>
						  <div class="col-sm-5">
							<input type="date" class="form-control" id="inputDateTo" name="inputDateTo" required>
						  </div>
						</div>
					  </form>
					</div>
					<div class="modal-footer justify-content-center">
					  <button type="button" class="btn btn-md me-sm-3" data-bs-dismiss="modal">Zamknij</button>
					  <button type="submit" class="btn btn-md">Zapisz</button>
					</div>
				  </div>
				</div>
		    </div>
		</form>
		  
		</div>
	  </div>
	  
	
	
	  <h3 class="h3First h3ColorForIncomes pb-3">Przychody</h3>
	  <?php
	  if ($result2->num_rows > 0) 
				{
					$totalSumOfIncomes = 0;
					$sumOfIncomes = 0;
					echo '<table class="table incomes"><tr><th>Kategoria</th><th>Przychód [zł]</th></tr>';
					  // output data of each row
				    while($row = $result2->fetch_assoc()) 
					{
						echo "<tr><td>".$row["name"]."</td><td>".$row["suma_przychodow"]." </td></tr>";
						$sumOfIncomes = $row["suma_przychodow"];
						$totalSumOfIncomes += (double)$sumOfIncomes;
					}
					
					echo '<tr><th class="table-dark">Suma</th> <td class="table-dark">';
					echo $totalSumOfIncomes;
					echo '</td></tr></table>';
				} 
				else 
				{
					$totalSumOfIncomes = 0;
					echo '<div class="row">
	    <label class="pb-3">Brak przychodów do wyświetlenia!</label>
	  </div>';
				}
				?>
	  
	  <h3 class="h3ColorForExpenses pb-3">Wydatki</h3>
	  
	  <?php
	  if ($result->num_rows > 0) 
				{
					$totalSumOfExpenses = 0;
					$sumOfExpenses = 0;
					echo '<table class="table expenses"><tr><th>Kategoria</th><th>Wydatek [zł]</th></tr>';
					  // output data of each row
				    while($row = $result->fetch_assoc()) 
					{
						echo "<tr><td>".$row["name"]."</td><td>".$row["suma_wydatkow"]." </td></tr>";
						$sumOfExpenses = $row["suma_wydatkow"];
						$totalSumOfExpenses += (double)$sumOfExpenses;
					}
					echo '<tr><th class="table-dark">Suma</th> <td class="table-dark">';
					echo $totalSumOfExpenses;
					echo '</td></tr></table>';
				} 
				else 
				{
					$totalSumOfExpenses = 0;
					
					echo '<div class="row">
	    <label class="pb-3">Brak wydatków do wyświetlenia!</label>
	  </div>';
				}
	  ?>
	  
	  
	  <h3 class="h3Color pb-3">Bilans</h3>
	  <table class="table table-dark">
	    <thead>
	      <tr>
		    <th class="table-dark">Bilans [zł]</th> <td class="table-dark">
			<?php
				$balance = 0;
				$balance = $totalSumOfIncomes - $totalSumOfExpenses;
				echo $balance;
			?>
			</td>
		  </tr>
		</thead>
	  </table>
	  <div class="row">
		<?php
		
			if ($balance > 0)
			{
				echo '<label class="pb-3">Gratulacje. Świetnie zarządzasz finansami!</label>';
			}
			else
			{
				echo '<label class="pb-3">Bierz się za robotę!</label>';
			}
		
		?>
		
	    
	  </div>
	  
	  <h3 class="h3ColorForExpenses pb-3">Diagram kołowy wydatków</h3>
	  <div class="row">
	    <div class="col">
		
		  <?php
			if ($result3->num_rows > 0) 
				{
					echo '<div id="piechart"></div>';
				}
				else
		  {
					
					echo '<div class="row">
	    <label class="pb-3">Brak wydatków do wyświetlenia!</label>
	  </div>';
				}
	  ?>
		  
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