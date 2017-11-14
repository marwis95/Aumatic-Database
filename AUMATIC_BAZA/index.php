<?php session_start();
      require_once('db.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>Witamy w Aumatic Database</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
</head>

<body>
  
  <?php
    /* jeżeli nie wypełniono formularza - to znaczy nie istnieje zmienna login, hasło i sesja auth
     * to wyświetl formularz logowania
     */
    if (!isset($_POST['login']) && !isset($_POST['haslo']) && $_SESSION['auth'] == FALSE) {
  ?>
		<center>
		
		<div style="font-size: 80px;">Witamy w Aumatic database</div>
		
		<div style="width: 300px; height:200px; background: #f0f0f0; text-align: left;">
		<font size="7">ZALOGUJ SIĘ</font><br><br>
      <form name="form-logowanie" action="index.php" method="post" >
          Login: <input type="text" name="login" autocomplete="off" style="width: 250px; float: right;"/><br><br>
          Hasło: <input type="text" id="passfld" autocomplete="off" name="haslo" style="width: 250px; float: right;"/><br><br>
          <input type="submit" name="zaloguj" value="Zaloguj" style="width: 300px"/>
      </form>
		</div>
		
		<br><br>
		
		<a href='rejestracja.php'>-->REJESTRACJA<--</a>
		
		</center>
		
<script type="text/javascript">

// or in pure javascript
 window.onload=function(){                                              
    setTimeout(function(){  
        document.getElementById('passfld').type = 'password';
    },10);
  }   
</script>
		
  <?php
  }
    /* jeżeli istnieje zmienna login oraz haslo i sesja z autoryzacją użytkownika jest FALSE to wykonaj
     * skrypt logowania
     */
	elseif (isset($_POST['login']) && isset($_POST['haslo']) && $_SESSION['auth'] == FALSE) {
      
        // jeżeli pole z loginem i hasłem nie jest puste      
		if (!empty($_POST['login']) && !empty($_POST['haslo'])) {
          
		// dodaje znaki unikowe dla potrzeb poleceń SQL
		$login = mysql_real_escape_string($_POST['login']);
		$haslo = mysql_real_escape_string($_POST['haslo']);
        
        // szyfruję wpisane hasło za pomocą funkcji md5()
        $haslo = str_rot13(md5($haslo));
		
        /* zapytanie do bazy danych
         * mysql_num_rows - sprawdzam ile wierszy odpowiada zapytaniu mysql_query
         * mysql_query - pobierz wszystkie dane z tabeli user gdzie login i hasło odpowiadają wpisanym danym
         */
		$sql = mysql_num_rows(mysql_query("SELECT * FROM `uzytkownicy` WHERE `login` = '$login' AND `haslo` = '$haslo' AND `block` = '0'"));
		
			// jeżeli powyższe zapytanie zwraca 1, to znaczy, że dane zostały wpisane poprawnie i rejestruję sesję
			if ($sql == 1) {
              
                // zmienne sesysje user (z loginem zalogowanego użytkownika) oraz sesja autoryzacyjna ustawiona na TRUE
				$_SESSION['user'] = $login;
				$_SESSION['auth'] = TRUE;
                
                // przekierwuję użytkownika na stronę z ukrytymi informacjami
				echo '<meta http-equiv="refresh" content="1; URL=hide.php">';
				echo '<p style="padding-top:10px";><strong>Proszę czekać...</strong><br />trwa logowanie i wczytywanie danych</p>';
			}
            
            // jeżeli zapytanie nie zwróci 1, to wyświetlam komunikat o błędzie podczas logowania
			else {
				echo '<p style="padding-top:10px;color:red";>Błąd podczas logowania do systemu<br />';
				echo '<a href="index.php">Wróć do formularza</a></p>';
			}
		}
        
        // jeżeli pole login lub hasło nie zostało uzupełnione wyświetlam błąd
		else {
			echo '<p style="padding-top:10px;color:red";>Błąd podczas logowania do systemu<br />';
			echo '<a href="index.php">Wróć do formularza</a></p>';	
		}
	}
    
    // jeżeli sesja auth jest TRUE to przekieruj na ukrytą podstronę
	elseif ($_SESSION['auth'] == TRUE && !isset($_GET['logout'])) {
		echo '<meta http-equiv="refresh" content="1; URL=hide.php">';
		echo '<p style="padding-top:10px"><strong>Proszę czekać...</strong><br />trwa wczytywanie danych</p>';
	}
    
    // wyloguj się
	elseif ($_SESSION['auth'] == TRUE && isset($_GET['logout'])) {
		$_SESSION['user'] = '';
		$_SESSION['auth'] = FALSE;
		echo '<meta http-equiv="refresh" content="1; URL=index.php">';
		echo '<p style="padding-top:10px"><strong>Proszę czekać...</strong><br />trwa wylogowywanie</p>';
	}
  ?>
  
</body>
  
</html>
