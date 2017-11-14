<html>
<head>

<meta http-equiv="Content-Language" content="pl">
<META NAME="Keywords" CONTENT="">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Dodaj typ</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<?php

mysql_connect("localhost", "root", "123") or die("Nie można poł±czyć się z MySQL");

mysql_select_db("aumatic") or die("Nie można poł±czyć się z baza danych");

?>

<?php session_start();
      //require_once('db.php');
?>

<?php
if ($_SESSION['auth'] == TRUE) {
		  $zapytanie="SELECT * from uzytkownicy where login = '" . $_SESSION['user'] . "'"; //query
		  $wykonaj=mysql_query($zapytanie);  // result
		  
		  while ($wiersz = mysql_fetch_array($wykonaj)){
		  if ($wiersz['prawa'] != ""){
		  $prawa = $wiersz['prawa'];
		  }
		  }
}

if ($prawa == "admin"){

echo "<center><font size='7'>Dodaj klasę funkcji</center><br></font>";
echo "<div style='float: left'><font size='7'><a href='hide.php'><--Wróć</a></div></font>";

echo "<center>";
echo "<div style='width: 300px; height:150px; background: #f0f0f0; text-align: left;'>";

echo "<form action='add_type.php' method='post'>";
echo "<br>Podaj nazwę klasy: ";
echo "<input type='text' name='typ' style='float: right'/><br><br>";
echo "<input type='submit' name='button1'  value='DODAJ' style='width: 300px; height: 40px;'>";

echo "</form>";

echo "</div>";
echo "</center>";
 
//var_dump($_POST); 
 
if(isset($_POST['button1'])){

$zapytanie="insert into typ_funkcji (id, typ) values ('', '" . mysql_real_escape_string($_POST['typ']) . "')"; //query
$wykonaj=mysql_query($zapytanie);  // result

echo "<script>";
echo "alert('Typ został dodany pomyślnie')";
echo "</script>";

}
 
}else{
echo "brak dostepu";
}
?>



</body>
</html>
