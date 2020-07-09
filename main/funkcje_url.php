<?php
require_once('funkcje_bazy.php');

function pobierz_urle_uzyt($nazwa_uz) {
  // pobranie z bazy danych wszystkich URL-i danego u¿ytkownika
  $lacz = lacz_bd();
  $wynik = $lacz->query("select URL_zak
                         from zakladka
                         where nazwa_uz = '".$nazwa_uz."'");
  if (!$wynik) {
    return false;
  }

  // tworzenie tablicy URL-i
  $tablica_url = array();
  for ($licznik = 0; $rzad = $wynik->fetch_row(); ++$licznik) {
    $tablica_url[$licznik] = $rzad[0];
  }
  return $tablica_url;
}

function dodaj_zak($nowy_url) {
  // dodawanie nowych zak³adek do bazy danych

  echo "Próba dodania ".htmlspecialchars($nowy_url)."<br />";
  $prawid_uzyt = $_SESSION['prawid_uzyt'];

  $lacz = lacz_bd();

  // sprawdzenie, czy zak³adka ju¿ istnieje
  $wynik = $lacz->query("select * from zakladka
                         where nazwa_uz='$prawid_uz'
                         and URL_zak='".$nowy_url."'");
  if ($wynik && ($wynik->num_rows>0)) {
    throw new Exception('Zak³adka ju¿ istnieje.');
  }

  // umieszczenie nowej zakladki
  if (!$lacz->query("insert into zakladka values
                     ('".$prawid_uzyt."', '".$nowy_url."')")) {
    throw new Exception('Wstawienie nowej zak³adki nie powiod³o siê');
  }

  return true;
}

function usun_zak($uzytkownik, $url) {
  // usuniêcie jednego URL-a z bazy danych
  $lacz = lacz_bd();
   // usuniêcie zak³adki
  if (!$lacz->query("delete from zakladka
                     where nazwa_uz='".$uzytkownik."' and URL_zak='".$url."'")) {
    throw new Exception('Usuniêcie zak³adki nie powiod³o siê.');
  }
  return true;
}

function rekomenduj_urle($prawid_uzyt, $popularnosc = 1) {
  // tworzenie pó³inteligentnych rekomendacji
  // Je¿eli posiadaj¹ URL-e wspólne z innymi u¿ytkownikami, mog¹ im siê
  // spodobaæ inne URL-e, które lubi¹ inni
  $lacz = lacz_bd();

  // znalezienie innych pasuj¹cych u¿ytkowników
  // z podobnymi URL-ami
  // jako prosty sposób wy³¹czania prywatnych stron u¿ytkowników oraz
  // zwiêkszania szansy rekomendacji wartoœciowego URL
  // podany jest minimalny poziom popularnoœci
  // je¿eli $popularnosc=1, wtedy wiêcej ni¿ jedna osoba musi posiadaæ
  // dany URL przed jego rekomendacj¹

  $zapytanie = "select URL_zak
                from zakladka
                where nazwa_uz in
                                 (select distinct(z2.nazwa_uz)
                                  from zakladka z1, zakladka z2
                                  where z1.nazwa_uz='".$prawid_uzyt."'
                                  and z1.nazwa_uz!=z2.nazwa_uz)
                and URL_zak not in
                                 (select URL_zak
                                  from zakladka
                                  where nazwa_uz='".$prawid_uzyt."')
                group by URL_zak
                having count(URL_zak)>".$popularnosc;

  if (!($wynik = $lacz->query($zapytanie))) {
     throw new Exception('Nie znaleziono ¿adnych rekomendowanych zak³adek.');
  }
  if ($wynik->num_rows==0) {
     throw new Exception('Nie znaleziono ¿adnych rekomendowanych zak³adek.');
  }

  $urle = array();
  // stworzenie tablicy odpowiednich URL-i
  for ($licznik=0; $rzad = $wynik->fetch_object(); $licznik++) {
     $urle[$licznik] = $rzad->URL_zak;
  }

  return $urle;
}
?>
