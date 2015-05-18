<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    $db = new PDO('mysql:host=localhost;dbname=Geschenk', 'root', '');
    $gebruikersnaam  =    $_SESSION['registratie']['gebruikersnaam'];
    
    $message    =   Message::getMessage();
    $gebruikers_type = '';
    
    
    $query  =   'SELECT *
                    FROM personeel
                    where gebruikersnaam = "'. $gebruikersnaam.'"';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $gebruiker[] =   $row; 
    }

    if ($gebruiker[0]['gebruikerstype'] === 'webmaster') 
    {
        $gebruikers_type  =   'Webmaster';
    }

    if ($gebruiker[0]['gebruikerstype'] === 'gebruiker') 
    {
        $gebruikers_type  =   'Gebruiker';
    }
  
    $_SESSION['gebruikers']['type']        =   $gebruikers_type;

    $query  =   'SELECT *
                    FROM geschenken
                    INNER JOIN personeel ON personeel.id = geschenken.personeel_id 
                    INNER JOIN producten ON geschenken.product_id = producten.product_id
                    where gebruikersnaam = "'. $gebruikersnaam.'"';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $personeel[] =   $row; 
    }
  
    if (!isset($_COOKIE['authenticated'])) 
        {
            header('location: index.php');
        }

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Geschenken</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Geschenken</h1>

            <p>U bent ingelogd als "<?= $gebruikersnaam ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>
            <?php if ($gebruikers_type === 'Gebruiker'): ?>
            	
            
            <?php if (isset($personeel[0]['product_naam'])): ?>
            	<p>U hebt de <?= $personeel[0]['product_naam'] ?> besteld. Veel plezier ermee.</p>
            <?php endif ?>

            <?php if (!isset($personeel[0]['product_naam'])): ?>
            	<p>U hebt nog geen keuze gemaakt. Gelieve te kiezen.</p>
            <?php endif ?>
            <?php endif ?>

            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

            <ul>
                <?php if ($gebruikers_type === 'Webmaster'): ?>
                    <li><a href="lijst_bestelling.php">Lijst weergeven</a></li>
                    <li><a href="artikels.php">Artikels weergeven</a></li>
                <?php endif ?>
                <?php if ($gebruikers_type === 'Gebruiker'): ?>
                    <li><a href="bestellen.php">Bestellen</a></li>
                <?php endif ?>
            </ul>

        </section>
        
    </body>
</html>