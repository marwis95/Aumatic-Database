<html>
<head>

<meta http-equiv="Content-Language" content="pl">
<META NAME="Keywords" CONTENT="">

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Dodawanie</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>


<?php session_start();
      //require_once('db.php');
?>

<?php

function sprawdz_bledy()
{
  if ($_FILES['nazwa_pliku']['error'] > 0)
  {
    echo 'problem: ';
    switch ($_FILES['nazwa_pliku']['error'])
    {
      // jest większy niż domyślny maksymalny rozmiar,
      // podany w pliku konfiguracyjnym
      case 1: {echo 'Rozmiar pliku jest zbyt duży.'; break;} 
	  
      // jest większy niż wartość pola formularza 
      // MAX_FILE_SIZE
      case 2: {echo 'Rozmiar pliku jest zbyt duży.'; break;}
	  
      // plik nie został wysłany w całości
      case 3: {echo 'Plik wysłany tylko częściowo.'; break;}
	  
      // plik nie został wysłany
      case 4: {echo 'Nie wysłano żadnego pliku.'; break;}
	  
      // pozostałe błędy
      default: {echo 'Wystąpił błąd podczas wysyłania.';
        break;}
    }
    return false;
  }
  return true;
}

?>

<?php

function sprawdz_bledy_2()
{
  if ($_FILES['nazwa_pliku_2']['error'] > 0)
  {
    echo 'problem: ';
    switch ($_FILES['nazwa_pliku_2']['error'])
    {
      // jest większy niż domyślny maksymalny rozmiar,
      // podany w pliku konfiguracyjnym
      case 1: {echo 'Rozmiar pliku jest zbyt duży.'; break;} 
	  
      // jest większy niż wartość pola formularza 
      // MAX_FILE_SIZE
      case 2: {echo 'Rozmiar pliku jest zbyt duży.'; break;}
	  
      // plik nie został wysłany w całości
      case 3: {echo 'Plik wysłany tylko częściowo.'; break;}
	  
      // plik nie został wysłany
      case 4: {echo 'Nie wysłano żadnego pliku.'; break;}
	  
      // pozostałe błędy
      default: {echo 'Wystąpił błąd podczas wysyłania.';
        break;}
    }
    return false;
  }
  return true;
}

?>

<?php

function zapisz_plik()
{
  $lokalizacja = "pliki" . chr(92) . $_FILES['nazwa_pliku']['name'];
	
  if(is_uploaded_file($_FILES['nazwa_pliku']['tmp_name']))
  {
    if(!move_uploaded_file($_FILES['nazwa_pliku']['tmp_name'], $lokalizacja))
    {
      echo 'problem: Nie udało się skopiować pliku do katalogu.';
        return false;  
    }
  }
  else
  {
	echo 'Plik nie został zapisany.';
    return false;
  }
  return true;
}

?>

<?php

function zapisz_plik_2()
{
  $lokalizacja_2 = "Dokumentacje" . chr(92) . $_FILES['nazwa_pliku_2']['name'];
	
  if(is_uploaded_file($_FILES['nazwa_pliku_2']['tmp_name']))
  {
    if(!move_uploaded_file($_FILES['nazwa_pliku_2']['tmp_name'], $lokalizacja_2))
    {
      echo 'problem: Nie udało się skopiować pliku do katalogu.';
        return false;  
    }
  }
  else
  {
	echo 'Plik nie został zapisany.';
    return false;
  }
  return true;
}

?>

<?php

mysql_connect("localhost", "root", "123") or die("Nie można poł±czyć się z MySQL");

mysql_select_db("aumatic") or die("Nie można poł±czyć się z baza danych");

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

echo "<div style='float: left'><font size='7'><a href='hide.php'><--Wróć</a></div></font>";

echo "<center>";



$tablica_wyborow = array();


echo "<div style='width: 300px; height:600px; background: #f0f0f0; text-align: left;'>";
echo "<div style='margin: 0 auto'><font size='6'>Dodaj nowy program: </font><br><br></div>";

		
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
	
echo "<form action='add_premium.php' method='post' name='form1' enctype='multipart/form-data'>";

echo "<select name='marka' style='width: 300px' id='marka' onchange='this.form.submit()'>";
		
		
		
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

echo "<br><br>";
	
	
//<!--====================Wypełnianie listy z markami============================-->


	echo "<select name='model' style='width: 300px'>";
		
		

		echo "<option value='select'>";
		echo "==WYBIERZ MODEL==";
		echo "</option>";
		
		$zapytanie_model_lista="SELECT * from sterowniki where marka='" . $_POST['marka'] . "'"; //query
		echo $zapytanie_model_lista;
		$wykonaj_model_lista=mysql_query($zapytanie_model_lista);  // result
		while ($wiersz_model_lista = mysql_fetch_array($wykonaj_model_lista)){
		
		
		echo "<option value='" . $wiersz_model_lista['id'] . "'";
		
			if($wiersz_model_lista['id'] == $_POST['model'])
				echo " selected='selected' ";
			
			echo ">";
		
		echo $wiersz_model_lista['model'];
		echo "</option>";

		}
		
		
	echo "</select>";
	echo "<br><br>";

