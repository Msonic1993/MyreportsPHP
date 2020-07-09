<?php

session_start();

// do³¹czenie plików funkcji tej aplikacji
require_once('funkcje_zakladki.php');

// pocz¹tek wyœwietlania HTML
tworz_naglowek_html('Dodawanie zak³adek');

sprawdz_prawid_uzyt();
wyswietl_dodaj_zak_form();

wyswietl_menu_uzyt();
tworz_stopke_html();

?>

