<?php
$db = new mysqli('localhost', 'root', '', 'bootstrap_2');
if($db->connect_errno > 0){
  die('Verbinding maken met de database is mislukt. [' . $db->connect_error . ']');
}
$db->set_charset("utf8");
?>
