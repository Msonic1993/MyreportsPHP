<?php

  // utworzenie kr�tkich nazw zmiennych
  $email=$_POST['email'];
  $nazwa_uz=$_POST['nazwa_uz'];
  $haslo=$_POST['haslo'];
  $haslo2=$_POST['haslo2'];

  // rozpocz�cie sesji, kt�ra mo�e okaza� si� konieczna p�niej
  // rozpocz�cie w tym miejscu, musi ona zosta� przekazana przed nag��wkami
   session_start();

   // do��czenie plik�w funkcji tej aplikacji
   require_once('funkcje_zakladki.php');

   try {
     // sprawdzenia wype�nienia formularzy
     if (!wypelniony($_POST)) {
        throw new Exception('Formularz wype�niony nieprawid�owo � prosz� wr�ci� i spr�bowa� ponownie.');
     }

     // nieprawid�owy adres poczty elektronicznej
     if (!prawidlowy_email($email)) {
        throw new Exception('Nieprawid�owy adres poczty elektronicznej � prosz� wr�ci� i spr�bowa� ponownie.');
     }

     // r�ne has�a
     if ($haslo != $haslo2) {
        throw new Exception('Niepasuj�ce do siebie has�a � prosz� wr�ci� i spr�bowa� ponownie.');
     }

     // sprawdzenie d�ugo�ci nazwy u�ytkownika
     if ((strlen($nazwa_uz) > 16) {
        throw new Exception('Nazwa uzytkownika nie mo�e mie� wi�cej ni� 16 znak�w � prosz� wr�ci� i spr�bowa� ponownie.');
     }

     // sprawdzenie d�ugo�ci has�a
     // nazw� u�ytkownika mo�na skr�ci�, lecz zbyt d�ugiego
     // has�a skr�ci� nie mo�na
     if ((strlen($haslo) < 6) || (strlen($haslo) > 16)) {
        throw new Exception('Has�o musi mie� co najmniej 6 i maksymalnie 16 znak�w � prosz� wr�ci� i spr�bowa� ponownie.');
     }

     // pr�ba zarejestrowania
     rejestruj($nazwa_uz, $email, $haslo);
     // rejestracja zmiennej sesji
     $_SESSION['prawid_uzyt'] = $nazwa_uz;


     // stworzenie ��cza do strony cz�onkowskiej
     tworz_naglowek_html('Rejestracja pomy�lna');
     echo 'Rejestracja zako�czy�a si� sukcesem. Prosz� uda� si� na stron� '
         .'cz�onkowsk� aby skonfigurowa� swoje zak�adki!';
     tworz_HTML_URL('czlonek.php', 'Strona cz�onkowska');

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