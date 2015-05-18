<?php
include('databaseverbinding.php');
if (isset($_GET['tabel'])){
  $tabel = $_GET['tabel'];
}
else {
  $tabel = 'klanten';
}
$kolommen = $db->query("SHOW COLUMNS FROM $tabel");
$records = $db->query("SELECT * FROM $tabel ORDER BY ID DESC");
$i = 0;
while ($rij = mysqli_fetch_array($kolommen)) {
  $rij['Field'] = ucfirst($rij['Field']);
  $csv_output .= $rij['Field']."; ";
  $i++;
}
$csv_output .= "\n";
while ($rijen = mysqli_fetch_row($records)) {
  for ($j = 0; $j < $i; $j++) {
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