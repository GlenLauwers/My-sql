<?php
  
  $berichten    =   array();
  $titel        =   'Forum - bootstrap';

  include('header.php');
  
  $query  = "SELECT voornaam, familienaam, datum, onderwerp, inhoud, forum_bootstrap.id 
            FROM gebruikers_bootstrap 
            INNER JOIN forum_bootstrap ON gebruikers_bootstrap.id = forum_bootstrap.id_gebruikers 
            ORDER BY datum";;

    $statement = $db->prepare( $query );

    $statement->execute( );

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
      $forum[]   = $row;
    }

?>

<h1><?= $titel ?></h1>

<?php foreach ($forum as $value): ?>
  <p><i><?= $value['voornaam'] ?> <?= $value['familienaam'] ?> - <?= $value['datum']?></i></p>
  <p><b><?= $value['onderwerp']?></b></p>
  <p><?= $value['inhoud']?></p>
  <div style="margin: 20px 0px; border-bottom: 1px solid blue"></div>
<?php endforeach ?>
  
<?php include('footer.php') ?>