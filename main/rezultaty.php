<html>
<head>
<title> "Wyniki dla towjego zapytania" </title>
</head>

<body>

<h1> Oto rezultaty wyszukiwania: </h1>

<?php
// utowrzenie krotkich nazw zmiennych
$metoda_szukania=$_POST['metoda_szukania'];
$wyrazenie=$_POST['wyrazenie1'];

$wyrazenie1 = ($wyrazenie);

if (!$metoda_szukania || !$wyrazenie) {
	echo 'Brak parametrów wyszukiwania. Wróć do poprzedniej strony i spróbuj ponownie. ';
	exit;
}
echo ($wyrazenie);
$zapytanie = "SELECT * FROM `sancrow_znanylekarz`.`Sprzedaz` WHERE NAME like '%$wyrazenie%'";

if (!get_magic_quotes_gpc()) {
	$metoda_szukania = addcslashes($metoda_szukania);
	$wyrazenie = addcslashes($wyrazenie);
}
$servername = "s27.hekko.net.pl";
$username = "sancrow_znanylekarz";
$password = "1Ketiow1";
$base = "sancrow_znanylekarz";

// Create connection
@ $db = new mysqli($servername, $username, $password, $base);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
echo " Connected successfully ";

echo ($wyrazenie);

$wynik = $db->query($zapytanie);

$ile_znalezionych = $wynik->num_rows;

echo "<p> Ilość znalezionych pozycji: ".$ile_znalezionych."</p>";

echo "<table>";
echo "<th>".($i+1).". Kod produktu </th>";
echo "<th> Nazwa produktu </th>";
echo "<th> Zakup </th>";
echo "<th> sprzedaż </th>";
echo "<th> Stan </th>";
echo "<th> Data sprzedaży </th>";

for ($i=0; $i <$ile_znalezionych; $i++) {
	$wiersz = $wynik->fetch_assoc();

echo "<tr><td>".$wiersz['SKU_CODE']."</td><td>".$wiersz['NAME']."</td><td>".$wiersz['SELLIN']."</td><td>".$wiersz['SELLOUT']."</td><td>".$wiersz['STOCK']."</td><td>".$wiersz['DATE']."</td></tr>";


}
echo "</table>";
$wynik->free();
$db->close();

?>


</body>
</html>
