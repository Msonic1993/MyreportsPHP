<?php
  session_start();
  require_once('funkcje_zakladki.php');
  tworz_naglowek_html('Zmiana has³a');

  // utworzenie krótkich nazw zmiennych
  $stare_haslo = $_POST['stare_haslo'];
  $nowe_haslo = $_POST['nowe_haslo'];
  $nowe_haslo2 = $_POST['nowe_haslo2'];


 try {
   sprawdz_prawid_uzyt();
    if (!wypelniony($_POST)) {
       throw new Exception('Formularz nie zosta³ wype³niony ca³kowicie. Proszê spróbowaæ ponownie.');
    }

    if ($nowe_haslo != $nowe_haslo2) {
       throw new Exception('Wprowadzone has³a nie s¹ identyczne. Has³o nie zosta³o zmienione.');
    }

    if ((strlen($nowe_haslo) > 16) || (strlen($nowe_haslo) < 6)) {
       throw new Exception('Nowe has³o musi mieæ d³ugoœæ co najmniej 6 i maksymalnie 16 znaków. Proszê spróbowaæ ponownie.');
    }

    // próba uaktualnienia
    zmien_haslo($_SESSION['prawid_uzyt'], $stare_haslo, $nowe_haslo);
    echo 'Has³o zmienione.';
 }
 catch (Exception $e) {
    echo $e->getMessage();
 }
 wyswietl_menu_uzyt();
 tworz_stopke_html();
?>