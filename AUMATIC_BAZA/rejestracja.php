<?php session_start();
      require_once('db.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>Zarejestruj się</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
</head>

<body>
  
  <script type="text/javascript">
// <![CDATA[
function usun_pl(formularz)
{
	for (i = 0; i < formularz.length; i++)
	{
		var pole = formularz.elements[i];
		if (pole.type != "text" && pole.type != "textarea") continue;
		var str = "";
		for (j = 0; j < pole.value.length; j++)
		{
			switch (pole.value.charAt(j))
			{
				case "ą": str += "a"; break;
				case "ć": str += "c"; break;
				case "ę": str += "e"; break;
				case "ł": str += "l"; break;
				case "ń": str += "n"; break;
				case "ó": str += "o"; break;
				case "ś": str += "s"; break;
				case "ź": str += "z"; break;
				case "ż": str += "z"; break;
				case "Ą": str += "A"; break;
				case "Ć": str += "C"; break;
				case "Ę": str += "E"; break;
				case "Ł": str += "L"; break;
				case "Ń": str += "N"; break;
				case "Ó": str += "O"; break;
				case "Ś": str += "S"; break;
				case "Ź": str += "Z"; break;
				case "Ż": str += "Z"; break;
				default: str += pole.value.charAt(j); break;
			}
		}
		pole.value = str;
	}
}
// ]]>
</script>
  
		<center>
		
		<div style="font-size: 80px;">Zarejestruj się w Aumatic database</div>
		
		<div style="float: left;"><font size='7'><a href='index.php'><--Wróć</a></div></font>
		<br><br>
		
		<div style="width: 400px; height:350px; background: #f0f0f0; text-align: left;">
		<font size="7">ZAREJESTRUJ SIĘ</font><br><br>
      <form name="form-rejestracja" action="rejestracja.php" method="post" onsubmit="usun_pl(this)">
          Imie: <input type="text" name="imie" style="width: 300px; float: right;"/><br><br>
          Nazwisko: <input type="text" name="nazwisko" style="width: 300px; float: right";/><br><br>
          E-mail: <input type="text" name="mail" style="width: 300px; float: right;"/><br><br>
          Login: <input type="text" name="login_reje" style="width: 300px; float: right;"/><br><br>
          Hasło: <input type="password" name="haslo_reje" style="width: 300px; float: right;"/><br><br>
          <input type="submit" name="zarejestruj" value="Zarejestruj" style="width: 400px; height: 50px"/>
      </form>
		</div>
		
		</center>
		
		<?php
		if (isset($_POST['zarejestruj'])){
		
		
		
		if(($_POST['imie']!="") and ($_POST['nazwisko']!="") and ($_POST['mail']!="") and ($_POST['login_reje']!="") and ($_POST['haslo_reje']!="")){
		
		if (mysql_num_rows(mysql_query("SELECT * FROM `uzytkownicy` WHERE `login` = '" . $_POST['login_reje'] . "'")) == 0){
		$zapytanie="INSERT INTO kandydaci (id, imie, nazwisko, mail, login, haslo) 
		VALUES ('', '"
		. mysql_real_escape_string($_POST['imie'])."', '"
		. mysql_real_escape_string($_POST['nazwisko'])."', '"
		. mysql_real_escape_string($_POST['mail'])."', '"
		. mysql_real_escape_string($_POST['login_reje'])."', '"
		. str_rot13(md5($_POST['haslo_reje']))."')";
		$wykonaj=mysql_query($zapytanie); 
				
		echo "<script>";
		echo "alert('Zgloszenie przyjete, czekaj na zatwierdzenie przez admina');";
		echo "</script>";
		}else{
			echo "<script>";
			echo "alert('Twój login już jest zajęty');";
			echo "</script>";
		}
		
		
		}else{
			echo "<script>";
			echo "alert('Nie podales wszystkiego');";
			echo "</script>";
			}	
		}
		

		?>
		

  
  
</body>
  
</html>
