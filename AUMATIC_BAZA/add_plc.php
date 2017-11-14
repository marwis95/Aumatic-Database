<html>
<head>

<meta http-equiv="Content-Language" content="pl">
<META NAME="Keywords" CONTENT="">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Dodaj sterownik</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<?php

mysql_connect("localhost", "root", "") or die("Nie można poł±czyć się z MySQL");

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
$tablica_wyborow = array();

echo "<center><font size='7'>Dodaj sterownik</center><br></font>";
echo "<div style='float: left'><font size='7'><a href='hide.php'><--Wróć</a></div></font>";

echo "<center>";
echo "<div style='width: 350px; height:350px; background: #f0f0f0; text-align: left;'>";
echo "<div style='margin: 0 auto'><font size='6'>Dodaj nowy model: </font><br></div>";

		$i=0;
		$tab = array();
		$tab[0][1] = "==WYBIERZ MARKE STEROWNIKA==";
		$zapytanie_marka_lista="SELECT * from sterowniki order by marka asc"; //query
		$wykonaj_marka_lista=mysql_query($zapytanie_marka_lista);  // result
		while ($wiersz_marka_lista = mysql_fetch_array($wykonaj_marka_lista)){
		
			$tab[$i+1][1] = $wiersz_marka_lista['marka'];
			$tab[$i+1][0] =  $wiersz_marka_lista['id'];
			$i++;
		}
		
		
//<!--====================Wypełnianie tablicy z markami================================-->		
	
echo "<form action='add_plc.php' method='post' enctype='multipart/form-data'>";

echo "<select name='marka' style='width: 350px' id='marka' onchange='this.form.submit()'>";
		
		
		
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

echo "<br>";



echo "<br>Podaj nazwę modelu: ";
echo "<input type='text' name='model' style='width: 200px; float: right;'/><br><br>";
echo "<input type='submit' name='button1'  value='DODAJ' style='width: 350px; height: 40px;'>";

echo "</form>";
echo "<hr>";

echo "<div style='margin: 0 auto'><font size='6'>Dodaj marke i model: </font><br></div>";



echo "<form action='add_plc.php' method='post' enctype='multipart/form-data'>";

echo "<br>Podaj markę: ";
echo "<input type='text' name='marka2' style='width: 200px; float: right;'/><br>";

echo "<br>Podaj model: ";
echo "<input type='text' name='model2' style='width: 200px; float: right;'/><br><br>";

echo "<input type='submit' name='button2'  value='DODAJ' style='width: 350px; height: 40px;'>";

echo "</form>";



echo "</div>";
echo "</center>";
 
//var_dump($_POST); 
 
if(isset($_POST['button1'])){
$zapytanie_model="insert into sterowniki (id, marka, model) values ('', '" . $_POST['marka'] . "', '" . $_POST['model'] . "')"; //query
$wykonaj_model=mysql_query($zapytanie_model);  // result

echo "<script>";
echo "alert('Sterownik został dodany poprawnie')";
echo "</script>";

}

if(isset($_POST['button2'])){
$zapytanie_model_2="insert into sterowniki (id, marka, model) values ('', '" . $_POST['marka2'] . "', '" . $_POST['model2'] . "')"; //query
$wykonaj_model_2=mysql_query($zapytanie_model_2);  // result

echo "<script>";
echo "alert('Sterownik został dodany poprawnie')";
echo "</script>";
	
}
 
}else{
echo "brak dostepu";
}
?>



</body>
</html>
