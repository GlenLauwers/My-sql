<?php
  
  $berichten    =   array();
  $titel        =   'Nieuwsbrief - bootstrap';
  $nummer       =    $_GET['id'];

  include('header.php');


    if (isset($_GET['id']))
    {
      $briefid = $nummer;
    }
  
    $query  = "SELECT onderwerp, inhoud, datum
               FROM nieuwsbrieven_bootstrap
               WHERE id = '$briefid'";

    $statement = $db->prepare( $query );

    $statement->execute( );

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
      $nieuwsbrief[]   = $row;
    }

?>

<h1><?= $titel ?></h1>

<?php foreach ($nieuwsbrief as $value): ?>
  <h1><?= $value['onderwerp']?></h1>
  <p><?= $value['inhoud']?></p>
  <p><i><?= $value['datum']?></i></p>
<?php endforeach ?>

<?php include('footer.php') ?>