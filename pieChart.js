google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Kategoria wydatków', 'Wydatki [zł]'],
  /*['Jedzenie', 1000.35],
  ['Mieszkanie', 1500.65],
  ['Transport', 102.48],
  ['Telekomunikacja', 100.59],
  ['Opieka zdrowotna', 0],
  ['Ubranie', 0],*/
  
  <?php
  
	while($row = mysqli_fetch_assoc($result))
	{
		echo "['".$row['name']."',".$row['suma_wydatkow']."],";
	}
  
  ?>
  
  /*['Higiena', 50],
  ['Dzieci ', 200],
  ['Rozrywka', 100],
  ['Wycieczka', 0],
  ['Szkolenia', 0],
  ['Książki', 100],
  ['Oszczędności', 200],
  ['Na emeryturę', 0],
  ['Spłata długów', 0],
  ['Darowizna', 0],
  ['Inne', 0]*/
]);

  var options = {'width': 'auto', 'height': 400};

	/*if (window.innerWidth >= 730) {
	  var options = {'width':650, 'height':400};
	} else if (window.innerWidth <= 730 && window.innerWidth >= 535) {
	var options = {'width':450, 'height':400};}
	 else
	{
	  var options = {'width':300, 'height':400};
	}*/

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}