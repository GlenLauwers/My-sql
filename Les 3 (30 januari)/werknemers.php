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
mysql_select_db("bootstrap");

$sql = "SELECT naam, voornaam, adres, stad FROM werknemers ORDER BY stad, naam";

$resultaat=mysql_query($sql, $db);
echo "<table>";
$velden = mysql_num_fields($resultaat);
echo "<tr>";
for ($i=0; $i < $velden; $i++){ 
  echo '<th>'.strtoupper(mysql_field_name($resultaat, $i)).'</th>'; 
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
