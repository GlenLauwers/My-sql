<!DOCTYPE html>
<html>
<head>
<title>Join</title>
<style>
table {border-collapse: collapse; border: 1px solid red}
th {background: blue; color: white}
th, td {font: 14px verdana; padding: 5px; border: 1px solid black}
</style>
</head>
<body>
<?php
if ($db = mysql_connect("localhost", "root", ""))
{}else die ('Verbinding maken met de database is mislukt.');
mysql_select_db("syntra");

$sql = "SELECT student_naam AS Naam, student_voornaam AS Voornaam, cursus_naam AS Cursus, inschrijving_datum AS Inschrijvingsdatum FROM inschrijvingen inner join cursussen ON inschrijvingen.cursus_id = cursussen.cursus_id inner join studenten ON inschrijvingen.student_id = studenten.student_id ORDER BY Naam, Inschrijvingsdatum";

$resultaat=mysql_query($sql, $db);
echo "<table>";
$velden = mysql_num_fields($resultaat);
echo "<tr>";
for ($i=0; $i < $velden; $i++){ 
  echo '<th>'.mysql_field_name($resultaat, $i).'</th>'; 
}
echo "</tr>";
while ($regel = mysql_fetch_row($resultaat)){
  echo "<tr>";
  foreach ($regel as $waarde){
	  echo "<td>$waarde</td>";
	}
	echo "</tr>";
}
mysql_free_result($resultaat);
?>
</table></body>
</html>
