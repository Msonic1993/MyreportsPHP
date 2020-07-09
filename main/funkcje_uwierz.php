<?php

require_once('funkcje_bazy.php');

function rejestruj($nazwa_uz, $email, $haslo) {
// zarejestrowanie nowej osoby w bazie danych
// zwraca true lub komunikat o b³êdzie

 // po³¹czenie z baz¹ danych
  $lacz = lacz_bd();

  // sprawdzenie, czy nazwa u¿ytkownika nie powtarza siê
  $wynik = $lacz->query("select * from uzytkownik where nazwa_uz='".$nazwa_uz."'");
  if (!$wynik) {
     throw new Exception('Wykonanie zapytania nie powiod³o siê.');
  }

  if ($lacz->num_rows>0) {
     throw new Exception('Nazwa u¿ytkownika zajêta — proszê wróciæ i wybraæ inn¹.');
  }

  // je¿eli wszystko w porz¹dku, umieszczenie w bazie danych
  $wynik = $lacz->query("insert into uzytkownik values
                       ('".$nazwa_uz."', sha1('".$haslo."'), '".$email."')");
  if (!$wynik) {
    throw new Exception('Rejestracja w bazie danych niemo¿liwa — proszê spróbowaæ póŸniej.');
  }

  return true;
}

function loguj($nazwa_uz, $haslo) {
// sprawdzenie nazwy u¿ytkownika i has³a w bazie danych
// je¿eli siê zgadza, zwraca true
// je¿eli nie, wyrzuca wyj¹tek

  // po³¹czenie z baz¹ danych
  $lacz = lacz_bd();

  // sprawdzenie unikatowoœci nazwy u¿ytkownika
  $wynik = $lacz->query("select * from uzytkownik
                         where nazwa_uz='".$nazwa_uz."'
                         and haslo = sha1('".$haslo."')");
  if (!$wynik) {
     throw new Exception('Logowanie nie powiod³o siê.');
  }

  if ($wynik->num_rows>0) {
     return true;
  } else {
     throw new Exception('Logowanie nie powiod³o siê.');
  }
}

function sprawdz_prawid_uzyt() {
// sprawdzenie czy u¿ytkownik jest zalogowany i powiadomienie go je¿eli nie
  if (isset($_SESSION['prawid_uzyt'])) {
      echo "Zalogowano jako ".$_SESSION['prawid_uzyt'].".<br />";
  } else {
     // nie jest zalogowany
     tworz_naglowek_html('Problem:');
     echo 'Brak zalogowania.<br />';
     tworz_HTML_URL('logowanie.php', 'Logowanie');
     tworz_stopke_html();
     exit;
  }
}

function zmien_haslo($nazwa_uz, $stare_haslo, $nowe_haslo) {
// zmiana has³a u¿ytkownika ze stare_haslo na nowe_haslo
// zwraca true lub false

  // je¿eli stare has³o jest prawid³owe zmiana nowe_haslo i zwrócenie true
  // w przeciwnym wypadku wyrzucenie wyj¹tku
  loguj($nazwa_uz, $stare_haslo);
  $lacz = lacz_bd();
  $wynik = $lacz->query("update uzytkownik
                         set haslo = sha1('".$nowe_haslo."')
                         where nazwa_uz = '".$nazwa_uz."'");
  if (!$wynik) {
    throw new Exception('Zmiana has³a nie powiod³a siê.');
  } else {
    return true;  // zmiana udana
  }
}

function pobierz_losowe_slowo($dlugosc_min, $dlugosc_max) {
//pobranie losowego s³owa ze s³ownika o okreœlonej d³ugoœci zwrócenie go

  // generowanie losowego s³owa
  $slowo = '';
  // tê œcie¿kê nale¿y dostosowaæ do ustawieñ w³asnego systemu
  $slownik = '/usr/dict/words';  // s³ownik ispell
  $wp = @fopen($slownik, 'r');
  if(!$wp) {
    return false;
  }
  $wielkosc = filesize($slownik);

  // przejœcie do losowej pozycji w s³owniku
  $losowa_pozycja = rand(0, $wielkosc);
  fseek($wp, $losowa_pozycja);

  // pobranie ze s³ownika nastêpnego pe³nego s³owa o w³aœciwej d³ugoœci
  while ((strlen($slowo) < $dlugosc_min) || (strlen($slowo)>$dlugosc_max) || strstr($slowo, "'")) {
     if (feof($wp)) {
        fseek($wp, 0);        // je¿eli koniec pliku, przeskocz na pocz¹tek
     }
     $slowo = fgets($wp, 80);  // przeskoczenie pierwszego s³owa bo mo¿e byæ niepe³ne
     $slowo = fgets($wp, 80);  // potencjalne has³o
  }
  $slowo = trim($slowo); // obciêcie pocz¹tkowego \n z funkcji fgets
  return $slowo;
}

function ustaw_haslo($nazwa_uz) {
// ustawienie has³a u¿ytkownika na losow¹ wartoœæ
// zwraca nowe has³o lub false w przypadku niepowodzenia

  // pobranie losowego s³owa ze s³ownika o d³ugoœci pomiêdzy 6 i 13 znaków
  $nowe_haslo = pobierz_losowe_slowo(6, 13);

  if($nowe_haslo == false) {
    throw new Exception('Wygenerowanie nowego has³a nie powiod³o siê.');
  }

  // dodanie liczby pomiêdzy 0 i 999 w celu stworzenia lepszego has³a
  $losowa_liczba = rand(0, 999);
  $nowe_haslo .= $losowa_liczba;

  // ustawienie nowego has³a w bazie danych lub zwrócenie false
  $lacz = lacz_bd();
      return false;
  $wynik = $lacz->query("update uzytkownik
                         set haslo = sha1('".$nowe_haslo."')
                         where nazwa_uz = '".$nazwa_uz."'");
  if (!$wynik) {
    throw new Exception('Zmiana has³a nie powiod³a siê.');  // has³o nie zmienione
  } else {
    return $nowe_haslo;  // has³o zmienione pomyœlnie
  }
}

function powiadom_haslo($nazwa_uz, $haslo) {
// powiadomienie u¿ytkownika o zmianie has³a

    $lacz = lacz_bd();
    $wynik = $lacz->query("select email from uzytkownik
                           where nazwa_uz='".$nazwa_uz."'");
    if (!$wynik) {
      throw new Exception('Nie znaleziono adresu e-mail');
    } else if ($wynik->num_rows == 0) {
      throw new Exception('Nie znaleziono adresu e-mail'); // nazwy u¿ytkownika nie ma w bazie danych
    } else {
      $wiersz = $wynik->fetch_object();
      $email = $wiersz->email;
      $od = "From: obsluga@zakladkaphp \r\n";
      $wiad = "Has³o systemu Zak³adkaPHP zosta³o zmienione na $haslo \r\n"
              ."Proszê zmieniæ je przy nastêpnym logowaniu. \r\n";


      if (mail($email, 'Informacja o logowaniu Zak³adkaPHP', $wiad, $od)) {
        return true;
      } else {
        throw new Exception('Wys³anie e-maila nie powiod³o siê');
      }
    }
}

?>