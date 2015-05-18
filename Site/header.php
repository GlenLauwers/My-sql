<?php
  
  session_start();
  include('Message.php');
  $message    =   Message::getMessage();

  include('databaseverbinding.php');
  
  $query  = "SELECT onderwerp, id
               FROM nieuwsbrieven_bootstrap 
               ORDER BY datum DESC";

  $statement = $db->prepare( $query );
  $statement->execute( );
  while ($row = $statement->fetch(PDO::FETCH_ASSOC))
  {
    $nieuwsbrieven[]   = $row;
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="" />
    <title><?= $titel ?></title>

    <!-- Style -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <header>
      <img class="logo" src="afbeeldingen/logo.jpg" alt="logo">
      <div class="menu navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">FAQ<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="faq1.php">FAQ 1</a></li>
                <li><a href="faq2.php">FAQ 2</a></li>
              </ul>
            </li>
      
            <li><a href="bootstrap.php">Bootstrap</a></li>
            <li><a href="video.php">Video</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Fotogalerij <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="fotogalerij1.php">Fotogalerij 1</a></li>
                <li><a href="#">Fotogalerij 2</a></li>
                <li><a href="#">Fotogalerij 3</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Contact <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Contactgegevens</a></li>
                <li><a href="#">Contactformulier</a></li>
                <li><a href="#">Route</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Nieuwsbrief <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <?php foreach ($nieuwsbrieven as $key => $value): ?>
                  <li><a href="nieuwsbrief.php?id=<?=$value['id']?>"><?= $value['onderwerp'] ?></a></li>
                <?php endforeach ?>

              </ul>
            </li>

            <li><a href="forum.php">Forum</a></li>
            <li><a href="aanmelden.php">Aanmelden</a></li>
          </ul>
        </div>
    </header>