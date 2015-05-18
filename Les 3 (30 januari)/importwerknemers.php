<?php
$db = new mysqli('localhost', 'root', '', 'bootstrap');
if($db->connect_errno > 0){
  die('Verbinding maken met de database is mislukt. [' . $db->connect_error . ']');
}
$db->set_charset("utf8");

$tabel = 'werknemers';
$bestand = 'employees.csv';
$db->query("DROP TABLE IF EXISTS $tabel");
$db->query("CREATE TABLE $tabel (naam varchar(50) NOT NULL, voornaam varchar(50) NOT NULL, adres varchar(50) NOT NULL, stad varchar(50) NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = latin1;");
				
if(!file_exists($bestand)) {    
  echo "Bestand niet gevonden."; 
}	
	
$handle = fopen("$bestand", "r");

while (($data = fgetcsv($handle, 0, "\n\r")) !== FALSE){
  $data[0] = str_replace("\"", "", $data[0]);
  $velden = explode(";", $data[0]);
	$import = "INSERT into $tabel(naam, voornaam, adres, stad) values ('$velden[0]', '$velden[1]', '$velden[2]', '$velden[3]')";
	$db->query($import);
}
$db->query("ALTER TABLE $tabel ADD id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");

echo "Het bestand is met succes geïmporteerd.";
?>