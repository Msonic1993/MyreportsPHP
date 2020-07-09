<?php
  session_start();
  require_once('funkcje_zakladki.php');

  //create short variable names
  $usun_mnie = $_POST['usun_mnie'];
  $prawid_uzyt = $_SESSION['prawid_uzyt'];

  tworz_naglowek_html('Usuwanie zak³adek');
  sprawdz_prawid_uzyt();
  if (!wypelniony($_POST)) {
    echo '<p>Nie wybrane zosta³y ¿adne zak³adki do usuniêcia.<br/>
          Proszê spróbowaæ ponownie.</p>';
    wyswietl_menu_uzyt();
    tworz_stopke_html();
    exit;
  } else {
    if (count($usun_mnie) > 0) {
      foreach($usun_mnie as $url) {
        if (usun_zak($prawid_uzyt, $url)) {
          echo 'Usuniêto '.htmlspecialchars($url).'.<br />';
        } else {
          echo 'Nie uda³o siê usuniêcie '.htmlspecialchars($url).'.<br />';
        }
      }
    } else {
      echo 'Nie wybrano ¿adnych zak³adek do usuniêcia';
    }
  }
  // odczytanie zak³adek u¿ytkownika
  if ($tablica_url = pobierz_urle_uzyt($prawid_uzyt)) {
    wyswietl_urle_uzyt($tablica_url);
  }

  wyswietl_menu_uzyt();
  tworz_stopke_html();
?>