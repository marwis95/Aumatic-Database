<html>
<head>

<meta http-equiv="Content-Language" content="pl">
<META NAME="Keywords" CONTENT="">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Zarzadzaj użytkownikami</title>
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


//var_dump($_POST);

if($_GET["block"]) {
	//echo "Blokuj " . $_GET['block'];
	$zapytanie_block="update uzytkownicy uzytkownicy set block='1' where id='" . $_GET['block'] . "';"; //query
	$wykonaj_block=mysql_query($zapytanie_block);  // result
	
	echo "<script>";
	echo "alert('Użytkownik został zablokowany');";
	echo "</script>";
}

if($_GET["unblock"]) {
	//echo "Odblokuj ". $_GET['unblock'];
	$zapytanie_unblock="update uzytkownicy uzytkownicy set block='0' where id='" . $_GET['unblock'] . "';"; //query
	$wykonaj_unblock=mysql_query($zapytanie_unblock);  // result
	
	echo "<script>";
	echo "alert('Użytkownik został odblokowany');";
	echo "</script>";
}

if($_GET["delete"]){
	//echo "Usuń " . $_GET['delete'];
	$zapytanie_delete="delete from uzytkownicy where id='" . $_GET['delete'] . "';"; //query
	$wykonaj_delete=mysql_query($zapytanie_delete);  // result
	
	echo "<script>";
	echo "alert('Użytkownik został usunięty');";
	echo "</script>";
}


$zapytanie="SELECT * from uzytkownicy"; //query
$wykonaj=mysql_query($zapytanie);  // result

$zapytanie_count="select * from uzytkownicy;"; //query
$wykonaj_count=mysql_query($zapytanie_count);  // result
$policz_count = mysql_num_rows($wykonaj_count);

$zapytanie_count_block="select * from uzytkownicy where block='1';"; //query
$wykonaj_count_block=mysql_query($zapytanie_count_block);  // result
$policz_count_block = mysql_num_rows($wykonaj_count_block);

echo "<center><font size='7'>Zarządzaj użytkownikami:</center><br></font>";

echo "<center><font size='5'>Uzytkowników w systemie: " . $policz_count . " (w tym zablokowanych: " . $policz_count_block . ")</center><br></font>";

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
$zapytanie_imie="SELECT * from uzytkownicy where id=$temp_imie"; //query
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
$zapytanie_nazwisko="SELECT * from uzytkownicy where id=$temp_nazwisko"; //query
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
$zapytanie_login="SELECT * from uzytkownicy where id=$temp_login"; //query
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
$zapytanie_mail="SELECT * from uzytkownicy where id=$temp_mail"; //query
$wykonaj_mail=mysql_query($zapytanie_mail);  // result
$wiersz_mail = mysql_fetch_array($wykonaj_mail);
echo $wiersz_mail['mail'];

echo "</td>";
echo "</tr>";


//////////////////////////////////////////////////////////



echo "<tr>";
echo "<td width='80'>";
echo "Prawa:";
echo "</td>";
echo "<td>";

$temp_prawa = $wiersz['id'];
$zapytanie_prawa="SELECT * from uzytkownicy where id=$temp_prawa"; //query
$wykonaj_prawa=mysql_query($zapytanie_prawa);  // result
$wiersz_prawa = mysql_fetch_array($wykonaj_prawa);
echo $wiersz_prawa['prawa'];

//echo "<a href='accept.php?usun=".$wiersz['id']."'>-->ODMÓW<--</a><br><br>";

//echo "<a href='accept.php?dodaj=".$wiersz['id']. "&prawa=" . $_POST['prawa'] . "'>-->NADAJ PRAWA I DODAJ<--</a>";

echo "</td>";
echo "</tr>";

///////////////////////////////////////////////////////

echo "<tr>";
echo "<td width='80'>";
echo "Status:";
echo "</td>";
echo "<td>";

$temp_status = $wiersz['id'];
$zapytanie_status="SELECT * from uzytkownicy where id=$temp_status"; //query
$wykonaj_status=mysql_query($zapytanie_status);  // result
$wiersz_status = mysql_fetch_array($wykonaj_status);
if ($wiersz_status['block'] == '0'){
echo "<div style='color: #006600; font-weight: bold;'>Odblokowany</div>";
}else{
echo "<div style='color: #CC0000; font-weight: bold;'>ZABLOKOWANY !!!</div>";
}


echo "</td>";
echo "</tr>";

///////////////////////////////////////////////////////////

echo "<tr>";
echo "<td width='80'>";
echo "Zarządzaj";
echo "</td>";
echo "<td>";

$temp_status = $wiersz['id'];
$zapytanie_status="SELECT * from uzytkownicy where id=$temp_status"; //query
$wykonaj_status=mysql_query($zapytanie_status);  // result
$wiersz_status = mysql_fetch_array($wykonaj_status);
if ($wiersz_status['block'] == '0'){
echo "<a href='users.php?block=".$wiersz['id']."'>-->Zablokuj<--</a><br><br>";
}else{
echo "<a href='users.php?unblock=".$wiersz['id']."'>-->Odblokuj<--</a><br><br>";
}

echo "<a href='users.php?delete=".$wiersz['id']."'>-->Usuń<--</a><br>";



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
