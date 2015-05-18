<?php
  
  $berichten    =   array();
  $titel        =   'Fotogalerij 1 - bootstrap';

  include('header.php');
  
  if (!isset ($_GET['album']))
  {
    $h1 = 'Fotogalerij';
  }
?>

<h1><?= $titel ?></h1>

<h1 class="hoofding"><?= $h1 ?></h1>
<div id="picasabox"></div>

<?php include('footer.php') ?>