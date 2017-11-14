<?php session_start();
      //require_once('db.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>Panel uzytkownika</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
</head>

<body>

<?php

mysql_connect("localhost", "root", "123") or die("Nie można poł±czyć się z MySQL");

mysql_select_db("aumatic") or die("Nie można poł±czyć się z baza danych");

$prawa;
?>
  
  <?php if ($_SESSION['auth'] == TRUE) {
		  
		  $zapytanie="SELECT * from uzytkownicy where login = '" . $_SESSION['user'] . "'"; //query
		  $wykonaj=mysql_query($zapytanie);  // result
		  
		  while ($wiersz = mysql_fetch_array($wykonaj)){
		  if ($wiersz['prawa'] != ""){
		  $prawa = $wiersz['prawa'];
		  }
		  }
		  
		  echo "<div style='background: #f0f0f0; width: 350px; height: 60px; float: right; font-size: 20px'>"; 
		  echo "Zalogowany jako: " . $_SESSION['user'] . "<br>Na prawach: " . $prawa . "<br>" ;
		  echo "</div>";
		  
		  echo "<div style='background: #f0f0f0; width: 250px; height: 60px; float: left; font-size: 40px;'>";
          echo '<a href="index.php?logout">Wyloguj się</a>';
		  echo "</div>";	
		  
		  echo "<div style='font-size: 60px; margin-left:auto; margin-right:auto; width: 500px;'>Aumatic database</div>";
			
		  echo "<center> <font size='5'>";
		  
		  if ($prawa == "junior"){
		  echo "<a href='read.php'>Przeglądaj baze</a>";	
		  }
		  
		  if ($prawa == "senior"){
		  echo "<a href='read.php'>Przeglądaj baze</a><br>";	
		  echo "<a href='add.php'>Dodaj program do bazy</a>";	
		  }
		  
		  if ($prawa == "vip"){
		  echo "<a href='read.php'>Przeglądaj baze</a><br>";	
		  echo "<a href='add.php'>Dodaj program do bazy</a><br>";	
		  echo "<a href='drop.php'>Usuń program z bazy</a>";
		  }
		  
		  if ($prawa == "admin"){
		  $count = 0;
		  
		  $zapytanie_count="select * from kandydaci";
		  $wykonaj_count=mysql_query($zapytanie_count);  // result

		  while ($wiersz_count = mysql_fetch_array($wykonaj_count)){
		  $count++;
		  }
		  
		  echo "<a href='read.php'>Przeglądaj baze</a><br>";	
		  echo "<a href='add_premium.php'>Dodaj program do bazy</a><br>";	
		  echo "<a href='drop.php'>Usuń program z bazy</a><br><br>";
		  
		  echo "<a href='accept.php'>Zatwierdź nowego użytkownika(" . $count . ")</a><br>";
		  echo "<a href='users.php'>Usuń/zablokuj użytkownia</a><br>";
		  //echo "<a href='add_plc.php'>Dodaj nowy sterownik</a><br>";
		  echo "<a href='add_producent.php'>Dodaj nowego producenta</a><br>";
		  echo "<a href='add_model.php'>Dodaj model do istniejącego sterownika</a><br>";
		  echo "<a href='add_type.php'>Dodaj nową klasę funkcji</a><br>";
		  }
		  
		  echo "</font></center>";
  }
  
  else {
		  echo '<p style="padding-top:10px;color:white";><strong>Próba nieautoryzowanego dostępu...</strong><br />trwa przenoszenie do formularza logowania</p>';
          echo '<meta http-equiv="refresh" content="1; URL=index.php">';
  }
  ?>
  
</body>
  
</html>
