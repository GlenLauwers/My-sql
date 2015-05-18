<?php session_start();
$titel = 'Home';
include('bootstrapheader.php');
$tabel = 'content_bootstrap';
$sql="SELECT * FROM $tabel WHERE onderwerp = 'home'";
$resultaat = $db->query($sql);
if ($regel = $resultaat->fetch_array()){
  echo "".$regel['inhoud']."";
}
$resultaat->free();
if (isset($_SESSION['webmaster'])){
  echo "<p><a class=\"btn btn-primary\" href=\"update.php?tabel=content&pagina=home\">Update home</a></p>";
}
include('bootstrapfooter.php');
?>

