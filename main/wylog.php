<?php

session_start();
// do��czenie plik�w funkcji tej aplikacji
require_once('funkcje_zakladki.php');
$stary_uzyt = $_SESSION['prawid_uzyt'];

// przechowanie do sprawdzenia, czy logowanie wyst�pi�o
unset($_SESSION['prawid_uzyt']);
$wynik_niszcz = session_destroy();

// pocz�tek wy�wietlania html
tworz_naglowek_html('Wylogowanie');

if (!empty($stary_uzyt)) {
  if ($wynik_niszcz) {
    // je�eli u�ytkownik zalogowany i nie wylogowany
    echo 'Wylogowano.<br />';
    tworz_HTML_URL('logowanie.php', 'Logowanie');
  } else {
   // u�ytkownik zalogowany i wylogowanie niemo�liwe
    echo 'Wylogowanie niemo�liwe.<br />';
  }
} else {
  // je�eli brak zalogowania, lecz w jaki� spos�b uzyskany dost�p do strony
  echo 'U�ytkownik niezalogowany, tak wi�c brak wylogowania.<br />';
  tworz_HTML_URL('logowanie.php', 'Logowanie');
}

tworz_stopke_html();

?>
