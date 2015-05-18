<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    $db = new PDO('mysql:host=localhost;dbname=personeelsfeest', 'root', '');
    $mail  =    $_SESSION['registratie']['mail'];
    
    $message    =   Message::getMessage();
    $gebruikers_type = '';
    
    
    $query  =   'SELECT *
                    FROM personeel
                    WHERE mailadres = "'. $mail.'"';

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
                    FROM menukeuze
                    WHERE id_personeel = "'. $gebruiker[0]['id'].'"';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $menu[] =   $row; 
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
        <title>Dashboard - Personeelsfeest</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Personeelsfeest</h1>

            <p>U bent ingelogd als "<?= $gebruiker[0]['voornaam'] ?> <?= $gebruiker[0]['familienaam'] ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>
            <?php if ($gebruikers_type === 'Gebruiker'): ?>
            	
            
            <?php if (isset($menu[0])): ?>
            	<p>U hebt reeds een keuze gemaakt. U kunt deze nog wijzigen.</p>
            <?php endif ?>

            <?php if (!isset($menu[0])): ?>
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
                    <li><a href="personeel_lijst.php">Personeel weergeven</a></li>
                    <li><a href="artikels.php">Menu weergeven</a></li>
                <?php endif ?>
                <?php if ($gebruikers_type === 'Gebruiker'): ?>
                    <li><a href="bestellen.php">Keuze maken</a></li>
                <?php endif ?>
            </ul>

        </section>
        
    </body>
</html>