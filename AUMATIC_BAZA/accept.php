<html>
<head>

<meta http-equiv="Content-Language" content="pl">
<META NAME="Keywords" CONTENT="">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Zatwierdź użytkownika</title>
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

if ($_POST['prawa'] == ""){
	$_POST['prawa'] = "junior";
}

//var_dump($_POST);

if($_GET["usun"]) {
	$zapytanie_drop="DELETE FROM kandydaci where id='" . $_GET["usun"]. "';"; //query
	$wykonaj_drop=mysql_query($zapytanie_drop);  // result
	
	echo "<script>";
	echo "alert ('Prośba kandydata zastała odrzucona !')";
	echo "</script>";
	
}

if($_GET["dodaj"]) {
	//echo "Dodawanie id ".$_GET['dodaj'];
	//echo "Prawa ".$_GET['prawa'];
	
	
	
	$zapytanie_select="select * from kandydaci where id='" . $_GET['dodaj'] . "';"; //query
	$wykonaj_select=mysql_query($zapytanie_select);  // result
	$wiersz_select = mysql_fetch_array($wykonaj_select);
	
	$zapytanie_add="INSERT INTO uzytkownicy (id, imie, nazwisko, mail, login, haslo, prawa, block) VALUES 
	('', '" . $wiersz_select['imie'] . "', '" . $wiersz_select['nazwisko'] . "', '" . $wiersz_select['mail'] . "', '" . $wiersz_select['login'] . "', '" . $wiersz_select['haslo'] . "', '" . $_GET['prawa'] . "', '0');";
	$wykonaj_add=mysql_query($zapytanie_add);
	

	
	$zapytanie_getid="select * from uzytkownicy where login='" . $wiersz_select['login'] . "'"; //query
	$wykonaj_getid=mysql_query($zapytanie_getid);  // result
	$wiersz_getid = mysql_fetch_array($wykonaj_getid);
	
	$zapytanie_programista="insert into programisci (id, imie, nazwisko, id_usera) values('', '" . $wiersz_select['imie'] ."', '" . $wiersz_select['nazwisko'] ."', '" . $wiersz_getid['id'] . "')"; //query
	$wykonaj_programista=mysql_query($zapytanie_programista);  // result
	
	
	$zapytanie_drop="DELETE FROM kandydaci where id='" . $_GET["dodaj"]. "';"; //query
	$wykonaj_drop=mysql_query($zapytanie_drop);  // result
	
	echo "<script>";
	echo "alert ('Kandydat został dodany do bazy')";
	echo "</script>";
}



$zapytanie="SELECT * from kandydaci"; //query
$wykonaj=mysql_query($zapytanie);  // result

echo "<center><font size='7'>Następujący użytkownicy proszą o dodanie ich do bazy</center><br></font>";
echo "<div style='float: left'><font size='7'><a href='hide.php'><--Wróć</a></div></font>";

