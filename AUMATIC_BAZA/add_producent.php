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

mysql_connect("localhost", "root", "123") or die("Nie mo�na po��czy� si� z MySQL");

mysql_select_db("aumatic") or die("Nie mo�na po��czy� si� z baza danych");

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

echo "<center><font size='7'>Dodaj nowego producenta</center><br></font>";
echo "<div style='float: left'><font size='7'><a href='hide.php'><--Wr��</a></div></font>";


echo "<div style='width: 350px; height:200px; background: #f0f0f0; text-align: left; float: right'>";
echo "<center><font size='5'>Podgl�dnij istniej�cych producent�w</center><br></font>";
		$i=0;
		$tab = array();
		$tab[0][1] = "==PRODUCENCI=";
		$zapytanie_marka_lista="SELECT * from sterowniki order by marka asc"; //query
		$wykonaj_marka_lista=mysql_query($zapytanie_marka_lista);  // result
		while ($wiersz_marka_lista = mysql_fetch_array($wykonaj_marka_lista)){
		
			$tab[$i+1][1] = $wiersz_marka_lista['marka'];
			$tab[$i+1][0] =  $wiersz_marka_lista['id'];
			$i++;
		}
		
		
//<!--====================Wype�nianie tablicy z markami================================-->		
	
echo "<form action='' method='post' enctype='multipart/form-data'>";

echo "<select name='marka' style='width: 350px' id='marka'>";
		
		
		
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


echo "</form>";


echo "</div>";


echo "<center>";
echo "<div style='width: 350px; height:200px; background: #f0f0f0; text-align: left;'>";




echo "<form action='add_producent.php' method='post' enctype='multipart/form-data'>";

echo "<br>Podaj nazw� producenta: ";
echo "<input type='text' name='marka2' style='width: 180px; float: right;'/><br>";

echo "<br>Podaj model (opcjonalne): ";
echo "<input type='text' name='model2' style='width: 180px; float: right;'/><br><br>";

echo "<input type='submit' name='button2'  value='DODAJ' style='width: 350px; height: 40px;'>";

echo "</form>";



echo "</div>";




echo "</center>";
 
//var_dump($_POST); 
 


if(isset($_POST['button2'])){
if ($_POST['marka2'] !=""){
$zapytanie_model_2="insert into sterowniki (id, marka, model) values ('', '" . mysql_real_escape_string($_POST['marka2']) . "', '" . mysql_real_escape_string($_POST['model2']) . "')"; //query
$wykonaj_model_2=mysql_query($zapytanie_model_2);  // result

echo "<script>";
echo "alert('Sterownik zosta� dodany poprawnie')";
echo "</script>";
}else{
echo "<script>";
echo "alert('Podaj nazw� sterownika')";
echo "</script>";
}
	
}
 
}else{
echo "brak dostepu";
}
?>



</body>
</html>
