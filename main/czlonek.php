<?php

session_start();

// do³¹czenie plików funkcji tej aplikacji
require_once('funkcje_zakladki.php');

// utworzenie krótkich nazw zmiennych
$nazwa_uz = $_POST['nazwa_uz'];
$haslo = $_POST['haslo'];

if ($nazwa_uz && $haslo) {
// w³aœnie nast¹pi³a próba logowania
  try {
    loguj($nazwa_uz, $haslo);
    // je¿eli u¿ytkownik znajduje siê w bazie danych rejestracja identyfikatora
    $_SESSION['prawid_uzyt'] = $nazwa_uz;
  }
  catch (Exception $e) {
    // niepomyœlne logowanie
    tworz_naglowek_html('Problem:');
    echo 'Zalogowanie niemo¿liwe.
          Nale¿y byæ zalogowanym aby ogl¹daæ tê stronê.';
    tworz_HTML_URL('logowanie.php', 'Logowanie');
    tworz_stopke_html();
    exit;
  }
}

tworz_naglowek_html('Strona g³ówna');
sprawdz_prawid_uzyt();
// odczytanie zak³adek u¿ytkownika
if ($tablica_url = pobierz_urle_uzyt($_SESSION['prawid_uzyt'])) {
  wyswietl_urle_uzyt($tablica_url);
}

// tworzenie menu opcji
wyswietl_menu_uzyt();

tworz_stopke_html();
?>