echo "<div style='margin: 0 auto;  width: 600px;'>";
while ($wiersz = mysql_fetch_array($wykonaj)){
echo "<table border='1' align='center' width='600'>"; 
echo "<tr>";
echo "<td width='80'>";
echo "ID:";
echo "</td>";
echo "<td>";
echo $wiersz['id'];
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td width='80'>";
echo "Imie:";
echo "</td>";
echo "<td>";

$temp_imie = $wiersz['id'];
$zapytanie_imie="SELECT * from kandydaci where id=$temp_imie"; //query
$wykonaj_imie=mysql_query($zapytanie_imie);  // result
$wiersz_imie = mysql_fetch_array($wykonaj_imie);
echo $wiersz_imie['imie'];


echo "</td>";
echo "</tr>";

//////////////////////////////////////////////////////////////


echo "<tr>";
echo "<td width='80'>";
echo "Nazwisko:";
echo "</td>";
echo "<td>";

$temp_nazwisko = $wiersz['id'];
$zapytanie_nazwisko="SELECT * from kandydaci where id=$temp_nazwisko"; //query
$wykonaj_nazwisko=mysql_query($zapytanie_nazwisko);  // result
$wiersz_nazwisko = mysql_fetch_array($wykonaj_nazwisko);
echo $wiersz_nazwisko['nazwisko'];
//setcookie("typ", $wiersz_typ['typ']);
echo "</td>";
echo "</tr>";

////////////////////////////////////////////////////////////


echo "<tr>";
echo "<td width='80'>";
echo "Login:";
echo "</td>";
echo "<td>";

$temp_login = $wiersz['id'];
$zapytanie_login="SELECT * from kandydaci where id=$temp_imie"; //query
$wykonaj_login=mysql_query($zapytanie_login);  // result
$wiersz_login = mysql_fetch_array($wykonaj_login);
echo $wiersz_login['login'];

echo "</td>";
echo "</tr>";

////////////////////////////////////////////////////////////



echo "<tr>";
echo "<td width='80'>";
echo "E-mail:";
echo "</td>";
echo "<td>";

$temp_mail = $wiersz['id'];
$zapytanie_mail="SELECT * from kandydaci where id=$temp_imie"; //query
$wykonaj_mail=mysql_query($zapytanie_mail);  // result
$wiersz_mail = mysql_fetch_array($wykonaj_mail);
echo $wiersz_mail['mail'];

echo "</td>";
echo "</tr>";


//////////////////////////////////////////////////////////



echo "<tr>";
echo "<td width='80'>";
echo "Usun/Zatwierdź:";
echo "</td>";
echo "<td>";
$nazwa = $wiersz['pobierz'];
//echo $wiersz['pobierz'];


echo "<a href='accept.php?usun=".$wiersz['id']."'>-->ODMÓW<--</a><br><br>";

echo "<form action='accept.php' method='post'>";
echo "<label for='prawa'>PRAWA:</label>";
echo "<select name='prawa' id='prawa' onchange='this.form.submit()'>";

if ($_POST['prawa'] == "junior"){
	echo "<option value='junior' selected='selected'>Junior (tylko odczyt)</option>";
	echo "<option value='senior' >Senior (odczyt + dopisywanie)</option>";
	echo "<option value='vip' >Vip (odczyt + dopisywanie + usuwanie)</option>";
	echo "<option value='admin'>Admin (wszystko)</option>";
	}

if ($_POST['prawa'] == "senior"){
	echo "<option value='junior'>Junior (tylko odczyt)</option>";
	echo "<option value='senior' selected='selected'>Senior (odczyt + dopisywanie)</option>";
	echo "<option value='vip' >Vip (odczyt + dopisywanie + usuwanie)</option>";
	echo "<option value='admin'>Admin (wszystko)</option>";
	}

if ($_POST['prawa'] == "vip"){
	echo "<option value='junior'>Junior (tylko odczyt)</option>";
	echo "<option value='senior'>Senior (odczyt + dopisywanie)</option>";
	echo "<option value='vip' selected='selected'>Vip (odczyt + dopisywanie + usuwanie)</option>";
	echo "<option value='admin'>Admin (wszystko)</option>";
	}

if ($_POST['prawa'] == "admin"){
	echo "<option value='junior'>Junior (tylko odczyt)</option>";
	echo "<option value='senior'>Senior (odczyt + dopisywanie)</option>";
	echo "<option value='vip'>Vip (odczyt + dopisywanie + usuwanie)</option>";
	echo "<option value='admin' selected='selected'>Admin (wszystko)</option>";
	}	
	
echo "</select>";
echo "</form>";

echo "<a href='accept.php?dodaj=".$wiersz['id']. "&prawa=" . $_POST['prawa'] . "'>-->NADAJ PRAWA I DODAJ<--</a>";

echo "</td>";
echo "</tr>";

echo "</table>";

echo "<br><br><br>";

}
echo "</div>";





echo "</center>";
echo "</div>";
   
   

  
}else{
echo "brak dostepu";
}
?>



</body>
</html>
