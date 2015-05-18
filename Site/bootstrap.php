<?php
  
  $berichten    =   array();
  $titel        =   'Bootstrap - bootstrap';

  include('header.php');
  
    $query  = "SELECT inhoud
               FROM content_bootstrap 
               WHERE onderwerp = 'bootstrap'";

    $statement = $db->prepare( $query );

    $statement->execute( );

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
      $berichten[]   = $row;
    }
?>

<h1><?= $titel ?></h1>

<div class="bootstrap">
  <?php foreach ($berichten[0] as $waarde): ?>
      <?= $waarde ?>
  <?php endforeach ?>
</div>
  
<?php include('footer.php') ?>