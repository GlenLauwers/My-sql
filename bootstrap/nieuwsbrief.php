<?php session_start();
if (isset($_GET['id'])){
  $briefid = $_GET['id'];
}
$titel = "Nieuwsbrieven";	
include('bootstrapheader.php');
$tabel = 'nieuwsbrieven_bootstrap';
$sql="SELECT * FROM $tabel WHERE id = '$briefid'";
$resultaat = $db->query($sql);	
if ($regel = $resultaat->fetch_array()){
  $onderwerp = $regel['onderwerp'];	
  $inhoud = $regel['inhoud'];
	$datum = $regel['datum'];
	$id = $regel['id'];
	echo "<div class=\"row\"><div class=\"col-lg-12\"><h1>".ucfirst($onderwerp)."</h1>$inhoud</div></div>";
}
$resultaat->free();
if ((isset($_SESSION['webmaster']))OR(isset($_SESSION['assistent']))){
  echo "<p><a class=\"btn btn-primary\" href=\"update.php?tabel=nieuws&pagina=$onderwerp\">Update $onderwerp</a></p>";
}
include('bootstrapfooter.php');
?>
