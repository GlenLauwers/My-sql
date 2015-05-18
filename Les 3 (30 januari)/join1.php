<?php
if ($db = mysql_connect("localhost", "root", ""))
{}else die ('Verbinding maken met de database is mislukt.');
mysql_select_db("syntra");

$sql = "SELECT student_naam AS Naam, student_voornaam AS Voornaam, cursus_naam AS Cursus, inschrijving_datum AS Inschrijvingsdatum FROM inschrijvingen inner join cursussen ON inschrijvingen.cursus_id = cursussen.cursus_id inner join studenten ON inschrijvingen.student_id = studenten.student_id ORDER BY Naam, Inschrijvingsdatum";

$resultaat=mysql_query($sql, $db);
while ($regel = mysql_fetch_row($resultaat)){
  echo "<p>";
	foreach($regel as $waarde) {
	  echo "$waarde ";
	} 
	echo "</p>";
}
mysql_free_result($resultaat);
?>
