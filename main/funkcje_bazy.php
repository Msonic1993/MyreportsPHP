<?php

function lacz_bd() {

  $servername = ".hekko.net.pl";
  $username = "";
  $password = "";
  $base = "sancrow_";

  // Create connection
  $wynik = new mysqli($servername, $username, $password, $base);
   if (!$wynik) {
      throw new Exception('Po��czenie z serwerem bazy danych nie powiod�o si�');
   } else {
      return $wynik;
   }
}

?>
