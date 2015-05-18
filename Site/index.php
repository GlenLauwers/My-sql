<?php
  
  $berichten    =   array();
  $titel        =   'Home - bootstrap';

  include('header.php');
  
    $query  = "SELECT inhoud
               FROM content_bootstrap 
               WHERE onderwerp = 'home'";

    $statement = $db->prepare( $query );

    $statement->execute( );

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
      $berichten[]   = $row;
    }
?>

<h1><?= $titel ?></h1>

<div class="berichten">
  <?php foreach ($berichten[0] as $waarde): ?>
      <?= $waarde ?>
  <?php endforeach ?>
</div>
  
<?php include('footer.php') ?>