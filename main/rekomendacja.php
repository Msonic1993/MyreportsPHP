<?php
  session_start();
  require_once('funkcje_zakladki.php');
  tworz_naglowek_html('Rekomendacja URL-i');
  try {
    sprawdz_prawid_uzyt();
    $urle = rekomenduj_urle($_SESSION['prawid_uzyt']);
    wyswietl_rekomend_urle($urle);
  }
  catch (Exception $e) {
    $e->getMessage();
  }
  wyswietl_menu_uzyt();
  tworz_stopke_html();
?>
