<?php
try
  {
    $db = new PDO('mysql:host=localhost;dbname=bootstrap_2', 'root', '');
    $bericht  = 'Connectie is gelukt.';
  }

 catch ( PDOException $e )
  {
    $bericht = "niet in orde";
  }