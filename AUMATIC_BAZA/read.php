<html>
<head>

<meta http-equiv="Content-Language" content="pl">
<META NAME="Keywords" CONTENT="">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Przeglądanie</title>
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

if (($prawa == "junior") || ($prawa == "senior") || ($prawa == "vip") || ($prawa == "admin")){


$tablica_wyborow = array();




echo "<div style='background-color:#eeeeee;'>";
echo "<center>";

		
		$i=0;
		$tab = array();
		$tab[0][1] = "==WYBIERZ PRODUCENTA==";
		$zapytanie_marka_lista="SELECT * from sterowniki order by marka asc"; //query
		$wykonaj_marka_lista=mysql_query($zapytanie_marka_lista);  // result
		while ($wiersz_marka_lista = mysql_fetch_array($wykonaj_marka_lista)){
		
			$tab[$i+1][1] = $wiersz_marka_lista['marka'];
			$tab[$i+1][0] =  $wiersz_marka_lista['id'];
			$i++;
		}
		
		
//<!--====================Wypełnianie tablicy z markami================================-->		

//var_dump($_POST);
	
echo "<form action='read.php' method='post'>";

echo "<select name='marka' id='marka' onchange='this.form.submit()'>";
		
		
		
		$flag = true;
		
		for ($i=0; $i<count($tab); $i++){
			for($j=0; $j<$i; $j++){
				if($tab[$j][1] == $tab[$i][1]){
				$flag = false;
				}
			}
		
		if($flag == true){
		
		echo "<option value='" . $tab[$i][1] . "'";
		
			
			if($tab[$i][1] == $_POST['marka'])
			echo " selected='selected' ";
			echo ">";
		
		echo $tab[$i][1];
		echo "</option>";
		}
		
		$flag = true;
		}
	
		
	echo "</select>";


	
	
//<!--====================Wypełnianie listy z markami============================-->


	echo "<select name='model' >";
		
		

		echo "<option value='select'>";
		echo "==WYBIERZ MODEL==";
		echo "</option>";
		
		$zapytanie_model_lista="SELECT * from sterowniki where marka='" . $_POST['marka'] . "'"; //query
		echo $zapytanie_model_lista;
		$wykonaj_model_lista=mysql_query($zapytanie_model_lista);  // result
		while ($wiersz_model_lista = mysql_fetch_array($wykonaj_model_lista)){
		
		
		if($wiersz_model_lista['model']!=""){
		echo "<option value='" . $wiersz_model_lista['id'] . "'";
		
			if($wiersz_model_lista['id'] == $_POST['model'])
				echo " selected='selected' ";
			
			echo ">";
		
		echo $wiersz_model_lista['model'];
		echo "</option>";
		}
		
		}
		
		
	echo "</select>";


//<!--========================Wypełnianie listy z modelami============================-->


	echo "<select name='typ' >";
		
		

		echo "<option value='select'>";
		echo "==WYBIERZ KLASĘ FUNKCJI==";
		echo "</option>";
		
		$zapytanie_typ_lista="SELECT * from typ_funkcji"; //query
		$wykonaj_typ_lista=mysql_query($zapytanie_typ_lista);  // result
		while ($wiersz_typ_lista = mysql_fetch_array($wykonaj_typ_lista)){
		
		echo "<option value='" . $wiersz_typ_lista['id'] . "'";
		
			if($wiersz_typ_lista['id'] == $_POST['typ'])
			echo " selected='selected' ";
			
			echo ">";
		
		echo $wiersz_typ_lista['typ'];
		echo "</option>";

		}
		
		
	echo '</select>';



//<!--========================Wypełnienie listy z typami=======================-->


	echo "<select name='programista' >";
		
		

		echo "<option value='select'>";
		echo "==WYBIERZ PROGRAMISTE==";
		echo "</option>";
		
		$zapytanie_programista_lista="SELECT * from programisci"; //query
		$wykonaj_programista_lista=mysql_query($zapytanie_programista_lista);  // result
		while ($wiersz_programista_lista = mysql_fetch_array($wykonaj_programista_lista)){
			// -a s-da-s- d
			echo "<option value='" . $wiersz_programista_lista['id'] . "'";
			
			if($wiersz_programista_lista['id'] == $_POST['programista'])
				echo " selected='selected' ";
			
			echo ">";
			// -- a-s-d a
			echo $wiersz_programista_lista['nazwisko'];
			echo " "; 
			echo $wiersz_programista_lista['imie'];
			echo "</option>";
		}
		
		
	echo "</select>";

	

//<!--========================Wypełnienie listy z programistami=======================-->


	if($_POST['opis'] != ''){
	echo "<input type='text' name='opis' value='" . $_POST['opis'] . "' />";
	}else{
	echo "<input type='text' name='opis' value='' />";
	}



echo "<input type='submit' name='button1'  value='SZUKAJ'>";
echo "</form>";

echo "</center>";
echo "</div>";

		  echo "<div><font size='7'><a href='hide.php'><--Wróć</a></div></font>";

if (isset($_POST['button1']))
{
   //echo "MARKA: " . $_POST['marka'] . "<br>";
   //echo "MODEL: " . $_POST['model'] . "<br>";
   //echo "TYP: " . $_POST['typ'] . "<br>";
   //echo "PROGRAMISTA: " . $_POST['programista'] . "<br>";
   //echo "OPIS: " . $_POST['opis'];
   
   
echo "<div class='div3'>";
echo "<center>";



$zapytanie="SELECT * from programy"; //query

if ($_POST['model'] != "select"){
$zapytanie = $zapytanie . " where id_sterownika=" . $_POST['model'];
}

if ($_POST['typ'] != "select"){
if (strpos($zapytanie, 'where') !== FALSE){
	$zapytanie = $zapytanie . " and id_typu =" . $_POST['typ'];
	}else{
	$zapytanie = $zapytanie . " where id_typu =" . $_POST['typ'];
	}
}

if ($_POST['programista'] != "select"){
if (strpos($zapytanie, 'where') !== FALSE){
	$zapytanie = $zapytanie . " and id_programisty =" . $_POST['programista'];
	}else{
	$zapytanie = $zapytanie . " where id_programisty =" . $_POST['programista'];
	}
}

if ($_POST['opis'] != ""){
if (strpos($zapytanie, 'where') !== FALSE){
	$zapytanie = $zapytanie . " and opis like '%" . mysql_real_escape_string($_POST['opis']) . "%'";
	}else{
	$zapytanie = $zapytanie . " where opis like '%" . mysql_real_escape_string($_POST['opis']) . "%'" ;
	}
}


//echo $zapytanie;
if (strpos($zapytanie, 'where') !== FALSE){
$wykonaj=mysql_query($zapytanie);  // result
}else{
echo "<script>";
echo "alert('Musisz wybrać jakieś kryteria')";
echo "</script>";
}


if (mysql_num_rows($wykonaj) == 0){
echo "Nie znaleziono takiego programu.<br>Zmień kryteria i wyszukaj ponownie.";
}


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
echo "Sterownik:";
echo "</td>";
echo "<td>";

$temp_ster = $wiersz['id_sterownika'];
$zapytanie_ster="SELECT * from sterowniki where id=$temp_ster"; //query
$wykonaj_ster=mysql_query($zapytanie_ster);  // result
$wiersz_ster = mysql_fetch_array($wykonaj_ster);
echo $wiersz_ster['marka'];
echo "  ";
echo $wiersz_ster['model'];

echo "</td>";
echo "</tr>";

//////////////////////////////////////////////////////////////


echo "<tr>";
echo "<td width='80'>";
echo "Typ:";
echo "</td>";
echo "<td>";

$temp_typ = $wiersz['id_typu'];
$zapytanie_typ="SELECT * from typ_funkcji where id=$temp_typ"; //query
$wykonaj_typ=mysql_query($zapytanie_typ);  // result
$wiersz_typ = mysql_fetch_array($wykonaj_typ);
echo $wiersz_typ['typ'];
//setcookie("typ", $wiersz_typ['typ']);
echo "</td>";
echo "</tr>";

////////////////////////////////////////////////////////////


echo "<tr>";
echo "<td width='80'>";
echo "Programista:";
echo "</td>";
echo "<td>";

$temp_programista = $wiersz['id_programisty'];
$zapytanie_programista="SELECT * from programisci where id=$temp_programista"; //query
$wykonaj_programista=mysql_query($zapytanie_programista);  // result
$wiersz_programista = mysql_fetch_array($wykonaj_programista);
echo $wiersz_programista['imie'];
echo "  ";
echo $wiersz_programista['nazwisko'];

echo "</td>";
echo "</tr>";

////////////////////////////////////////////////////////////



echo "<tr>";
echo "<td width='80'>";
echo "Wersja:";
echo "</td>";
echo "<td>";
echo $wiersz['wersja'];
echo "</td>";
echo "</tr>";


//////////////////////////////////////////////////////////

echo "<tr>";
echo "<td width='80'>";
echo "Data dodania:";
echo "</td>";
echo "<td>";
echo $wiersz['data'];
echo "</td>";
echo "</tr>";


//////////////////////////////////////////////////////////



echo "<tr>";
echo "<td width='80'>";
echo "Opis:";
echo "</td>";
echo "<td>";
echo $wiersz['opis'];
echo "</td>";
echo "</tr>";

/////////////////////////////////////////////////////////

echo "<tr>";
echo "<td width='80'>";
echo "Program:";
echo "</td>";
echo "<td>";
$nazwa = $wiersz['pobierz'];
//echo $wiersz['pobierz'];
echo "<a href='pliki/" . $nazwa . "'>" . $nazwa . "</a>";
echo "</td>";
echo "</tr>";


////////////////////////////////////////////////////////


echo "<tr>";
echo "<td width='80'>";
echo "Dokumentacja:";
echo "</td>";
echo "<td>";
$nazwa_dok = $wiersz['dokumentacja'];
//echo $wiersz['pobierz'];
echo "<a href='Dokumentacje/" . $nazwa_dok . "'>" . $nazwa_dok . "</a>";
echo "</td>";
echo "</tr>";



echo "</table>";

echo "<br><br><br>";

}








echo "</center>";
echo "</div>";
   
   
}
  
}else{
echo "brak dostepu";
}
?>



</body>
</html>
