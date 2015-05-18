<?php session_start();
$titel = 'Bootstrap';
include('bootstrapheader.php');
echo "<h1>$titel</h1>";
$tabel = 'content_bootstrap';
$onderwerp = strtolower($titel);
$sql="SELECT * FROM $tabel WHERE onderwerp = '$onderwerp'";
$resultaat = $db->query($sql);	
if ($regel = $resultaat->fetch_array()){
  echo "".$regel['inhoud']."";
}
$resultaat->free();
if (isset($_SESSION['webmaster'])){
  echo "<p><a class=\"btn btn-primary\" href=\"update.php?tabel=content&pagina=$onderwerp\">Update $onderwerp</a></p>";
}
include('bootstrapfooter.php');
?>

