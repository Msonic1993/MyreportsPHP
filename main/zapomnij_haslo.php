<?php
  require_once("funkcje_zakladki.php");
  tworz_naglowek_html("Ustawianie has³a");

  // utworzenie krótkiej nazwy zmiennej
  $nazwa_uz = $_POST['nazwa_uz'];

  try {
     $haslo=ustaw_haslo($nazwa_uz);
     powiadom_haslo($nazwa_uz, $haslo);
     echo 'Nowe has³o zosta³o przes³ane na adres poczty elektronicznej.<br />';
  }
  catch (Exception $e) {
     echo 'Has³o nie mog³o zostaæ ustawione. Proszê spróbowaæ póŸniej.';
  }
  tworz_HTML_URL('logowanie.php', 'Logowanie');
  tworz_stopke_html();
?>