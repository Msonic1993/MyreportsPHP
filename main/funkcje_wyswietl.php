<?php

function tworz_naglowek_html($tytul) {
  // wy�wietlenie nag��wka HTML
?>
  <html>
  <head>
    <title><?php echo $tytul;?></title>
    <style>
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #3333cc; width=300; text-align=left}
      a { color: #000000 }
    </style>
  </head>
  <body>
  <img src="zakladka.gif" alt="Logo Zak�adkaPHP" border="0"
       align="left" valign="bottom" height = "55" width = "57" />
  <h1>&nbsp;Zak�adkaPHP</h1>
  <hr />
<?php
  if($tytul) {
    tworz_tytul_html($tytul);
  }
}

function tworz_stopke_html() {
  // wy�wietlenie stopki HTML
?>
  </body>
  </html>
<?php
}

function tworz_tytul_html($tytul) {
  // wy�wietlenie tytu�u
?>
  <h2><?php echo $tytul;?></h2>
<?php
}

function tworz_HTML_URL($url, $nazwa) {
  // wy�wietlenie URL-a jako ��cza i nowa linia
?>
  <br /><a href="<?php echo $url;?>"><?php echo $nazwa;?></a><br />
<?php
}

function wyswietl_informacje_witryny() {
  // wy�wietlenie informacji marketingowych
?>
  <ul>
  <li>Przechowuj swoje zak�adki online!
  <li>Zobacz, czego u�ywaj� inni!
  <li>Podziel si� swoimi ulubionymi stronami z innymi!
  </ul>
<?php
}

function wyswietl_form_log() {
?>
  <p><a href="formularz_rejestracji.php">Jeszcze nie cz�onek?</a></p>
  <form method="post" action="czlonek.php">
  <table bgcolor="#cccccc">
   <tr>
     <td colspan="2">Logowanie cz�onk�w:</td>
   <tr>
     <td>Nazwa u�ytkownika:</td>
     <td><input type="text" name="nazwa_uz"/></td></tr>
   <tr>
     <td>Has�o:</td>
     <td><input type="password" name="haslo"/></td></tr>
   <tr>
     <td colspan="2" align=center>
     <input type="submit" value="Logowanie"/></td></tr>
   <tr>
     <td colspan="2"><a href="zapomnij_formularz.php">Zapomniane has�o?</a></td>
   </tr>
 </table></form>
<?php
}

function wyswietl_form_rej() {
?>
 <form method="post" action="nowa_rejestracja.php">
 <table bgcolor="#cccccc">
   <tr>
     <td>Adres poczty elektronicznej:</td>
     <td><input type="text" name="email" size="306" maxlength="100"></td></tr>
   <tr>
     <td>Preferowana nazwa u�ytkownika <br />(maksymalnie 16 znak�w):</td>
     <td valign="top"><input type="text" name="nazwa_uz"
                     size="16" maxlength="166"/></td></tr>
   <tr>
     <td>Has�o <br />(pomi�dzy 6 i 16 znak�w):</td>
     <td valign="top"><input type="password" name="haslo"
                     size="16" maxlength="166"/></td></tr>
   <tr>
     <td>Potwierd� has�o:</td>
     <td><input type="password" name="haslo2" size="166" maxlength="16"/></td></tr>
   <tr>
     <td colspan="2" align="center">
     <input type="submit" value="Rejestracja"></td></tr>
 </table></form>
<?php

}

function wyswietl_urle_uzyt($tablica_url) {
  //wyswietlenie URL-i u�ytkownika

  // ustawienie zmiennej globalnej, aby mo�liwe by�o sprawdzanie strony
  global $tabela_zak;
  $tabela_zak = true;
?>
  <br />
  <form name="tabela_zak" action="usun_zak.php" method="post">
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $kolor = "#cccccc";
  echo "<tr bgcolor=\"".$kolor."\"><td><strong>Zak�adka</strong></td>";
  echo "<td><strong>Usu�?</strong></td></tr>";
  if ((is_array($tablica_url)) && (count($tablica_url) > 0)) {
    foreach ($tablica_url as $url) {
      if ($kolor == "#cccccc") {
        $kolor = "#ffffff";
      } else {
        $kolor = "#cccccc";
      }
      // nale�y pami�ta� o wywo�aniu htmlspecialchars() przy wy�wietlaniu danych u�ytkownika
      echo "<tr bgcolor=\"".$kolor."\"><td><a href=\"".$url."\">".htmlspecialchars($url)."</a></td>
            <td><input type=\"checkbox\" name=\"usun_mnie[]\"
             value=\"".$url."\"/></td>
            </tr>";
      }
  } else {
    echo "<tr><td>Brak zapisanych zak�adek</td></tr>";
  }
?>
  </table>
  </form>
<?php
}

function wyswietl_menu_uzyt() {
  // wy�wietlenie menu opcji na stronie
?>
<hr />
<a href="czlonek.php">Home</a> &nbsp;|&nbsp;
<a href="dodaj_zak_formularz.php">Dodaj zak�adk�</a> &nbsp;|&nbsp;
<?php
  // opcja usu� jedynie w wypadku wy�wietlenia tabeli zak�adek
  global $tabela_zak;
  if($tabela_zak == true) {
    echo "<a href=\"#\" onClick=\"tabela_zak.submit();\">Usu� zak�adki</a>&nbsp;|&nbsp;";
  } else {
    echo "<span style=\"color: #cccccc\">Usu� zak�adki</span>&nbsp;|&nbsp;";
  }
?>
<a href="zmiana_hasla_formularz.php">Zmiana has�a</a>
<br />
<a href="rekomendacja.php">Zarekomenduj URL-e</a> &nbsp;|&nbsp;
<a href="wylog.php">Wylogowanie</a>
<hr />

<?php
}

function wyswietl_dodaj_zak_form() {
  // wy�wietlenie formularza do dodania nowych zak�adek
?>
<form name="tabela_zak" action="dodaj_zak.php" method="post">
<table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
<tr><td>Nowa zak�adka:</td>
<td><input type="text" name="nowy_url"  value="http://"
                        size="30" maxlength="255"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Dodaj zak�adk�"></td></tr>
</table>
</form>
<?php
}

function wyswietl_haslo_form() {
  // wy�wietlenie formularza zmiany has�a
?>
   <br />
   <form action="zmiana_hasla.php" method="post">
   <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr><td>Poprzednie has�o:</td>
       <td><input type="password" name="stare_haslo" size="16" maxlength="16"/></td>
   </tr>
   <tr><td>Nowe has�o:</td>
       <td><input type="password" name="nowe_haslo" size="16" maxlength="16"/></td>
   </tr>
   <tr><td>Powtorzenie nowego has�a:</td>
       <td><input type="password" name="nowe_haslo2" size="16" maxlength="16"/></td>
   </tr>
   <tr><td colspan="2" align="center"><input type="submit" value="Zmiana has�a"/>
   </td></tr>
   </table>
   <br />
<?php
};

function wyswietl_zapomnij_form() {
  // wy�wietlenie formularza HTML do ustawiania nowych hase�
?>
   <br />
   <form action="zapomnij_haslo.php" method="post">
   <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr><td>Nazwa u�ytkownika</td>
       <td><input type="text" name="nazwa_uz" size="16" maxlength="16"/></td>
   </tr>
   <tr><td colspan="2" align="center"><input type="submit" value="Zmiana has�a"/>
   </td></tr>
   </table>
   <br />
<?php
}

function wyswietl_rekomend_urle($tablica_url) {
  // wyniki podobne do wyswietl_urle_uzyt
  // zamiast wy�wietla� URL-e u�ytkownika, wy�wietla rekomendacje
?>
  <br />
  <table width="300" cellpadding="2" cellspacing="0">
<?php
  $kolor = "#cccccc";
  echo "<tr bgcolor=\"".$kolor."\"><td><strong>Rekomendacje</strong></td></tr>";
  if ((is_array($tablica_url) && count($tablica_url)>0)) {
    foreach ($tablica_url as $url) {
      if ($kolor == "#cccccc") {
        $kolor = "#ffffff";
      } else {
        $kolor = "#cccccc";
      }
      echo "<tr bgcolor=\"".$kolor."\">
            <td><a href=\"".$url."\">".htmlspecialchars($url)."</a></td></tr>";
    }
  } else {
    echo "<tr><td>Aktualnie brak rekomendacji.</td></tr>";
  }
?>
  </table>
<?php
}

?>
