<?php
  /*Połączenie z bazą danych*/
  $dbhost = 'localhost'; 	
  $dblogin = 'root';
  $dbpass = '123';
  $dbselect = 'aumatic';
  mysql_connect($dbhost,$dblogin,$dbpass);
  mysql_select_db($dbselect) or die("Błąd przy wyborze bazy danych");
  mysql_query("SET CHARACTER SET UTF8");
  
?>