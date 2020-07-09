<?php
 session_start();

 require_once('funkcje_zakladki.php');

  // utworzenie krótkiej nazwy zmiennej
  $nowy_url = $_POST['nowy_url'];

  tworz_naglowek_html('Dodawanie zak³adek');

  try {
    sprawdz_prawid_uzyt();
    if (!wypelniony($_POST)) {
    throw new Exception('Formularz wype³niony niew³aœciwie. Proszê spróbowaæ ponownie.');
    }
    // sprawdzenie formatu URL-a
    if (strstr($nowy_url, 'http://') === false) {
       $nowy_url = 'http://'.$nowy_url;
    }

    // sprawdzenie prawid³owoœci URL-a
    if (!(@fopen($nowy_url, 'r'))) {
       throw new Exception('URL nieprawid³owy.');
    }

    // próba dodania zak³adki
    dodaj_zak($nowy_url);
    echo 'Zak³adka dodana.';

    // pobranie zak³adek zapisanych przez u¿ytkownika
    if ($tablica_urli = pobierz_urle_uzyt($_SESSION['prawid_uzyt'])) {
        wyswietl_urle_uzyt($tablica_url);
    }
  }
  catch (Exception $e) {
    echo $e->getMessage();
  }
  wyswietl_menu_uzyt();
  tworz_stopke_html();
?>