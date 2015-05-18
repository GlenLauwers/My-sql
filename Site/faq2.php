<?php
  
  $faq          =   array();
  $titel        =   'FAQ 2 - bootstrap';

  include('header.php');
  
    $query_vraag  = "SELECT vraag, antwoord
                    FROM faq_bootstrap
                    WHERE 1";

    $statement = $db->prepare( $query_vraag );

    $statement->execute( );

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
      $vragen[]   = $row;
    }

    $i = 0;
?>

<h1><?= $titel ?></h1>
<div class="panel-group" id="accordion" style="margin-top: 20px">
  
  <?php foreach ($vragen as $key => $value): ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#<?= $i++ ?>"><?= $i?>. <?= $value['vraag']?></a></h4>
      </div>
  
      <div id="<?= $i-1 ?>" class="panel-collapse collapse">
        <div class="panel-body">
          <p><?= $value['antwoord']?></p>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>

  
<?php include('footer.php') ?>