<?php
/*
$db = new mysqli('localhost', 'root', '', 'northwind');
if($db->connect_errno > 0){
  die('Verbinding maken met de database is mislukt. [' . $db->connect_error . ']');
}
*/
$db = new PDO('mysql:host=localhost;dbname=northwind', 'root', '');

//$db->set_charset("utf8");
$db->exec("SET CHARACTER SET utf8");


if (isset($_GET['tabel'])){
  $tabel = $_GET['tabel'];
}
else {
  $tabel = 'employees';
}
$kolommen = $db->query("SHOW COLUMNS FROM $tabel");
$records = $db->query("SELECT * FROM $tabel ORDER BY LastName ASC");

$i = 0;

//while ($rij = mysqli_fetch_array($kolommen)) {
while ($rij = $kolommen->fetch(PDO::FETCH_ASSOC)) {
  $rij['Field'] = ucfirst($rij['Field']);
  $csv_output .= $rij['Field']."; ";
  $i++;
}

$csv_output .= "\n";

//while ($rijen = mysqli_fetch_row($records)) {
while ($rijen = $records->fetch(PDO::FETCH_NUM)) {
  for ($j = 0; $j < $i; $j++) {
	  $rijen[$j] = str_replace("'", "\'", $rijen[$j]); 
    $rijen[$j] = str_replace("\r\n", " ", $rijen[$j]); 
    $csv_output .= $rijen[$j]."; ";
  }
  $csv_output .= "\n";
}
$bestand = $tabel."_".date("d-m-Y");
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("d-m-Y") . ".csv");
header( "Content-disposition: filename=".$bestand.".csv");
print $csv_output;
exit;
?>