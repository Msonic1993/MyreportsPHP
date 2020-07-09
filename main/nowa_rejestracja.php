<?php

  // utworzenie krótkich nazw zmiennych
  $email=$_POST['email'];
  $nazwa_uz=$_POST['nazwa_uz'];
  $haslo=$_POST['haslo'];
  $haslo2=$_POST['haslo2'];

  // rozpoczêcie sesji, która mo¿e okazaæ siê konieczna póŸniej
  // rozpoczêcie w tym miejscu, musi ona zostaæ przekazana przed nag³ówkami
   session_start();

   // do³¹czenie plików funkcji tej aplikacji
   require_once('funkcje_zakladki.php');

   try {
     // sprawdzenia wype³nienia formularzy
     if (!wypelniony($_POST)) {
        throw new Exception('Formularz wype³niony nieprawid³owo — proszê wróciæ i spróbowaæ ponownie.');
     }

     // nieprawid³owy adres poczty elektronicznej
     if (!prawidlowy_email($email)) {
        throw new Exception('Nieprawid³owy adres poczty elektronicznej — proszê wróciæ i spróbowaæ ponownie.');
     }

     // ró¿ne has³a
     if ($haslo != $haslo2) {
        throw new Exception('Niepasuj¹ce do siebie has³a — proszê wróciæ i spróbowaæ ponownie.');
     }

     // sprawdzenie d³ugoœci nazwy u¿ytkownika
     if ((strlen($nazwa_uz) > 16) {
        throw new Exception('Nazwa uzytkownika nie mo¿e mieæ wiêcej ni¿ 16 znaków — proszê wróciæ i spróbowaæ ponownie.');
     }

     // sprawdzenie d³ugoœci has³a
     // nazwê u¿ytkownika mo¿na skróciæ, lecz zbyt d³ugiego
     // has³a skróciæ nie mo¿na
     if ((strlen($haslo) < 6) || (strlen($haslo) > 16)) {
        throw new Exception('Has³o musi mieæ co najmniej 6 i maksymalnie 16 znaków — proszê wróciæ i spróbowaæ ponownie.');
     }

     // próba zarejestrowania
     rejestruj($nazwa_uz, $email, $haslo);
     // rejestracja zmiennej sesji
     $_SESSION['prawid_uzyt'] = $nazwa_uz;


     // stworzenie ³¹cza do strony cz³onkowskiej
     tworz_naglowek_html('Rejestracja pomyœlna');
     echo 'Rejestracja zakoñczy³a siê sukcesem. Proszê udaæ siê na stronê '
         .'cz³onkowsk¹ aby skonfigurowaæ swoje zak³adki!';
     tworz_HTML_URL('czlonek.php', 'Strona cz³onkowska');

     // koniec strony
     tworz_stopke_html();
   }
   catch (Exception $e) {
     tworz_naglowek_html('Problem:');
     echo $e->getMessage();
     tworz_stopke_html();
     exit;
   }
?>