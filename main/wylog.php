<?php

session_start();
// do³¹czenie plików funkcji tej aplikacji
require_once('funkcje_zakladki.php');
$stary_uzyt = $_SESSION['prawid_uzyt'];

// przechowanie do sprawdzenia, czy logowanie wyst¹pi³o
unset($_SESSION['prawid_uzyt']);
$wynik_niszcz = session_destroy();

// pocz¹tek wyœwietlania html
tworz_naglowek_html('Wylogowanie');

if (!empty($stary_uzyt)) {
  if ($wynik_niszcz) {
    // je¿eli u¿ytkownik zalogowany i nie wylogowany
    echo 'Wylogowano.<br />';
    tworz_HTML_URL('logowanie.php', 'Logowanie');
  } else {
   // u¿ytkownik zalogowany i wylogowanie niemo¿liwe
    echo 'Wylogowanie niemo¿liwe.<br />';
  }
} else {
  // je¿eli brak zalogowania, lecz w jakiœ sposób uzyskany dostêp do strony
  echo 'U¿ytkownik niezalogowany, tak wiêc brak wylogowania.<br />';
  tworz_HTML_URL('logowanie.php', 'Logowanie');
}

tworz_stopke_html();

?>