//<!--========================Wypełnianie listy z modelami============================-->


	echo "<select name='typ' style='width: 300px'>";
		
		

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
	echo "<br><br>";


//<!--========================Wypełnienie listy z typami=======================-->


	echo "<select name='programista' style='width: 300px'>";
		
		

		echo "<option value='select'>";
		echo "==WYBIERZ PROGRAMISTE==";
		echo "</option>";
		
		$zapytanie_programista_lista="SELECT * from programisci"; //query
		$wykonaj_programista_lista=mysql_query($zapytanie_programista_lista);  // result
		while ($wiersz_programista_lista = mysql_fetch_array($wykonaj_programista_lista)){
		
		
			echo "<option value='" . $wiersz_programista_lista['id'] . "'";
			
			if($wiersz_programista_lista['id'] == $_POST['programista'])
				echo " selected='selected' ";
			
			echo ">";
			
			echo $wiersz_programista_lista['nazwisko'];
			echo " "; 
			echo $wiersz_programista_lista['imie'];
			echo "</option>";

		}
		
		
	echo "</select>";
	
	

//<!--========================Wypełnienie listy z programistami=======================-->


	echo "<br><br>";
	if ($_POST['wersja'] != ""){
	echo "Wersja: <input type='text' name='wersja' value='" . $_POST['wersja'] . "' style='float: right; width: 220px;'>";
	}else{
	echo "Wersja: <input type='text' name='wersja'  style='float: right; width: 220px;'>";
	}
	
	echo "<br><br>";
	echo "Opis: <br>";
	
	if($_POST['opis'] != ""){
	echo "<textarea name='opis' style='width: 300px; height: 200px;'>" . $_POST['opis'] . "</textarea>";	
	}else{
	echo "<textarea name='opis' style='width: 300px; height: 200px;' onclick='this.focus();this.select()'>Tu dodaj opis programu</textarea>";
	}
	
	echo "<br><br>";

	echo "Program:";
	echo "<input type='hidden' name='MAX_FILE_SIZE' value='512000' />";
	echo "<input type='file' name='nazwa_pliku' />";
	 
	echo "<br><br>"; 
	
	echo "Dokumentacja:";
	echo "<input type='hidden' name='MAX_FILE_SIZE' value='512000' />";
	echo "<input type='file' name='nazwa_pliku_2' />";

	echo "<br><br>";


echo "<input type='submit' name='button1'  value='DODAJ' style='width: 300px; height: 40px;'>";
echo "</form>";

echo "</center>";
echo "</div>";

$data = date("d.n.o - G:i");

if (isset($_POST['button1'])){

   //echo "MARKA: " . $_POST['marka'] . "<br>";
   //echo "MODEL: " . $_POST['model'] . "<br>";
   //echo "TYP: " . $_POST['typ'] . "<br>";
   //echo "PROGRAMISTA: " . $_POST['programista'] . "<br>";
   //echo "Wersja: " . $_POST['wersja']. "<br>";
   //echo "OPIS: " . $_POST['opis'] . "<br>";
   //echo "Program: " . $_FILES['nazwa_pliku']['name']. "<br>";
   //echo "Dokumentacja: " . $_FILES['nazwa_pliku_2']['name']. "<br>";
   
   //echo "POPRAWNOSC PROGRAMU: " . sprawdz_bledy(); //jak zwraca true to jest ok;
   //echo "POPRAWNOSC DOKUMENTACJI: " . sprawdz_bledy_2();
   
   if (($_POST['model']!="select") 
   and ($_POST['typ']!="select") 
   and ($_POST['programista']!="select") 
   and ($_POST['wersja']!="") 
   and ($_POST['opis']!="Tu dodaj opis programu")
   and ($_FILES['nazwa_pliku']['name']!="")
   and ($_FILES['nazwa_pliku_2']['name']!="")
   and (sprawdz_bledy() == 1)
   and (sprawdz_bledy_2() == 1)){
   
   if(sprawdz_bledy() == 1){
   zapisz_plik();
   }

    if(sprawdz_bledy_2() == 1){
   zapisz_plik_2();
   }
   
   	$zapytanie="INSERT INTO programy (id, id_sterownika, id_typu, id_programisty, wersja, data, opis, pobierz, dokumentacja) 
	VALUES ('', '".$_POST['model']."', '".$_POST['typ']."', '".$_POST['programista']."', '".mysql_real_escape_string($_POST['wersja'])."', '" . $data . "' , '".mysql_real_escape_string($_POST['opis'])."', '" . $_FILES['nazwa_pliku']['name'] . "', '" . $_FILES['nazwa_pliku_2']['name'] . "')";
	$wykonaj=mysql_query($zapytanie); 
   //echo $zapytanie;
   
   echo "<script>";
   echo "alert('Program dodano pomyślnie');";
   echo "</script>";
   

   
   }else{
   
   echo "<script>";
   echo "alert('Wystąpił błąd (Musisz wypełnić wszystkie pola i wybrać załącznik)');";
   echo "</script>";
   
   }
   
  }
  
  }else{
  echo "Brak dostepu";
  }

?>



</body>
</html>